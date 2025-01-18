<?php

// Definir el espacio de nombres y la ruta base para las clases
define('BASE_NAMESPACE', 'LiteForge\\');
define('BASE_PATH', __DIR__ . '/');

// Registrar la función de autoloading con spl_autoload_register
spl_autoload_register(function ($class) {
    // Asegurarnos de que la clase pertenece al espacio de nombres del framework
    $prefix = BASE_NAMESPACE;

    // Verificamos si la clase pertenece al prefijo definido
    if (strncmp($prefix, $class, strlen($prefix)) !== 0) {
        return;
    }

    // Obtener el nombre de la clase después del prefijo
    $relativeClass = substr($class, strlen($prefix));

    // Construir la ruta del archivo correspondiente
    $file = BASE_PATH . str_replace('\\', DIRECTORY_SEPARATOR, $relativeClass) . '.php';

    // Verificamos si el archivo existe y lo incluimos
    if (file_exists($file)) {
        require_once $file;
    }
});
