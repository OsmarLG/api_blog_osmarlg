# Project name
***
# API Blog OsmarLG

Esta API permite la gestión de usuarios y publicaciones con diferentes roles y permisos. Está diseñada siguiendo el patrón repositorio y retorna colecciones con recursos de Laravel. Los administradores pueden gestionar usuarios y publicaciones, mientras que los autores pueden crear y ver publicaciones.

## Tabla de Contenidos

- [Instalación](#instalación)
- [Seeders](#seeders)
  - [Roles Seeder](#roles-seeder)
  - [Users Seeder](#users-seeder)
  - [Posts Seeder](#posts-seeder)
- [Rutas de la API](#rutas-de-la-api)
  - [Autenticación](#autenticación)
  - [Usuarios](#usuarios)
  - [Publicaciones](#publicaciones)
  - [Bitácora de Actividades](#bitácora-de-actividades)
- [Roles y Permisos](#roles-y-permisos)

## Instalación

1. **Clona el repositorio:**

   ```bash
   git clone https://github.com/tu_usuario/api_blog_osmarlg.git
   cd api_blog_osmarlg

2. **Instala las dependencias**
   
    ```bash
    composer install
    npm install

3. **Configura el archivo .env**
    
    ```bash
    cp .env.example .env

4. **Genera la clave de la aplicación**
    
    ```bash
    php artisan key:generate

5. **Configura la base de datos**
    
    Abre el archivo .env y configura las variables de entorno para la base de datos.

6. **Ejecuta las migraciones y seeders**
    
    ```bash
    php artisan migrate --seed

7. **Inicia el servidor de desarrollo**

    Metodo recomendado: 
        A traves de Laragon ya que las peticiones estan configuradas para el dominio https://api_blog_osmarlg.test/
        Entonces configurar servidores de nombres para dar con el dominio.
    
    Metodo general, cambiar las peticiones hacia el localhost y el puerto
    ```bash
    php artisan serve

## Seeders
1. **Roles Sedeer**
    Este seeder crea los roles Admin y Author.

2. **Users Sedeer**
    Este seeder trae usuarios de jsonplaceholder y les asigna el rol de Author. Además, crea un usuario administrador.

3. **Posts Seeder**
    Este seeder trae publicaciones de jsonplaceholder y las guarda en la base de datos. 

## Rutas de la API

### Autenticación
- **Registro:**

    ```http
    POST api/auth/register

- **Login:**

    ```http
    POST api/auth/login

- **Logout:**

    ```http
    POST /auth/logout

### Usuarios
- **Listar Usuarios:**

    ```http
    GET /users

- **Ver Usuario:**

    ```http
    GET /user/{id}

- **Crear Usuario:**
    
    ```http
    POST /users

- **Actualizar Usuario:**

    ```http
    PUT /user/{id}

- **Parchear Usuario:**

    ```http
    PATCH /user/{id}

- **Eliminar Usuario:**

    ```http
    DELETE /user/{id}

### Publicaciones
- **Listar Publicaciones:**

    ```http
    GET /posts/{status?}

- **Listar Publicaciones por Usuario:**

    ```http
    GET /myposts/user/{id}

- **Ver Publicación:**

    ```http
    GET /post/{id}

- **Crear Publicación:**

    ```http
    POST /posts

- **Actualizar Publicación:**

    ```http
    PUT /post/{id}

- **Parchear Publicación:**

    ```http
    PATCH /post/{id}

- **Eliminar Publicación:**

    ```http
    DELETE /post/{id}

### Bitácora de Actividades
- **Listar Actividades:**

    ```http
    GET /activities

## Roles y Permisos
- **Admin:**
    - Activar y desactivar usuarios y publicaciones.
    - Acceso al dashboard administrativo.
    - Ver bitácora de actividades.
    - Gestionar usuarios y publicaciones.

- **Author:**
    - Crear publicaciones.
    - Ver publicaciones de otros autores.

## Osmar LG
La API esta creada con patron repositorio, aunque me falto extender de un archivo base, sin embargo es la misma logica.

####
Este `README.md` proporciona una guía detallada para instalar y configurar el proyecto Laravel, así como una descripción clara de las funcionalidades y las rutas disponibles en la API.