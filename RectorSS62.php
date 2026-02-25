<?php

declare(strict_types=1);


use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets([
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        //silverstripe rector
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_6_2
    ]);
};
