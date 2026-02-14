// Vista principal
import { serviciosService, galeriaService } from '../services/services';
import { BACKEND_URL } from '../services/api.js';
import { t, languageSelectorHTML } from '../i18n.js';
import { heroService } from '../services/heroService.js';
import { imageService } from '../services/imageService.js';
import { Footer } from '../components/footer.js';

export class HomeView {
    constructor() {
        this.servicios = [];
        this.galeria = [];
        this.heroSettings = null;
        this.init();
    }

    async init() {
        // Precargar imágenes críticas
        imageService.preloadCriticalImages();
        
        await Promise.all([
            this.loadData(),
            this.loadHeroSettings()
        ]);
        this.render();
        this.bindEvents();
    }

    async loadHeroSettings() {
        try {
            const response = await heroService.getSettings();
            this.heroSettings = response.data;
        } catch (error) {
            console.error('Error al cargar configuración del hero:', error);
        }
    }

    async loadData() {
        try {
            const [serviciosResponse, galeriaResponse] = await Promise.all([
                serviciosService.getAll(),
                galeriaService.getAll(6)
            ]);
            
            this.servicios = serviciosResponse.data || [];
            this.galeria = galeriaResponse.data || [];
        } catch (error) {
            console.error('Error loading data:', error);
            this.showError('Error al cargar los datos');
        }
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flex-grow-1 py-4">
                ${this.heroSettings && this.heroSettings.activo ? `
                <section class="hero rounded-3 p-5 mb-5 text-center position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${imageService.getHeroImage(this.heroSettings.imagen_fondo)}'); background-size: cover; background-position: center; color: white; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    <h1 class="display-4 fw-bold text-white">${this.heroSettings.titulo}</h1>
                    <p class="lead text-white">${this.heroSettings.subtitulo}</p>
                    <p class="text-white-50">${this.heroSettings.descripcion}</p>
                    <a href="${this.heroSettings.enlace_boton}" class="btn btn-warning btn-lg mt-3">
                        <i class="bi bi-tools"></i> ${this.heroSettings.texto_boton}
                    </a>
                </section>
            ` : `
                <section class="hero rounded-3 p-5 mb-5 text-center position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('${imageService.getHeroImage()}'); background-size: cover; background-position: center; color: white; min-height: 400px; display: flex; align-items: center; justify-content: center;">
                    <h1 class="display-4 fw-bold text-white">${t('home.hero.title')}</h1>
                    <p class="lead text-white">${t('home.hero.subtitle')}</p>
                    <p class="text-white-50">${t('home.hero.desc')}</p>
                    <a href="#/solicitar-servicio" class="btn btn-warning btn-lg mt-3">
                        <i class="bi bi-tools"></i> ${t('nav.request_service')}
                    </a>
                </section>
            `}

                <section class="mb-5">
                    <h2 class="h3 mb-4">${t('home.services.title')}</h2>
                    <div class="row g-4" id="serviciosContainer">
                        ${this.renderServicios()}
                    </div>
                </section>

                ${this.galeria.length > 0 ? this.renderGaleria() : ''}
            </main>

            ${Footer.getHTML()}
        `;
    }

    renderServicios() {
        if (this.servicios.length === 0) {
            return '<div class="col-12"><p class="text-center text-muted">No hay servicios disponibles</p></div>';
        }

        return this.servicios.map(servicio => `
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    ${imageService.generateImageHTML(
                        servicio.imagen ? `${BACKEND_URL}/storage/${servicio.imagen}` : null,
                        servicio.nombre,
                        'card-img-top',
                        'height:180px;object-fit:cover'
                    )}
                    <div class="card-body">
                        <h5 class="card-title">${servicio.nombre}</h5>
                        <p class="card-text text-muted small">${this.truncateText(servicio.descripcion, 80)}</p>
                        <a href="#/servicios/${servicio.slug}" class="btn btn-outline-primary btn-sm">Ver más</a>
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderGaleria() {
        return `
            <section class="mb-5">
                <h2 class="h3 mb-4">${t('home.gallery.title')}</h2>
                <div class="row g-3">
                    ${this.galeria.map(item => `
                        <div class="col-6 col-md-4">
                            ${imageService.generateImageHTML(
                                `${BACKEND_URL}/storage/${item.imagen}`,
                                item.titulo,
                                'img-fluid rounded shadow-sm',
                                'height:180px;width:100%;object-fit:cover'
                            )}
                        </div>
                    `).join('')}
                </div>
                <div class="text-center mt-3">
                    <a href="#/galeria" class="btn btn-outline-secondary">${t('home.gallery.cta')}</a>
                </div>
            </section>
        `;
    }

    getNavbarHTML() {
        return `
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="#/">${t('app.name')}</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link active" href="#/">${t('nav.home')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/servicios">${t('nav.services')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/galeria">${t('nav.gallery')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/contacto">${t('nav.contact')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/faq">FAQ</a></li>
                            ${this.isAuthenticated() ? 
                                `<li class="nav-item"><a class="nav-link" href="#/solicitar-servicio">${t('nav.request_service')}</a></li>` : ''
                            }
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item d-flex align-items-center me-2">${languageSelectorHTML()}</li>
                            ${this.isAuthenticated() ? 
                                `<li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                        ${this.getCurrentUser().name}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" id="logoutBtn">${t('nav.logout')}</a></li>
                                    </ul>
                                </li>` :
                                `<li class="nav-item"><a class="nav-link" href="#/login">${t('nav.login')}</a></li>
                                <li class="nav-item"><a class="nav-link" href="#/register">${t('nav.register')}</a></li>`
                            }
                        </ul>
                    </div>
                </div>
            </nav>
        `;
    }

    getFooterHTML() {
        return `
            <footer class="bg-dark text-light py-4 mt-auto">
                <div class="container text-center">
                    <p class="mb-0">&copy; ${new Date().getFullYear()} HANDY SOLUTIONS. Soluciones de reparación en el hogar.</p>
                </div>
            </footer>
        `;
    }

    truncateText(text, maxLength) {
        if (!text) return '';
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    }

    getPlaceholderImage(servicioNombre) {
        const nombre = servicioNombre.toLowerCase();
        
        if (nombre.includes('plomer') || nombre.includes('agua')) {
            return '1581094794329-c8112a89af12'; // Herramientas de plomería
        } else if (nombre.includes('electric') || nombre.includes('luz')) {
            return '1581092794329-c8112a89af12'; // Herramientas eléctricas
        } else if (nombre.includes('carpinter') || nombre.includes('madera')) {
            return '1581092794329-c8112a89af12'; // Herramientas de carpintería
        } else if (nombre.includes('pintur') || nombre.includes('color')) {
            return '1581092794329-c8112a89af12'; // Pintura
        } else if (nombre.includes('albañ') || nombre.includes('muro') || nombre.includes('construcc')) {
            return '1581092796363-535d3b8c6d91'; // Construcción
        } else if (nombre.includes('impermeabil') || nombre.includes('techumb')) {
            return '1581092796363-535d3b8c6d91'; // Techo/impermeabilización
        } else if (nombre.includes('baño') || nombre.includes('tina') || nombre.includes('regadera')) {
            return '1581092796363-535d3b8c6d91'; // Baño
        } else if (nombre.includes('reparac') || nombre.includes('arreglo')) {
            return '1581092794329-c8112a89af12'; // Reparación general
        } else {
            return '1581092794329-c8112a89af12'; // Herramientas generales
        }
    }

    showError(message) {
        const alertHTML = `
            <div class="container mt-2">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('afterbegin', alertHTML);
    }

    bindEvents() {
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.hash = '#/login';
                location.reload();
            });
        }
    }

    isAuthenticated() {
        return localStorage.getItem('token') !== null;
    }

    getCurrentUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }
}
