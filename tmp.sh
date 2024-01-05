#!/bin/bash

response=$(curl -L -X POST "https://packagist.org/api/create-package?username=sunnysideup&apiToken=3bfle73lwrwgwsckgcsw" -H "Content-Type: application/json" -d "{\"repository\":{\"url\":\"https://github.com/sunnysideup/silverstripe-download\"}}")
echo "$response"
