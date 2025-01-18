## Arquitectura del directorio /system/core  

Dentro de este directorio, almacenaremos las clases que proporcionan la funcionalidad básica del framework y que se usan a través de toda la aplicación. Aquí es donde definiremos las clases centrales que gestionan el ciclo de vida de las solicitudes, el enrutamiento, la carga de dependencias, el manejo de errores y otras funcionalidades esenciales.  

/system/core/  
  ├── Controller.php         # Clase base para los controladores  
  ├── Model.php              # Clase base para los modelos  
  ├── Router.php             # Manejador de rutas  
  ├── View.php               # Clase para la carga y renderizado de vistas  
  ├── Config.php             # Clase para la configuración  
  ├── Loader.php             # Cargador de librerías, modelos, etc.  
  ├── Session.php            # Gestión de sesiones  
  ├── Error.php              # Manejo de errores y excepciones  
  └── Request.php            # Manejo de las solicitudes HTTP  



## Descripción de las clases clave

 - Controller.php  
    - Esta clase base será utilizada por todos los controladores de la aplicación. Proporcionará métodos comunes para gestionar las solicitudes y cargar vistas o modelos.  
    - Funciones clave: loadModel(), loadView(), render(), etc.
    
 - Model.php
    - Esta clase base será utilizada por todos los modelos de la aplicación. Permitirá la interacción con la base de datos y proporcionará métodos comunes para la gestión de datos.
    - Funciones clave: find(), save(), delete(), etc.
    
 - Router.php
    - Gestiona el enrutamiento de las solicitudes entrantes. Determina qué controlador y acción deben ejecutarse en función de la URL.
Funciones clave: addRoute(), getRoute(), etc.
View.php
    - Se encarga de cargar y renderizar las vistas. Acepta datos pasados desde los controladores y los muestra a través de plantillas.
Funciones clave: load(), render(), etc.

 - Config.php
    - Contiene los métodos necesarios para cargar archivos de configuración y acceder a variables globales de la aplicación.
    - Funciones clave: get(), set(), etc.
    
 - Loader.php
    - Carga dinámicamente librerías, modelos, vistas y otros componentes que son necesarios durante la ejecución de la aplicación.
    - Funciones clave: loadLibrary(), loadModel(), etc.
    
 - Session.php
    - Maneja las sesiones de usuario. Proporciona métodos para crear, acceder y destruir sesiones.
    - Funciones clave: start(), get(), set(), destroy(), etc.
    
 - Error.php
    - Proporciona un sistema para el manejo de errores y excepciones, incluyendo la visualización de errores personalizados.
    - Funciones clave: handle(), log(), etc.

 - Request.php
    - Gestiona las solicitudes HTTP. Facilita la obtención de parámetros, encabezados y otros detalles de las solicitudes.
    - Funciones clave: getParam(), getHeader(), etc.


## Flujo de trabajo dentro de /system/core

1. Controlador: Los controladores son responsables de manejar las solicitudes del usuario. Usan el enrutador para determinar qué método debe ejecutarse y luego interactúan con los modelos para recuperar datos. Finalmente, cargan las vistas para mostrar la respuesta.

2. Modelo: Los modelos interactúan con la base de datos o cualquier otro origen de datos. Los controladores usan los modelos para obtener y manipular datos.

3. Vista: Las vistas se cargan en los controladores y son responsables de presentar la información al usuario.

4. Enrutador: El enrutador toma las solicitudes entrantes y las dirige al controlador y método correspondiente. Esto permite un enrutamiento limpio y eficiente en la aplicación.

5. Manejo de Errores: Los errores y excepciones se gestionan globalmente dentro del framework, lo que permite una respuesta unificada ante fallos.

