<?php

declare(strict_types=1);

namespace Some\Package {
    /**
     * @internal
     */
    class SomeClass
    {

    }
}

// Valid usage. In the same package
namespace Some\Package {
    $class = new SomeClass();
}

// Valid usage. In subpackage
namespace Some\Package\Sub {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Valid usage. Edgy case when an it is application itself. Like `namespace App;`
namespace Some {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Prohibited usage. From another package of the same vendor.
namespace Some\AnotherPackage {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Prohibited usage. From different package.
namespace Another\Package {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}

// Prohibited usage. From global namespace(be it information expert or not)
namespace {

    use Some\Package\SomeClass;

    $class = new SomeClass();
}
