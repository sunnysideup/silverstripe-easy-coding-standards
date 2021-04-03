<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer;

use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;

use PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use PhpCsFixer\Fixer\Basic\Psr4Fixer;

use PhpCsFixer\Fixer\Import\OrderedImportsFixer;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(ArraySyntaxFixer::class)
        ->call('configure', [[
            'syntax' => 'short',
        ]]);
    $services->set(Psr4Fixer::class);
    $services->set(OrderedImportsFixer::class)
        ->call(
            'configure', [[
                'imports_order' => ['class', 'const', 'function'],
                'sort_algorithm' => 'alpha', // possible values ['alpha', 'length', 'none']
            ]]
        );
    $parameters = $containerConfigurator->parameters();

    $parameters->set(Option::PATHS, [
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
    $parameters->set(
        Option::SETS, [
        // run and fix, one by one
        // SetList::SPACES,
        // SetList::ARRAY,
        // SetList::STRICT,
        // SetList::SYMFONY,
        SetList::DOCBLOCK,
        SetList::NAMESPACES,
        // SetList::SYMPLIFY,
        SetList::COMMON,
        SetList::COMMENTS,
        // SetList::CONTROL_STRUCTURES,
        SetList::CLEAN_CODE,
        // SetList::PSR_1,
        SetList::PHP_CS_FIXER,
        SetList::PSR_12,
        // SetList::PHP_CS_FIXER_RISKY,
        // SetList::PHPUNIT,
        ]
    );
    $parameters->set(Option::SKIP, [
        SelfAccessorFixer::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        ArrayListItemNewlineFixer::class,
        OrderedClassElementsFixer::class,
    ]);

};
