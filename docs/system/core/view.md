# Documentación de la Clase `View`

Esta clase gestiona la renderización de vistas, el uso de layouts y la administración de secciones de contenido dinámico en el framework. Proporciona herramientas para estructurar y organizar las vistas de manera eficiente.

---

## Propiedades

### `protected $layout`
- **Tipo**: `string`
- **Descripción**: Nombre del archivo de layout principal.

### `protected $sections`
- **Tipo**: `array`
- **Descripción**: Almacena el contenido de las diferentes secciones definidas.

### `protected $currentSection`
- **Tipo**: `string`
- **Descripción**: Nombre de la sección que se está procesando actualmente.

---

## Métodos

### `setLayout($layout)`
- **Descripción**: Establece el layout principal que se utilizará para renderizar las vistas.
- **Parámetros**:
  - `string $layout`: Nombre del archivo de layout.
- **Uso**:
  ```php
  $view->setLayout('main');
  ```

---

### `startSection($name)`
- **Descripción**: Inicia una nueva sección de contenido.
- **Parámetros**:
  - `string $name`: Nombre de la sección.
- **Uso**:
  ```php
  $view->startSection('header');
  ```

---

### `endSection()`
- **Descripción**: Finaliza la sección actual y almacena su contenido en la propiedad `sections`.
- **Uso**:
  ```php
  $view->endSection();
  ```

---

### `render($view, $data = [])`
- **Descripción**: Renderiza una vista específica utilizando el layout y las secciones definidas.
- **Parámetros**:
  - `string $view`: Nombre del archivo de vista a renderizar.
  - `array $data`: (Opcional) Datos a pasar a la vista.
- **Uso**:
  ```php
  $view->render('home', ['title' => 'Bienvenido']);
  ```

---

### `section($name)`
- **Descripción**: Obtiene el contenido de una sección previamente definida.
- **Parámetros**:
  - `string $name`: Nombre de la sección.
- **Retorno**: `string` Contenido de la sección.
- **Uso**:
  ```php
  echo $view->section('header');
  ```

---

## Flujo de Uso

1. **Configurar un Layout**:
   ```php
   $view->setLayout('main');
   ```

2. **Definir Secciones**:
   ```php
   $view->startSection('header');
   echo '<h1>Bienvenido</h1>';
   $view->endSection();
   ```

3. **Renderizar una Vista**:
   ```php
   $view->render('home', ['title' => 'Inicio']);
   ```

4. **Incluir Secciones en el Layout**:
   En el archivo del layout:
   ```php
   echo $this->section('header');
   ```

---

## Ejemplo Completo

### Vista (`views/home.php`):
```php
<h1><?= $title ?></h1>
<p>Este es el contenido principal.</p>
```

### Layout (`views/layouts/main.php`):
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layout Principal</title>
</head>
<body>
    <?= $this->section('header') ?>
    <main>
        <?= $content ?>
    </main>
</body>
</html>
```

### Controlador:
```php
$view = new View();
$view->setLayout('main');

$view->startSection('header');
echo '<header><h1>Mi Sitio</h1></header>';
$view->endSection();

$view->render('home', ['title' => 'Página de Inicio']);
