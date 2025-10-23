# What it does

Lints your silverstripe php code, checks for potential bugs, and also has a raft of other helpful commands.

## tl;dr

Install as global composer package and then try to access the commands, starting with `sake-` from the command line.

## commands available

```shell

# help
 - sake-help

# composer
 - sake-composer-about
 - sake-composer-available-updates
 - sake-composer-force-update
 - sake-composer-require
 - sake-composer-update

# find
 - sake-find-in-files
 - sake-find-large-files

# git
 - sake-git-quick
 - sake-git-commit-and-push
 - sake-git-commit-and-push-vendor-packages
 - sake-git-diff-analyser
 - sake-git-fork-comparison
 - sake-git-remove-stale-branches
 - sake-git-merge-towards-production
 - sake-git-squash-and-pr
 - sake-git-squash-commits
 - sake-git-tag


# php
 - sake-php-set-timezone

# lint and security
 - sake-lint-all
 - sake-lint-class-rename-comparison
 - sake-lint-compat
 - sake-lint-ecs
 - sake-lint-ide-annotator
 - sake-lint-js
 - sake-lint-one-file
 - sake-lint-phan
 - sake-lint-psr-4-checker
 - sake-lint-rector
 - sake-lint-remove-origs
 - sake-lint-security
 - sake-lint-stan

# webpack
 - sake-npm-audit
 - sake-npm-install
 - sake-npm-build
 - sake-npm-dev
 - sake-npm-watch

 # npm / node
 - sake-npm-update-self
 - sake-npm-publish-on-npmjs-org


# silverstripe
 - sake-ss-add-site
 - sake-ss-create-env-file
 - sake-ss-db-dump
 - sake-ss-db-import
 - sake-ss-db-open
 - sake-ss-dev-build
 - sake-ss-flush
 - sake-ss-rsync-asset
 - sake-ss-start-new-module

# test
- sake-test-site

# rsync
- sake-ss-rsync-all
- sake-ss-rsync-assets
- sake-ss-rsync-db
- sake-ss-rsync-start-new-feature
- sake-ss-rsync-start-new-module
- sake-ss-rsync-sspak

# scrutinizer
 - sake-scrutinizer-add

# machine maintenance
 - sake-update-chromium
 - sake-update-vs-code


```

## How to install for one project (not recommended - as it may not work)

1. open your terminal
2. browse to root folder of your project and type:

```shell
composer require --dev sunnysideup/easy-coding-standards:dev-master
```

## global install (recommended - more likely to work)

1. open your terminal and type

```shell
composer global config minimum-stability dev
composer global config prefer-stable true
composer global require sunnysideup/easy-coding-standards:dev-master
```

2. then add path to `~/.bashrc` (or otherwise):
   choose the appropriate one ...

```shell
PATH=~/.composer/vendor/bin:$PATH
PATH=~/.config/composer/vendor/bin:$PATH
```

This will make the global composer `vendor/bin` available anywhere (use with care!).

3. To enable it, run:

```shell
source ~/.bashrc
```

or restart your computer.

4. Now you should be able to run it from anywhere like this:

```shell
sake-lint-ecs [dir]
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
