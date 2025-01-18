# Documentación de Controller.php

## Introducción

La clase `Controller` es el núcleo de la lógica de control en nuestro framework. Su propósito principal es proporcionar herramientas fundamentales para manejar solicitudes HTTP, renderizar vistas y gestionar funcionalidades comunes como AJAX, manejo de respuestas, y redirecciones.

---

## Código completo de `Controller.php`

```php
<?php

/**
 * Clase base para controladores en el framework LiteForge.
 *
 * Proporciona funcionalidades comunes para la gestión de solicitudes,
 * manejo de vistas, respuestas AJAX, redirecciones y más.
 */
class Controller
{
    /**
     * Renderiza una vista.
     *
     * @param string $view Nombre de la vista.
     * @param array $data Datos a pasar a la vista.
     */
    public function render($view, $data = [])
    {
        extract($data);
        include __DIR__ . "/../views/{$view}.php";
    }

    /**
     * Redirige a una URL específica.
     *
     * @param string $url URL de destino.
     * @param int $status Código de estado HTTP (por defecto: 302).
     */
    public function redirect($url, $status = 302)
    {
        http_response_code($status);
        header("Location: {$url}");
        exit;
    }

    /**
     * Verifica si la solicitud actual es una solicitud AJAX.
     *
     * @return bool Retorna `true` si la solicitud es AJAX, de lo contrario `false`.
     */
    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    /**
     * Envía una respuesta JSON para solicitudes AJAX.
     *
     * @param mixed $data Los datos a enviar como respuesta.
     * @param int $statusCode Código de estado HTTP (por defecto: 200).
     */
    public function respondAjax($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Envía una respuesta exitosa en formato JSON.
     *
     * @param mixed $data Los datos a enviar.
     * @param string $message Mensaje opcional.
     */
    public function respondSuccess($data = null, $message = 'Operation successful')
    {
        $this->respondAjax(['status' => 'success', 'message' => $message, 'data' => $data]);
    }

    /**
     * Envía una respuesta de error en formato JSON.
     *
     * @param string $message Mensaje de error.
     * @param int $statusCode Código de estado HTTP (por defecto: 400).
     */
    public function respondError($message, $statusCode = 400)
    {
        $this->respondAjax(['status' => 'error', 'message' => $message], $statusCode);
    }

    /**
     * Maneja excepciones no capturadas y las registra en un log.
     *
     * @param Exception $exception Excepción capturada.
     */
    public function handleException($exception)
    {
        error_log($exception->getMessage());
        http_response_code(500);
        echo "An internal server error occurred. Please try again later.";
    }
}
```

---

## Mejoras Implementadas

### 1. **Soporte para AJAX**
La clase incluye métodos para verificar si una solicitud es AJAX y para manejar respuestas JSON de forma eficiente:

- `isAjax()`: Verifica si la solicitud actual es AJAX.
- `respondAjax($data, $statusCode)`: Envía una respuesta JSON con un código de estado.

### 2. **Métodos Auxiliares para Formateo de Respuestas**
Se agregaron métodos para estandarizar las respuestas JSON:

- `respondSuccess($data, $message)`: Envía una respuesta de éxito.
- `respondError($message, $statusCode)`: Envía una respuesta de error con un mensaje personalizado.

### 3. **Soporte para Redirecciones**
El método `redirect($url, $status)` permite redirigir a una URL específica con un código de estado opcional.

### 4. **Manejo de Excepciones**
Se incluyó el método `handleException($exception)` para capturar excepciones no manejadas y registrar los errores en los logs del servidor.

---

## Uso

A continuación, se presenta un ejemplo de cómo utilizar la clase `Controller`:

```php
class HomeController extends Controller
{
    public function index()
    {
        $data = ['title' => 'Home Page', 'content' => 'Welcome to LiteForge!'];
        $this->render('home', $data);
    }

    public function fetchData()
    {
        if (!$this->isAjax()) {
            $this->respondError('Forbidden', 403);
        }

        $data = ['key' => 'value'];
        $this->respondSuccess($data);
    }

    public function redirectToAbout()
    {
        $this->redirect('/about');
    }
}
```

---

## Conclusión

La clase `Controller` proporciona una base sólida para manejar solicitudes HTTP en el framework LiteForge. Las mejoras implementadas aseguran que sea fácil de usar, extensible y capaz de manejar casos comunes como AJAX, excepciones y redirecciones.
