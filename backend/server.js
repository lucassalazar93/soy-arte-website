require("dotenv").config();

const express = require("express");
const cors = require("cors");
const db = require("./config/db"); // Conexión a la BD

const app = express();

// Middleware
app.use(cors());
app.use(express.json());

// Importar rutas de administrador
app.use("/api/admin", require("./routes/admin.routes"));

// Verificar conexión a la base de datos
db.query("SELECT 1", (err) => {
  if (err) {
    console.error("❌ Error al conectar con la base de datos:", err);
    process.exit(1);
  } else {
    console.log("✅ Conexión a la base de datos establecida correctamente.");
  }
});

// Ruta de prueba
app.get("/", (req, res) => {
  res.send("🚀 ¡Servidor funcionando correctamente!");
});

// Iniciar el servidor
const PORT = process.env.PORT || 5000;
app.listen(PORT, () => {
  console.log(`🚀 Servidor corriendo en http://localhost:${PORT}`);
});
