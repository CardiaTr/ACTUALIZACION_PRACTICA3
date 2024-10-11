<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tareas');

// Verificar la conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener los datos del formulario
$nombre_tarea = $_POST['nombre_tarea'];
$descripcion_tarea = $_POST['descripcion_tarea'];
$fecha_final = $_POST['fecha_final'];

// Preparar la consulta SQL para insertar la tarea
$sql = "INSERT INTO tareas (nombre_tarea, descripcion_tarea, fecha_final) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('sss', $nombre_tarea, $descripcion_tarea, $fecha_final);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo 'Tarea agregada exitosamente.';
} else {
    echo 'Error al agregar la tarea: ' . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Redirigir al formulario principal
header('Location: index.php');
exit();
?>
