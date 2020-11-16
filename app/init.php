<?php

declare(strict_type=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1); 
error_reporting(E_ALL);


function config(string $key)
{
    $config = [];
    $configExists = false;

    // Load all config file in 'config' folder.
    foreach (scandir(__DIR__ . '/../config') as $file) {
        $path = __DIR__ . "/../config/{$file}";
        if (is_file($path)) {
            $configValue = require $path;
            if ((array) $configValue) {
                $configKey = basename($path, '.php');
                $config = array_merge($config, (array) [
                    $configKey => $configValue,
                ]);
            }
        }
    }

    $config = &$config;

    // Get config value.
    foreach (explode('.', $key) as $step) {
        if (isset($config[$step])) {
            $config = &$config[$step];
            $configExists = true;
        }
    }

    return $configExists ? $config : false;
}