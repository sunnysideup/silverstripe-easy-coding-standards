<?php

declare(strict_types=1);


use Netwerkstatt\SilverstripeRector\Set\SilverstripeSetList;
use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\Config\RectorConfig;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig
        ->sets([
            SilverstripeSetList::SS_6_0_ADDITIONAL,
        ]);
};
