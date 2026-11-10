# Deploying the API

The API deploys from `main` through GitHub Actions. A successful test run is required before anything reaches the server. The deploy runs over SSH, keeps a database dump and a code archive for every release, and puts the site into maintenance mode for the risky part of the release.

## One-time setup

### 1. Add a deploy key to the hosting account

Generate a dedicated key on your machine (no passphrase, it is used only by CI):

```bash
ssh-keygen -t ed25519 -C "github-actions@mamajaya" -f ~/.ssh/mamajaya_deploy_ed25519 -N ""
```

Add the **public** key in hPanel: **Advanced → SSH Keys → Add SSH key**. Paste the contents of `~/.ssh/mamajaya_deploy_ed25519.pub`.

Verify the fingerprint shown by hPanel matches the key:

```bash
ssh-keygen -lf ~/.ssh/mamajaya_deploy_ed25519.pub
```

### 2. Store the deployment secrets

The workflow needs these repository secrets:

| Secret | Value |
| --- | --- |
| `DEPLOY_SSH_KEY` | Contents of `~/.ssh/mamajaya_deploy_ed25519` (the private key) |
| `DEPLOY_KNOWN_HOSTS` | Output of `ssh-keyscan -p <port> <host>` (pin the host keys) |
| `DEPLOY_HOST` | Server hostname |
| `DEPLOY_PORT` | SSH port |
| `DEPLOY_USER` | SSH user |
| `DEPLOY_PATH` | Absolute Laravel application root on the server |

Set them with the GitHub CLI:

```bash
gh secret set DEPLOY_SSH_KEY --repo <owner>/Mama-Jaya-Bahagia-API < ~/.ssh/mamajaya_deploy_ed25519
ssh-keyscan -p <port> <host> | gh secret set DEPLOY_KNOWN_HOSTS --repo <owner>/Mama-Jaya-Bahagia-API
gh secret set DEPLOY_HOST --repo <owner>/Mama-Jaya-Bahagia-API --body "<host>"
gh secret set DEPLOY_PORT --repo <owner>/Mama-Jaya-Bahagia-API --body "<port>"
gh secret set DEPLOY_USER --repo <owner>/Mama-Jaya-Bahagia-API --body "<user>"
gh secret set DEPLOY_PATH --repo <owner>/Mama-Jaya-Bahagia-API --body "<absolute path>"
```

Verify the host fingerprints before trusting them. Compare `ssh-keyscan` output with hPanel → SSH access, or with the fingerprints listed there.

### 3. Confirm the server layout

`DEPLOY_PATH` must be the Laravel application root: the directory containing `artisan` and `public/`. Run the read-only preflight:

```bash
DEPLOY_HOST=<host> DEPLOY_PORT=<port> DEPLOY_USER=<user> DEPLOY_PATH=<path> \
  scripts/deploy.sh --check
```

If it reports a missing `artisan` or `public/`, stop and fix `DEPLOY_PATH` before deploying. The deploy script does not support a flattened layout where `public/` contents were copied directly into the web root.

### 4. First, code-only deploy

The baseline command has to exist on the server before you can run it, so the first deploy ships code but skips migrations:

```bash
DEPLOY_HOST=<host> DEPLOY_PORT=<port> DEPLOY_USER=<user> DEPLOY_PATH=<path> \
DEPLOY_SSH_KEY=~/.ssh/mamajaya_deploy_ed25519 \
  scripts/deploy.sh --apply --skip-migrations
```

This backs up, syncs, installs dependencies, and rebuilds caches, but leaves the database untouched. The workflow refuses to deploy until the marker exists, which is why this first cutover is manual.

### 5. Baseline the existing database (one time)

Production was built partly outside Laravel's migration system. Reconcile the bookkeeping **after** taking a dump, and **before** any deploy runs migrations:

```bash
# On the server, from the application root
php artisan deploy:db-dump --path="$HOME/deploy-backups/db" --name="pre-baseline.sql.gz"

# Dry run: lists what would be marked as already applied, changes nothing
php artisan deploy:baseline-migrations

# Review the list, then write the bookkeeping rows
php artisan deploy:baseline-migrations --apply

# Prove that nothing is still pending
php artisan migrate:status
php artisan migrate --pretend
```

The command only inserts rows into the `migrations` table. It never creates, alters, or drops a table, and it refuses to baseline a `create_*_table` migration whose table does not exist. If it refuses, the migration is genuinely pending and must run with `php artisan migrate`.

After baselining, `migrate --pretend` must not show a destructive statement. If it does, stop and inspect before deploying.

Only once that check is clean, create the marker that unblocks migrations:

```bash
touch ~/.mamajaya-baselined
```

Both the local deploy script and the remote step refuse to run migrations without this marker. It lives outside the application, so deploys cannot remove it.

### 6. First automated deploy

Run the workflow manually from the Actions tab (`workflow_dispatch` with `action: deploy`) and watch it. This run installs dependencies, runs migrations, and rebuilds caches.

## Daily flow

1. Merge to `main`.
2. GitHub Actions runs `php artisan test` against a disposable MySQL service seeded from scratch.
3. If tests pass, the deploy job connects over SSH, backs up, syncs, installs, migrates, rebuilds caches, and brings the site back up.
4. The workflow log records the commit SHA.

Manual redeploy: run the workflow with `workflow_dispatch`.

Manual deploy from your machine:

```bash
DEPLOY_HOST=<host> DEPLOY_PORT=<port> DEPLOY_USER=<user> DEPLOY_PATH=<path> \
DEPLOY_SSH_KEY=~/.ssh/mamajaya_deploy_ed25519 \
  scripts/deploy.sh --apply
```

## What the deploy does

1. Read-only preflight: PHP, Composer, `mysqldump`, `gzip`, `tar`, application layout.
2. Maintenance mode.
3. Database dump and code archive in `~/deploy-backups` (last 10 kept, outside the web root).
4. `rsync` of the working tree, excluding `.env`, `vendor`, `storage`, `tests`, `.github`, `docs`, and `public/storage`.
5. `composer install --no-dev --optimize-autoloader`.
6. `php artisan migrate --force`.
7. `storage:link` if missing, `config:cache`, best-effort `route:cache`.
8. Permissions on `storage` and `bootstrap/cache`.
9. Maintenance mode off — including on failure, via a trap.

## Rollback

### From GitHub Actions

Run the workflow manually with `action: rollback`, the archive name, and optionally the matching database dump. This requires the same secrets as a deploy and does not need your laptop.

### From your machine

List what is available:

```bash
DEPLOY_HOST=<host> DEPLOY_PORT=<port> DEPLOY_USER=<user> DEPLOY_PATH=<path> \
  scripts/rollback.sh --list
```

Roll back the code:

```bash
DEPLOY_HOST=<host> DEPLOY_PORT=<port> DEPLOY_USER=<user> DEPLOY_PATH=<path> \
DEPLOY_SSH_KEY=~/.ssh/mamajaya_deploy_ed25519 \
  scripts/rollback.sh --archive <timestamp>-<sha> --apply
```

If a migration caused the problem, restore the matching dump as well:

```bash
... scripts/rollback.sh --archive <timestamp>-<sha> --db <timestamp>-<sha>.sql.gz --apply
```

The rollback restores the archive over the application (keeping `.env`, `storage`, and the installed `vendor`), reinstalls dependencies, rebuilds caches, and brings the site back up.

The server records the last deployed commit in `~/.mamajaya-deployed`, and the preflight prints it. That is the durable answer to "what is live?".

## Data repairs

Schema changes belong in migrations. One-off data repairs are explicit commands run by hand, never seeders in the deploy path. Create a command that is safe to run twice, and run it deliberately:

```bash
php artisan <your-repair-command> --dry-run
php artisan <your-repair-command> --apply
```

## Troubleshooting

- **Host key verification failed**: the local `known_hosts` does not have the pinned host key. Add `ssh-keyscan -p <port> <host>` to `~/.ssh/known_hosts`, and set `DEPLOY_KNOWN_HOSTS` for CI.
- **missing composer / mysqldump**: the non-interactive SSH session does not see the binary. Find the absolute path on the server and set `PHP_BIN` or `COMPOSER_BIN` in the remote script's environment, or load the login shell's PATH.
- **Site is down after a failed deploy**: `ssh` into the server, `cd` to the application root, run `php artisan up`.
- **Migration fails mid-deploy**: the site is brought back up. Restore the dump from that release with `scripts/rollback.sh --db <dump> --apply` after fixing the code.
- **Composer runs out of memory**: set `COMPOSER_MEMORY_LIMIT=-1` in the remote script environment.

## Out of scope

The admin SPA is not part of this pipeline. It keeps its existing deployment flow.
