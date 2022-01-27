<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;
use PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector;
use Rector\CodeQuality\Rector\If_\CombineIfRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQuality\Rector\Return_\SimplifyUselessVariableRector;

use Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\CodingStyle\Rector\If_\NullableCompareToNullRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\Assign\RemoveUnusedVariableAssignRector;
use Rector\DeadCode\Rector\Cast\RecastingRemovalRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateConstantRector;
use Rector\DeadCode\Rector\ClassConst\RemoveUnusedPrivateClassConstantRector;
use Rector\DeadCode\Rector\ClassMethod\RemoveUnusedConstructorParamRector;
use Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\Property\RemoveSetterOnlyPropertyAndMethodCallRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\Set\ValueObject\SetList;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer;
use Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer;
// use PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer;

return static function (ContainerConfigurator $containerConfigurator): void {

    $parameters = $containerConfigurator->parameters();
    // print_r($parameters);
    // Define what rule sets will be applied
    // $containerConfigurator->import(SetList::DEAD_CODE); - causes error!
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODING_STYLE);

    $parameters->set(Option::SKIP, [
        IssetOnPropertyObjectToPropertyExistsRector::class,
        RemoveUnusedConstructorParamRector::class,
        //RemoveUnusedPrivateConstantRector::class,
        RemoveUnusedPrivateClassConstantRector::class,
        RemoveUnusedPrivatePropertyRector::class,
        // RemoveSetterOnlyPropertyAndMethodCallRector::class,
        ArrayOpenerAndCloserNewlineFixer::class,
        ArrayListItemNewlineFixer::class,
        SelfAccessorFixer::class,
        NotOperatorWithSuccessorSpaceFixer::class,
        OrderedClassElementsFixer::class,
        CombineIfRector::class,
        RemoveUnusedVariableAssignRector::class,
        SimplifyUselessVariableRector::class,
        EncapsedStringsToSprintfRector::class,
        ExplicitBoolCompareRector::class,
        NullableCompareToNullRector::class,
        RemoveDeadInstanceOfRector::class,
        SimplifyBoolIdenticalTrueRector::class,
        RemoveCodeAfterReturnRector::class,
        RecastingRemovalRector::class,
    ]);
    $parameters->set(Option::AUTOLOAD_PATHS, [
        getcwd(),
    ]);
    // SlevomatCodingStandard\Sniffs\Classes\UnusedPrivateElementsSniff: ~
    // # SlevomatCodingStandard\Sniffs\Functions\UnusedInheritedVariablePassedToClosureSniff: ~
    // # SlevomatCodingStandard\Sniffs\Classes\ModernClassNameReferenceSniff.ClassNameReferencedViaMagicConstant: ~
    // PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff.Found: ~
    // PHP_CodeSniffer\Standards\Squiz\Sniffs\Classes\ValidClassNameSniff.NotCamelCaps: ~
    // PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer: ~
    // PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer: ~
    // PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer: ~
    // get services (needed for register a single rule)
    // $services = $containerConfigurator->services();

    // register a single rule
    // $services->set(TypedPropertyRector::class);
};
