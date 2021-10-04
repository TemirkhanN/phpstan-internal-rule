<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class InternalTraitInAnotherTraitUsageRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalTraitInAnotherTraitUsageRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__.'/data/internal-trait-usage-rule-violation.php'
            ],
            [
                [
                    'Internal trait Some\Package\InternalTrait is used in Another\Package\DeepTrait',
                    54
                ],
                [
                    'Internal trait Another\DifferentPackage\OneInternalTrait is used in Another\Package\TrickyTrait',
                    59
                ],
            ],
        );
    }
}
