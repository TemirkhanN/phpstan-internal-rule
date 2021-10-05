<?php

declare(strict_types=1);

namespace {
    /**
     * @internal
     */
    class SomeRootClass
    {

    }
}

namespace Some\Package {
    /**
     * @internal
     */
    class SomeClass
    {

    }
}

namespace Some\Package {
    // Valid usage. In the same package
    $class = new SomeClass();
    // Invalid usage.
    $anotherClass = new \SomeRootClass();
}

// Valid usage. In subpackage
namespace Some\Package\Sub {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

namespace Some {

    use Some\Package\SomeClass;

    // Valid usage. Edgy case when an it is application itself. Like `namespace App;`
    $class = new SomeClass();
    // Invalid usage.
    $anotherClass = new \SomeRootClass();
}

// Invalid usage. From another package of the same vendor.
namespace Some\AnotherPackage {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Invalid usage. From different package.
namespace Another\Package {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Phpstan\Analyser is broken and absorbs previous namespace in Scope
// Not working correctly until that behavior is fixed.
namespace {

    //use Some\Package\SomeClass;

    // Invalid usage. From global namespace(be it information expert or not)
    //  $class = new SomeClass();
    // Valid usage. From same root namespace.
    // $anotherClass = new \SomeRootClass();
}
