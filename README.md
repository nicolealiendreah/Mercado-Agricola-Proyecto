<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="300" alt="Laravel Logo">
</p>

<h1 align="center">Mercado Agrícola / AgroVida</h1>

<p align="center">
Sistema web desarrollado en Laravel para la gestión de un mercado agrícola.
</p>

---

## Descripción general

Mercado Agrícola / AgroVida es una plataforma web que permite la publicación, visualización y compra de productos agrícolas, incluyendo **animales**, **maquinaria** y **productos orgánicos**.  
El sistema gestiona usuarios con distintos roles (cliente, vendedor y administrador), incorpora reportes administrativos y expone una API REST preparada para futuras integraciones móviles.

---

## Instalación nativa (sin contenedores)

### Requisitos
- PHP 8.2 o superior
- Composer
- Node.js y npm
- PostgreSQL
- Git

### Pasos

1. Clonar el repositorio:
```bash
git clone https://github.com/nicolealiendreah/Mercado-Agricola-Proyecto
cd Proyecto-Agricola
````

2. Crear el archivo de entorno:

```bash
cp .env.example .env
```

Configurar las variables de base de datos en el archivo `.env`.

3. Instalar dependencias:

```bash
composer install
npm install
npm run build
```

4. Generar la clave de la aplicación:

```bash
php artisan key:generate
```

5. Ejecutar migraciones y seeders:

```bash
php artisan migrate:fresh --seed
```

6. Crear el enlace de almacenamiento:

```bash
php artisan storage:link
```

7. Levantar el servidor:

```bash
php artisan serve
```

Acceso desde el navegador:

```
http://localhost:8000
```

---

## Instalación con contenedores (Docker)

### Requisitos

* Docker
* Docker Compose

### Archivos necesarios en la raíz del proyecto

* `docker-compose.yml`
* `Dockerfile`
* `entrypoint.sh`
* `nginx.conf`

### Pasos

1. Clonar el repositorio:

```bash
git clone https://github.com/nicolealiendreah/Mercado-Agricola-Proyecto
cd Proyecto-Agricola
```

2. Crear el archivo de entorno:

```bash
cp .env.example .env
```

3. Construir y levantar los contenedores:

```bash
docker compose up -d --build
```

4. Configurar la aplicación dentro del contenedor:

```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate:fresh --seed
docker compose exec app php artisan storage:link
```

5. Acceder al sistema:

```
http://localhost
```

---

## Verificación

* La aplicación web debe cargar correctamente.
* Verificar el estado de la API:

```http
GET /api/health
```

Debe responder con estado OK.

---

## Usuario administrador de prueba

Creado automáticamente por los seeders:

* **Correo:** [admin@agrovida.com](mailto:admin@agrovida.com)
* **Contraseña:** admin123

Se recomienda cambiar estas credenciales en entornos de producción.

---

## Notas

* El archivo `.env.example` no contiene credenciales reales.
* Para producción se recomienda configurar:

```env
APP_ENV=production
APP_DEBUG=false
