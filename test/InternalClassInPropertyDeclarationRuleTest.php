<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class InternalClassInPropertyDeclarationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalClassInPropertyDeclarationRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__.'/data/internal-class-in-property-declaration-rule-violation.php'
            ],
            [
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    83
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    86
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    92
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    102
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    112
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    135
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    138
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    144
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    154
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    164
                ],
            ],
        );
    }
}
