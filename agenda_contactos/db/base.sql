CREATE DATABASE IF NOT EXISTS mvc_agenda;
USE mvc_agenda;

CREATE TABLE contactos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20) NOT NULL,
    direccion VARCHAR(150) NOT NULL,
    correo VARCHAR(100) NOT NULL
);
