const express = require("express");
const router = express.Router();
const mysql = require("mysql2");

// Configurar conexión a MySQL
const db = mysql.createConnection({
  host: process.env.DB_HOST || "localhost",
  user: process.env.DB_USER || "root",
  password: process.env.DB_PASSWORD || "",
  database: process.env.DB_NAME || "db_soy_arte_1.0",
});

// **Obtener todas las recetas**
router.get("/", (req, res) => {
  const sql = "SELECT * FROM recetas";
  db.query(sql, (err, results) => {
    if (err) {
      return res.status(500).json({ error: "Error al obtener recetas" });
    }
    res.json(results);
  });
});

// **Obtener una receta por ID**
router.get("/:id", (req, res) => {
  const { id } = req.params;
  const sql = "SELECT * FROM recetas WHERE id = ?";
  db.query(sql, [id], (err, results) => {
    if (err) {
      return res.status(500).json({ error: "Error al obtener la receta" });
    }
    if (results.length === 0) {
      return res.status(404).json({ message: "Receta no encontrada" });
    }
    res.json(results[0]);
  });
});

// **Agregar una nueva receta**
router.post("/", (req, res) => {
  const { 
    titulo, descripcion, ingredientes, preparacion, imagen, video, 
    audio, youtube_link, categoria, nivel_dificultad, tiempo_preparacion, porciones 
  } = req.body;

  const sql = `INSERT INTO recetas 
    (titulo, descripcion, ingredientes, preparacion, imagen, video, audio, youtube_link, 
    categoria, nivel_dificultad, tiempo_preparacion, porciones, fecha_creacion) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())`;

  db.query(sql, 
    [titulo, descripcion, ingredientes, preparacion, imagen, video, audio, 
    youtube_link, categoria, nivel_dificultad, tiempo_preparacion, porciones], 
    (err, result) => {
      if (err) {
        console.error("Error al agregar receta:", err);
        return res.status(500).json({ error: "Error al agregar receta" });
      }
      res.json({ message: "Receta agregada correctamente", id: result.insertId });
    });
});

// **Actualizar una receta**
router.put("/:id", (req, res) => {
  const { id } = req.params;
  const { 
    titulo, descripcion, ingredientes, preparacion, imagen, video, 
    audio, youtube_link, categoria, nivel_dificultad, tiempo_preparacion, porciones 
  } = req.body;

  const sql = `UPDATE recetas SET 
    titulo = ?, descripcion = ?, ingredientes = ?, preparacion = ?, imagen = ?, video = ?, 
    audio = ?, youtube_link = ?, categoria = ?, nivel_dificultad = ?, 
    tiempo_preparacion = ?, porciones = ? 
    WHERE id = ?`;

  db.query(sql, 
    [titulo, descripcion, ingredientes, preparacion, imagen, video, audio, 
    youtube_link, categoria, nivel_dificultad, tiempo_preparacion, porciones, id], 
    (err, result) => {
      if (err) {
        console.error("Error al actualizar receta:", err);
        return res.status(500).json({ error: "Error al actualizar receta" });
      }
      res.json({ message: "Receta actualizada correctamente" });
    });
});

// **Eliminar una receta**
router.delete("/:id", (req, res) => {
  const { id } = req.params;
  const sql = "DELETE FROM recetas WHERE id = ?";
  db.query(sql, [id], (err, result) => {
    if (err) {
      console.error("Error al eliminar receta:", err);
      return res.status(500).json({ error: "Error al eliminar receta" });
    }
    res.json({ message: "Receta eliminada correctamente" });
  });
});

module.exports = router;
