<?php

declare(strict_types=1);

namespace Temirkhan\PhpstanInternalRule;

use PhpParser\Node;
use PHPStan\Analyser\Scope;
use PHPStan\Node\ClassPropertyNode;
use PHPStan\Reflection\ReflectionProvider;
use PHPStan\Rules\Rule;

/**
 * Rule that checks if declared property type is internal and comes from the same package
 */
class InternalClassInPropertyDeclarationRule implements Rule
{
    private ReflectionProvider $reflectionProvider;

    public function __construct(ReflectionProvider $reflectionProvider)
    {
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getNodeType(): string
    {
        return ClassPropertyNode::class;
    }

    public function processNode(Node $node, Scope $scope): array
    {
        $errors = [];

        assert($node instanceof ClassPropertyNode);
        foreach ($this->getPropertyClassTypes($node, $scope) as $class) {
            $classInfo = $this->reflectionProvider->getClass($class);
            if (!$classInfo->isInternal()) {
                continue;
            }

            $additionalInfo = $classInfo->getNativeReflection();

            if (!NamespaceChecker::arePartOfTheSamePackage(
                $scope->getNamespace(),
                $additionalInfo->getNamespaceName()
            )) {
                $errors[] = sprintf('Internal class %s is used in type declaration.', $classInfo->getName());
            }
        }

        return $errors;
    }

    /**
     * @param ClassPropertyNode $node
     * @param Scope             $scope
     *
     * @return string[]
     */
    private function getPropertyClassTypes(ClassPropertyNode $node, Scope $scope): array
    {
        $propertyReflection = $scope->getClassReflection()->getNativeProperty($node->getName());
        $type               = $propertyReflection->getReadableType();

        return $type->getReferencedClasses();
    }
}
