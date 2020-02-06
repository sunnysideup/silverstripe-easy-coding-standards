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
default: `app/src`

## configFile
```shell
configFile=myproject/_config.php vendor/bin/php-sslint-ecs
```
default: `app/_config.php`
We are adding this so that you can do the src dir and the config file at the same time. 

## level
```shell
level=7 vendor/bin/php-sslint-stan
```
default: 4, this is only relevant for php-stan.
