# What it does

Lints your silverstripe php code, checks for potential bugs.

# How to install

 - open your terminal
 - browse to root folder or project and type: 
 ```
 composer require --dev sunnysideup/easy-coding-standards:dev-master
 ```

## global install

1. open your terminal and type
```
composer global require sunnysideup/easy-coding-standards:dev-master
composer global update
```

2. then add path to `~/.bash_rc` (or otherwise):
```
PATH=~/.composer/vendor/bin:$PATH
```

now you should be able to run it from anywhere... like this:

### apply easy coding standards:
```
php-sslint-ecs
```

### lint your code for bugs:
```
php-sslint-stan
```
### quick and dirty: do both and commit it ... 
```
php-sslint-all
```



# How to use:
From project root, run:

### apply easy coding standards:
```
vendor/bin/php-sslint-ecs
```

### lint your code for bugs:
```
vendor/bin/php-sslint-stan
```
### quick and dirty: do both and commit it ... 
```
vendor/bin/php-sslint-all
```

# available settings

If your code does not live in `app/src` you can set an alternative dir like this:

## dir
`dir=myproject vendor/bin/php-sslint-ecs`

## configFile
`configFile=myproject/_config.php vendor/bin/php-sslint-ecs`

## level
`level=7 vendor/bin/php-sslint-stan`

