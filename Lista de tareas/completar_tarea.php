<?php
// Conectar a la base de datos
$conn = new mysqli('localhost', 'root', '', 'tareas');

// Verificar la conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}

// Obtener el ID de la tarea y la acción a realizar (completar o desmarcar)
$id_tarea = $_GET['id'];
$action = $_GET['action'];

// Preparar la consulta SQL según la acción
if ($action === 'completar') {
    $sql = "UPDATE tareas SET completada = 1 WHERE id_tarea = ?";
} else {
    $sql = "UPDATE tareas SET completada = 0 WHERE id_tarea = ?";
}

$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_tarea);

// Ejecutar la consulta
if ($stmt->execute()) {
    echo 'Tarea actualizada exitosamente.';
} else {
    echo 'Error al actualizar la tarea: ' . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();

// Redirigir al formulario principal
header('Location: index.php');
exit();
?>
