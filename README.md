# Sistema de Seguimiento de Equipos de Fútbol

Este es un sistema de seguimiento de equipos de fútbol que permite a los usuarios buscar equipos, agregarlos a una lista de favoritos y ver los próximos y últimos partidos de sus equipos favoritos.

## Features

-   **Autenticación de usuarios:** Registro e inicio de sesión.
-   **Búsqueda de equipos:** Búsqueda de equipos de fútbol por nombre.
-   **Gestión de favoritos:** Los usuarios pueden agregar y eliminar equipos de su lista de favoritos.
-   **Dashboard:** Visualización de los equipos favoritos y sus partidos.
-   **Partidos:** Muestra los últimos y próximos partidos de los equipos favoritos.

## Arquitectura y Decisiones de Diseño

La aplicación sigue una arquitectura que intenta separar las preocupaciones del dominio de las del framework, inspirada en principios de Diseño Guiado por el Dominio (DDD).

-   **Backend:** Laravel 12. 
-   **Frontend:** React con TypeScript y Vite.js.
-   **Inertia.js:** Para conectar el backend de Laravel con el frontend de React, se utiliza Inertia.js. Esta elección permite construir una aplicación de página única (SPA) sin la complejidad de manejar una API RESTful completa y la autenticación de la misma. Inertia permite renderizar componentes de React directamente desde los controladores de Laravel.
-   **Estructura de Dominio:** Dentro de `app/Domain`, se encuentran los Servicios y DTOs (Data Transfer Objects).
    -   **Services:** Contienen la lógica de negocio principal de la aplicación (e.g., `FavoriteTeamService`, `FootballDataService`).
    -   **DTOs:** Se utilizan para transferir datos de una capa a otra de forma estructurada y con tipado estricto.
-   **Capa Externa (API):** En `app/External`, se encuentra la lógica para interactuar con la API externa de datos de fútbol. Se utiliza un `FootballClient` para encapsular las llamadas a la API y `Mappers` para transformar las respuestas de la API en los DTOs del dominio.



## Instalación

### Con Docker (Recomendado)

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/prueba-tecnica-futbol.git
    cd prueba-tecnica-futbol
    ```

2.  **Configurar el entorno:**
    Copia el archivo de ejemplo `.env.example` a `.env` y llénalo con tus credenciales.
    ```bash
    cp .env.example .env
    ```
    Asegúrate de configurar la conexión a la base de datos (los valores por defecto en `docker-compose.yml` son `mysql`, `sail`, `password`). Lo más importante es configurar tu API Key de Football-API:
    ```
    FOOTBALL_API_KEY=tu_api_key
    FOOTBALL_API_HOST=https://v3.football.api-sports.io
    ```

3.  **Levantar los contenedores:**
    ```bash
    docker-compose up -d --build
    ```


### Sin Docker (Entorno Local)
### Prerrequisitos

-   PHP >= 8.3
-   Composer
-   Node.js & npm
-   Docker y Docker Compose (para la instalación con Docker)
-   Una base de datos (MySQL, PostgreSQL, etc.)

1.  **Clonar el repositorio:**
    ```bash
    git clone https://github.com/tu-usuario/prueba-tecnica-futbol.git
    cd prueba-tecnica-futbol
    ```

2.  **Instalar dependencias:**
    ```bash
    composer install
    npm install
    ```

3.  **Configurar el entorno:**
    Copia el archivo de ejemplo `.env.example` a `.env`.
    ```bash
    cp .env.example .env
    ```
    Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```
    Configura tu base de datos y tu API Key de Football-API en el archivo `.env`:
    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=nombre_de_tu_db
    DB_USERNAME=tu_usuario_db
    DB_PASSWORD=tu_password_db

    FOOTBALL_API_KEY=tu_api_key
    FOOTBALL_API_HOST=https://v3.football.api-sports.io
    ```

4.  **Ejecutar migraciones:**
    ```bash
    php artisan migrate
    ```

## Uso

1.  **Iniciar los servidores:**
    -   Servidor de Laravel: `php artisan serve`
    -   Servidor de Vite: `npm run dev`

2.  **Acceder a la aplicación:**
    Abre tu navegador y ve a `http://localhost:8000` (o la URL que te indique `php artisan serve`).

## Testing

Para ejecutar la suite de tests, puedes usar el siguiente comando:

```bash
php artisan test
```
O si prefieres ejecutar phpunit directamente:
```bash
./vendor/bin/phpunit
```

Asegúrate de tener un archivo `.env.testing` configurado para los tests. Puedes copiar el que está en el repositorio.
