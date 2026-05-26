<?php
require_once "../model/modelo.php";

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
        // El Controlador redirige a la Vista de listado
        header("Location: ../vista/listado.php");
        exit();
    } else {
        echo "Error al guardar el contacto.";
    }
}
?>
