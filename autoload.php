<?php

spl_autoload_register(function ($class) {
    $classFile = str_replace('\\', '/', $class) . '.php';
    $classFile = str_replace('App/', 'app/', $classFile);
    if (file_exists($classFile)) {
        require_once $classFile;
    }
});
