#!/bin/bash
SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"
WORKING_DIR=$(pwd)
# : ${stanConfig:=$SCRIPT_DIR/../sunnysideup/easy-coding-standards/phpstan.neon}

if [ "$1" != "" ]; then
    dir=$1;
else
    dir='themes/client'
fi

help_and_exit() {
    echo " ---------------------------------";
    echo "   Available settings:";
    echo " ---------------------------------";
    echo "   none"
    echo " ---------------------------------";
    echo "   Example usage:"
    echo " ---------------------------------";
    echo "   ssu-npm-watch themes/client";
    echo " ---------------------------------";
    echo " "
    echo " "
    exit;
}

while (( $# )); do
  case $1 in
    -*)                printf 'Unknown option: %q\n\n' "$1";
                       help_and_exit 1 ;;
    *)                 dir=$1;;
  esac
  shift
done

echo " "
echo " "
echo " ---------------------------------";
echo "   Running NPM watch";
echo " ---------------------------------";
echo "   Directory of script:              $SCRIPT_DIR";
echo "   Directory to install:             $WORKING_DIR/$dir";
echo " ---------------------------------";
echo " "
echo " "

cd themes/sswebpack_engine_only/
npm run watch --theme_dir=$dir
