<?php

declare(strict_types=1);

namespace Some\Package {

    use Another\Package\AnotherClass;

    /**
     * @internal
     */
    class SomeInternalClass
    {

    }

    class SomePublicClass
    {
        private SomeInternalClass $validProperty;
        private ?SomeInternalClass $validNullableProperty;

        /**
         * @var SomeInternalClass
         */
        private $validPhpDocumentedProperty;

        /**
         * @var ?SomeInternalClass
         */
        private $validPhpDocumentedNullableProperty;

        /**
         * @var AnotherClass|SomeInternalClass
         */
        private $validMultiTypeProperty;
    }
}

namespace Another\Package {

    use Some\Package\SomeInternalClass;
    use Some\Package\SomePublicClass;

    class AnotherClass
    {
        private SomeInternalClass $invalidProperty;
        private SomePublicClass   $validProperty;

        private ?SomeInternalClass $invalidNullableProperty;
        private ?SomePublicClass   $validNullableProperty;

        /**
         * @var SomeInternalClass
         */
        private $invalidPhpDocumentedProperty;

        /**
         * @var SomePublicClass
         */
        private $validPhpDocumentedProperty;

        /**
         * @var ?SomeInternalClass
         */
        private $invalidPhpDocumentedNullableProperty;

        /**
         * @var ?SomePublicClass
         */
        private $validPhpDocumentedNullableProperty;

        /**
         * @var SomeInternalClass|SomePublicClass
         */
        private $invalidMultiTypeProperty;

        #/**
        # * @TODO this shall result in error but I don't know how to check it properly
        # * @var SomeInternalClass|SomePublicClass|mixed
        # */
        #private $invalidMultiTypePropertyWithMixedType;

        /**
         * @var SomePublicClass|\stdClass
         */
        private $validMultiTypeProperty;
    }
}
