const express = require("express");
const router = express.Router();
const db = require("../config/db");

// 🚀 **Obtener todas las recetas**
router.get("/", (req, res) => {
  db.query("SELECT * FROM recetas", (err, results) => {
    if (err) {
      console.error("❌ Error al obtener recetas:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json(results);
  });
});

// 🚀 **Obtener una receta por ID**
router.get("/:id", (req, res) => {
  db.query("SELECT * FROM recetas WHERE id = ?", [req.params.id], (err, result) => {
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
router.post("/", (req, res) => {
  const { nombre, descripcion, imagen, video, audio, link_youtube } = req.body;
  const sql = "INSERT INTO recetas (nombre, descripcion, imagen, video, audio, link_youtube) VALUES (?, ?, ?, ?, ?, ?)";

  db.query(sql, [nombre, descripcion, imagen, video, audio, link_youtube], (err, result) => {
    if (err) {
      console.error("❌ Error al insertar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta creada correctamente", id: result.insertId });
  });
});

// 🚀 **Actualizar una receta**
router.put("/:id", (req, res) => {
  const { nombre, descripcion, imagen, video, audio, link_youtube } = req.body;
  const sql = "UPDATE recetas SET nombre=?, descripcion=?, imagen=?, video=?, audio=?, link_youtube=? WHERE id=?";

  db.query(sql, [nombre, descripcion, imagen, video, audio, link_youtube, req.params.id], (err, result) => {
    if (err) {
      console.error("❌ Error al actualizar receta:", err);
      return res.status(500).json({ error: "Error en el servidor" });
    }
    res.json({ message: "✅ Receta actualizada correctamente" });
  });
});

// 🚀 **Eliminar una receta**
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
