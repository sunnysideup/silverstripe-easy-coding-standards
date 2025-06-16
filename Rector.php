<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector;
use Rector\Config\RectorConfig;

return RectorConfig::configure()

    // here we can define, what prepared sets of rules will be applied
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true
    )
    ->withSkip(
        [
            CompleteDynamicPropertiesRector::class,
            //\Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer
            //\Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer::class,
        ]
    );
