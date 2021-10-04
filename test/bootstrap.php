<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

foreach (glob(__DIR__ . '/data/**.php') as $file) {
    if (file_exists($file)) {
        require $file;
    }
}

