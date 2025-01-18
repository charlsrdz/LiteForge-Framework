# Documentación de la clase `Validation`

## Descripción
La clase `Validation` proporciona una herramienta para la validación de datos, permitiendo aplicar diferentes reglas a campos específicos. Es útil para validar datos de entrada como formularios y asegurarse de que cumplan con ciertos requisitos antes de procesarlos.

---

## Propiedades

### `rules`
- **Tipo**: `array`
- **Descripción**: Contiene las reglas de validación asociadas a cada campo.

### `errorMessages`
- **Tipo**: `array`
- **Descripción**: Mensajes de error personalizados para las reglas de validación.

---

## Métodos

### `addRule($field, $rules)`
- **Descripción**: Añade una o varias reglas de validación para un campo específico.
- **Parámetros**:
  - `$field` (string): El nombre del campo a validar.
  - `$rules` (array): Un array de reglas para el campo.
- **Ejemplo**:
  ```php
  $validation->addRule('email', ['required', 'email']);
  ```

### `setErrorMessage($rule, $message)`
- **Descripción**: Define un mensaje de error personalizado para una regla específica.
- **Parámetros**:
  - `$rule` (string): La regla de validación.
  - `$message` (string): El mensaje de error personalizado.
- **Ejemplo**:
  ```php
  $validation->setErrorMessage('required', 'Este campo es obligatorio.');
  ```

### `validate($data)`
- **Descripción**: Valida los datos según las reglas registradas.
- **Parámetros**:
  - `$data` (array): Los datos a validar, como `$_POST` o `$_GET`.
- **Retorno**: `array` con los errores de validación encontrados.
- **Ejemplo**:
  ```php
  $errors = $validation->validate($_POST);
  ```

### `applyRule($rule, $value)`
- **Descripción**: Aplica una regla de validación específica a un valor.
- **Parámetros**:
  - `$rule` (string): La regla de validación a aplicar.
  - `$value` (mixed): El valor del campo a validar.
- **Retorno**: `bool` indicando si la validación fue exitosa.
- **Nota**: Este método es privado.

### `getErrorMessage($rule)`
- **Descripción**: Obtiene el mensaje de error asociado con una regla.
- **Parámetros**:
  - `$rule` (string): La regla de validación.
- **Retorno**: `string` con el mensaje de error.
- **Nota**: Este método es privado.

---

## Reglas de validación soportadas

- **required**: El campo no puede estar vacío.
- **email**: El campo debe contener una dirección de correo válida.
- **numeric**: El campo debe ser un número.
- **min_length**: El campo debe tener al menos 6 caracteres.
- **max_length**: El campo debe tener como máximo 255 caracteres.

---

## Ejemplo de uso

```php
require_once 'Validation.php';

$validation = new Validation();

// Añadir reglas
$validation->addRule('email', ['required', 'email']);
$validation->addRule('password', ['required', 'min_length']);

// Mensajes personalizados
$validation->setErrorMessage('required', 'Este campo es obligatorio.');
$validation->setErrorMessage('email', 'Por favor, introduce un correo electrónico válido.');
$validation->setErrorMessage('min_length', 'La contraseña debe tener al menos 6 caracteres.');

// Datos a validar
$data = [
    'email' => 'usuario@example.com',
    'password' => '12345'
];

// Validar datos
$errors = $validation->validate($data);

if (!empty($errors)) {
    print_r($errors);
} else {
    echo 'Datos válidos';
}
```

---

## Notas
- Si no se define un mensaje de error personalizado para una regla, se usará un mensaje genérico.
- La clase puede extenderse para incluir nuevas reglas de validación según sea necesario.
