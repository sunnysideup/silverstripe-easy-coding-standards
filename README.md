# What it does

Lints your silverstripe php code, checks for potential bugs.

# How to install

1. open your terminal
2. browse to root folder of your project and type:
 ```shell
 composer require --dev sunnysideup/easy-coding-standards:dev-master
 ```

## global install

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
php-sslint-ecs
```

# How to use
From the root dir of your project (the folder where the composer.json file lives).

### apply easy coding standards:
```shell
php-sslint-ecs
```
options:
- dir
- also
- ecsConfig

### lint your code for bugs:
```shell
php-sslint-stan
```
options:
- dir
- also
- level
- stanConfig

### quick and dirty: do both and commit it ...
```shell
php-sslint-all
```
- dir
- also
- message
- logFile


# How to use:
From project root, run:

### apply easy coding standards:
```shell
vendor/bin/php-sslint-ecs
```

If installed globally, you can just run:
```shell
php-sslint-ecs
```

### lint your code for bugs:
```shell
vendor/bin/php-sslint-stan
```

If installed globally, you can just run:
```shell
php-sslint-stan
```


### quick and dirty: do both and commit it ...
```shell
vendor/bin/php-sslint-all
```

If installed globally, you can just run:
```shell
php-sslint-all
```

# available settings
Set the directory you want to check / fix / analyse:

## dir
```shell
dir=myproject php-sslint-ecs
```
default: `app/src`

## also
On top of your code dir you can add one config file:
```shell
also=myproject/_config.php php-sslint-ecs
```
default: `app/_config.php`

## level
This is only relevant for php-stan.
1 = only show serious worries,
6 = show all issues.
```shell
level=2 php-sslint-stan
```
default: `4`

## ecsConfig
Set an alternative location for the Easy Coding Standards config file.

## stanConfig
Set an alternative location for the PHP Stan config file.

## logFile
The log file to record any errors / recommendations.
The default is: `LINTING_ERRORS.txt`.  This is used by the `php-sslint-all` command.

## message
Git commit message. This is used by the `php-sslint-all` command.
