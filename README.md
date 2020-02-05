# What it does

Lints your silverstripe php code, checks for potential bugs.

# How to install

 - open your terminal
 - browse to root folder or project and type: `composer require --dev sunnysideup/easy-coding-standards:dev-master`

## global install

1. open your terminal and type
`composer global require sunnysideup/easy-coding-standards:dev-master`
`composer global update`

2. then add path to `~/.bash_rc` (or otherwise):
`PATH=~/.composer/vendor/bin:$PATH`

now you should be able to run it from anywhere... like this:

apply easy coding standards:
```sh
php-sslint-ecs
```

lint your code for bugs:
```sh
php-sslint-stan
```
quick and dirty: do both and commit it ... 
```sh
php-sslint-all
```



# How to use:

From project root, run:
 - `vendor/bin/php-sslint-ecs`
   - lints app/src
 - `vendor/bin/php-sslint-stan`
   - checks app/src for bugs
 - `vendor/bin/php-sslint-all`
   - runs the above commands,
   - writes all errors to KNOW_ISSUES file in project root dir
   - commits all the changes to the project

# available settings

If your code does not live in `app/src` you can set an alternative dir like this:

## lint
`dir=myproject vendor/bin/php-sslint-ecs`
`configFile=myproject/_config.php vendor/bin/php-sslint-ecs`

## bugfix
`dir=myproject vendor/bin/php-sslint-stan`
`level=7 vendor/bin/php-sslint-stan`

## commit
`dir=myproject configFile=myproject/_config.php vendor/bin/php-sslint-all`
