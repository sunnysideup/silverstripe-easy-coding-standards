<?php

declare(strict_types=1);

use Netwerkstatt\SilverstripeRector\Rector\Injector\UseCreateRector;
use Rector\Config\RectorConfig;
use Netwerkstatt\SilverstripeRector\Rector\DataObject\EnsureTableNameIsSetRector;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;

return RectorConfig::configure()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    )
    ->withSets([
        //rector lists
        LevelSetList::UP_TO_PHP_83,
        SetList::CODE_QUALITY,
        SetList::CODING_STYLE,
        //silverstripe rector
        SilverstripeSetList::CODE_STYLE,
        SilverstripeLevelSetList::UP_TO_SS_6_0
    ])

    // any rules that are included in the selected sets you want to skip
    // ->withSkip([
    //     //        ClassPropertyAssignToConstructorPromotionRector::class,
    //     //        ReturnNeverTypeRector::class
    // ])
    // // any rules that are included in the selected sets you want to skip
    // ->withSkip([
    //     ClassPropertyAssignToConstructorPromotionRector::class,
    //     ReturnNeverTypeRector::class
    // ])
;
