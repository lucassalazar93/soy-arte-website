import { BrowserRouter as Router, Routes, Route, Link, useParams } from 'react-router-dom';
import Home from './pages/Home';
import Recetas from './pages/Recetas';
import Blog from './pages/Blog';
import Comunidad from './pages/Comunidad';
import Tienda from './pages/Tienda';
import Contacto from './pages/Contacto';
import RecetaDetalle from './pages/RecetaDetalle';

function App() {
  return (
    <Router>
      <div className="min-h-screen bg-gray-100">
        <nav className="bg-white shadow-md p-4 flex justify-between">
          <h1 className="text-xl font-bold">Soy Arte</h1>
          <ul className="flex space-x-4">
            <li><Link to="/" className="text-blue-500 hover:underline">Inicio</Link></li>
            <li><Link to="/recetas" className="text-blue-500 hover:underline">Recetas</Link></li>
            <li><Link to="/blog" className="text-blue-500 hover:underline">Blog</Link></li>
            <li><Link to="/comunidad" className="text-blue-500 hover:underline">Comunidad</Link></li>
            <li><Link to="/tienda" className="text-blue-500 hover:underline">Tienda</Link></li>
            <li><Link to="/contacto" className="text-blue-500 hover:underline">Contacto</Link></li>
          </ul>
        </nav>
        
        <Routes>
          <Route path="/" element={<Home />} />
          <Route path="/recetas" element={<Recetas />} />
          <Route path="/recetas/:id" element={<RecetaDetalle />} />
          <Route path="/blog" element={<Blog />} />
          <Route path="/comunidad" element={<Comunidad />} />
          <Route path="/tienda" element={<Tienda />} />
          <Route path="/contacto" element={<Contacto />} />
        </Routes>
      </div>
    </Router>
  );
}

export default App;

// RecetaDetalle.jsx
import React from 'react';
import { useParams } from 'react-router-dom';

const recetasData = [
  { id: 1, nombre: "Torta de Chocolate", categoria: "Postres", imagen: "https://via.placeholder.com/150", ingredientes: ["Harina", "Azúcar", "Chocolate"], pasos: ["Mezclar ingredientes", "Hornear", "Servir"] },
  { id: 2, nombre: "Ensalada Detox", categoria: "Saludable", imagen: "https://via.placeholder.com/150", ingredientes: ["Lechuga", "Zanahoria", "Pepino"], pasos: ["Lavar ingredientes", "Cortar", "Servir"] },
  { id: 3, nombre: "Pizza Casera", categoria: "Comida Rápida", imagen: "https://via.placeholder.com/150", ingredientes: ["Harina", "Tomate", "Queso"], pasos: ["Preparar masa", "Añadir ingredientes", "Hornear"] }
];

const RecetaDetalle = () => {
  const { id } = useParams();
  const receta = recetasData.find((r) => r.id === parseInt(id));

  if (!receta) {
    return <h2 className="text-center text-red-500">Receta no encontrada</h2>;
  }

  return (
    <div className="max-w-2xl mx-auto p-6">
      <h2 className="text-3xl font-bold text-gray-800">{receta.nombre}</h2>
      <img src={receta.imagen} alt={receta.nombre} className="w-full h-60 object-cover rounded-lg mt-4" />
      <p className="text-gray-500 mt-2">Categoría: {receta.categoria}</p>
      <h3 className="text-xl font-semibold mt-4">Ingredientes:</h3>
      <ul className="list-disc pl-6 text-gray-600">
        {receta.ingredientes.map((ing, index) => (
          <li key={index}>{ing}</li>
        ))}
      </ul>
      <h3 className="text-xl font-semibold mt-4">Pasos:</h3>
      <ol className="list-decimal pl-6 text-gray-600">
        {receta.pasos.map((paso, index) => (
          <li key={index}>{paso}</li>
        ))}
      </ol>
    </div>
  );
};

export default RecetaDetalle;
