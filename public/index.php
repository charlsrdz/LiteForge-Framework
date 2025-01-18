<?php
require_once __DIR__ . '../vendor/autoload.php'; // Autoload de Composer

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Ahora puedes usar getenv() para acceder a las variables
echo getenv('DB_HOST'); // Ejemplo de cómo acceder a la variable de entorno
?>
