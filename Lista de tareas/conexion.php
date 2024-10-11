<?php
$servername = "localhost"; // SERVIDOR
$username = "root"; // NOMBRE DE USUARIO
$password = ""; // CONTRASEÑA
$database = "tareas"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $database);

// Verificar la conexión
if ($conn->connect_error) {
    echo "Error: Conexión fallida - " . $conn->connect_error;
} else {
    echo "Conectado exitosamente a la base de datos.";
}
?>