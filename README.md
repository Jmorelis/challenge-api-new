
## Challenge

API REST desarrollada en Laravel para la gestión de artículos y categorías, incluyendo generación automática de slug, relaciones many-to-many y estructura preparada para escalabilidad.

## Stack Tecnológico

- PHP 8.x
- Laravel
- MySQL
- Docker & Docker Compose
- Arquitectura RESTful

## Características Implementadas

- CRUD completo de artículos
- Relación many-to-many: Articles ↔ Categories
- Generación automática y única de slug
- Manejo de errores estructurado
- Respuestas JSON con códigos HTTP correctos
- Uso de Eloquent ORM y relaciones
- Proyecto dockerizado para ejecución simple



Endpoints Disponibles
## Articles
- Método	Endpoint	Descripción
    GET	/api/articles	Listar artículos        
    GET	/api/articles/{id}	Obtener artículo
    POST	/api/articles	Crear artículo
    PUT	/api/articles/{id}	Actualizar artículo
    DELETE	/api/articles/{id}	Eliminar artículo

## Ejemplo – Crear Artículo

POST /api/articles

{
  "title": "Mi primer artículo",
  "content": "Contenido del artículo",
  "status": "published"
}

- Base de Datos

MySQL configurado en Docker:
Host: mysql
Puerto: 3306
Base de datos: laravel
Usuario: root
Password: root

## Decisiones Técnicas

El slug se genera automáticamente utilizando eventos del modelo (boot() + creating).

Se utiliza findOrFail() para manejo automático de 404.

Se implementó relación many-to-many entre artículos y categorías mediante tabla pivot.
