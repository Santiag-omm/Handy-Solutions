import { Router } from './Router.js';
import { HomeView } from './views/HomeView.js';
import { LoginView } from './views/LoginView.js';
import { RegisterView } from './views/RegisterView.js';
import { ServiciosView } from './views/ServiciosView.js';
import { GaleriaView } from './views/GaleriaView.js';
import { ContactoView } from './views/ContactoView.js';
import { FaqView } from './views/FaqView.js';
import { SolicitarServicioView } from './views/SolicitarServicioView.js';
import { setLang } from './i18n.js';

/**
 * Entry point del frontend (SPA).
 *
 * Responsabilidades:
 * - Inicializar Router.
 * - Registrar rutas/vistas.
 * - Cargar assets externos (Bootstrap).
 * - Inyectar estilos globales mínimos.
 */

// Router
const router = new Router();

// Definir rutas
router.addRoute('/', HomeView);
router.addRoute('/login', LoginView);
router.addRoute('/register', RegisterView);
router.addRoute('/servicios', ServiciosView);
router.addRoute('/galeria', GaleriaView);
router.addRoute('/contacto', ContactoView);
router.addRoute('/faq', FaqView);
router.addRoute('/solicitar-servicio', SolicitarServicioView);

// Ruta 404
router.addRoute('/404', () => {
    const app = document.getElementById('app');
    app.innerHTML = `
        <div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
            <div class="text-center">
                <h1 class="display-1">404</h1>
                <h2>Página no encontrada</h2>
                <p class="text-muted">La página que buscas no existe.</p>
                <a href="#/" class="btn btn-primary">Ir al inicio</a>
            </div>
        </div>
    `;
});

// Cargar Bootstrap CSS dinámicamente
const bootstrapCSS = document.createElement('link');
bootstrapCSS.rel = 'stylesheet';
bootstrapCSS.href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css';
document.head.appendChild(bootstrapCSS);

// Cargar Bootstrap Icons
const bootstrapIcons = document.createElement('link');
bootstrapIcons.rel = 'stylesheet';
bootstrapIcons.href = 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css';
document.head.appendChild(bootstrapIcons);

// Cargar Bootstrap JS
const bootstrapJS = document.createElement('script');
bootstrapJS.src = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js';
document.head.appendChild(bootstrapJS);

// Estilos globales
const globalStyles = document.createElement('style');
globalStyles.textContent = `
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    main {
        flex: 1;
    }
    
    .hero {
        color: white;
    }
    
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    
    .servicio-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .galeria-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    
    .navbar-brand {
        font-size: 1.5rem;
    }
    
    .btn {
        border-radius: 8px;
        padding: 10px 24px;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }
    
    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 20px rgba(0,0,0,0.1);
    }
    
    .navbar-brand {
        color: #2c3e50 !important;
        font-weight: 700;
        font-size: 1.5rem;
    }
    
    .navbar-nav .nav-link {
        color: #2c3e50 !important;
        font-weight: 500;
        margin: 0 8px;
        transition: color 0.3s ease;
    }
    
    .navbar-nav .nav-link:hover {
        color: #3498db !important;
    }
    
    .navbar-nav .nav-link.active {
        color: #3498db !important;
        font-weight: 600;
    }
    
    .alert {
        border-radius: 10px;
        border: none;
    }
    
    .modal-content {
        border-radius: 15px;
        border: none;
    }
    
    .accordion-button:not(.collapsed) {
        background-color: #667eea;
        color: white;
    }
    
    .accordion-button:focus {
        box-shadow: none;
        border-color: #667eea;
    }
`;
document.head.appendChild(globalStyles);

// Hacer disponible globalmente para las vistas
/**
 * API mínima global para que algunas vistas puedan interactuar con el Router.
 * @type {{ router: Router, galeriaView: any }}
 */
window.app = { router, galeriaView: null };

window.app.setLang = (lang) => {
    setLang(lang);
    router.render();
};

// Inicializar la aplicación
document.addEventListener('DOMContentLoaded', () => {
    console.log('HANDY+ Frontend iniciado');
    
    // Verificar si hay un token guardado y actualizar la UI
    const token = localStorage.getItem('token');
    if (token) {
        console.log('Usuario autenticado encontrado');
    }
});
