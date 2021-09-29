<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;

class InternalClassInstantiationRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return Node\Expr\New_::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        assert($node instanceof Node\Expr\New_);

        $classInfo = $this->getInstantiatedClassInfo($node, $scope);

        if ($classInfo === null) {
            return [];
        }

        $additionalInfo = $classInfo->getNativeReflection();

        // Internal classes in top level namespace are meaningless and should be ignored
        if (!$additionalInfo->inNamespace() || !$classInfo->isInternal()) {
            return [];
        }

        if (!$this->arePartOfTheSamePackage($scope->getNamespace(), $additionalInfo->getNamespaceName())) {
            return [
                sprintf('Instantiation of internal class %s.', $classInfo->getName())
            ];
        }

        return [];
    }

    private function getInstantiatedClassInfo(Node\Expr\New_ $node, Scope $scope): ?ClassReflection
    {
        $className = null;
        if ($node->class instanceof Node\Name) {
            $className = $scope->resolveName($node->class);
        }

        if ($className === null) {
            return null;
        }

        return $this->reflectionProvider->getClass($className);
    }

    private function arePartOfTheSamePackage(string $someNamespace, string $anotherNamespace): bool
    {
        if ($someNamespace === $anotherNamespace) {
            return true;
        }

        $someNamespaceParts    = explode('\\', $someNamespace);
        $anotherNamespaceParts = explode('\\', $anotherNamespace);

        foreach ($someNamespaceParts as $key => $part) {
            if (!isset($anotherNamespaceParts[$key])) {
                break;
            }

            if ($anotherNamespaceParts[$key] !== $part) {
                return false;
            }
        }

        return true;
    }
}
