<?php require_once "../modelos/conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agenda - Listado</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        .tarjeta { border: 1px solid #ddd; padding: 15px; margin-bottom: 10px; border-radius: 8px; max-width: 400px;}
        .btn-eliminar { color: red; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Listado de Contactos</h2>
    <a href="formulario.php" style="display:inline-block; margin-bottom: 20px;">+ Añadir Otro Contacto</a>
    
    <div>
        <?php
        // Mostramos la información consultando a través de la conexión
        $stmt = Conexion::conectar()->prepare("SELECT * FROM contactos ORDER BY id DESC");
        $stmt->execute();
        $contactos = $stmt->fetchAll();

        foreach ($contactos as $c) {
            echo "<div class='tarjeta'>";
            echo "<h3>" . htmlspecialchars($c['nombre']) . "</h3>";
            echo "<p><strong>Teléfono:</strong> " . htmlspecialchars($c['telefono']) . "</p>";
            echo "<p><strong>Dirección:</strong> " . htmlspecialchars($c['direccion']) . "</p>";
            echo "<p><strong>Correo:</strong> " . htmlspecialchars($c['correo']) . "</p>";
            echo "<a href='../controladores/eliminar.php?id=" . $c['id'] . "' class='btn-eliminar' onclick='return confirm(\"¿Seguro que deseas eliminar este contacto?\")'>Eliminar</a>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
