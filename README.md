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
sslint-ecs
```


# How to use:
From project root, run:

### apply easy coding standards:
```shell
vendor/bin/sslint-ecs
```

If installed globally, you can run:
```shell
sslint-ecs
```

### lint your code for bugs:
```shell
vendor/bin/sslint-stan
```

If installed globally, you can run:
```shell
sslint-stan
```


### quick and dirty: do both and commit it ...
```shell
vendor/bin/sslint-all
```

If installed globally, you can just run:
```shell
sslint-all
```



# available settings
Set the directory you want to check / fix / analyse:

## dir
```shell
dir=myproject sslint-ecs
```
default: `app/src`

## also
On top of your code dir you can add one config file:
```shell
also=myproject/_config.php sslint-ecs
```
default: `app/_config.php`

## level
This is only relevant for php-stan.
1 = only show serious worries,
6 = show all issues.
```shell
level=2 sslint-stan
```
default: `4`

## ecsConfig
Set an alternative location for the Easy Coding Standards config file.

## stanConfig
Set an alternative location for the PHP Stan config file.

## logFile
The log file to record any errors / recommendations.
The default is: `LINTING_ERRORS.txt`.  This is used by the `sslint-all` command.

## message
Git commit message. This is used by the `sslint-all` command.
