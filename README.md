# LiteForge - Documentación

## Introducción

**LiteForge** es un framework PHP ligero y modular, diseñado para ofrecer una base sólida y flexible para el desarrollo de aplicaciones web. Su enfoque es permitir a los desarrolladores crear aplicaciones rápidas, seguras y fáciles de extender, utilizando una estructura minimalista pero poderosa.

LiteForge toma inspiración de frameworks populares como **CodeIgniter 3**, pero con un enfoque en simplicidad, rendimiento y facilidad de uso. Este framework está pensado para desarrolladores que desean tener un control total sobre su aplicación, mientras aprovechan las herramientas y buenas prácticas integradas.

## Características principales

- **Ligereza y rapidez**: El núcleo de LiteForge está diseñado para ser rápido y eficiente, sin sacrificar funcionalidad.
- **Modularidad**: Estructura basada en módulos para facilitar la extensibilidad.
- **Fácil de configurar**: Listo para funcionar con una configuración mínima.
- **Seguridad**: Implementación de medidas de seguridad desde el principio.

---

## Estructura del Proyecto

La estructura de directorios de LiteForge está organizada de manera que permita una gestión eficiente del código y los recursos. A continuación se detalla la estructura propuesta:

LiteForge/  
├── application/  
│ ├── controllers/ # Controladores de la aplicación  
│ ├── models/ # Modelos que interactúan con la base de datos  
│ ├── views/ # Vistas de la aplicación  
│ ├── core/ # Clases base y funcionalidades fundamentales  
│ ├── helpers/ # Funciones auxiliares  
│ └── libraries/ # Librerías personalizadas  
├── system/  
│ ├── [core](docs/system/core.md)/ # Código interno del framework  
│ └── [libraries](docs/system.md)/ # Librerías de bajo nivel y componentes  
├── public/  
│ ├── assets/ # Archivos públicos como CSS, JS, imágenes  
│ └── index.php # Archivo de entrada principal  
├── logs/ # Archivos de registro  
├── config/ # Archivos de configuración  
├── .env # Variables de entorno  
├── composer.json # Dependencias de Composer  
├── README.md # Documentación general del proyecto  
└── LICENSE # Archivo de licencia 

### Descripción de directorios clave:

- **/application**: Contiene los elementos que forman la aplicación, como controladores, modelos, vistas, y más. Aquí es donde se desarrollará la mayor parte de la lógica de la aplicación.
- **/system**: Contiene el núcleo del framework, clases esenciales y librerías internas.
- **/public**: El directorio accesible al público, donde se encuentran los archivos estáticos y el punto de entrada de la aplicación.
- **/logs**: Almacena los registros de eventos y errores.
- **/config**: Archivos de configuración globales y específicos de la aplicación.

---

## Instalación

1. Clona el repositorio de LiteForge:
    ```bash
    git clone https://github.com/tu_usuario/LiteForge.git
    ```
2. Instala las dependencias utilizando Composer:
    ```bash
    composer install
    ```
3. Configura las variables de entorno en el archivo `.env` (por ejemplo, conexión a la base de datos, claves secretas, etc.).
4. Accede a tu aplicación abriendo `public/index.php` desde tu navegador.

---

## .htaccess

El archivo `.htaccess` está configurado para asegurar que la aplicación sea accesible solo desde el directorio público, protegiendo carpetas sensibles como `application`, `system`, `logs` y `config`.

```apache
# Habilitar Reescritura de URLs
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^/public/
    RewriteRule ^(.*)$ /public/$1 [L]
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [L]
</IfModule>

# Proteger directorios sensibles
<FilesMatch "(^|/)(application|system|config|logs|core|libraries|helpers)/">
    Order Deny,Allow
    Deny from all
</FilesMatch>

# Denegar acceso a archivos sensibles
<FilesMatch "^\.">
    Order Deny,Allow
    Deny from all
</FilesMatch>
