#!/usr/bin/env bash
#
# Roll the API back to a code archive created by scripts/deploy.sh.
#
#   scripts/rollback.sh --list
#   scripts/rollback.sh --archive 20260101-120000-abc1234        dry run
#   scripts/rollback.sh --archive 20260101-120000-abc1234 --apply
#   scripts/rollback.sh --archive <name> --db 20260101-120000-abc1234.sql.gz --apply
#
# Required environment:
#   DEPLOY_HOST  DEPLOY_USER  DEPLOY_PATH
# Optional:
#   DEPLOY_PORT (default 22)  DEPLOY_SSH_KEY (path to a private key)

set -Eeuo pipefail

REPO_ROOT="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$REPO_ROOT"

usage() {
    sed -n '2,16p' "$0" | sed 's/^# \{0,1\}//'
}

MODE="dry-run"
ARCHIVE=""
DUMP=""
LIST=0

while [[ $# -gt 0 ]]; do
    case "$1" in
        --apply) MODE="apply" ;;
        --list) LIST=1 ;;
        --archive) ARCHIVE="${2:-}"; shift ;;
        --db) DUMP="${2:-}"; shift ;;
        -h|--help) usage; exit 0 ;;
        *) echo "Unknown option: $1" >&2; usage >&2; exit 2 ;;
    esac
    shift
done

# shellcheck source=lib/remote.sh
source "$REPO_ROOT/scripts/lib/remote.sh"

if [[ "$LIST" == "1" ]]; then
    remote_script "list-backups"
    exit 0
fi

if [[ -z "$ARCHIVE" ]]; then
    echo "--archive is required (use --list to see available archives)" >&2
    exit 2
fi

if [[ "$MODE" != "apply" ]]; then
    echo "Dry run. A rollback would:"
    echo "  1. put the site into maintenance mode"

    if [[ -n "$DUMP" ]]; then
        echo "  2. restore the database dump: $DUMP"
    fi

    echo "  3. restore the code archive: $ARCHIVE"
    echo "  4. reinstall dependencies and rebuild caches"
    echo "  5. bring the site back up"
    echo
    echo "Nothing was changed. Re-run with --apply to roll back."
    exit 0
fi

cleanup() {
    local status=$?

    echo "==> Bringing the site back up"
    remote_script "up" || true

    exit "$status"
}

trap cleanup EXIT

upload_remote_script

remote_script "down"

if [[ -n "$DUMP" ]]; then
    echo "==> Restoring database $DUMP"
    remote_script "restore-db" "$DUMP"
fi

echo "==> Restoring code $ARCHIVE"
remote_script "rollback" "$ARCHIVE"

echo "==> Rollback finished for ${ARCHIVE}"
