# DSS-2026-G01-E02

## Integrantes:
* Marcos González Fernández
* Israel Izquierdo Sanchís
* Adrián Martínez Gallego
* Alejandro José Martín Millan
* José Manuel Álvarez Cánovas

## Tecnologías utilizadas

* PHP, con Laravel
* Git
* MySQL
* EloquentORM
* [draw.io](https://draw.io)
* Bootstrap

## Estado del proyecto

En desarrollo, actualmente implementado versión visual de la aplicación web. Casi terminado, solo queda la parte de la autenticación de los usuarios y la fase de prueba del software

## Despliegue local

Para iniciar el proyecto:

```bash
php artisan serve
```

### Inicializar la base de datos en localhost

Para incialiar la base de datos en local, se debe modificar el archivo `.env` añadiendo los siguientes campos de conexión:
```txt
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=dss2026
DB_USERNAME=dss2026
DB_PASSWORD=dss2026
```
Posteriormente, para inicializar la base de datos, en una terminal con `mysql` instalado:
```sql
CREATE DATABASE dss2026 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'dss2026'@'localhost' IDENTIFIED BY 'dss2026';
GRANT ALL PRIVILEGES ON dss2026.* TO 'dss2026'@'localhost';
FLUSH PRIVILEGES;
```

## Contribuciones

Cada integrante tiene su propia rama a partir de la rama `devel`. Todas las contribuciones a `devel` o `master` se realizan mediante **pull requests**. Para la organización del equipo, utilizamos [proyects](https://github.com/users/iis8-ua/projects/2) de GitHub.
