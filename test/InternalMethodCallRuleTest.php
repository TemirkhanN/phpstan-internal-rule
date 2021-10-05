<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PHPStan\Rules\Rule;
use PHPStan\Testing\RuleTestCase;

class InternalMethodCallRuleTest extends RuleTestCase
{
    protected function getRule(): Rule
    {
        return new InternalMethodCallRule($this->createReflectionProvider());
    }

    public function testRule(): void
    {
        $this->analyse(
            [
                __DIR__ . '/data/internal-method-call-rule-violation.php',
            ],
            [
                [
                    'Call to internal method SomeClassE::someRootNamespaceInternalMethod',
                    53,
                ],
                [
                    'Call to internal method SomeClassE::someRootNamespaceInternalMethod',
                    82,
                ],
                [
                    'Call to internal method SomeClassE::someRootNamespaceInternalMethod',
                    90,
                ],
                [
                    'Call to internal method Some\PackageE\SomeClass::someInternalMethod',
                    96,
                ],
                [
                    'Call to internal method SomeClassE::someRootNamespaceInternalMethod',
                    104,
                ],
                [
                    'Call to internal method Some\PackageE\SomeClass::someInternalMethod',
                    110,
                ],
                [
                    'Call to internal method Some\PackageE\AnotherClass::someInternalMethod',
                    116,
                ],
            ],
        );
    }
}
