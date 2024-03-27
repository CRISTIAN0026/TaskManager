# TaskManager
### Para intalar las dependencias

Ejecuta `composer install`, para instalar las dependencias de laravel, depues seguido de eso ejeccuta `npm install` para instalar las dependencias de de Vue.

### Ejecutar las migraciones y configurar la base de datos:

Se tiene que configurar las variables de entorno de la base de datos en el archivo `.env`, igual forma también las variables
del correo para poder usar el correo electrónico. Seguido de eso puede ejecutar el comando `php artisan migrate`.

También tiene que configurar las variables de entorno para poder acceder como super administrador, por ejemplo:

#### USER_NAME="Administrador"
#### USER_EMAIL="admin@example.com"
#### USER_PASSWORD="Brg$.001M"
#### USER_IS_SUPER_ADMIN=true


## Acerca de la Aplicación de Tareas

La Aplicación de Tareas es un sistema de administración de tareas con una sintaxis expresiva y elegante. Creemos que el desarrollo debe ser una experiencia agradable y creativa para ser verdaderamente satisfactoria. La Aplicación de Tareas facilita el desarrollo al simplificar las tareas comunes utilizadas en muchos proyectos web, tales como:

- Funcionalidad de "Login" mediante correo y contraseña.
- Funcionalidad "Olvidé mi clave" que permite el cambio de contraseña mediante correo electrónico.
- Registro manual de usuarios por un usuario super admin.
- Creación y eliminación de tareas únicamente por usuarios super admin.
- Modificación de los empleados asignados en las tareas solo por usuarios super admin.
- Visualización de la lista de tareas asignadas al ingresar al sistema.
- Comentarios en las tareas propias y las de compañeros.
- Adjuntar archivos (PDF, JPG, JPEG, PNG) a las tareas propias y las de compañeros.
- Eliminación de archivos adjuntados a cada tarea únicamente por el empleado asignado de la tarea, por el empleado que lo adjuntó o super admins.
- Modificación del estado de sus tareas asignadas únicamente por los empleados (Super admins pueden modificar cualquiera).
- Generación de un reporte/resumen (PDF) de las tareas realizadas en un periodo de tiempo por super admins.

