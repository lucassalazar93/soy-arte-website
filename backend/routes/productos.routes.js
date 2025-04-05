const express = require("express");
const router = express.Router();
const db = require("../config/db");


// 🔥 Obtener todos los productos
router.get("/", (req, res) => {
  const sql = "SELECT * FROM productos";
  db.query(sql, (err, results) => {
    if (err) {
      console.error("❌ Error al consultar todos los productos:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }
    res.json(results); // ✅ Devuelve un array con todos los productos
  });
});


// 🌟 Obtener productos en oferta (limita a 4 por defecto)
router.get("/oferta", (req, res) => {
  const sql = "SELECT * FROM productos WHERE oferta = 1 LIMIT 4";
  db.query(sql, (err, results) => {
    if (err) {
      console.error("❌ Error al consultar productos en oferta:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }
    res.json(results); // ✅ Devuelve productos en oferta
  });
});


// 📦 Obtener un producto específico por su ID
router.get("/:id", (req, res) => {
  const { id } = req.params;
  const sql = "SELECT * FROM productos WHERE product_id = ?";
  db.query(sql, [id], (err, results) => {
    if (err) {
      console.error("❌ Error al obtener el producto:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }

    if (results.length === 0) {
      return res.status(404).json({ error: "Producto no encontrado" });
    }

    res.json(results[0]); // ✅ Devuelve un único producto
  });
});


// 🧾 Obtener categorías únicas (para filtros en el frontend)
router.get("/categorias", (req, res) => {
  const sql = "SELECT DISTINCT categoria FROM productos";
  db.query(sql, (err, results) => {
    if (err) {
      console.error("❌ Error al obtener categorías:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }
    res.json(results); // ✅ Ej: [{ categoria: "hogar" }, { categoria: "arte" }]
  });
});


// ✅ Exportar el router para que pueda ser usado en server.js
module.exports = router;
