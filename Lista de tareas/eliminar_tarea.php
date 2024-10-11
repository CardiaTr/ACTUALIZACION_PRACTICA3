<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tareas');

// Verificar la conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener el ID de la tarea a eliminar
$id_tarea = $_GET['id'];

// Preparar la consulta SQL para eliminar la tarea
$sql = "DELETE FROM tareas WHERE id_tarea = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_tarea);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo 'Tarea eliminada exitosamente.';
} else {
    echo 'Error al eliminar la tarea: ' . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Redirigir al formulario principal
header('Location: index.php');
exit();
?>
