# What it does

Lints your silverstripe php code, checks for potential bugs.

# How to install

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

2. then add path to `~/.bash_rc` (or otherwise):
```shell
PATH=~/.composer/vendor/bin:$PATH
```
To make the composer `vendor/bin` available anywhere

now you should be able to run it from anywhere like this:
```shell
sslint-ecs [dir]
```


# How to use:
Once intalled you can run some simple commands to lint your Silverstripe (and other) code.
Make sure to always run from root of project, even if you are linting a vendor module.
All commands take one parameter: the dir you wan to lint.

The default is `app/src`.


### apply easy coding standards:
```shell
vendor/bin/sslint-ecs [dir]
```

If installed globally:
```shell
sslint-ecs [dir]
```

### lint your code for bugs:
```shell
vendor/bin/sslint-stan [dir]
```

If installed globally:
```shell
sslint-stan [dir]
```

### check for outdated code
```shell
vendor/bin/sslint-compat [dir]
```

If installed globally:
```shell
sslint-compat [dir]
```

### lint, git and push:
```shell
vendor/bin/sslint-all [dir]
```

If installed globally:
```shell
sslint-all [dir]
```

### bonus - lint your javascript:
If you install js standards, like this (you may need to use `sudo`):
```shell
npm install standard --global
```

Then you can the following command to fix your js:
```shell
vendor/bin/sslint-js [dir]
```

If installed globally:
```shell
sslint-js [dir]
```
You may need to set the right directory - e.g.

# available flags

### -a (also)
On top of your code dir you can add one config file:
```shell
sslint-ecs -a myproject/_config.php foo/bar
```
default: `app/_config.php`

### -l (level)
This is only relevant for `sslint-stan`.
1 = only show serious worries,
6 = show all issues.
default: `4`
```shell
sslint-stan -l 2 foo/bar
```


### -p (level)
This is only relevant for `sslint-compat`.
default: `7.4`
```shell
sslint-compat -p 7.3 foo/bar
```

### -m (message)
Git commit message. This is used by the `sslint-all` command.

### -e (ecsConfig)
This is used by the `sslint-ecs` command.
Set an alternative location for the Easy Coding Standards config file.

### -s (stanConfig)
This is used by the `sslint-stan` command.
Set an alternative location for the PHP Stan config file.
