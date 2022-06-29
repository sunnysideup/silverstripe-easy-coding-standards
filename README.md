# What it does

Lints your silverstripe php code, checks for potential bugs, and other helpful commands.

# tl;dr version:

Install as global composer package and then try to access the commands, starting with `sake-` from the command line.

# commands available:

```shell

# silverstripe
sake-dev-build

# linting
sake-lint-all
sake-lint-compat
sake-lint-ecs
sake-lint-js
sake-lint-rector
sake-lint-stan

# git
sake-gitpush
sake-gitpush-vendor-packages  
sake-remove-origs

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
composer global update
```

2. then add path to `~/.bashrc` (or otherwise):
```shell
PATH=~/.composer/vendor/bin:$PATH
PATH=~/.config/composer/vendor/bin:$PATH
```
To make the composer `vendor/bin` available anywhere

3. To enable it, run:
```shell
source ~/.bashrc
```
or restart your computer.

4. Now you should be able to run it from anywhere like this:

```shell
sake-lint-ecs [dir]
```
and all the other commands.

# How to use:
Once intalled you can run some simple commands to lint your Silverstripe (and other) code.
Make sure to always run from root of project, even if you are linting a vendor module.
In general commands take one parameter: the dir you wan to lint and a number of flags.


The default is `app`.


### apply easy coding standards:
```shell
vendor/bin/sake-lint-ecs [dir]
```

If installed globally:
```shell
sake-lint-ecs [dir]
```


### apply php rector:
```shell
vendor/bin/sake-lint-rector [dir]
```

If installed globally:
```shell
sake-lint-rector [dir]
```


### lint your code for bugs:
```shell
vendor/bin/sake-lint-stan [dir]
```

If installed globally:
```shell
sake-lint-stan [dir]
```

### check for outdated code
```shell
vendor/bin/sake-lint-compat [dir]
```

If installed globally:
```shell
sake-lint-compat [dir]
```

### lint, git and push:
```shell
vendor/bin/sake-lint-all [dir]
```

If installed globally:
```shell
sake-lint-all [dir]
```

### lint your javascript:
If you install js standards, like this (you may need to use `sudo`):
```shell
npm install standard --global
sudo npm install standard --global
```

Then you can the following command to fix your js:
```shell
vendor/bin/sake-lint-js [dir]
```

If installed globally:
```shell
sake-lint-js [dir]
```
You may need to set the right directory - e.g.



### git push:

Do a quick git push
```shell
vendor/bin/sake-gitpush [dir]
```

If installed globally:
```shell
sake-gitpush [dir]
```

### git push vendor packages

Do a quick git push
```shell
vendor/bin/sake-gitpush-vendor-packages vendor/[vendorName]
```

If installed globally:
```shell
sake-gitpush-vendor-packages vendor/[vendorName]
```

e.g.
```shell
sake-gitpush-vendor-packages vendor/silverstripe
```
will git commit and git push ALL SilverStripe vendor packages.


### resync assets from server

Get all the assets from a website server
```shell
vendor/bin/sake-rsync-assets [webserver:/var/www/websiteroot]
```

If installed globally:
```shell
sake-rsync-assets [webserver:/var/www/websiteroot]
```

e.g. browse to your local webroot dir and run:
```shell
sake-rsync-assets my-ssh-login@123.123.123.123:/var/www/html
```
will git commit and git push ALL SilverStripe vendor packages.


### remove *.orig files:

Do a quick git push
```shell
vendor/bin/sake-origs [dir]
```

If installed globally:
```shell
sake-origs [dir]
```

### remove stale branches from local:

Do a quick git push
```shell
vendor/bin/sake-origs [dir]
```

If installed globally:
```shell
sake-origs [dir]
```

### dev/build

Do a quick git push
```shell
vendor/bin/sake-dev-build [dir]
```

If installed globally:
```shell
sake-dev-build [dir]
```


# available flags


### -h|--help
Find out all your options for any of the functions.
```shell
sake-lint-ecs -h
```
default: `false`
