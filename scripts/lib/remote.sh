#!/usr/bin/env bash
#
# Shared SSH helpers for scripts/deploy.sh and scripts/rollback.sh.
# Expects REPO_ROOT to be set by the caller.

: "${DEPLOY_HOST:?DEPLOY_HOST is required}"
: "${DEPLOY_USER:?DEPLOY_USER is required}"
: "${DEPLOY_PATH:?DEPLOY_PATH is required}"

DEPLOY_PORT="${DEPLOY_PORT:-22}"
DEPLOY_SSH_KEY="${DEPLOY_SSH_KEY:-}"
REMOTE="${DEPLOY_USER}@${DEPLOY_HOST}"

case "$DEPLOY_PATH" in
    /|/home|/home/|"$HOME")
        echo "Refusing unsafe DEPLOY_PATH: $DEPLOY_PATH" >&2
        exit 2
        ;;
esac

if [[ "$DEPLOY_PATH" != /* ]]; then
    echo "DEPLOY_PATH must be absolute: $DEPLOY_PATH" >&2
    exit 2
fi

SSH_OPTIONS=(
    -p "$DEPLOY_PORT"
    -o BatchMode=yes
    -o StrictHostKeyChecking=yes
    -o ConnectTimeout=15
)

if [[ -n "$DEPLOY_SSH_KEY" ]]; then
    SSH_OPTIONS+=(-i "$DEPLOY_SSH_KEY")
fi

q() {
    printf '%q' "$1"
}

remote() {
    ssh "${SSH_OPTIONS[@]}" "$REMOTE" "$@"
}

remote_script() {
    local mode="$1"
    local argument="${2:-}"
    local prefix=""

    if [[ -n "${REMOTE_ENV:-}" ]]; then
        prefix="${REMOTE_ENV} "
    fi

    remote "${prefix}bash ~/.mamajaya-remote-deploy.sh $(q "$mode") $(q "$DEPLOY_PATH") $(q "$argument")"
}

upload_remote_script() {
    remote "cat > ~/.mamajaya-remote-deploy.sh && chmod 700 ~/.mamajaya-remote-deploy.sh" \
        < "$REPO_ROOT/scripts/remote-deploy.sh"
}
