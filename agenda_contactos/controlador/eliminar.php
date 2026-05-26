<?php
require_once "../modelos/conexion.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    $stmt = Conexion::conectar()->prepare("DELETE FROM contactos WHERE id = :id");
    $stmt->bindParam(":id", $id);
    
    if ($stmt->execute()) {
        header("Location: ../vistas/listado.php");
        exit();
    } else {
        echo "Error al eliminar.";
    }
}
?>
