------------------------------------------------------------------------
1. REQUISITOS PREVIOS
------------------------------------------------------------------------

Para ejecutar este proyecto localmente en Windows 11, asegúrese de tener instalado:
1. Visual Studio Code (o su editor de código preferido).
2. XAMPP (con los servicios de Apache y PHP 8.2.12). 
3. PostgreSQL 18 y pgAdmin 4 para la gestión de la base de datos.

------------------------------------------------------------------------
2. GUÍA DE INSTALACIÓN Y CONFIGURACIÓN
------------------------------------------------------------------------

Sigue estos pasos detallados para configurar y desplegar el proyecto en tu entorno local con la nueva estructura:

Paso 1: Ubicación del Proyecto y Renombrado
1. Descarga o extrae los archivos de este proyecto.
2. Asegúrese de que la carpeta principal se llame "prueba".
3. Mueva la carpeta completa a la ruta raíz pública de tu servidor XAMPP:
   C:\xampp\htdocs\prueba\

Paso 2: Configuración de la Base de Datos (PostgreSQL)
1. Abre pgAdmin 4 e inicia sesión con tu contraseña de superusuario.
2. En el panel izquierdo, despliega "Servers" y haz clic derecho sobre "Databases" -> "Create" -> "Database..."
3. Nombra la base de datos exactamente como: prueba y haz clic en "Save".
4. Haz clic derecho sobre la base de datos recién creada (prueba) y selecciona "Query Tool".
5. Ve a la carpeta "sql" dentro de tu proyecto, abre el archivo "database.sql", copia su contenido completo, pégalo en el Query Tool y presiona F5 (o el botón Play) para ejecutarlo. Esto creará las tablas estructurales e insertará los datos iniciales de catálogo.

Paso 3: Habilitar PostgreSQL en XAMPP (PHP)
Por defecto, PHP viene configurado únicamente para MySQL. Sigue estos pasos para activar el soporte de PostgreSQL:
1. Abre el Panel de Control de XAMPP.
2. En la fila de "Apache", haz clic en el botón "Config" y selecciona "PHP (php.ini)".
3. Se abrirá un archivo de texto. Presiona Ctrl + B (o Ctrl + F) y busca el término "pgsql".
4. Localiza las siguientes líneas y elimine el punto y coma (;) al principio de cada una para descomentarlas:
   extension=pdo_pgsql
   extension=pgsql
5. Guarda los cambios en el archivo (Ctrl + G o Archivo > Guardar) y ciérralo.

Paso 4: Configurar Credenciales de Conexión
1. Abre la carpeta "prueba" en Visual Studio Code.
2. Abre el archivo "conexion.php".
3. Edita la variable $password reemplazando su valor por la contraseña real que configuraste para tu usuario "postgres" en la instalación del gestor:
   $password = "TU_CONTRASEÑA_REAL_AQUÍ";
4. Guarda el archivo.

Paso 5: Despliegue de la Aplicación
1. En el Panel de Control de XAMPP, haz clic en el botón "Start" al lado de "Apache". El módulo debería ponerse en color verde.
2. Abre tu navegador web e ingresa a la siguiente URL actualizada:
   http://localhost/prueba/

------------------------------------------------------------------------
3. ESTRUCTURA DEL PROYECTO
------------------------------------------------------------------------


prueba/
├── api/
│   ├── obtener_bodegas.php     # Endpoint que extrae el catálogo de bodegas
│   ├── obtener_monedas.php     # Endpoint que extrae el catálogo de monedas
│   ├── obtener_sucursales.php  # Endpoint condicional basado en la bodega elegida
│   ├── verificar_codigo.php    # Endpoint de AJAX que valida la unicidad del código
│   └── guardar_producto.php    # Controlador que procesa e inserta los datos en la BD
├── sql/
│   └── base_de_datos.sql       # Script estructural y cargas iniciales para PostgreSQL
├── conexion.php                # Instancia de conexión segura mediante PDO
├── estilos.css                 # Hoja de estilos en CSS Nativo
├── index.html                  # Interfaz de usuario estándar del formulario
└── app.js                      # Lógica frontend y validaciones estrictas vía JavaScript
