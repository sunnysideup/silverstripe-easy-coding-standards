PHP Linter all in one.

# How to install

Just like any other Silverstripe module:
composer require --dev 'sunnysideup/easy-coding-standards'

# How to use:

From project root, run:
 - `vendor/bin/php-lint` - lints app/src
 - `vendor/bin/php-bugfix` - checks app/src for bugs
 - `vendor/bin/php-git-commit-lint`
   - runs the above commands,
   - writes all errors to KNOW_ISSUES file in project root dir
   - commits all the changes to the project

# assumptions made

Your code lives in `app/src`  you can set an alternative dir like this:

`dir=myproject vendor/bin/php-lint`
`configFile=myproject/_config.php vendor/bin/php-lint`

`dir=myproject vendor/bin/php-bugfix`
