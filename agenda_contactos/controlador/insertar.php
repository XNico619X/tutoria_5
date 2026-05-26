<?php
require_once "../modelos/conexion.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $direccion = $_POST["direccion"];
    $correo = $_POST["correo"];

    // Consultas preparadas para seguridad básica 
    $stmt = Conexion::conectar()->prepare("INSERT INTO contactos (nombre, telefono, direccion, correo) VALUES (:nombre, :telefono, :direccion, :correo)");
    
    $stmt->bindParam(":nombre", $nombre);
    $stmt->bindParam(":telefono", $telefono);
    $stmt->bindParam(":direccion", $direccion);
    $stmt->bindParam(":correo", $correo);

    if ($stmt->execute()) {
        // El Controlador redirige a la Vista de listado [cite: 29]
        header("Location: ../vistas/listado.php");
        exit();
    } else {
        echo "Error al guardar el contacto.";
    }
}
?>
