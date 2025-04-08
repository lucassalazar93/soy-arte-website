require("dotenv").config(); // ✅ Cargar variables de entorno

const express = require("express");
const cors = require("cors");
const db = require("./config/db"); // ✅ Conexión a la base de datos

// 🛠 Crear la app de Express
const app = express();

// ✅ Middlewares globales
app.use(cors()); // Permite peticiones desde otros dominios (ej: localhost:3000)
app.use(express.json()); // Permite recibir datos en formato JSON en las peticiones

// 📦 Importar rutas
const adminRoutes = require("./routes/admin.routes");
const productosRoutes = require("./routes/productos.routes");
const recetasRoutes = require("./routes/recetas.routes"); // ✅ Incluye rutas de recetas

// ✅ Asociar rutas con su prefijo
app.use("/api/admin", adminRoutes); // Rutas para administración
app.use("/productos", productosRoutes); // Rutas para productos
app.use("/api/recetas", recetasRoutes); // ✅ Ruta principal de recetas (incluye /:id/pasos)

// ✅ Verificar conexión a la BD al iniciar
db.query("SELECT 1", (err) => {
  if (err) {
    console.error("❌ Error al conectar con la base de datos:", err);
    process.exit(1); // ❌ Detener ejecución si hay error
  } else {
    console.log("✅ Conexión a la base de datos establecida correctamente.");
  }
});

// ✅ Ruta de prueba básica
app.get("/", (req, res) => {
  res.send("🚀 ¡Servidor funcionando correctamente!");
});

// ✅ Levantar servidor en el puerto definido
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
});
