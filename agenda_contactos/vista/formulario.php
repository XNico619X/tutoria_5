<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda - Nuevo Contacto</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        form { background: #f9f9f9; padding: 20px; border-radius: 5px; width: 300px; margin-bottom: 20px;}
        input { width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        button { background: #28a745; color: white; border: none; padding: 10px; width: 100%; cursor: pointer;}
    </style>
</head>
<body>
    <h2>Agregar Nuevo Contacto</h2>
    <form action="../controlador/insertar.php" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="text" name="telefono" placeholder="Teléfono" required>
        <input type="text" name="direccion" placeholder="Dirección" required>
        <input type="email" name="correo" placeholder="Correo electrónico" required>
        <button type="submit">Guardar Contacto</button>
    </form>
    <a href="listado.php">Ver Lista de Contactos</a>
</body>
</html>
