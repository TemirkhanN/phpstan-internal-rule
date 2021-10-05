<?php

declare(strict_types=1);

namespace {

    use function Some\PackageD\someInternalFunction;

    /**
     * @internal
     */
    function internalFunction(): void
    {

    }

    /**
     * @internal
     */
    $ofCourseIAmInternal = function (): void {

    };

    $ofCourseIAmInternal();

    internalFunction();

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
        // Valid. Inside same package
        \Some\PackageD\someInternalFunction();

        // Invalid. From root
        internalFunction();
    }
}

namespace Some\PackageD\Subpackage {

    use function Some\PackageD\someInternalFunction;
    use function Some\PackageD\somePublicFunction;

    // valid. In subpackage
    someInternalFunction();

    // valid. Public function
    somePublicFunction();

    // Invalid. From root
    internalFunction();
}

namespace Another\PackageD {

    use function Some\PackageD\someInternalFunction;
    use function Some\PackageD\somePublicFunction;

    // invalid. Call from different package
    someInternalFunction();

    // valid. Public function
    somePublicFunction();

    // valid. Edge-case
    internalFunction();
}
