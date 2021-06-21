# What it does

Lints your silverstripe php code, checks for potential bugs, and other helpful commands.

# tl;dr version:

Install as global composer package and then try to access the commands, starting with `ssu-` from the command line. 

# commands available:

```shell

# silverstripe
ssu-dev-build

# linting
ssu-lint-all
ssu-lint-compat
ssu-lint-ecs
ssu-lint-js
ssu-lint-rector
ssu-lint-stan

# git
ssu-gitpush
ssu-gitpush-vendor-packages  
ssu-remove-origs

# webpack
ssu-npm-install
ssu-npm-build
ssu-npm-watch    

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
ssu-lint-ecs [dir]
```
and all the other commands.

# How to use:
Once intalled you can run some simple commands to lint your Silverstripe (and other) code.
Make sure to always run from root of project, even if you are linting a vendor module.
In general commands take one parameter: the dir you wan to lint and a number of flags.


The default is `app`.


### apply easy coding standards:
```shell
vendor/bin/ssu-lint-ecs [dir]
```

If installed globally:
```shell
ssu-lint-ecs [dir]
```


### apply php rector:
```shell
vendor/bin/ssu-lint-rector [dir]
```

If installed globally:
```shell
ssu-lint-rector [dir]
```


### lint your code for bugs:
```shell
vendor/bin/ssu-lint-stan [dir]
```

If installed globally:
```shell
ssu-lint-stan [dir]
```

### check for outdated code
```shell
vendor/bin/ssu-lint-compat [dir]
```

If installed globally:
```shell
ssu-lint-compat [dir]
```

### lint, git and push:
```shell
vendor/bin/ssu-lint-all [dir]
```

If installed globally:
```shell
ssu-lint-all [dir]
```

### lint your javascript:
If you install js standards, like this (you may need to use `sudo`):
```shell
npm install standard --global
sudo npm install standard --global
```

Then you can the following command to fix your js:
```shell
vendor/bin/ssu-lint-js [dir]
```

If installed globally:
```shell
ssu-lint-js [dir]
```
You may need to set the right directory - e.g.



### git push:

Do a quick git push
```shell
vendor/bin/ssu-gitpush [dir]
```

If installed globally:
```shell
ssu-gitpush [dir]
```

### git push vendor packages

Do a quick git push
```shell
vendor/bin/ssu-gitpush-vendor-packages vendor/[vendorName]
```

If installed globally:
```shell
ssu-gitpush-vendor-packages vendor/[vendorName]
```

e.g.
```shell
ssu-gitpush-vendor-packages vendor/silverstripe
```
will git commit and git push ALL SilverStripe vendor packages.


### resync assets from server

Get all the assets from a website server
```shell
vendor/bin/ssu-rsync-assets [webserver:/var/www/websiteroot]
```

If installed globally:
```shell
ssu-rsync-assets [webserver:/var/www/websiteroot]
```

e.g. browse to your local webroot dir and run:
```shell
ssu-rsync-assets my-ssh-login@123.123.123.123:/var/www/html
```
will git commit and git push ALL SilverStripe vendor packages.


### remove *.orig files:

Do a quick git push
```shell
vendor/bin/ssu-origs [dir]
```

If installed globally:
```shell
ssu-origs [dir]
```

### dev/build

Do a quick git push
```shell
vendor/bin/ssu-dev-build [dir]
```

If installed globally:
```shell
ssu-dev-build [dir]
```


# available flags


### -h|--help
Find out all your options for any of the functions.
```shell
ssu-lint-ecs -h
```
default: `false`
