#!/usr/bin/env bash
#
# Deploy the API to the Hostinger host.
#
#   scripts/deploy.sh --check     read-only preflight
#   scripts/deploy.sh             dry run: print the plan, change nothing
#   scripts/deploy.sh --apply     deploy
#   scripts/deploy.sh --apply --skip-migrations   first cutover only, before baseline
#
# Required environment:
#   DEPLOY_HOST  DEPLOY_USER  DEPLOY_PATH
# Optional:
#   DEPLOY_PORT (default 22)  DEPLOY_SSH_KEY (path to a private key)

set -Eeuo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$REPO_ROOT"

usage() {
    sed -n '2,13p' "$0" | sed 's/^# \{0,1\}//'
}

MODE="dry-run"
SKIP_MIGRATIONS=0

for argument in "$@"; do
    case "$argument" in
        --apply) MODE="apply" ;;
        --check) MODE="check" ;;
        --skip-migrations) SKIP_MIGRATIONS=1 ;;
        -h|--help) usage; exit 0 ;;
        *)
            echo "Unknown option: $argument" >&2
            usage >&2
            exit 2
            ;;
    esac
done

# shellcheck source=lib/remote.sh
source "$REPO_ROOT/scripts/lib/remote.sh"

preflight() {
    remote "bash -s" <<EOF
set -e
cd $(q "$DEPLOY_PATH")

test -f artisan || { echo "missing artisan in $DEPLOY_PATH"; exit 1; }
test -d public || { echo "missing public/ in $DEPLOY_PATH"; exit 1; }

php -v | head -n 1
php -r 'exit(version_compare(PHP_VERSION, "8.1.0", ">=") ? 0 : 1);' \
    || { echo "PHP 8.1 or newer is required"; exit 1; }

if [ -f "\$HOME/.mamajaya-baselined" ]; then
    echo "baseline marker: present"
else
    echo "baseline marker: MISSING — migrations stay blocked until docs/deploy.md step 4 is done"
fi

deployed="\$(cat "\$HOME/.mamajaya-deployed" 2>/dev/null || echo unknown)"
echo "deployed: \$deployed"

for binary in composer mysqldump gzip tar; do
    command -v "\$binary" >/dev/null 2>&1 || { echo "missing required binary: \$binary"; exit 1; }
done

composer --version
EOF
}

echo "==> Preflight ${DEPLOY_USER}@${DEPLOY_HOST}:${DEPLOY_PORT} ${DEPLOY_PATH}"
preflight

if [[ "$MODE" == "check" ]]; then
    echo "Preflight OK. Nothing was changed."
    exit 0
fi

if [[ "$MODE" != "apply" ]]; then
    cat <<'EOF'

Dry run. A deploy would:
  1. put the site into maintenance mode
  2. dump the database and archive the current code into ~/deploy-backups
  3. rsync the working tree (excluding .env, vendor, storage, tests, .github)
  4. run composer install --no-dev
  5. run php artisan migrate --force
  6. rebuild config cache, storage link and permissions
  7. bring the site back up

The database and the server were not touched. Re-run with --apply to deploy.
EOF
    exit 0
fi

command -v rsync >/dev/null 2>&1 || {
    echo "rsync is required to deploy" >&2
    exit 1
}

if [[ "$SKIP_MIGRATIONS" != "1" ]] && ! remote 'test -f "$HOME/.mamajaya-baselined"'; then
    echo "Refusing to deploy: the one-time migration baseline has not been done." >&2
    echo "Follow docs/deploy.md step 4, then create the marker:" >&2
    echo "  ssh ... 'touch ~/.mamajaya-baselined'" >&2
    echo "For the first code-only cutover, use --apply --skip-migrations." >&2
    exit 1
fi

SHA="$(git rev-parse --short HEAD 2>/dev/null || echo unknown)"
STARTED=0

cleanup() {
    local status=$?

    if [[ "$STARTED" == "1" ]]; then
        echo "==> Bringing the site back up"
        remote_script "up" || true
    fi

    exit "$status"
}

trap cleanup EXIT

upload_remote_script

echo "==> Maintenance mode"
remote_script "down"
STARTED=1

echo "==> Backing up database and code"
remote_script "backup" "$SHA"

echo "==> Syncing code"
rsync -az --delete \
    -e "ssh ${SSH_OPTIONS[*]}" \
    --exclude '.git/' \
    --exclude '.github/' \
    --exclude 'docs/' \
    --exclude 'tests/' \
    --exclude 'vendor/' \
    --exclude 'node_modules/' \
    --exclude '.env' \
    --exclude '.DS_Store' \
    --exclude 'storage/' \
    --exclude 'public/storage' \
    --exclude 'bootstrap/cache/' \
    ./ "$REMOTE:$DEPLOY_PATH/"

echo "==> Installing dependencies and running migrations"
REMOTE_ENV="SKIP_MIGRATIONS=$SKIP_MIGRATIONS" remote_script "post" "$SHA"

STARTED=0

echo "==> Deployed ${SHA} to ${DEPLOY_USER}@${DEPLOY_HOST}:${DEPLOY_PATH}"
