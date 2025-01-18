<?php

// Aseguramos que la clase Validation no se cargue múltiples veces.
if (!class_exists('Validation')) {

    /**
     * Clase que proporciona métodos para la validación de datos.
     * Permite aplicar diferentes reglas de validación a los datos de entrada.
     */
    class Validation
    {
        /**
         * Registra las reglas de validación para los datos.
         *
         * @var array
         */
        private $rules = [];
        
        /**
         * Registra los mensajes de error personalizados para cada regla.
         *
         * @var array
         */
        private $errorMessages = [];

        /**
         * Añadir una regla de validación a un campo específico.
         *
         * @param string $field El nombre del campo a validar
         * @param array $rules Un array de reglas para el campo
         */
        public function addRule($field, $rules)
        {
            $this->rules[$field] = $rules;
        }

        /**
         * Establecer un mensaje de error personalizado para una regla.
         *
         * @param string $rule La regla de validación
         * @param string $message El mensaje de error personalizado
         */
        public function setErrorMessage($rule, $message)
        {
            $this->errorMessages[$rule] = $message;
        }

        /**
         * Validar los datos basados en las reglas registradas.
         *
         * @param array $data Los datos a validar (ej. $_POST, $_GET)
         * @return array Un array con los errores de validación
         */
        public function validate($data)
        {
            $errors = [];
            
            // Iterar sobre cada campo y aplicar sus reglas
            foreach ($this->rules as $field => $rules) {
                foreach ($rules as $rule) {
                    // Aplicar la regla y obtener el resultado de la validación
                    $result = $this->applyRule($rule, $data[$field] ?? null);

                    // Si la validación falla, registramos el error
                    if (!$result) {
                        $errors[$field][] = $this->getErrorMessage($rule);
                    }
                }
            }
            
            return $errors;
        }

        /**
         * Aplicar una regla de validación específica a un dato.
         *
         * @param string $rule La regla de validación a aplicar
         * @param mixed $value El valor del campo que estamos validando
         * @return bool El resultado de la validación (true si es válido, false si no)
         */
        private function applyRule($rule, $value)
        {
            switch ($rule) {
                case 'required':
                    return !empty($value);
                case 'email':
                    return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
                case 'numeric':
                    return is_numeric($value);
                case 'min_length':
                    return strlen($value) >= 6;
                case 'max_length':
                    return strlen($value) <= 255;
                default:
                    return true;
            }
        }

        /**
         * Obtener el mensaje de error asociado con una regla.
         *
         * @param string $rule La regla de validación
         * @return string El mensaje de error
         */
        private function getErrorMessage($rule)
        {
            // Devolver un mensaje de error predeterminado si no se especificó uno personalizado
            return $this->errorMessages[$rule] ?? "La validación falló para la regla: {$rule}.";
        }
    }
}
