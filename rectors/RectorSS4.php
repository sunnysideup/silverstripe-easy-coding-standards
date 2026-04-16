<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;

return static function (RectorConfig $rectorConfig): void {

    $rectorConfig->sets([
        //rector lists
        LevelSetList::UP_TO_PHP_81,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        //silverstripe rector
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_4_13
    ]);
    $rectorConfig->skip(
        [
            CompleteDynamicPropertiesRector::class,
        ]
    );
};
