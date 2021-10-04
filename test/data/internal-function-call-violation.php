<?php

declare(strict_types=1);

namespace {

    use function Some\PackageD\someInternalFunction;

    /**
     * @internal
     */
    function meaninglessInternalTaggedFunction(): void
    {

    }

    /**
     * @internal
     */
    $ofCourseIAmInternal = function (): void {

    };

    $ofCourseIAmInternal();

    meaninglessInternalTaggedFunction();

    someInternalFunction();
}

namespace Some\PackageD {
    /**
     * @internal
     */
    function someInternalFunction(): void
    {

    }

    function somePublicFunction(): void
    {
        // valid. Inside same package
        \Some\PackageD\someInternalFunction();

        // valid. Edge-case
        meaninglessInternalTaggedFunction();
    }
}

namespace Some\PackageD\Subpackage {

    use function Some\PackageD\someInternalFunction;
    use function Some\PackageD\somePublicFunction;

    // valid. In subpackage
    someInternalFunction();

    // valid. Public function
    somePublicFunction();

    // valid. Edge-case
    meaninglessInternalTaggedFunction();
}

namespace Another\PackageD {

    use function Some\PackageD\someInternalFunction;
    use function Some\PackageD\somePublicFunction;

    // invalid. Call from different package
    someInternalFunction();

    // valid. Public function
    somePublicFunction();

    // valid. Edge-case
    meaninglessInternalTaggedFunction();
}
