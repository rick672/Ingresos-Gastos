<?php
// Script temporal para deshabilitar PWA
$configFile = __DIR__ . '/config/app.php';
$content = file_get_contents($configFile);

// Buscar y comentar el provider de PWA
$content = str_replace(
    "TomatoPHP\\FilamentPWA\\FilamentPWAServiceProvider::class,",
    "// TomatoPHP\\FilamentPWA\\FilamentPWAServiceProvider::class,",
    $content
);

file_put_contents($configFile, $content);
echo "PWA provider deshabilitado temporalmente\n";