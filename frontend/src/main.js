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

// Sistema simple de imágenes sin módulos complejos
window.imageService = {
    generateImageHTML: function(src, alt, className, style = '', type = 'services', subtype = null) {
        // Si no hay src, usar imagen por defecto
        if (!src) {
            src = this.getDefaultImage(type, subtype);
        }
        
        return `<img src="${src}" alt="${alt}" class="${className}" style="${style}" 
                onerror="this.src='${this.getDefaultImage(type, subtype)}'">`;
    },
    
    getDefaultImage: function(type, subtype) {
        // Imágenes por defecto según el tipo
        const defaults = {
            'services': 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
            'gallery': 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format',
            'hero': 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format'
        };
        
        return defaults[type] || defaults['services'];
    }
};

// Estilos globales
const globalStyles = document.createElement('style');
globalStyles.textContent = `
    body {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    
    /* Fallback para hero section */
    .hero {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    }
    
    main {
        flex: 1;
    }
    
    .hero {
        color: white;
    }
    
    /* Formularios responsivos */
    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3498db;
        box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
    }
    
    .form-label {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 0.5rem;
    }
    
    /* Cards responsivos */
    .card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    
    .card:hover {
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
    }
    
    /* Mejoras para móviles */
    @media (max-width: 768px) {
        .container {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .card-body {
            padding: 1.5rem 1rem;
        }
        
        .btn-lg {
            padding: 12px 20px;
            font-size: 1rem;
        }
    }
    
    /* Espaciado consistente */
    .mb-3 {
        margin-bottom: 1.25rem !important;
    }
    
    /* Alertas responsivas */
    .alert {
        border-radius: 8px;
        border: none;
        padding: 1rem 1.25rem;
    }
    
    /* Textos de ayuda */
    .form-text {
        font-size: 0.875rem;
        color: #6c757d;
        margin-top: 0.375rem;
    }
    
    /* Footer responsivo */
    footer {
        background: linear-gradient(135deg, #1a1a1a 0%, #2c3e50 100%) !important;
    }
    
    footer h5 {
        font-weight: 600;
        font-size: 0.9rem;
        letter-spacing: 0.5px;
    }
    
    footer .text-light-50 {
        color: rgba(255, 255, 255, 0.7) !important;
        transition: color 0.3s ease;
    }
    
    footer .hover-primary:hover {
        color: #3498db !important;
    }
    
    footer .hover-success:hover {
        color: #28a745 !important;
    }
    
    footer a {
        transition: color 0.3s ease;
    }
    
    footer .bi {
        transition: transform 0.2s ease;
    }
    
    footer a:hover .bi {
        transform: scale(1.1);
    }
    
    /* Footer mobile */
    @media (max-width: 768px) {
        footer {
            padding-top: 3rem !important;
            padding-bottom: 2rem !important;
        }
        
        footer .col-md-6,
        footer .col-md-12 {
            text-align: center !important;
        }
        
        footer .d-flex {
            justify-content: center !important;
        }
    }
    
    /* Contacto page responsive */
    .contact-info-item {
        border-left: 3px solid #3498db;
        padding-left: 1rem;
        margin-bottom: 1rem;
    }
    
    .social-btn {
        transition: all 0.3s ease;
        min-width: 120px;
    }
    
    .social-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    @media (max-width: 768px) {
        .social-btn {
            min-width: 100px;
            font-size: 0.875rem;
        }
        
        .social-btn span {
            display: inline !important;
        }
        
        .contact-info-item {
            border-left: none;
            border-left: 3px solid #3498db;
            padding-left: 1rem;
            margin-bottom: 1rem;
        }
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
