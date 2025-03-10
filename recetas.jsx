import { BrowserRouter as Router, Routes, Route, Link } from 'react-router-dom';
import Home from './pages/Home';
import Recetas from './pages/Recetas';
import Blog from './pages/Blog';
import Comunidad from './pages/Comunidad';
import Tienda from './pages/Tienda';
import Contacto from './pages/Contacto';

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

// Recetas.jsx
import React from 'react';
import { Link } from 'react-router-dom';

const recetasData = [
  { id: 1, nombre: "Torta de Chocolate", categoria: "Postres", imagen: "https://via.placeholder.com/150" },
  { id: 2, nombre: "Ensalada Detox", categoria: "Saludable", imagen: "https://via.placeholder.com/150" },
  { id: 3, nombre: "Pizza Casera", categoria: "Comida Rápida", imagen: "https://via.placeholder.com/150" }
];

const Recetas = () => {
  return (
    <div className="max-w-4xl mx-auto p-6">
      <h2 className="text-3xl font-bold text-gray-800">Recetas</h2>
      <p className="text-gray-600 mt-2">Explora nuestras recetas organizadas por categorías.</p>
      
      {/* Tarjetas de recetas */}
      <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
        {recetasData.map((receta) => (
          <div key={receta.id} className="bg-white p-4 shadow-md rounded-lg">
            <img src={receta.imagen} alt={receta.nombre} className="w-full h-40 object-cover rounded" />
            <h3 className="text-lg font-semibold mt-2">{receta.nombre}</h3>
            <p className="text-gray-500">{receta.categoria}</p>
            <Link to={`/recetas/${receta.id}`} className="text-blue-500 hover:underline block mt-2">Ver receta</Link>
          </div>
        ))}
      </div>
    </div>
  );
};

export default Recetas;
