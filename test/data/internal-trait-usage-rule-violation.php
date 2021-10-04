<?php

declare(strict_types=1);

namespace Some\PackageC {
    /**
     * @internal
     */
    trait InternalTrait
    {

    }

    trait PublicTrait
    {
        use InternalTrait;
    }

    class SomeClass
    {
        use InternalTrait;
    }
}

namespace Another\DifferentPackage {
    /**
     * @internal
     */
    trait OneInternalTrait
    {

    }

    trait OnePublicTrait
    {

    }
}

namespace Another\PackageC {

    use Another\DifferentPackage\OneInternalTrait;
    use Another\DifferentPackage\OnePublicTrait;
    use Some\PackageC\InternalTrait;
    use Some\PackageC\PublicTrait;

    /**
     * @internal
     */
    trait AnotherTrait
    {
        use PublicTrait;
    }

    trait DeepTrait
    {
        use InternalTrait;
    }

    trait TrickyTrait
    {
        use DeepTrait, OneInternalTrait;
    }

    class SomeClass
    {
        use PublicTrait;
    }

    class AnotherClass
    {
        use AnotherTrait, OnePublicTrait;
    }

    class MultiTraitClass
    {
        use PublicTrait, AnotherTrait, InternalTrait;
    }

    class YetAnotherClass
    {
        use TrickyTrait;
    }
}

namespace {

    use Another\DifferentPackage\OneInternalTrait;

    class OneMoreClass
    {
        use OneInternalTrait;
    }
}
