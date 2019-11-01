<?php
use Bitrix\Main\Loader;

Loader::includeModule('module.setting');

\spl_autoload_register(function ($a) {
    $path = __DIR__ . DIRECTORY_SEPARATOR . str_replace('\\', DIRECTORY_SEPARATOR, str_replace('module.setting\\', 'lib\\', ltrim($a, '\\'))) . '.php';
    if (file_exists($path)) {
        include_once $path;
    }
});


\Bitrix\Main\Loader::registerAutoLoadClasses(
    'module.setting', [
        'Setting\\Options' => 'lib/Options.php',
    ]
);