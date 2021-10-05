<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class InternalFunctionCallRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalFunctionCallRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/data/internal-function-call-violation.php',
            ],
            [
                [
                    'Call of internal function Some\PackageD\someInternalFunction',
                    28,
                ],
                [
                    'Call of internal function internalFunction',
                    46,
                ],
                [
                    'Call of internal function internalFunction',
                    62,
                ],
                [
                    'Call of internal function Some\PackageD\someInternalFunction',
                    71,
                ],
                [
                    'Call of internal function internalFunction',
                    77,
                ],
            ],
        );
    }
}
