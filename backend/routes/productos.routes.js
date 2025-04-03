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
    res.json(results);
  });
});


// 🌟 Obtener productos en oferta
router.get("/oferta", (req, res) => {
  const sql = "SELECT * FROM productos WHERE oferta = 1 LIMIT 4";
  db.query(sql, (err, results) => {
    if (err) {
      console.error("❌ Error al consultar productos en oferta:", err);
      return res.status(500).json({ error: "Error del servidor" });
    }
    res.json(results);
  });
});


// 📦 Obtener un solo producto por su ID (para la vista de detalle)
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

    res.json(results[0]); // Solo un producto
  });
});

module.exports = router;
