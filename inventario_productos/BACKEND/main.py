from fastapi import FastAPI, HTTPException
from pydantic import BaseModel, field_validator
import mysql.connector
from fastapi.middleware.cors import CORSMiddleware

app = FastAPI()

app.add_middleware(
    CORSMiddleware,
    allow_origins=["*"],
    allow_credentials=True,
    allow_methods=["*"],
    allow_headers=["*"],
)


def conectar():
    try:
        return mysql.connector.connect(
            host="localhost",
            user="root",
            password="",
            database="inventario_db"
        )
    except mysql.connector.Error as e:
        raise HTTPException(status_code=500, detail=f"Error al conectar a la BD: {str(e)}")


class Producto(BaseModel):
    nombre: str
    precio: float
    cantidad: int

    @field_validator("nombre")
    def nombre_no_vacio(cls, v):
        if not v or not v.strip():
            raise ValueError("El nombre no puede estar vacío")
        return v.strip()

    @field_validator("precio")
    def precio_valido(cls, v):
        if v < 0:
            raise ValueError("El precio no puede ser negativo")
        return round(v, 2)

    @field_validator("cantidad")
    def cantidad_valida(cls, v):
        if v < 0:
            raise ValueError("La cantidad no puede ser negativa")
        return int(v)


@app.on_event("startup")
def crear_tabla_si_no_existe():
    try:
        db = conectar()
        cursor = db.cursor()
        cursor.execute(
            """
            CREATE TABLE IF NOT EXISTS productos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(255) NOT NULL,
                precio DECIMAL(10,2) NOT NULL,
                cantidad INT NOT NULL
            )
            """
        )
        db.commit()
    except Exception:
        pass
    finally:
        try:
            cursor.close()
            db.close()
        except Exception:
            pass


@app.post("/productos")
def crear_producto(data: Producto):
    try:
        db = conectar()
        cursor = db.cursor()
        sql = "INSERT INTO productos (nombre, precio, cantidad) VALUES (%s, %s, %s)"
        cursor.execute(sql, (data.nombre, data.precio, data.cantidad))
        db.commit()
        return {"mensaje": "Producto creado", "id": cursor.lastrowid}
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al crear producto: {str(e)}")
    finally:
        cursor.close()
        db.close()


@app.get("/productos")
def listar_productos():
    try:
        db = conectar()
        cursor = db.cursor()
        cursor.execute("SELECT id, nombre, precio, cantidad FROM productos")
        resultados = cursor.fetchall()
        productos = [
            {"id": r[0], "nombre": r[1], "precio": float(r[2]), "cantidad": r[3]}
            for r in resultados
        ]
        return productos
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al listar productos: {str(e)}")
    finally:
        cursor.close()
        db.close()


@app.get("/productos/{producto_id}")
def obtener_producto(producto_id: int):
    try:
        db = conectar()
        cursor = db.cursor()
        cursor.execute("SELECT id, nombre, precio, cantidad FROM productos WHERE id = %s", (producto_id,))
        resultado = cursor.fetchone()
        if resultado:
            return {"id": resultado[0], "nombre": resultado[1], "precio": float(resultado[2]), "cantidad": resultado[3]}
        raise HTTPException(status_code=404, detail="Producto no encontrado")
    except HTTPException:
        raise
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al obtener producto: {str(e)}")
    finally:
        cursor.close()
        db.close()


@app.put("/productos/{producto_id}")
def editar_producto(producto_id: int, data: Producto):
    try:
        db = conectar()
        cursor = db.cursor()
        sql = "UPDATE productos SET nombre = %s, precio = %s, cantidad = %s WHERE id = %s"
        cursor.execute(sql, (data.nombre, data.precio, data.cantidad, producto_id))
        db.commit()
        if cursor.rowcount == 0:
            raise HTTPException(status_code=404, detail="Producto no encontrado para editar")
        return {"mensaje": "Producto actualizado"}
    except HTTPException:
        raise
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al editar producto: {str(e)}")
    finally:
        cursor.close()
        db.close()


@app.delete("/productos/{producto_id}")
def eliminar_producto(producto_id: int):
    try:
        db = conectar()
        cursor = db.cursor()
        cursor.execute("DELETE FROM productos WHERE id = %s", (producto_id,))
        db.commit()
        if cursor.rowcount == 0:
            raise HTTPException(status_code=404, detail="Producto no encontrado para eliminar")
        return {"mensaje": "Producto eliminado"}
    except HTTPException:
        raise
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Error al eliminar producto: {str(e)}")
    finally:
        cursor.close()
        db.close()
