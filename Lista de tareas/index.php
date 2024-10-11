<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <h1>Lista de Tareas</h1>

    <!-- Formulario para agregar nuevas tareas -->
    <form action="agregar_tarea.php" method="POST">
        <input type="text" name="nombre_tarea" placeholder="Nombre de la tarea..." required>
        <input type="text" name="descripcion_tarea" placeholder="Descripción de la tarea..." required>
        <input type="date" name="fecha_final" required>
        <button type="submit">Agregar Tarea</button>
    </form>

    <!-- Aquí se mostrará la lista de tareas -->
    <ul>
        <?php
        // Conectar a la base de datos
        $conn = new mysqli('localhost', 'root', '', 'tareas');
        if ($conn->connect_error) {
            die('Error de conexión: ' . $conn->connect_error);
        }

        // Obtener todas las tareas de la base de datos
        $sql = "SELECT * FROM tareas";
        $result = $conn->query($sql);

        // Mostrar cada tarea en la lista
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determinar si la tarea está completada
                $completedClass = $row['completada'] ? 'completed' : '';
                $completeAction = $row['completada'] ? 'desmarcar' : 'completar';

                echo '<li class="' . $completedClass . '">';
                echo '<strong>' . $row['nombre_tarea'] . '</strong> - ' . $row['descripcion_tarea'] . ' (Fecha límite: ' . $row['fecha_final'] . ')';
                echo ' <a href="completar_tarea.php?id=' . $row['id_tarea'] . '&action=' . $completeAction . '">';
                echo $row['completada'] ? 'Desmarcar' : 'Completar';
                echo '</a>';
                echo ' | <a href="eliminar_tarea.php?id=' . $row['id_tarea'] . '">Eliminar</a>';
                echo '</li>';
            }
        } else {
            echo '<li>No hay tareas aún.</li>';
        }

        // Cerrar la conexión
        $conn->close();
        ?>
    </ul>
</body>
</html>

