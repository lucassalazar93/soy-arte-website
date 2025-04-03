require("dotenv").config(); // ✅ Cargar variables de entorno

const express = require("express");
const cors = require("cors");
const db = require("./config/db"); // ✅ Conexión a la base de datos

// 🛠 Crear la app de Express
const app = express();

// ✅ Middlewares
app.use(cors()); // Permite peticiones desde otros dominios
app.use(express.json()); // Permite leer JSON en el body de peticiones

// 📦 Importar rutas
app.use("/api/admin", require("./routes/admin.routes")); // Rutas de administrador
app.use("/productos", require("./routes/productos.routes")); // ✅ Ruta para productos
// También podrías desglosarlo como:
// const productosRoutes = require("./routes/productos.routes");
// app.use("/productos", productosRoutes);

// ✅ Verificar conexión a la BD al iniciar
db.query("SELECT 1", (err) => {
  if (err) {
    console.error("❌ Error al conectar con la base de datos:", err);
    process.exit(1); // Detener si hay error
  } else {
    console.log("✅ Conexión a la base de datos establecida correctamente.");
  }
});

// ✅ Ruta de prueba básica
app.get("/", (req, res) => {
  res.send("🚀 ¡Servidor funcionando correctamente!");
});

// ✅ Levantar el servidor
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
});
