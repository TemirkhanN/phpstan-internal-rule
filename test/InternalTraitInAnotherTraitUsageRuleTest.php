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
                __DIR__ . '/data/internal-trait-usage-rule-violation.php',
            ],
            [
                [
                    'Internal trait Some\PackageC\InternalTrait is used in Another\PackageC\DeepTrait',
                    55,
                ],
                [
                    'Internal trait Another\DifferentPackage\OneInternalTrait is used in Another\PackageC\TrickyTrait',
                    60,
                ],
            ],
        );
    }
}
