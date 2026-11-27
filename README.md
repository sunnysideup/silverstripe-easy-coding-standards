# What it does

Lints your silverstripe php code, checks for potential bugs, and also has a raft of other helpful commands.

## tl;dr

Install as global composer package and then try to access the commands, starting with `sake-` from the command line.

## commands available

Run `sake-help` for the full list, `sake-help --more` for summaries grouped by section,
`sake-help <section>` (e.g. `sake-help git`) for a single section, or `sake-help -f <keyword>` to search.

### naming convention

`sake-<category>-<group>-<task>`, for example `sake-lint-php-stan` or `sake-ss-db-import`.

Any task that works on more than one website / project (many repos, a whole GitHub organisation, ...)
lives in the `pm` group: `sake-<category>-pm-<task>` (see `sake-help -f -pm-`).

```shell

# composer
## package
 - sake-composer-package-about - Shows which packages depend on a specific composer package
 - sake-composer-package-fork-comparison - Compares a GitHub repo and its forks to find forks with changes ahead of the base repo
 - sake-composer-package-require - Requires a composer package with specified branch using --prefer-source
## update
 - sake-composer-update - Updates composer packages with optional force, minimal changes, and auto-commit
 - sake-composer-update-available - Lists all outdated packages and security audit results
 - sake-composer-update-force - Forces update of dev packages via Packagist API and updates dependencies

# find
## large
 - sake-find-large-files - Finds and lists files and directories larger than specified size
 - sake-find-large-folders - Analyzes folder sizes with customizable depth and sorting options
## misc
 - sake-find-in-files - Recursively searches for text string in all files using grep

# general
 - sake-help - Displays a list of all available sake commands and their descriptions

# git
## commit
 - sake-gc - Git commit shortcut: lists vendor modules with changes, has an LLM review the diff for security issues and write the commit message, then commits and pushes
 - sake-git-commit-and-push - Commits changes to git and pushes to remote with optional tagging and review
 - sake-git-commit-and-push-vendor-packages - Scans vendor directories for git changes and optionally commits them
 - sake-git-commit-quick - Quickly commits all changes and pushes with auto vendor checks
 - sake-git-commit-tag - Creates semantic version tags based on commit message prefixes (API:, ENH:, FIX:)
## info
 - sake-git-info - Displays comprehensive git repository information and sync state
 - sake-git-info-prod-diff - Diffs remote uncommitted changes and untracked files against your local codebase
## merge
 - sake-git-merge-majors - Guided merge of one version branch into another (e.g. SS5 → SS6), keeping version-specific code
 - sake-git-merge-pipeline-ssh - Generates SSH key pair for git pipeline authentication and displays both keys
 - sake-git-merge-towards-production - Merges branches stepwise through workflow: develop → test → stage → production
 - sake-git-merge-towards-production-changes - Summarises everything since the last commit in CHANGELOG.md and adds a categorised entry to it
## pm
 - sake-git-pm-add-collaborator - Manages collaborators on GitHub repositories (add, remove, list)
 - sake-git-pm-diff - Analyses recent git changes across repos and estimates the time spent
 - sake-git-pm-diff-analyser - Analyses git commits by committer over a period and estimates the effort involved
 - sake-git-pm-diff-recent - Net diff per GitHub repo (public + private) for the last X days
 - sake-git-pm-find-any-changes - Recursively searches for git repos with local changes or unpushed commits
 - sake-git-pm-fix-bitbucket-ssh - Moves Bitbucket SSH access to ssh.bitbucket.org (remotes, ssh config, known_hosts, git config)
 - sake-git-pm-master-to-main - Renames master branch to main across GitHub organization repositories
 - sake-git-pm-my-pull-requests - Lists pull requests filtered by mode (mine/incoming/review) and criteria
 - sake-git-pm-my-work-being-forked - Scans your repos and their forks to find branches ahead of originals
 - sake-git-pm-scrutinizer-add - Identifies GitHub repositories not yet added to Scrutinizer CI
## squash
 - sake-git-squash-and-pr - Squashes all commits in current branch and creates a pull request
 - sake-git-squash-commits - Squashes multiple commits into one with various filtering options
 - sake-git-squash-stale-branches - Removes local branches that have been merged, excluding protected branches like master and develop
 - sake-git-upgrade-5-to-6-all - For every repo of an owner: if branch 5 is ahead of main, merge 5 into main, drop SS5-only changes, clean up conflicts, Rector (SS62) and verify SS6 with LLM help

# lint
## class
 - sake-lint-class-namespacing - Scans PHP files and validates how each class is referenced (use statements, FQCNs) across the project
 - sake-lint-class-psr-4-checker - Validates and auto-corrects PHP namespaces for PSR-4 compliance
 - sake-lint-class-rename-comparison - Compares classes between two git branches to find renamed classes (optionally fixes references)
## files
 - sake-lint-files-js - Lints and auto-fixes JavaScript files using the Standard JS style
 - sake-lint-files-remove-origs - Finds and removes .orig files created by merge conflicts or patches
## php
 - sake-lint-php-compat - Checks code compatibility with specified PHP versions using PHPCompatibility
 - sake-lint-php-ecs - Runs PHP ECS linter to check and fix code style issues
 - sake-lint-php-phan - Performs static analysis on PHP code using Phan
 - sake-lint-php-rector - Refactors and upgrades PHP code automatically using Rector
 - sake-lint-php-security - Runs security checks including composer audit, semgrep, and vulnerability scanning
 - sake-lint-php-stan - Performs static analysis on PHP code using PHPStan
## run
 - sake-lint-run-all - Runs all linting tools in sequence: compat, ide-annotator, ecs, rector, and stan
 - sake-lint-run-one-file - Runs comprehensive linting on a single file or directory (compat, ecs, rector, stan)
## ss
 - sake-lint-ss-ide-annotator - Generates IDE annotations and DocBlock hints for DataObjects
 - sake-lint-ss-template-check - Checks template files for conflicts and aligns with vendor module structure

# llm
 - sake-llm-add-agents-file - Adds an AGENTS.md file (instructions for LLM coding agents) to a project (default) or globally for your user
 - sake-llm-opencode - Runs OpenCode LLM agent to process files based on custom prompts

# npm
## build
 - sake-npm-build - Builds production-ready npm/webpack assets for deployment
 - sake-npm-build-dev - Runs npm build in development mode with unminified assets
 - sake-npm-build-watch - Watches files and automatically rebuilds assets when changes are detected
## package
 - sake-npm-package-audit - Audits npm packages for security vulnerabilities and outdated dependencies
 - sake-npm-package-install - Installs NPM packages for webpack and application, including node-sass rebuild
 - sake-npm-package-publish-on-npmjs-org - Publishes an npm package to npmjs.org with automatic version bumping

# php
## config
 - sake-php-config-switch-versions - Switches the active PHP version to match require.php in composer.json (via php-switch)
 - sake-php-config-timezone - Sets the PHP timezone in all php.ini configuration files
## misc
 - sake-php-line-counter - Counts PHP lines of code and estimates project complexity in hours

# server
## management
 - sake-server-management-check-basics - Checks the basics on one or more servers over SSH (backups, git state, composer packages)

# ss
## build
 - sake-ss-build-dev - Runs SilverStripe dev/build with proper permissions and folder setup
 - sake-ss-build-flush - Clears all SilverStripe caches and runs dev/build with flush
## contribute
 - sake-ss-contribute-step-1 - Clones repo, creates fork, sets up remotes, and creates working branch
 - sake-ss-contribute-step-2 - Squashes commits, rebases onto target branch, pushes to fork for PR
## db
 - sake-ss-db-dump - Exports SilverStripe database to an .sspak file
 - sake-ss-db-export - Executes SQL or exports to CSV using SilverStripe .env credentials
 - sake-ss-db-import - Imports a MySQL database dump file into local SilverStripe database
 - sake-ss-db-open - Opens MySQL CLI connected to SilverStripe database from .env credentials
## rsync
 - sake-ss-rsync-all - Syncs database and assets between local and remote server
 - sake-ss-rsync-assets - Syncs public/assets folder between local and remote server via rsync
 - sake-ss-rsync-db - Syncs database between local and remote server via SSH
 - sake-ss-rsync-sspak - Syncs database and assets from remote server using sspak format
## start
 - sake-ss-start-env-file - Generates a SilverStripe .env file from YAML configuration data
 - sake-ss-start-new-feature - Creates a new feature branch with optional database and asset sync
 - sake-ss-start-new-module - Creates a new SilverStripe module from template with GitHub and Packagist setup
 - sake-ss-start-new-site - Adds a new SilverStripe site to your environment
 - sake-ss-start-test-site - Creates fresh SilverStripe test site with mock data for module testing
## upgrade
 - sake-ss-upgrade-align-versions - Aligns SilverStripe core package versions to match requirements
 - sake-ss-upgrade-install-upgrader - Installs the SilverStripe upgrade tool into /var/www/upgrader
 - sake-ss-upgrade-ready - Checks if SilverStripe project meets version requirements and dependencies
 - sake-ss-upgrade-security-update - Runs complete security update workflow with tests and composer updates

# test
 - sake-test-speed-server - Gentle server health check and benchmark (CPU, RAM, disk I/O, database)
 - sake-test-speed-site - Tests website performance by measuring response times and connection speed

# update
## app
 - sake-update-app-chromium - Updates Chromium browser to the latest available version
 - sake-update-app-shell - Updates the shell to Zsh and configures terminal environments
 - sake-update-app-vs-code - Updates Visual Studio Code to the latest stable version
## runtime
 - sake-update-runtime-composer - Updates Composer dependency manager to the latest version
 - sake-update-runtime-go - Updates Go programming language to the latest version
 - sake-update-runtime-npm - Updates NVM, Node.js, and npm to their latest stable versions

# self
 - sake-self-edit - Opens the code of this module in OpenCode for editing
 - sake-self-update

```

## server lists

Commands in the `sake-server-management-*` group read one SSH login per line.
The default is `./servers.txt` in the directory where the command is run.
Otherwise `SAKE_SERVERS_FILE` from `~/.config/composer/.env` (or a project
`.env`) is used.

Resolution order (first match wins):

1. `--servers-file FILE` or the positional file argument
2. `SAKE_SERVERS_FILE` in the project `.env`
3. `./servers.txt` in the current working directory
4. `SAKE_SERVERS_FILE` in `~/.config/composer/.env`
5. `~/.config/composer/servers.txt`
6. `SAKE_SERVERS` (optional inline fallback)

Each line is an SSH login: `user@host`, `host`, or an `~/.ssh/config` alias.
Blank lines and lines starting with `#` are ignored.

Example `servers.txt`:

```text
# production
user@111.222.333.444
myserver-alias

# test
testuser@111.222.333.555
```

Set a global default in `~/.config/composer/.env`:

```shell
SAKE_SERVERS_FILE=/home/me/servers.txt
SAKE_SERVERS_PAUSE_SECONDS=20
```

`SAKE_SERVERS_FILE` may point at a shared list or a project-local file. You can
also symlink `~/.config/composer/servers.txt` to a list instead.

## How to install for one project (not recommended - as it may not work)

1. open your terminal
2. browse to root folder of your project and type:

```shell
composer require --dev sunnysideup/easy-coding-standards:dev-main
```

## global install (recommended - more likely to work)

1. open your terminal and type

```shell

# install ...
composer global config minimum-stability dev
composer global config prefer-stable true
composer global require sunnysideup/easy-coding-standards:dev-main
cat << 'EOF' >> ~/.bashrc

# Add composer path
PATH=~/.config/composer/vendor/bin:$PATH
EOF
source ~/.bashrc

```

or restart your computer.

1. Now you should be able to run it from anywhere like this:

```shell
sake-lint-php-ecs [dir]
```

(this command, and all the other commands listed above).

## How to use

Commands should be run from the root directory of your project.

To find out the options for a specific command:

```shell
sake-my-command -h
```

## Not installed globally?

If not installed globally, then you should add `vendor/bin/` in front of the commands.

```shell
vendor/bin/sake-my-command -h
```
