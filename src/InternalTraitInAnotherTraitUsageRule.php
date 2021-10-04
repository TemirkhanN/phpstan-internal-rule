<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;
use PhpParser\Node\Stmt\TraitUse;

class InternalTraitInAnotherTraitUsageRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Node\Stmt\Trait_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        assert($node instanceof Node\Stmt\Trait_);

        $errors = [];
        foreach ($node->stmts as $stmt) {
            if ($stmt instanceof TraitUse) {
                $errors += $this->processTraitInsideTraitUsage($node->namespacedName->toString(), $stmt, $scope);
            }
        }

        return $errors;
    }

    private function processTraitInsideTraitUsage(string $parentTrade, TraitUse $node, Scope $scope): array
    {
        $errors = [];
        foreach ($node->traits as $traitName) {
            $traitInfo = $this->reflectionProvider->getClass((string)$traitName);
            if (!$traitInfo->isInternal()) {
                continue;
            }

            if (
                !NamespaceChecker::arePartOfTheSamePackage(
                    $scope->getNamespace(),
                    $traitInfo->getNativeReflection()->getNamespaceName()
                )
            ) {
                $errors[] = sprintf('Internal trait %s is used in %s', $traitInfo->getName(), $parentTrade);
            }
        }

        return $errors;
    }
}
