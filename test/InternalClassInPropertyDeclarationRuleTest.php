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
                    46
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    49
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    55
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    65
                ],
                [
                    'Internal class Some\Package\SomeInternalClass is used in type declaration.',
                    75
                ],
            ],
        );
    }
}
