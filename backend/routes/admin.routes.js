const express = require("express");
const bcrypt = require("bcryptjs");
const pool = require("../config/db"); // 📌 Importar conexión a la base de datos

const router = express.Router();

// 🔹 **Registrar un nuevo administrador**
router.post("/register", async (req, res) => {
  try {
    const { nombre_completo, email, password, role } = req.body;

    if (!nombre_completo || !email || !password) {
      return res.status(400).json({ error: "Todos los campos son obligatorios" });
    }

    // Verificar si el usuario ya existe
    const [existingUser] = await pool.promise().query(
      "SELECT id FROM administradores WHERE email = ?",
      [email]
    );

    if (existingUser.length > 0 && existingUser[0].length > 0) {
      return res.status(400).json({ error: "El usuario ya existe" });
    }

    // Encriptar contraseña
    const hashedPassword = await bcrypt.hash(password, 10);

    // Insertar usuario
    await pool.promise().query(
      "INSERT INTO administradores (nombre_completo, email, password, role) VALUES (?, ?, ?, ?)",
      [nombre_completo, email, hashedPassword, role || "editor"]
    );

    res.status(201).json({ message: "Administrador registrado correctamente" });
  } catch (error) {
    console.error("❌ Error al registrar administrador:", error);
    res.status(500).json({ error: "Error en el servidor" });
  }
});

// 🔹 **Inicio de sesión de administrador**
router.post("/login", async (req, res) => {
  try {
    const { email, password } = req.body;

    if (!email || !password) {
      return res.status(400).json({ error: "Todos los campos son obligatorios" });
    }

    // Buscar administrador en la base de datos
    const [results] = await pool.promise().query(
      "SELECT id, email, password, role FROM administradores WHERE email = ?",
      [email]
    );

    if (!results || results[0].length === 0) {
      return res.status(401).json({ error: "Usuario no encontrado" });
    }

    const user = results[0][0]; // Obtener el primer resultado
    const isMatch = await bcrypt.compare(password, user.password);

    if (!isMatch) {
      return res.status(401).json({ error: "Contraseña incorrecta" });
    }

    res.status(200).json({
      message: "Inicio de sesión exitoso",
      usuario: { id: user.id, email: user.email, role: user.role },
    });
  } catch (error) {
    console.error("❌ Error en el servidor:", error);
    res.status(500).json({ error: "Error en el servidor" });
  }
});

// 🔹 **Obtener todos los administradores**
router.get("/admins", async (req, res) => {
  try {
    const [results] = await pool.promise().query(
      "SELECT id, nombre_completo, email, role FROM administradores"
    );

    res.status(200).json(results[0] || []); // Siempre devuelve un arreglo, incluso si está vacío
  } catch (error) {
    console.error("❌ Error al obtener administradores:", error);
    res.status(500).json({ error: "Error en el servidor" });
  }
});

// 🔹 **Eliminar un administrador**
router.delete("/:id", async (req, res) => {
  try {
    const { id } = req.params;

    if (!id) {
      return res.status(400).json({ error: "ID de administrador requerido" });
    }

    // Verificar si el usuario existe antes de eliminar
    const [userExists] = await pool.promise().query(
      "SELECT id FROM administradores WHERE id = ?",
      [id]
    );

    if (!userExists || userExists[0].length === 0) {
      return res.status(404).json({ error: "Administrador no encontrado" });
    }

    // Proceder con la eliminación
    const [result] = await pool.promise().query(
      "DELETE FROM administradores WHERE id = ?", 
      [id]
    );

    if (result.affectedRows === 0) {
      return res.status(400).json({ error: "No se pudo eliminar el administrador" });
    }

    res.status(200).json({ message: "Administrador eliminado correctamente" });
  } catch (error) {
    console.error("❌ Error al eliminar administrador:", error);
    res.status(500).json({ error: "Error en el servidor" });
  }
});

module.exports = router;
