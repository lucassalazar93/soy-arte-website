const express = require("express");
const router = express.Router();
const db = require("../config/db");

// ===============================================
// 📅 1. Obtener todas las recetas (versión resumida)
// ===============================================
router.get("/", (req, res) => {
  const sql = `
    SELECT 
      id,
      titulo AS title,
      descripcion AS description,
      imagen AS image,
      tiempo_preparacion AS time,
      nivel_dificultad AS level,
      autor,
      calificacion AS rating,
      categoria
    FROM recetas
  `;
  db.query(sql, (err, results) => {
    if (err) {
      console.error("❌ Error al obtener recetas:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json(results);
  });
});

// =================================================
// 📘 2. Obtener una receta por ID (detalle completo)
// =================================================
router.get("/:id", (req, res) => {
  const sql = `
    SELECT 
      id,
      titulo AS title,
      descripcion AS description,
      descripcion_larga,
      imagen AS image,
      tiempo_preparacion AS time,
      nivel_dificultad AS level,
      autor,
      calificacion AS rating,
      video,
      audio,
      link_youtube,
      ingredientes
    FROM recetas
    WHERE id = ?
  `;
  db.query(sql, [req.params.id], (err, result) => {
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

// ==================================
// 🌟 3. Crear una nueva receta
// ==================================
router.post("/", (req, res) => {
  const { 
    titulo, 
    descripcion, 
    descripcion_larga, 
    imagen, 
    tiempo_preparacion, 
    nivel_dificultad, 
    autor, 
    calificacion, 
    video, 
    audio, 
    link_youtube,
    categoria,
    ingredientes
  } = req.body;

  const sql = `
    INSERT INTO recetas (
      titulo, descripcion, descripcion_larga, imagen, 
      tiempo_preparacion, nivel_dificultad, autor, 
      calificacion, video, audio, link_youtube, categoria, ingredientes
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  `;

  db.query(sql, [
    titulo, descripcion, descripcion_larga, imagen,
    tiempo_preparacion, nivel_dificultad, autor,
    calificacion, video, audio, link_youtube, categoria, ingredientes
  ], (err, result) => {
    if (err) {
      console.error("❌ Error al insertar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta creada correctamente", id: result.insertId });
  });
});

// ==================================
// ✏️ 4. Actualizar una receta existente
// ==================================
router.put("/:id", (req, res) => {
  const { 
    titulo, 
    descripcion, 
    descripcion_larga, 
    imagen, 
    tiempo_preparacion, 
    nivel_dificultad, 
    autor, 
    calificacion, 
    video, 
    audio, 
    link_youtube,
    categoria,
    ingredientes
  } = req.body;

  const sql = `
    UPDATE recetas SET 
      titulo = ?, 
      descripcion = ?, 
      descripcion_larga = ?, 
      imagen = ?, 
      tiempo_preparacion = ?, 
      nivel_dificultad = ?, 
      autor = ?, 
      calificacion = ?, 
      video = ?, 
      audio = ?, 
      link_youtube = ?, 
      categoria = ?,
      ingredientes = ?
    WHERE id = ?
  `;

  db.query(sql, [
    titulo, descripcion, descripcion_larga, imagen,
    tiempo_preparacion, nivel_dificultad, autor,
    calificacion, video, audio, link_youtube, categoria, ingredientes, req.params.id
  ], (err, result) => {
    if (err) {
      console.error("❌ Error al actualizar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta actualizada correctamente" });
  });
});

// ==================================
// 🗑️ 5. Eliminar una receta
// ==================================
router.delete("/:id", (req, res) => {
  db.query("DELETE FROM recetas WHERE id = ?", [req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al eliminar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta eliminada correctamente" });
  });
});

module.exports = router;
