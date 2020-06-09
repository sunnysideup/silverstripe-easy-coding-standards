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
sslint-ecs
```


# How to use:
From project root, run:

### apply easy coding standards:
```shell
vendor/bin/sslint-ecs
```

If installed globally:
```shell
sslint-ecs
```

### lint your code for bugs:
```shell
vendor/bin/sslint-stan
```

If installed globally:
```shell
sslint-stan
```


### quick and dirty - do both and commit the results:
```shell
vendor/bin/sslint-all
```

If installed globally:
```shell
sslint-all
```

### bonus: lint your javascript:
If you install js standards, like this (you may need to use `sudo`):
```shell
npm install standard --global
```

Then you can the following command to fix your js:
```shell
vendor/bin/sslint-js
```

If installed globally:
```shell
sslint-js
```
You may need to set the right directory - e.g.

# available settings
Set the directory you want to check / fix / analyse:
```shell
dir=app/client/javascript/ sslint-js
```

### dir
```shell
dir=myproject sslint-ecs
```
default: `app/src`

### also
On top of your code dir you can add one config file:
```shell
also=myproject/_config.php sslint-ecs
```
default: `app/_config.php`

### level
This is only relevant for php-stan.
1 = only show serious worries,
6 = show all issues.
```shell
level=2 sslint-stan
```
default: `4`

### ecsConfig
Set an alternative location for the Easy Coding Standards config file.

### stanConfig
Set an alternative location for the PHP Stan config file.

### logFile
The log file to record any errors / recommendations.
The default is: `LINTING_ERRORS.txt`.  This is used by the `sslint-all` command.

### message
Git commit message. This is used by the `sslint-all` command.

# pro tips

 - Always run from root of project, even if you are linting a vendor module.
