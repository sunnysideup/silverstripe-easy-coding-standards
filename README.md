# What it does

Lints your silverstripe php code, checks for potential bugs, and other helpful commands.

# tl;dr version:

Install as global composer package and then try to access the commands, starting with `sake-` from the command line.

# commands available:

```shell

# silverstripe
sake-ss-dev-build

# linting
sake-lint-all
sake-lint-compat
sake-lint-ecs
sake-lint-js
sake-lint-rector
sake-lint-stan

# git
sake-git-commit-and-push
sake-git-commit-and-push-vendor-packages  
sake-lint-remove-origs
sake-git-squash-commits

# webpack
sake-npm-install
sake-npm-build
sake-npm-watch    

```

# How to install (may not work!)

1. open your terminal
2. browse to root folder of your project and type:
 ```shell
composer require --dev sunnysideup/easy-coding-standards:dev-master
 ```

## global install (recommended)

1. open your terminal and type
```shell
composer global require sunnysideup/easy-coding-standards:dev-master
```

2. then add path to `~/.bashrc` (or otherwise):
choose the appropriate one ...
```shell
PATH=~/.composer/vendor/bin:$PATH
PATH=~/.config/composer/vendor/bin:$PATH
```
To make the composer `vendor/bin` available anywhere (use with care!).

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

# How to use:
Commands should be run from the root directory of your project.

To find out the options, just do this:

```shell
sake-my-command -h
```

The default director, in most cases, is `app`.

## Not installed globally?
If not installed globally, then you should add `vendor/bin/` in front of the commands.
```shell
vendor/bin/sake-my-command -h
```

### apply easy coding standards:
see: https://github.com/symplify/easy-coding-standard
```shell
sake-lint-ecs [dir]
```
