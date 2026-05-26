<?php
require_once "../model/modelo.php";

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    
    $stmt = Conexion::conectar()->prepare("DELETE FROM contactos WHERE id = :id");
    $stmt->bindParam(":id", $id);
    
    if ($stmt->execute()) {
        header("Location: ../vista/listado.php");
        exit();
    } else {
        echo "Error al eliminar.";
    }
}
?>
