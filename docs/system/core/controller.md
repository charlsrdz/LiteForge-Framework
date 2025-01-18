# Documentación de `Controller.php`

Esta documentación describe la funcionalidad y características del archivo `Controller.php`, que actúa como una clase base para los controladores de la aplicación. Se incluyen las mejoras añadidas, como soporte para Ajax, manejo de vistas y middleware, y métodos auxiliares para formateo de respuestas.

---

## Clase `Controller`

### Propiedades

#### `dependencies`
- **Tipo:** `array`
- **Descripción:** Almacena las dependencias inyectadas al controlador.

#### `beforeFilters`
- **Tipo:** `array`
- **Descripción:** Contiene los filtros que se ejecutarán antes de las acciones del controlador.

#### `afterFilters`
- **Tipo:** `array`
- **Descripción:** Contiene los filtros que se ejecutarán después de las acciones del controlador.

#### `middleware`
- **Tipo:** `array`
- **Descripción:** Define middleware global que se ejecutará antes de cualquier acción.

---

### Métodos

#### `__construct($dependencies = [])`
- **Descripción:** Constructor que permite inicializar dependencias comunes para los controladores.
- **Parámetros:**
  - `$dependencies` (opcional): Array de dependencias inyectadas.

#### `loadLibrary($library)`
- **Descripción:** Carga una librería desde el espacio de nombres `App\Libraries`.
- **Parámetros:**
  - `$library`: Nombre de la librería a cargar.
- **Excepciones:** Lanza una excepción si la librería no existe.

#### `redirect($url, $statusCode = 302)`
- **Descripción:** Redirige al usuario a una URL específica.
- **Parámetros:**
  - `$url`: URL de destino.
  - `$statusCode`: Código de estado HTTP (predeterminado: `302`).

#### `redirectWithMessage($url, $message, $messageType = 'success')`
- **Descripción:** Redirige a una URL con un mensaje almacenado en la sesión.
- **Parámetros:**
  - `$url`: URL de destino.
  - `$message`: Mensaje para la sesión.
  - `$messageType`: Tipo de mensaje (`success`, `error`, etc.).

#### `displayMessage()`
- **Descripción:** Muestra un mensaje de sesión, si está disponible, y lo elimina de la sesión.

#### `getDependency($key)`
- **Descripción:** Obtiene una dependencia inyectada por su clave.
- **Parámetros:**
  - `$key`: Clave de la dependencia.
- **Excepciones:** Lanza una excepción si la dependencia no existe.

#### `loadModel($model)`
- **Descripción:** Carga un modelo desde el directorio `application/models`.
- **Parámetros:**
  - `$model`: Nombre del modelo a cargar.
- **Excepciones:** Lanza una excepción si el modelo no existe.

#### `loadView($view, $data = [])`
- **Descripción:** Carga y muestra una vista desde el directorio `application/views`.
- **Parámetros:**
  - `$view`: Nombre de la vista.
  - `$data`: Datos opcionales para pasar a la vista.
- **Excepciones:** Lanza una excepción si la vista no existe.

#### `handleException($e)`
- **Descripción:** Maneja excepciones, registra errores y muestra mensajes amigables al usuario.
- **Parámetros:**
  - `$e`: Objeto de excepción.

#### `logError($e)`
- **Descripción:** Registra un error en el log de errores.
- **Parámetros:**
  - `$e`: Objeto de excepción a registrar.

#### `render($view, $data = [])`
- **Descripción:** Renderiza una vista utilizando el método `loadView`.
- **Parámetros:**
  - `$view`: Nombre de la vista.
  - `$data`: Datos opcionales para pasar a la vista.

#### `before($action, $filter)`
- **Descripción:** Registra un filtro que se ejecutará antes de una acción específica.
- **Parámetros:**
  - `$action`: Nombre de la acción.
  - `$filter`: Filtro a ejecutar.

#### `after($action, $filter)`
- **Descripción:** Registra un filtro que se ejecutará después de una acción específica.
- **Parámetros:**
  - `$action`: Nombre de la acción.
  - `$filter`: Filtro a ejecutar.

#### `useMiddleware($middleware)`
- **Descripción:** Registra un middleware global.
- **Parámetros:**
  - `$middleware`: Middleware a ejecutar.

#### `runMiddleware()`
- **Descripción:** Ejecuta todos los middlewares registrados.
- **Retorno:**
  - `true` si todos los middlewares se ejecutan correctamente, `false` en caso contrario.

#### `runBeforeFilter($action)`
- **Descripción:** Ejecuta el filtro antes de una acción específica.
- **Parámetros:**
  - `$action`: Nombre de la acción.
- **Retorno:**
  - `true` si el filtro se ejecuta correctamente, `false` en caso contrario.

#### `runAfterFilter($action)`
- **Descripción:** Ejecuta el filtro después de una acción específica.
- **Parámetros:**
  - `$action`: Nombre de la acción.

#### `execute($action, $params = [])`
- **Descripción:** Ejecuta una acción del controlador, incluyendo middleware y filtros.
- **Parámetros:**
  - `$action`: Nombre de la acción.
  - `$params`: Parámetros adicionales para la acción.

---

## Métodos Auxiliares

### `isAjax()`
- **Descripción:** Verifica si la solicitud actual es una solicitud AJAX.
- **Retorno:**
  - `true` si la solicitud es AJAX, `false` en caso contrario.

### `respondAjax($data, $statusCode = 200)`
- **Descripción:** Envía una respuesta JSON para solicitudes AJAX.
- **Parámetros:**
  - `$data`: Datos a enviar.
  - `$statusCode`: Código de estado HTTP (predeterminado: `200`).

### `respondSuccess($data = null, $message = 'Operation successful')`
- **Descripción:** Envía una respuesta exitosa en formato JSON.
- **Parámetros:**
  - `$data`: Datos a enviar.
  - `$message`: Mensaje opcional.

### `respondError($message, $statusCode = 400)`
- **Descripción:** Envía una respuesta de error en formato JSON.
- **Parámetros:**
  - `$message`: Mensaje de error.
  - `$statusCode`: Código de estado HTTP (predeterminado: `400`).

---

## Mejoras Incluidas

1. **Soporte para Ajax:** Métodos como `isAjax`, `respondAjax`, `respondSuccess` y `respondError` facilitan la interacción con solicitudes AJAX.
2. **Manejo de vistas:** Métodos como `loadView` y `render` permiten cargar vistas y gestionar datos.
3. **Middleware y Filtros:** Gestión de middlewares globales y filtros específicos para ejecutar lógica antes y después de acciones.

---

**Nota:** Este archivo actúa como la base de controladores en la aplicación. Las funcionalidades descritas ofrecen flexibilidad, extensibilidad y una estructura robusta para manejar solicitudes HTTP, vistas y lógica de negocios.
