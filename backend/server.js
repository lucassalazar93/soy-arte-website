const express = require("express");
const mysql = require("mysql2");
const cors = require("cors");
require("dotenv").config(); // Cargar variables de entorno desde .env

const app = express();
app.use(cors());
app.use(express.json()); // Permitir JSON en las solicitudes

// 🔹 Usamos un "pool" en lugar de una única conexión
const pool = mysql.createPool({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "db_soy_arte_1.0",
  waitForConnections: true, // Evita rechazar conexiones nuevas
  connectionLimit: 10, // Limita las conexiones simultáneas
  queueLimit: 0,
});

// 🔹 Verificar la conexión con MySQL
pool.getConnection((err, connection) => {
  if (err) {
    console.error("❌ Error al conectar con MySQL:", err);
    return;
  }
  console.log("✅ Conectado a la base de datos MySQL");
  connection.release(); // Liberamos la conexión
});

// 🔹 Ruta de prueba para verificar que el servidor está funcionando
app.get("/", (req, res) => {
  res.send("¡Servidor funcionando correctamente!");
});

// 🚀 **Obtener todas las recetas**
app.get("/api/recetas", (req, res) => {
  pool.query("SELECT * FROM recetas", (err, results) => {
    if (err) {
      console.error("❌ Error al obtener recetas:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json(results);
  });
});

// 🚀 **Obtener una receta por ID**
app.get("/api/recetas/:id", (req, res) => {
  pool.query("SELECT * FROM recetas WHERE id = ?", [req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al obtener la receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    if (result.length === 0) {
      return res.status(404).json({ error: "Receta no encontrada" });
    }
    res.json(result[0]);
  });
});

// 🚀 **Crear una nueva receta**
app.post("/api/recetas", (req, res) => {
  const { nombre, descripcion, imagen, video, audio, link_youtube } = req.body;
  const sql = "INSERT INTO recetas (nombre, descripcion, imagen, video, audio, link_youtube) VALUES (?, ?, ?, ?, ?, ?)";
  
  pool.query(sql, [nombre, descripcion, imagen, video, audio, link_youtube], (err, result) => {
    if (err) {
      console.error("❌ Error al insertar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "Receta creada correctamente", id: result.insertId });
  });
});

// 🚀 **Actualizar una receta**
app.put("/api/recetas/:id", (req, res) => {
  const { nombre, descripcion, imagen, video, audio, link_youtube } = req.body;
  const sql = "UPDATE recetas SET nombre=?, descripcion=?, imagen=?, video=?, audio=?, link_youtube=? WHERE id=?";
  
  pool.query(sql, [nombre, descripcion, imagen, video, audio, link_youtube, req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al actualizar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "Receta actualizada correctamente" });
  });
});

// 🚀 **Eliminar una receta**
app.delete("/api/recetas/:id", (req, res) => {
  pool.query("DELETE FROM recetas WHERE id = ?", [req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al eliminar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "Receta eliminada correctamente" });
  });
});

// 🔹 Iniciar el servidor en el puerto 5000
app.listen(5000, () => {
  console.log("🚀 Servidor corriendo en http://localhost:5000");
});
