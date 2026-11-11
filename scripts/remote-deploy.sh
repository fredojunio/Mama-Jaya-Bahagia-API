#!/usr/bin/env bash
#
# Runs on the production host. Invoked by scripts/deploy.sh and scripts/rollback.sh.
#
# Usage: remote-deploy.sh <mode> <app-dir> [sha|archive]

set -Eeuo pipefail

MODE="${1:?usage: remote-deploy.sh <mode> <app-dir> [sha|archive]}"
APP_DIR="${2:?app directory is required}"
ARG="${3:-}"

PHP_BIN="${PHP_BIN:-php}"
COMPOSER_BIN="${COMPOSER_BIN:-composer}"
BACKUP_ROOT="${BACKUP_ROOT:-$HOME/deploy-backups}"
KEEP="${KEEP:-10}"

cd "$APP_DIR"

prune() {
    local directory="$1" pattern="$2"
    local files count

    files="$(ls -1t "$directory"/$pattern 2>/dev/null || true)"
    count="$(printf '%s\n' "$files" | sed '/^$/d' | wc -l | tr -d ' ')"

    if [ "$count" -gt "$KEEP" ]; then
        printf '%s\n' "$files" | tail -n +$((KEEP + 1)) | while IFS= read -r file; do
            rm -f "$file"
        done
    fi
}

case "$MODE" in
    down)
        "$PHP_BIN" artisan down --retry=15
        ;;

    up)
        "$PHP_BIN" artisan up || true
        ;;

    backup)
        mkdir -p "$BACKUP_ROOT/db" "$BACKUP_ROOT/code"

        timestamp="$(date +%Y%m%d-%H%M%S)"

        if "$PHP_BIN" artisan list --raw 2>/dev/null | grep -q 'deploy:db-dump'; then
            "$PHP_BIN" artisan deploy:db-dump \
                --path="$BACKUP_ROOT/db" \
                --name="$timestamp-$ARG.sql.gz" \
                --keep="$KEEP"
        else
            echo "warning: deploy:db-dump is not installed yet; skipping the database dump for this cutover"
        fi

        tar -czf "$BACKUP_ROOT/code/$timestamp-$ARG.tar.gz" \
            --exclude=./vendor \
            --exclude=./.git \
            --exclude=./storage \
            --exclude=./.env \
            --exclude=./node_modules \
            --exclude=./__MACOSX \
            --exclude=./.DS_Store \
            -C "$APP_DIR" .

        prune "$BACKUP_ROOT/code" '*.tar.gz'

        echo "dump: $BACKUP_ROOT/db/$timestamp-$ARG.sql.gz"
        echo "archive: $BACKUP_ROOT/code/$timestamp-$ARG.tar.gz"
        ;;

    post)
        trap '"$PHP_BIN" artisan up >/dev/null 2>&1 || true' EXIT

        # Hostinger's PHP 8.1 CLI does not ship ext-sodium. Passport uses RSA
        # keys, so the platform check can be ignored here safely.
        "$COMPOSER_BIN" install \
            --no-dev \
            --prefer-dist \
            --optimize-autoloader \
            --no-interaction \
            --no-progress \
            --ignore-platform-req=ext-sodium

        if [ "${SKIP_MIGRATIONS:-0}" = "1" ]; then
            echo "migrations skipped by request (first cutover before baseline)"
        else
            test -f "$HOME/.mamajaya-baselined" || {
                echo "migrations blocked: the one-time baseline marker is missing (docs/deploy.md step 4)"
                exit 1
            }

            "$PHP_BIN" artisan migrate --force
        fi

        if [ -L public/storage ]; then
            :
        elif "$PHP_BIN" -r 'exit(function_exists("symlink") ? 0 : 1);'; then
            "$PHP_BIN" artisan storage:link
        else
            echo "warning: symlink() is disabled on this PHP; skipping storage:link"
        fi

        "$PHP_BIN" artisan config:cache

        if ! "$PHP_BIN" artisan route:cache >/dev/null 2>&1; then
            "$PHP_BIN" artisan route:clear >/dev/null 2>&1 || true
            echo "warning: route cache skipped (the route table contains closures)"
        fi

        chmod -R ug+rwX storage bootstrap/cache

        if [ -n "$ARG" ]; then
            printf '%s\n' "$ARG" > "$HOME/.mamajaya-deployed"
        fi
        ;;

    rollback)
        archive="$ARG"
        [ -f "$archive" ] || archive="$BACKUP_ROOT/code/$archive"

        test -f "$archive" || {
            echo "archive not found: $ARG"
            exit 1
        }

        trap '"$PHP_BIN" artisan up >/dev/null 2>&1 || true' EXIT

        workdir="$(mktemp -d)"
        tar -xzf "$archive" -C "$workdir"

        rsync -a --delete \
            --exclude=.env \
            --exclude=.git \
            --exclude=storage \
            --exclude=public/storage \
            --exclude=vendor \
            --exclude=bootstrap/cache \
            "$workdir/" "$APP_DIR/"

        rm -rf "$workdir"

        "$COMPOSER_BIN" install \
            --no-dev \
            --prefer-dist \
            --optimize-autoloader \
            --no-interaction \
            --no-progress

        "$PHP_BIN" artisan config:cache

        if ! "$PHP_BIN" artisan route:cache >/dev/null 2>&1; then
            "$PHP_BIN" artisan route:clear >/dev/null 2>&1 || true
        fi

        chmod -R ug+rwX storage bootstrap/cache

        deployed="${ARG##*-}"
        deployed="${deployed%.tar.gz}"
        printf '%s\n' "$deployed" > "$HOME/.mamajaya-deployed"
        ;;

    restore-db)
        dump="$ARG"
        [ -f "$dump" ] || dump="$BACKUP_ROOT/db/$dump"

        "$PHP_BIN" artisan deploy:db-restore "$dump" --force
        ;;

    list-backups)
        echo "database dumps:"
        ls -1t "$BACKUP_ROOT"/db/*.sql.gz 2>/dev/null || echo "  (none)"
        echo "code archives:"
        ls -1t "$BACKUP_ROOT"/code/*.tar.gz 2>/dev/null || echo "  (none)"
        ;;

    *)
        echo "unknown mode: $MODE" >&2
        exit 2
        ;;
esac
