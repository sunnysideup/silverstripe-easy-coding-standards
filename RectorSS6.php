<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;

$paths = [
    __DIR__ . '/app/_config.php',
    __DIR__ . '/app/src',
    __DIR__ . '/_config.php',
    __DIR__ . '/src',
];

foreach ($paths as $key => $path) {
    if (!file_exists($path)) {
        unset($paths[$key]);
    }
}

return RectorConfig::configure()
    ->withPaths($paths)
    // uncomment to reach your current PHP version
    ->withPhpSets()
    ->withSets([
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_6_0
    ])
    ->withTypeCoverageLevel(0)
    ->withDeadCodeLevel(0)
    ->withCodeQualityLevel(0);
