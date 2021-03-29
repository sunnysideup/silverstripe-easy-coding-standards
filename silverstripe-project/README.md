# what is all about?

This  is a first step towards better linting of all silverstripe modules to such a level that it is part of CI and 100s of fixes are applied every time a pull request is made. This means that developers have less work through automation , that the code looks more professional, that we are more likely to pick up on errors, etc...

# why here and now?

The background is that I did around five hours worth of work on Silverstripe Framework (see: https://github.com/silverstripe/silverstripe-framework/pull/9625), but it was just to big, so it makes more sense to run it on a smaller module first - check the result, improve and in this way keep creating pull requests until it is good enough... In other words, I need to know why this pull request will be rejected.

  - https://github.com/silverstripe/silverstripe-framework/issues/9616
  - https://github.com/silverstripe/silverstripe-framework/pull/9103
  - https://github.com/silverstripe/silverstripe-framework/issues/7899

There are a couple of things I can see already (e.g. changing `==` to `===` is obviously TOO MUCH).

# Rules applied:

 * https://github.com/sunnysideup/silverstripe-easy-coding-standards/blob/master/rector.php
 * https://github.com/sunnysideup/silverstripe-easy-coding-standards/blob/master/ecs.php
 * for stan, we are doing level 2

# Why and what was changed
see changes here, but also review:

 - TMP_LINTING_NOTES_ECS
 - TMP_LINTING_NOTES_RECTOR
 - TMP_LINTING_NOTES_STAN

These files need to be deleted, but they are useful for now as they show us the rules applies

# How to try this at home?

To try this out for yourself on a module, run:
```shell
composer global require sunnysideup/easy-coding-standards:dev-master
composer global update
```

Then run:
```shell
git clone [REPO]
cd [REPO]
composer install
echo "/vendor/" >> .gitignore
echo "/resources/" >> .gitignore
sslint-ecs src/ > TMP_LINTING_NOTES_ECS
sslint-rector src/ > TMP_LINTING_NOTES_RECTOR
sslint-stan -l 2 src/ > TMP_LINTING_NOTES_STAN
git add .  -A
git commit . -m "MY TEST"
```

# what shall we do now?

The idea is that we:

1. work out what rules should be in / out.
    - should we apply one rule at the time?
    - should we go for as many rules as possible or as few as useful?
    - rector rules are here: https://github.com/rectorphp/rector/blob/main/docs/rector_rules_overview.md, we should also look up ecs rules ...
    - STAN results, that do not fix anything should be saved as `KNOWN_ISSUES`.


2. work out a good time and branch to apply this lint
    - it will lead to merge conflicts from other pull request

3. run it on all modules
    - include as CI?
    - how to apply to 100s of modules easily?

# what to add:

https://github.com/silverleague/silverstripe-ideannotator/blob/master/docs/en/Installation.md


# current rules

## ecs
```shell
ecs show --config [location of config file]
```
4 checkers from PHP_CodeSniffer:
--------------------------------

 * PHP_CodeSniffer\Standards\Generic\Sniffs\CodeAnalysis\AssignmentInConditionSniff
 * PHP_CodeSniffer\Standards\Generic\Sniffs\VersionControl\GitMergeConflictSniff
 * PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\LanguageConstructSpacingSniff
 * PHP_CodeSniffer\Standards\Squiz\Sniffs\WhiteSpace\SuperfluousWhitespaceSniff

96 checkers from PHP-CS-Fixer:
------------------------------

 * PhpCsFixer\Fixer\ArrayNotation\ArraySyntaxFixer
 * PhpCsFixer\Fixer\ArrayNotation\NoTrailingCommaInSinglelineArrayFixer
 * PhpCsFixer\Fixer\ArrayNotation\NoWhitespaceBeforeCommaInArrayFixer
 * PhpCsFixer\Fixer\ArrayNotation\TrailingCommaInMultilineArrayFixer
 * PhpCsFixer\Fixer\ArrayNotation\TrimArraySpacesFixer
 * PhpCsFixer\Fixer\ArrayNotation\WhitespaceAfterCommaInArrayFixer
 * PhpCsFixer\Fixer\Basic\BracesFixer
 * PhpCsFixer\Fixer\Basic\EncodingFixer
 * PhpCsFixer\Fixer\Casing\ConstantCaseFixer
 * PhpCsFixer\Fixer\Casing\LowercaseKeywordsFixer
 * PhpCsFixer\Fixer\Casing\MagicConstantCasingFixer
 * PhpCsFixer\Fixer\CastNotation\CastSpacesFixer
 * PhpCsFixer\Fixer\CastNotation\LowercaseCastFixer
 * PhpCsFixer\Fixer\CastNotation\ShortScalarCastFixer
 * PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer
 * PhpCsFixer\Fixer\ClassNotation\ClassDefinitionFixer
 * PhpCsFixer\Fixer\ClassNotation\NoBlankLinesAfterClassOpeningFixer
 * PhpCsFixer\Fixer\ClassNotation\OrderedClassElementsFixer
 * PhpCsFixer\Fixer\ClassNotation\ProtectedToPrivateFixer
 * PhpCsFixer\Fixer\ClassNotation\SelfAccessorFixer
 * PhpCsFixer\Fixer\ClassNotation\SingleClassElementPerStatementFixer
 * PhpCsFixer\Fixer\ClassNotation\SingleTraitInsertPerStatementFixer
 * PhpCsFixer\Fixer\ClassNotation\VisibilityRequiredFixer
 * PhpCsFixer\Fixer\Comment\NoTrailingWhitespaceInCommentFixer
 * PhpCsFixer\Fixer\ControlStructure\ElseifFixer
 * PhpCsFixer\Fixer\ControlStructure\NoBreakCommentFixer
 * PhpCsFixer\Fixer\ControlStructure\NoUnneededControlParenthesesFixer
 * PhpCsFixer\Fixer\ControlStructure\NoUnneededCurlyBracesFixer
 * PhpCsFixer\Fixer\ControlStructure\NoUselessElseFixer
 * PhpCsFixer\Fixer\ControlStructure\SwitchCaseSemicolonToColonFixer
 * PhpCsFixer\Fixer\ControlStructure\SwitchCaseSpaceFixer
 * PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer
 * PhpCsFixer\Fixer\FunctionNotation\FunctionDeclarationFixer
 * PhpCsFixer\Fixer\FunctionNotation\FunctionTypehintSpaceFixer
 * PhpCsFixer\Fixer\FunctionNotation\MethodArgumentSpaceFixer
 * PhpCsFixer\Fixer\FunctionNotation\NoSpacesAfterFunctionNameFixer
 * PhpCsFixer\Fixer\FunctionNotation\ReturnTypeDeclarationFixer
 * PhpCsFixer\Fixer\Import\NoLeadingImportSlashFixer
 * PhpCsFixer\Fixer\Import\NoUnusedImportsFixer
 * PhpCsFixer\Fixer\Import\OrderedImportsFixer
 * PhpCsFixer\Fixer\Import\SingleLineAfterImportsFixer
 * PhpCsFixer\Fixer\LanguageConstruct\DeclareEqualNormalizeFixer
 * PhpCsFixer\Fixer\LanguageConstruct\ExplicitIndirectVariableFixer
 * PhpCsFixer\Fixer\LanguageConstruct\FunctionToConstantFixer
 * PhpCsFixer\Fixer\LanguageConstruct\IsNullFixer
 * PhpCsFixer\Fixer\NamespaceNotation\BlankLineAfterNamespaceFixer
 * PhpCsFixer\Fixer\NamespaceNotation\NoLeadingNamespaceWhitespaceFixer
 * PhpCsFixer\Fixer\NamespaceNotation\SingleBlankLineBeforeNamespaceFixer
 * PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer
 * PhpCsFixer\Fixer\Operator\ConcatSpaceFixer
 * PhpCsFixer\Fixer\Operator\NewWithBracesFixer
 * PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer
 * PhpCsFixer\Fixer\Operator\StandardizeIncrementFixer
 * PhpCsFixer\Fixer\Operator\TernaryOperatorSpacesFixer
 * PhpCsFixer\Fixer\Operator\UnaryOperatorSpacesFixer
 * PhpCsFixer\Fixer\PhpTag\BlankLineAfterOpeningTagFixer
 * PhpCsFixer\Fixer\PhpTag\FullOpeningTagFixer
 * PhpCsFixer\Fixer\PhpTag\NoClosingTagFixer
 * PhpCsFixer\Fixer\PhpUnit\PhpUnitMethodCasingFixer
 * PhpCsFixer\Fixer\PhpUnit\PhpUnitSetUpTearDownVisibilityFixer
 * PhpCsFixer\Fixer\PhpUnit\PhpUnitStrictFixer
 * PhpCsFixer\Fixer\PhpUnit\PhpUnitTestAnnotationFixer
 * PhpCsFixer\Fixer\Phpdoc\NoEmptyPhpdocFixer
 * PhpCsFixer\Fixer\Phpdoc\NoSuperfluousPhpdocTagsFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocIndentFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocLineSpanFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocNoEmptyReturnFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocReturnSelfReferenceFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocSingleLineVarSpacingFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocTrimConsecutiveBlankLineSeparationFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocTrimFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocTypesFixer
 * PhpCsFixer\Fixer\Phpdoc\PhpdocVarWithoutNameFixer
 * PhpCsFixer\Fixer\Semicolon\NoEmptyStatementFixer
 * PhpCsFixer\Fixer\Semicolon\NoSinglelineWhitespaceBeforeSemicolonsFixer
 * PhpCsFixer\Fixer\Semicolon\SpaceAfterSemicolonFixer
 * PhpCsFixer\Fixer\Strict\StrictComparisonFixer
 * PhpCsFixer\Fixer\Strict\StrictParamFixer
 * PhpCsFixer\Fixer\StringNotation\ExplicitStringVariableFixer
 * PhpCsFixer\Fixer\StringNotation\SingleQuoteFixer
 * PhpCsFixer\Fixer\Whitespace\ArrayIndentationFixer
 * PhpCsFixer\Fixer\Whitespace\IndentationTypeFixer
 * PhpCsFixer\Fixer\Whitespace\LineEndingFixer
 * PhpCsFixer\Fixer\Whitespace\MethodChainingIndentationFixer
 * PhpCsFixer\Fixer\Whitespace\NoSpacesAroundOffsetFixer
 * PhpCsFixer\Fixer\Whitespace\NoSpacesInsideParenthesisFixer
 * PhpCsFixer\Fixer\Whitespace\NoTrailingWhitespaceFixer
 * PhpCsFixer\Fixer\Whitespace\NoWhitespaceInBlankLineFixer
 * PhpCsFixer\Fixer\Whitespace\SingleBlankLineAtEofFixer
 * Symplify\CodingStandard\Fixer\ArrayNotation\ArrayListItemNewlineFixer
 * Symplify\CodingStandard\Fixer\ArrayNotation\ArrayOpenerAndCloserNewlineFixer
 * Symplify\CodingStandard\Fixer\ArrayNotation\StandaloneLineInMultilineArrayFixer
 * Symplify\CodingStandard\Fixer\Commenting\ParamReturnAndVarTagMalformsFixer
 * Symplify\CodingStandard\Fixer\Commenting\RemoveUselessDefaultCommentFixer
 * Symplify\CodingStandard\Fixer\Spacing\NewlineServiceDefinitionConfigFixer
 * Symplify\CodingStandard\Fixer\Spacing\StandaloneLinePromotedPropertyFixer



 [OK] Loaded 100 checkers in total                                                                                      


Loaded Sets
===========

 * ../../symplify/easy-coding-standard/config/set/clean-code.php
 * ../../symplify/easy-coding-standard/config/set/common.php
 * ../../symplify/easy-coding-standard/config/set/common/comments.php
 * ../../symplify/easy-coding-standard/config/set/common/docblock.php
 * ../../symplify/easy-coding-standard/config/set/common/namespaces.php
 * ../../symplify/easy-coding-standard/config/set/psr12.php

## rector

```shell
rector show --config [location of config file]
```


Loaded Rector rules
===================

 * Rector\CodeQuality\Rector\Array_\ArrayThisCallToThisMethodCallRector
 * Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector
 * Rector\CodeQuality\Rector\Assign\CombinedAssignRector
 * Rector\CodeQuality\Rector\Assign\SplitListAssignToSeparateLineRector
 * Rector\CodeQuality\Rector\BooleanAnd\SimplifyEmptyArrayCheckRector
 * Rector\CodeQuality\Rector\BooleanNot\SimplifyDeMorganBinaryRector
 * Rector\CodeQuality\Rector\Catch_\ThrowWithPreviousExceptionRector
 * Rector\CodeQuality\Rector\ClassMethod\DateTimeToDateTimeInterfaceRector
 * Rector\CodeQuality\Rector\Class_\CompleteDynamicPropertiesRector
 * Rector\CodeQuality\Rector\Concat\JoinStringConcatRector
 * Rector\CodeQuality\Rector\Equal\UseIdenticalOverEqualWithSameTypeRector
 * Rector\CodeQuality\Rector\Expression\InlineIfToExplicitIfRector
 * Rector\CodeQuality\Rector\For_\ForRepeatedCountToOwnVariableRector
 * Rector\CodeQuality\Rector\For_\ForToForeachRector
 * Rector\CodeQuality\Rector\Foreach_\ForeachItemsAssignToEmptyArrayToAssignRector
 * Rector\CodeQuality\Rector\Foreach_\ForeachToInArrayRector
 * Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToArrayFilterRector
 * Rector\CodeQuality\Rector\Foreach_\SimplifyForeachToCoalescingRector
 * Rector\CodeQuality\Rector\Foreach_\UnusedForeachValueToArrayKeysRector
 * Rector\CodeQuality\Rector\FuncCall\AddPregQuoteDelimiterRector
 * Rector\CodeQuality\Rector\FuncCall\ArrayKeysAndInArrayToArrayKeyExistsRector
 * Rector\CodeQuality\Rector\FuncCall\ArrayMergeOfNonArraysToSimpleArrayRector
 * Rector\CodeQuality\Rector\FuncCall\ChangeArrayPushToArrayAssignRector
 * Rector\CodeQuality\Rector\FuncCall\CompactToVariablesRector
 * Rector\CodeQuality\Rector\FuncCall\InArrayAndArrayKeysToArrayKeyExistsRector
 * Rector\CodeQuality\Rector\FuncCall\IntvalToTypeCastRector
 * Rector\CodeQuality\Rector\FuncCall\IsAWithStringWithThirdArgumentRector
 * Rector\CodeQuality\Rector\FuncCall\RemoveSoleValueSprintfRector
 * Rector\CodeQuality\Rector\FuncCall\SetTypeToCastRector
 * Rector\CodeQuality\Rector\FuncCall\SimplifyFuncGetArgsCountRector
 * Rector\CodeQuality\Rector\FuncCall\SimplifyInArrayValuesRector
 * Rector\CodeQuality\Rector\FuncCall\SimplifyRegexPatternRector
 * Rector\CodeQuality\Rector\FuncCall\SimplifyStrposLowerRector
 * Rector\CodeQuality\Rector\FuncCall\SingleInArrayToCompareRector
 * Rector\CodeQuality\Rector\FuncCall\UnwrapSprintfOneArgumentRector
 * Rector\CodeQuality\Rector\FunctionLike\RemoveAlwaysTrueConditionSetInConstructorRector
 * Rector\CodeQuality\Rector\Identical\BooleanNotIdenticalToNotIdenticalRector
 * Rector\CodeQuality\Rector\Identical\GetClassToInstanceOfRector
 * Rector\CodeQuality\Rector\Identical\SimplifyArraySearchRector
 * Rector\CodeQuality\Rector\Identical\SimplifyBoolIdenticalTrueRector
 * Rector\CodeQuality\Rector\Identical\SimplifyConditionsRector
 * Rector\CodeQuality\Rector\Identical\StrlenZeroToIdenticalEmptyStringRector
 * Rector\CodeQuality\Rector\If_\ConsecutiveNullCompareReturnsToNullCoalesceQueueRector
 * Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector
 * Rector\CodeQuality\Rector\If_\ShortenElseIfRector
 * Rector\CodeQuality\Rector\If_\SimplifyIfElseToTernaryRector
 * Rector\CodeQuality\Rector\If_\SimplifyIfIssetToNullCoalescingRector
 * Rector\CodeQuality\Rector\If_\SimplifyIfNotNullReturnRector
 * Rector\CodeQuality\Rector\If_\SimplifyIfReturnBoolRector
 * Rector\CodeQuality\Rector\Include_\AbsolutizeRequireAndIncludePathRector
 * Rector\CodeQuality\Rector\Isset_\IssetOnPropertyObjectToPropertyExistsRector
 * Rector\CodeQuality\Rector\LogicalAnd\AndAssignsToSeparateLinesRector
 * Rector\CodeQuality\Rector\LogicalAnd\LogicalToBooleanRector
 * Rector\CodeQuality\Rector\Name\FixClassCaseSensitivityNameRector
 * Rector\CodeQuality\Rector\New_\NewStaticToNewSelfRector
 * Rector\CodeQuality\Rector\NotEqual\CommonNotEqualRector
 * Rector\CodeQuality\Rector\Switch_\SingularSwitchToIfRector
 * Rector\CodeQuality\Rector\Ternary\ArrayKeyExistsTernaryThenValueToCoalescingRector
 * Rector\CodeQuality\Rector\Ternary\SimplifyDuplicatedTernaryRector
 * Rector\CodeQuality\Rector\Ternary\SimplifyTautologyTernaryRector
 * Rector\CodeQuality\Rector\Ternary\SwitchNegatedTernaryRector
 * Rector\CodeQuality\Rector\Ternary\UnnecessaryTernaryExpressionRector
 * Rector\CodingStyle\Rector\Assign\ManualJsonStringToJsonEncodeArrayRector
 * Rector\CodingStyle\Rector\Assign\PHPStormVarAnnotationRector
 * Rector\CodingStyle\Rector\Assign\SplitDoubleAssignRector
 * Rector\CodingStyle\Rector\Catch_\CatchExceptionNameMatchingTypeRector
 * Rector\CodingStyle\Rector\ClassConst\SplitGroupedConstantsAndPropertiesRector
 * Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector
 * Rector\CodingStyle\Rector\ClassMethod\MakeInheritedMethodVisibilitySameAsParentRector
 * Rector\CodingStyle\Rector\ClassMethod\NewlineBeforeNewAssignSetRector
 * Rector\CodingStyle\Rector\ClassMethod\RemoveDoubleUnderscoreInMethodNameRector
 * Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector
 * Rector\CodingStyle\Rector\Class_\AddArrayDefaultToArrayPropertyRector
 * Rector\CodingStyle\Rector\Encapsed\WrapEncapsedVariableInCurlyBracesRector
 * Rector\CodingStyle\Rector\FuncCall\CallUserFuncCallToVariadicRector
 * Rector\CodingStyle\Rector\FuncCall\ConsistentImplodeRector
 * Rector\CodingStyle\Rector\FuncCall\ConsistentPregDelimiterRector
 * Rector\CodingStyle\Rector\FuncCall\VersionCompareFuncCallToConstantRector
 * Rector\CodingStyle\Rector\If_\NullableCompareToNullRector
 * Rector\CodingStyle\Rector\Include_\FollowRequireByDirRector
 * Rector\CodingStyle\Rector\MethodCall\UseMessageVariableForSprintfInSymfonyStyleRector
 * Rector\CodingStyle\Rector\Plus\UseIncrementAssignRector
 * Rector\CodingStyle\Rector\PostInc\PostIncDecToPreIncDecRector
 * Rector\CodingStyle\Rector\Property\AddFalseDefaultToBoolPropertyRector
 * Rector\CodingStyle\Rector\String_\SplitStringClassConstantToClassConstFetchRector
 * Rector\CodingStyle\Rector\String_\SymplifyQuoteEscapeRector
 * Rector\CodingStyle\Rector\Switch_\BinarySwitchToIfElseRector
 * Rector\CodingStyle\Rector\Ternary\TernaryConditionVariableAssignmentRector
 * Rector\CodingStyle\Rector\Use_\RemoveUnusedAliasRector
 * Rector\CodingStyle\Rector\Use_\SplitGroupedUseImportsRector
 * Rector\DeadCode\Rector\Array_\RemoveDuplicatedArrayKeyRector
 * Rector\DeadCode\Rector\Assign\RemoveAssignOfVoidReturnFunctionRector
 * Rector\DeadCode\Rector\Assign\RemoveDoubleAssignRector
 * Rector\DeadCode\Rector\BinaryOp\RemoveDuplicatedInstanceOfRector
 * Rector\DeadCode\Rector\BooleanAnd\RemoveAndTrueRector
 * Rector\DeadCode\Rector\Cast\RecastingRemovalRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveDeadConstructorRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveDelegatingParentCallRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveEmptyClassMethodRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveUnusedPrivateMethodRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveUselessParamTagRector
 * Rector\DeadCode\Rector\ClassMethod\RemoveUselessReturnTagRector
 * Rector\DeadCode\Rector\Concat\RemoveConcatAutocastRector
 * Rector\DeadCode\Rector\Expression\RemoveDeadStmtRector
 * Rector\DeadCode\Rector\Expression\SimplifyMirrorAssignRector
 * Rector\DeadCode\Rector\For_\RemoveDeadIfForeachForRector
 * Rector\DeadCode\Rector\For_\RemoveDeadLoopRector
 * Rector\DeadCode\Rector\Foreach_\RemoveUnusedForeachKeyRector
 * Rector\DeadCode\Rector\FunctionLike\RemoveCodeAfterReturnRector
 * Rector\DeadCode\Rector\FunctionLike\RemoveDeadReturnRector
 * Rector\DeadCode\Rector\FunctionLike\RemoveDuplicatedIfReturnRector
 * Rector\DeadCode\Rector\FunctionLike\RemoveOverriddenValuesRector
 * Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector
 * Rector\DeadCode\Rector\If_\RemoveUnusedNonEmptyArrayBeforeForeachRector
 * Rector\DeadCode\Rector\If_\SimplifyIfElseWithSameContentRector
 * Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfFunctionExistsRector
 * Rector\DeadCode\Rector\If_\UnwrapFutureCompatibleIfPhpVersionRector
 * Rector\DeadCode\Rector\MethodCall\RemoveDefaultArgumentValueRector
 * Rector\DeadCode\Rector\MethodCall\RemoveEmptyMethodCallRector
 * Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector
 * Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector
 * Rector\DeadCode\Rector\Return_\RemoveDeadConditionAboveReturnRector
 * Rector\DeadCode\Rector\StaticCall\RemoveParentCallWithoutParentRector
 * Rector\DeadCode\Rector\Stmt\RemoveUnreachableStatementRector
 * Rector\DeadCode\Rector\Switch_\RemoveDuplicatedCaseInSwitchRector
 * Rector\DeadCode\Rector\Ternary\TernaryToBooleanOrFalseToBooleanAndRector
 * Rector\DeadCode\Rector\TryCatch\RemoveDeadTryCatchRector
 * Rector\PHPUnit\Rector\ClassMethod\RemoveEmptyTestMethodRector
 * Rector\Php52\Rector\Property\VarToPublicPropertyRector
 * Rector\Php55\Rector\String_\StringClassNameToClassConstantRector
 * Rector\Php71\Rector\FuncCall\RemoveExtraParametersRector
 * Rector\Renaming\Rector\FuncCall\RenameFunctionRector
 * Rector\Transform\Rector\FuncCall\FuncCallToConstFetchRector


 [OK] 133 loaded Rectors                                                                                                




Loaded Sets
===========

 * ../../rector/rector/config/set/code-quality.php
 * ../../rector/rector/config/set/coding-style.php
 * ../../rector/rector/config/set/dead-code.php
