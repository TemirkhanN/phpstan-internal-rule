<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class InternalClassInstantiationRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalClassInstantiationRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__.'/data/internal-class-instantiation-rule-violation.php'
            ],
            [
                [
                    'Instantiation of internal class Some\Package\SomeClass.',
                    53
                ],
                [
                    'Instantiation of internal class Some\Package\SomeClass.',
                    61,
                ],
                [
                    'Instantiation of internal class Some\Package\SomeClass.',
                    69,
                ],
            ],
        );
    }
}
