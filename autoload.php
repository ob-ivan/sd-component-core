<?php
require_once __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($name) {
    $parts = explode('_', $name);
    while ($parts) {
        $filename = __DIR__ . '/' . implode('/', $parts) . '.php';
        if (file_exists($filename)) {
            include_once $filename;
        }
        if (class_exists($name, false) || interface_exists($name, false)) {
            return;
        }
        array_pop($parts);
    }
});
