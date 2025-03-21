const jwt = require("jsonwebtoken");

module.exports = (req, res, next) => {
  const token = req.header("Authorization"); // 📌 Obtener el token del encabezado

  if (!token) {
    return res.status(401).json({ error: "Acceso denegado, token requerido" });
  }

  try {
    const verified = jwt.verify(token, process.env.JWT_SECRET); // 📌 Verificar el token
    req.admin = verified; // 📌 Guardamos los datos del usuario autenticado
    next(); // 📌 Continuar con la siguiente función en la ruta protegida
  } catch (error) {
    res.status(400).json({ error: "Token inválido" });
  }
};
