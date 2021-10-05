<?php

declare(strict_types=1);

namespace {
    class SomeClassE
    {
        /**
         * @internal
         */
        public function someRootNamespaceInternalMethod(): void
        {

        }

        public function somePublicMethod(): void
        {

        }
    }

    $class = new SomeClassE();
    // Valid. From same namespace
    $class->someRootNamespaceInternalMethod();
    // Valid. common
    $class->somePublicMethod();
}

namespace Some\PackageE {
    class SomeClass
    {
        /**
         * @internal
         */
        public function someInternalMethod(): void
        {

        }

        public function somePublicMethod(): void
        {

        }
    }

    class AnotherClass extends SomeClass
    {

    }

    $class = new \SomeClassE();
    // Invalid. From root namespace
    $class->someRootNamespaceInternalMethod();
    // Valid. Common
    $class->somePublicMethod();

    $anotherClass = new SomeClass();
    // Valid. from same package
    $anotherClass->someInternalMethod();
    // Valid. common
    $anotherClass->somePublicMethod();

    $subpackageClass = new \Some\PackageE\Subpackage\SomeClass();
    // Valid. call internal method of subpackage
    $subpackageClass->internalMethod();
}

namespace Some\PackageE\Subpackage {
    class SomeClass
    {
        /**
         * @internal
         */
        public function internalMethod(): void
        {

        }
    }

    $rootClass = new \SomeClassE();
    // Invalid. From root namespace
    $rootClass->someRootNamespaceInternalMethod();
    // Valid. common
    $rootClass->somePublicMethod();
}

namespace AnotherVendor\PackageE {
    $class = new \SomeClassE();
    // Invalid. From root namespace
    $class->someRootNamespaceInternalMethod();
    // Valid. common
    $class->somePublicMethod();

    $anotherClass = new \Some\PackageE\SomeClass();
    // Invalid. Attempt to call internal method of another package
    $anotherClass->someInternalMethod();
    // Valid. common
    $anotherClass->somePublicMethod();
}

namespace Some\AnotherPackageE {
    $rootClass = new \SomeClassE();
    // Invalid. From root namespace
    $rootClass->someRootNamespaceInternalMethod();
    // Valid. Common
    $rootClass->somePublicMethod();

    $someClass = new \Some\PackageE\SomeClass();
    // Invalid. Attempt to call internal method of another package
    $someClass->someInternalMethod();
    // Valid. Common
    $someClass->somePublicMethod();

    $inheritedClass = new \Some\PackageE\AnotherClass();
    // Invalid. Attempt to call internal method of another package
    $inheritedClass->someInternalMethod();
    // Valid. Common
    $inheritedClass->somePublicMethod();
}
