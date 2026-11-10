## Problem Statement

Every change to the Mama Jaya Bahagia API requires manually uploading the changed files to the Hostinger shared host and running SQL scripts by hand against production. This is slow and silent: it is easy to forget a file, forget the SQL, skip `composer install`, run the wrong script, or run a destructive change without a backup. There is no audit trail of what is actually live, no rollback path, and production's migrations bookkeeping has drifted from the repository because schema changes have been applied outside Laravel's migration system. The developer cannot tell from the repo alone whether production matches `main`.

## Solution

Push-to-deploy for the API project. A merge to `main` triggers a GitHub Actions workflow that first runs the test suite, then connects to the hosting account over SSH and runs a committed deploy script. The deploy script puts the site into maintenance mode, dumps the database, syncs the code, installs production dependencies, runs pending migrations, rebuilds caches and the public storage link, fixes permissions, and brings the site back up. Database structure is owned by Laravel migrations from then on; one-off data repairs become explicit artisan commands. A one-time baseline reconciles the existing production schema with the migrations bookkeeping table without touching business data. Every deploy retains a database dump and the previous code archive so a rollback is a known, repeatable procedure.

## User Stories

1. As the solo developer, I want a push to `main` to deploy automatically, so that I never have to remember to upload files again.
2. As the solo developer, I want the deploy to run my test suite first, so that a breaking change never reaches production.
3. As the solo developer, I want a failed test run to block the deploy, so that red tests cannot become a red production site.
4. As the solo developer, I want a manual "deploy" trigger, so that I can re-run a deploy or roll back without inventing a new commit.
5. As the solo developer, I want a visible deploy log, so that I can see exactly which steps ran and what failed.
6. As the solo developer, I want the deployed commit SHA recorded, so that I can answer "what is actually live?" without guessing.
7. As the solo developer, I want production's migrations bookkeeping reconciled once, so that `migrate` reports the truth.
8. As the solo developer, I want that reconciliation to insert bookkeeping rows only, so that no business table, column, or row is created, altered, or dropped.
9. As the solo developer, I want a full database dump before any migration runs, so that every schema change has a restore point.
10. As the solo developer, I want the deploy to abort on the first failed step, so that a half-deployed state is impossible to mistake for success.
11. As the solo developer, I want the site in maintenance mode during the deploy, so that users never see a partial deploy.
12. As the solo developer, I want maintenance mode to end automatically, so that a failed deploy does not leave the site down.
13. As the solo developer, I want the previous code version archived before it is replaced, so that I can restore it quickly.
14. As the solo developer, I want a documented rollback that restores the previous code and, when needed, the matching database dump, so that recovery is a procedure rather than an improvisation.
15. As the solo developer, I want the last ten database dumps and code archives kept outside the web root, so that backups exist but are never web-accessible.
16. As the solo developer, I want the production `.env` and uploaded files left untouched by deploys, so that deployment cannot break configuration or lose data.
17. As the solo developer, I want dependencies installed on the server from the lock file, so that a laptop's `vendor` directory never becomes production.
18. As the solo developer, I want caches rebuilt as part of the deploy, so that stale config or routes never survive a release.
19. As the solo developer, I want the public storage link and writable directories ensured on every deploy, so that uploads and logs keep working.
20. As the solo developer, I want the deploy to authenticate with a dedicated SSH key, so that no hosting password lives in CI or in a secret manager.
21. As the solo developer, I want the SSH host key pinned, so that CI cannot be tricked into connecting to the wrong server.
22. As the solo developer, I want password authentication left as a break-glass path, so that I can still reach the server if the key path fails.
23. As the solo developer, I want only `main` to be deployable, so that a feature branch can never reach production by accident.
24. As the solo developer, I want schema changes to exist only as migrations, so that the repository is the single source of truth for structure.
25. As the solo developer, I want one-off data repairs to be explicit artisan commands, so that no invisible data mutation runs on every deploy.
26. As the solo developer, I want seeders kept out of the deploy path, so that test or demo data can never touch production.
27. As the solo developer, I want the CI test database to be disposable and seeded, so that tests are repeatable and never depend on production data.
28. As the solo developer, I want the whole deploy to finish in about a minute, so that the maintenance window stays negligible.
29. As the solo developer, I want a dry-run mode for the deploy and baseline scripts, so that I can verify what they will do before they do it.
30. As the solo developer, I want the admin SPA left on its current pipeline, so that this change has one clear blast radius.
31. As the solo developer, I want a documented first-deploy cutover, so that switching from manual uploads to automation is a controlled event.
32. As the solo developer, I want the manual deploy path to remain available, so that a GitHub outage never blocks an urgent fix.
33. As the solo developer, I want the pipeline to notify me when a deploy fails, so that I do not discover a broken deploy from a user.
34. As the solo developer, I want the pipeline to refuse to run if required server tooling is missing, so that failures are explicit instead of mysterious.

## Implementation Decisions

- **Trigger**: GitHub Actions on push to `main`, plus manual workflow dispatch for redeploys and rollbacks. Feature branches and pull requests never deploy.
- **Authentication**: a dedicated ed25519 deploy key registered on the hosting account; the private key stored as a GitHub Actions secret; server host key pinned in CI configuration. Password login remains available to the developer but is not used by automation.
- **Layout**: deploy in place into the existing web root, with the Laravel application root unchanged. The document root is not restructured to atomic releases in this pass.
- **Deploy sequence** (each step aborts the deploy on failure): verify the server has the required binaries and a supported PHP version; run the test suite; enter maintenance mode with a short retry window; dump the database; archive the current code; sync code excluding dependencies, `.env`, uploaded storage, and VCS metadata; install production dependencies from the lock file with autoloader optimization; run pending migrations; recreate the public storage link; rebuild config and route caches; fix directory permissions; exit maintenance mode.
- **Database ownership**: `php artisan migrate` is the only mechanism for schema change. Data repairs are standalone artisan commands run explicitly, never seeders and never migrations that mutate rows.
- **Baseline (one time)**: dump the database; compare every migration against the live schema; dry-run prints the bookkeeping inserts that would be made; apply inserts only for migrations whose corresponding schema is confirmed present, refusing any migration whose table is missing; then confirm that a migration dry-run reports nothing pending. No DDL and no business-data writes occur during baseline.
- **Backups and rollback**: dumps and code archives are stored in a directory outside the web root, retaining the last ten of each. Rollback redeploys the previous commit SHA and, for a bad migration, restores the matching dump first. Both paths are documented and repeatable.
- **Configuration**: production `.env` is never read from, written to, or uploaded by the pipeline. No secret is committed to the repository or printed in workflow logs.
- **Scope**: API project only. The admin SPA keeps its current deployment flow.
- **Test gate**: the CI test suite must be green before deploy. This requires a disposable, seeded CI database; the current tests use a real seeded database and hardcoded report fixtures, so they must be verified green against a fresh migration-and-seed before the gate becomes blocking.
- **Known unknowns to close before implementation**: whether the server provides the required PHP, Composer, rsync, and database dump tooling; whether the application root is the web root; and whether production has a migrations bookkeeping table at all. These are answered by a read-only diagnostic on the server and shape the final script details, not the design.

## Testing Decisions

- **Good tests** here assert external behavior: a dry-run makes no changes to code or data; an apply run makes exactly the claimed changes; a missing prerequisite causes a non-zero exit before anything is modified; a failed step leaves the previous release intact and the site reachable; a red test suite blocks the deploy.
- **Single seam**: both the deploy and baseline scripts expose a dry-run mode that emits the exact operations they would perform. Tests exercise that seam against a disposable MySQL instance and a temporary release directory, so the same code path used in production is the one under test. The workflow itself is validated by running its steps locally where possible and by a manual dispatch against a non-production directory before first production use.
- **Modules under test**: the deploy script, the baseline script, and the workflow's ordering guarantees (tests before deploy, dump before migrate, maintenance mode around the risky window).
- **Prior art**: the existing feature tests (COA and laba rugi endpoints) demonstrate the repository's preference for exercising real HTTP behavior against a database rather than mocking internals. New pipeline tests follow that preference at the process boundary, using a real database and filesystem rather than stubbed commands.
- **Non-hermetic tests**: the current report tests depend on a specific seeded dataset. They are a prerequisite for the gate, not a reason to weaken it; they must be made repeatable before the workflow runs them as a blocker.

## Out of Scope

- Deploying the admin SPA or changing its Vercel-based flow.
- A staging environment or a second hosting account.
- Atomic releases with a `current` symlink or a document-root move.
- Moving the application to a VPS, Docker, or a managed Laravel platform.
- Rewriting or squashing the existing migration history into one baseline migration.
- Multi-developer deploy approvals, release trains, or change freezes.
- Uptime monitoring, alerting infrastructure, and log aggregation.
- Changing application code, PHP version, queue driver, or cache backend.
- Migrating the production database to a different engine.

## Further Notes

- The production database is live and contains real business data. Nothing in this plan may run against it until the server diagnostic has been reviewed and the database has been dumped.
- The repository contains 53 migrations, including at least one that removes a column. Blindly running `migrate` before baseline would be the most dangerous possible first step.
- The API repository is public; no credentials, host addresses, usernames, or environment values belong in this issue or in workflow logs.
- The repository currently ignores dependencies, `.env`, and the public storage link, so a deploy that only syncs files is insufficient by design.
- The first automated deploy should happen during a low-traffic window and be treated as a cutover event with the manual path still available.
