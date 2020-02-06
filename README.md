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

now you should be able to run it from anywhere... like this:

### apply easy coding standards:
```shell
php-sslint-ecs
```

### lint your code for bugs:
```shell
php-sslint-stan
```
### quick and dirty: do both and commit it ... 
```shell
php-sslint-all
```

Typically you would run these from the root directory of your project. 


# How to use:
From project root, run:

### apply easy coding standards:
```shell
vendor/bin/php-sslint-ecs
```

### lint your code for bugs:
```shell
vendor/bin/php-sslint-stan
```
### quick and dirty: do both and commit it ... 
```shell
vendor/bin/php-sslint-all
```

# available settings
If your code does not live in `app/src` you can set an alternative dir like this:
## dir 
```shell
dir=myproject vendor/bin/php-sslint-ecs
```


## configFile
On top of your code dir you can add one config file:
```shell
configFile=myproject/_config.php vendor/bin/php-sslint-ecs
```
default: `app/_config.php`

## level
This is only relevant for php-stan. 
1 = only highlight serious worries, 
6 = highlight most issues. 
```shell
level=7 vendor/bin/php-sslint-stan
```
default: `4`

## logFile
The log file to record any errors / recommendations. The default is: `LINTING_ERRORS.txt`.  This is used by the "all in one" command.
