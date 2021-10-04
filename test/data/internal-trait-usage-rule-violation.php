<?php

declare(strict_types=1);

namespace Some\Package {
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
namespace Another\Package {

    use Another\DifferentPackage\OneInternalTrait;
    use Another\DifferentPackage\OnePublicTrait;
    use Some\Package\InternalTrait;
    use Some\Package\PublicTrait;

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
