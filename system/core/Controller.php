<?php

// Aseguramos que la clase Controller no se cargue múltiples veces.
if (!class_exists('Controller')) {

    /**
     * Clase base para todos los controladores de la aplicación
     */
    class Controller
    {
        /**
         * Array para almacenar las dependencias inyectadas.
         * 
         * @var array
         */
        protected $dependencies = [];
        
        /**
         * Almacena los filtros asociados a las acciones del controlador.
         *
         * @var array
         */
        protected $beforeFilters = [];
        protected $afterFilters = [];

        /**
         * Almacena los middleware globales que se ejecutarán antes de cualquier acción.
         *
         * @var array
         */
        protected $middleware = [];
        

        /**
         * Constructor de la clase Controller
         * Puede inicializar propiedades o dependencias comunes en los controladores
         */
        public function __construct($dependencies = [])
        {
            // Inicialización si es necesario, por ejemplo, cargando un modelo o librerías comunes.
            
            // Almacenamos las dependencias inyectadas
            $this->dependencies = $dependencies;
        }

         /**
         * Cargar una librería del sistema.
         * 
         * @param string $library El nombre de la librería a cargar
         */
        public function loadLibrary($library)
        {
            // Convertimos el nombre de la librería a un formato adecuado
            $libraryClass = 'App\\Libraries\\' . ucfirst($library);

            // Intentamos cargar la librería utilizando autoload
            if (class_exists($libraryClass)) {
                return new $libraryClass();
            } else {
                throw new Exception("La librería '{$library}' no se encuentra.");
            }
        }

        /**
         * Redirigir a una URL específica.
         * 
         * @param string $url La URL a la que se redirigirá al usuario
         * @param int $statusCode El código de estado HTTP (por defecto 302)
         */
        public function redirect($url, $statusCode = 302)
        {
            // Aseguramos que la URL comience con "http" o "https" si es una URL completa
            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                // Si no es una URL completa, asumimos que es relativa a la raíz
                $url = BASE_URL . '/' . ltrim($url, '/');
            }

            // Configuramos el código de estado HTTP
            http_response_code($statusCode);

            // Establecemos una cabecera de redirección
            header('Location: ' . $url);

            // Finalizamos la ejecución del script
            exit();
        }

        /**
         * Redirigir con un mensaje en la sesión (ej. éxito o error)
         * 
         * @param string $url La URL a la que se redirigirá al usuario
         * @param string $message El mensaje a guardar en la sesión
         * @param string $messageType El tipo de mensaje (ej. 'success', 'error')
         */
        public function redirectWithMessage($url, $message, $messageType = 'success')
        {
            // Iniciamos la sesión si no está iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Guardamos el mensaje en la sesión con el tipo de mensaje
            $_SESSION['message'] = $message;
            $_SESSION['message_type'] = $messageType;

            // Llamamos al método de redirección estándar
            $this->redirect($url);
        }


        /**
         * Mostrar un mensaje de sesión (si está disponible)
         */
        public function displayMessage()
        {
            // Iniciamos la sesión si no está iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            // Comprobamos si hay un mensaje en la sesión
            if (isset($_SESSION['message'])) {
                $message = $_SESSION['message'];
                $messageType = isset($_SESSION['message_type']) ? $_SESSION['message_type'] : 'info';

                // Mostrar el mensaje al usuario
                echo "<div class='message $messageType'>$message</div>";

                // Limpiar el mensaje de la sesión después de mostrarlo
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
        }

        /**
         * Obtener una dependencia inyectada.
         * 
         * @param string $key Clave de la dependencia
         * @return mixed La dependencia inyectada
         * @throws Exception Si la dependencia no existe
         */
        protected function getDependency($key)
        {
            if (isset($this->dependencies[$key])) {
                return $this->dependencies[$key];
            } else {
                throw new Exception("Dependencia $key no encontrada.");
            }
        }

        /**
         * Cargar un modelo de la aplicación
         * 
         * @param string $model El nombre del modelo a cargar
         * @return object Instancia del modelo
         */
        public function loadModel($model)
        {
            try {
                $modelFile = 'application/models/' . $model . '.php';

                if (file_exists($modelFile)) {
                    require_once $modelFile;
                    return new $model();
                } else {
                    // Lanzamos una excepción si el modelo no existe
                    throw new Exception("Modelo $model no encontrado.");
                }
            } catch (Exception $e) {
                // Llamamos al manejador de excepciones
                $this->handleException($e);
            }

        }

        /**
         * Cargar una vista
         * 
         * @param string $view El nombre de la vista a cargar
         * @param array $data Datos opcionales que se pasan a la vista
         */
        public function loadView($view, $data = [])
        {
            try {
                $viewFile = 'application/views/' . $view . '.php';

                if (file_exists($viewFile)) {
                    extract($data);
                    require_once $viewFile;
                } else {
                    // Lanzamos una excepción si la vista no existe
                    throw new Exception("Vista $view no encontrada.");
                }
            } catch (Exception $e) {
                // Llamamos al manejador de excepciones
                $this->handleException($e);
            }
        }

        /**
         * Manejo centralizado de excepciones.
         * 
         * @param Exception $e Excepción a manejar
         */
        protected function handleException($e)
        {
            // Registrar el error en un log de errores (puede ser en un archivo, base de datos, etc.)
            $this->logError($e);

            // Mostrar un mensaje amigable al usuario
            echo "Lo siento, ha ocurrido un error. Por favor, inténtelo más tarde.";

            // Opcional: Puedes redirigir al usuario a una página de error personalizada o página de inicio.
            // header("Location: /error");
            exit();
        }

        /**
         * Registrar un error en un log de errores.
         * 
         * @param Exception $e Excepción que se desea registrar
         */
        protected function logError($e)
        {
            // Guardar la excepción en un archivo de log (en producción, esto debería ser más detallado)
            error_log(
                "[" . date('Y-m-d H:i:s') . "] " . 
                "Error: " . $e->getMessage() . " | " . 
                "Archivo: " . $e->getFile() . " | " . 
                "Línea: " . $e->getLine() . "\n", 
                3, 'application/logs/error_log.txt'
            );
        }

        /**
         * Renderizar una vista
         * 
         * @param string $view El nombre de la vista
         * @param array $data Datos opcionales que se pasan a la vista
         */
        public function render($view, $data = [])
        {
            // Este método llamará a loadView para cargar la vista
            $this->loadView($view, $data);
        }

        /**
         * Registra un filtro que se ejecutará antes de la acción.
         *
         * @param string $action El nombre de la acción del controlador.
         * @param callable $filter El filtro que se ejecutará antes de la acción.
         */
        public function before($action, $filter)
        {
            $this->beforeFilters[$action] = $filter;
        }

        /**
         * Registra un filtro que se ejecutará después de la acción.
         *
         * @param string $action El nombre de la acción del controlador.
         * @param callable $filter El filtro que se ejecutará después de la acción.
         */
        public function after($action, $filter)
        {
            $this->afterFilters[$action] = $filter;
        }

        /**
         * Registra un middleware que se ejecutará antes de cualquier acción.
         *
         * @param callable $middleware El middleware que se ejecutará antes de la acción.
         */
        public function useMiddleware($middleware)
        {
            $this->middleware[] = $middleware;
        }

        /**
         * Ejecuta el middleware global.
         *
         * @return bool
         */
        protected function runMiddleware()
        {
            foreach ($this->middleware as $middleware) {
                if (!$middleware()) {
                    return false;  // Si cualquier middleware falla, se detiene la ejecución
                }
            }
            return true;
        }

        /**
         * Ejecuta el filtro antes de la acción.
         *
         * @param string $action El nombre de la acción.
         * @return bool
         */
        protected function runBeforeFilter($action)
        {
            if (isset($this->beforeFilters[$action])) {
                return call_user_func($this->beforeFilters[$action]);
            }
            return true;  // Si no hay filtro, continúa sin detenerse
        }

        /**
         * Ejecuta el filtro después de la acción.
         *
         * @param string $action El nombre de la acción.
         */
        protected function runAfterFilter($action)
        {
            if (isset($this->afterFilters[$action])) {
                call_user_func($this->afterFilters[$action]);
            }
        }

        /**
         * Método que ejecuta la acción del controlador y maneja los filtros y middleware.
         *
         * @param string $action El nombre de la acción a ejecutar
         * @param array $params Parámetros adicionales para la acción
         */
        public function execute($action, $params = [])
        {
            // Ejecutar middleware global
            if (!$this->runMiddleware()) {
                return false;  // Detener ejecución si el middleware falla
            }

            // Ejecutar filtro antes de la acción
            if (!$this->runBeforeFilter($action)) {
                return false;  // Detener ejecución si el filtro de antes falla
            }

            // Ejecutar la acción del controlador
            if (method_exists($this, $action)) {
                call_user_func_array([$this, $action], $params);
            }

            // Ejecutar filtro después de la acción
            $this->runAfterFilter($action);
        }
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
     * @return void
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
     * @return void
     */
    public function respondError($message, $statusCode = 400)
    {
        $this->respondAjax(['status' => 'error', 'message' => $message], $statusCode);
    }

}
