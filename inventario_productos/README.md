# Inventario de Productos

Campos: `nombre`, `precio`, `cantidad`.

Requisitos: `fastapi`, `uvicorn`, `mysql-connector-python` (ya listados en `requirements.txt`).

1) Crear la base de datos MySQL y la tabla (ejecutar en MySQL/MariaDB):

```sql
CREATE DATABASE inventario_db;
USE inventario_db;
CREATE TABLE productos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  precio DECIMAL(10,2) NOT NULL,
  cantidad INT NOT NULL
);
```

El código en `main.py` intenta crear la tabla al iniciar si no existe.

2) Ejecutar la API:

```bash
uvicorn inventario_productos.main:app --reload --port 8001
```

3) Endpoints principales:

- `POST /productos` - crear
- `GET /productos` - listar
- `GET /productos/{id}` - obtener por id
- `PUT /productos/{id}` - actualizar
- `DELETE /productos/{id}` - eliminar
