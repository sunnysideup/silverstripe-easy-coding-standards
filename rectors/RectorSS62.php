<?php

declare(strict_types=1);


use Netwerkstatt\SilverstripeRector\Set\SilverstripeLevelSetList;
use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Rector\Set\ValueObject\LevelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->sets(
        [
            LevelSetList::UP_TO_PHP_84,
            SetList::CODE_QUALITY,
            SetList::CODING_STYLE,
            //silverstripe rector
            SilverstripeSetList::CODE_STYLE,
            SilverstripeLevelSetList::UP_TO_SS_6_2
        ]
    );
    $rectorConfig->skip(
        [
            CompleteDynamicPropertiesRector::class,
            //\Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer
            //\Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer::class,
        ]
    );
};
