<?php
class Conexion {
    public static function conectar() {
        try {
            // Ajusta las credenciales según tu entorno local (XAMPP/WAMP por defecto usan usuario 'root' y sin contraseña)
            $conexion = new PDO("mysql:host=localhost;dbname=mvc_agenda", "root", "");
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}
?>
