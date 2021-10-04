<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Testing\RuleTestCase;
use PHPStan\Rules\Rule;

class InternalTraitUsageRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalTraitUsageRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__.'/data/internal-trait-usage-rule-violation.php'
            ],
            [
                [
                    'Internal trait Some\PackageC\InternalTrait is used in Another\PackageC\MultiTraitClass',
                    77
                ],
                [
                    'Internal trait Another\DifferentPackage\OneInternalTrait is used in OneMoreClass',
                    92,
                ]
            ],
        );
    }
}
