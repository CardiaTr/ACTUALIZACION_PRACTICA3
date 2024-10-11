const express = require('express');
const path = require('path');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const app = express();
const port = 3000; // Puedes cambiar el puerto si es necesario

// Configurar middleware
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// Servir archivos estáticos (HTML, CSS, JS)
app.use(express.static(path.join(__dirname, 'public'))); // Asegúrate de tener tus archivos en una carpeta llamada 'public'

// Conexión a la base de datos MySQL
const db = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'tareas' // Cambia esto según tu configuración
});

// Conectar a la base de datos
db.connect((err) => {
    if (err) {
        throw err;
    }
    console.log('Conectado a la base de datos MySQL');
});

// Ruta para obtener todas las tareas
app.get('/tareas', (req, res) => {
    const sql = 'SELECT * FROM tareas';
    db.query(sql, (err, results) => {
        if (err) throw err;
        res.json(results);
    });
});

// Ruta para agregar una tarea
app.post('/agregar_tarea', (req, res) => {
    const { nombre_tarea, descripcion_tarea, fecha_final } = req.body;
    const tarea = { nombre_tarea, descripcion_tarea, fecha_final, completada: 0 };
    const sql = 'INSERT INTO tareas SET ?';

    db.query(sql, tarea, (err) => {
        if (err) throw err;
        res.redirect('/'); // Redirigir a la página principal después de agregar la tarea
    });
});

// Ruta para marcar una tarea como completada
app.get('/completar_tarea', (req, res) => {
    const { id, action } = req.query;
    const completada = action === 'completar' ? 1 : 0;
    const sql = 'UPDATE tareas SET completada = ? WHERE id_tarea = ?';

    db.query(sql, [completada, id], (err) => {
        if (err) throw err;
        res.redirect('/'); // Redirigir a la página principal después de completar la tarea
    });
});

// Ruta para eliminar una tarea
app.get('/eliminar_tarea', (req, res) => {
    const { id } = req.query;
    const sql = 'DELETE FROM tareas WHERE id_tarea = ?';

    db.query(sql, [id], (err) => {
        if (err) throw err;
        res.redirect('/'); // Redirigir a la página principal después de eliminar la tarea
    });
});

// Iniciar el servidor
app.listen(port, () => {
    console.log(`Servidor escuchando en http://localhost:${port}`);
});
