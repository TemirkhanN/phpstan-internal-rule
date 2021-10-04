<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PhpParser\Node;
use PhpParser\Node\Stmt\TraitUse;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;

class InternalTraitUsageRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return TraitUse::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        assert($node instanceof TraitUse);

        // Indirect usage detection is not part of the rule. If the trait uses internal trait it has to be
        // validated by @see InternalTraitInAnotherTraitUsageRule
        if ($scope->isInTrait()) {
            return [];
        }

        $errors = [];
        $usedBy = $scope->getClassReflection()->getName();

        foreach ($node->traits as $traitName) {
            $traitInfo = $this->reflectionProvider->getClass((string)$traitName);
            if (!$traitInfo->isInternal()) {
                continue;
            }

            if (!NamespaceChecker::arePartOfTheSamePackage(
                $scope->getNamespace(),
                $traitInfo->getNativeReflection()->getNamespaceName())
            ) {
                $errors[] = sprintf('Internal trait %s is used in %s', $traitInfo->getName(), $usedBy);
            }
        }

        return $errors;
    }
}
