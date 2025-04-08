// Importaciones necesarias
const express = require("express");
const router = express.Router();
const db = require("../config/db");

// ==========================================================
// 🗕️ 1. Obtener todas las recetas (resumen)
// ==========================================================
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

// ==========================================================
// 🎲 2. Obtener recetas aleatorias (ANTES del /:id)
// ==========================================================
router.get("/aleatorias", (req, res) => {
  const sql = "SELECT * FROM recetas ORDER BY RAND() LIMIT 3";

  db.query(sql, (err, result) => {
    if (err) {
      console.error("❌ Error al obtener recetas aleatorias:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }

    if (!result || result.length === 0) {
      return res.status(404).json({ error: "Receta no encontrada" });
    }

    console.log("🎲 Recetas aleatorias enviadas:", result);
    res.json(result);
  });
});

// ==========================================================
// 📘 3. Obtener una receta por ID (detalle completo + utensilios)
// ==========================================================
router.get("/:id", (req, res) => {
  const recetaQuery = `
    SELECT 
      id,
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
      youtube_link,
      categoria,
      ingredientes
    FROM recetas
    WHERE id = ?
  `;

  db.query(recetaQuery, [req.params.id], (err, recetaResult) => {
    if (err) {
      console.error("❌ Error al obtener la receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }

    if (recetaResult.length === 0) {
      return res.status(404).json({ error: "Receta no encontrada" });
    }

    const receta = recetaResult[0];

    const utensiliosQuery = `
      SELECT u.id, u.nombre, u.icono
      FROM receta_utensilios ru
      JOIN utensilios u ON ru.utensilio_id = u.id
      WHERE ru.receta_id = ?
    `;

    db.query(utensiliosQuery, [req.params.id], (err, utensiliosResult) => {
      if (err) {
        console.error("❌ Error al obtener los utensilios:", err);
        return res.status(500).json({ error: "Error obteniendo utensilios" });
      }

      receta.utensilios = utensiliosResult;
      res.json(receta);
    });
  });
});

// ==========================================================
// ✏️ 4. Crear una nueva receta
// ==========================================================
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
    youtube_link,
    categoria,
    ingredientes
  } = req.body;

  const sql = `
    INSERT INTO recetas (
      titulo, descripcion, descripcion_larga, imagen,
      tiempo_preparacion, nivel_dificultad, autor,
      calificacion, video, audio, youtube_link, categoria, ingredientes
    )
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
  `;

  db.query(sql, [
    titulo, descripcion, descripcion_larga, imagen,
    tiempo_preparacion, nivel_dificultad, autor,
    calificacion, video, audio, youtube_link, categoria, ingredientes
  ], (err, result) => {
    if (err) {
      console.error("❌ Error al insertar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta creada correctamente", id: result.insertId });
  });
});

// ==========================================================
// 🔁 5. Actualizar una receta existente
// ==========================================================
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
    youtube_link,
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
      youtube_link = ?,
      categoria = ?,
      ingredientes = ?
    WHERE id = ?
  `;

  db.query(sql, [
    titulo, descripcion, descripcion_larga, imagen,
    tiempo_preparacion, nivel_dificultad, autor,
    calificacion, video, audio, youtube_link, categoria, ingredientes,
    req.params.id
  ], (err, result) => {
    if (err) {
      console.error("❌ Error al actualizar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta actualizada correctamente" });
  });
});

// ==========================================================
// 🗑️ 6. Eliminar una receta
// ==========================================================
router.delete("/:id", (req, res) => {
  db.query("DELETE FROM recetas WHERE id = ?", [req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al eliminar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta eliminada correctamente" });
  });
});

// ==========================================================
// 🧾 7. Obtener pasos de preparación para una receta
// ==========================================================
router.get("/:id/pasos", (req, res) => {
  const recetaId = req.params.id;
  const query = `
    SELECT 
      id,
      numero_paso,
      descripcion,
      tiempo,
      imagen
    FROM pasos_receta
    WHERE receta_id = ?
    ORDER BY numero_paso ASC
  `;

  db.query(query, [recetaId], (err, result) => {
    if (err) {
      console.error("❌ Error al obtener pasos:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }

    res.json(result);
  });
});

// Exportar rutas
module.exports = router;
