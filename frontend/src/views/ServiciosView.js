// Vista de Servicios
import { t, languageSelectorHTML } from '../i18n.js';
import { serviciosService } from '../services/services';
import { BACKEND_URL } from '../services/api.js';
import { imageService } from '../services/imageService.js';
import { Footer } from '../components/footer.js';

export class ServiciosView {
    constructor() {
        this.servicios = [];
        this.init();
    }

    async init() {
        // Precargar imágenes críticas
        imageService.preloadCriticalImages();
        
        await this.loadData();
        this.render();
        this.bindEvents();
    }

    async loadData() {
        try {
            const response = await serviciosService.getAll();
            this.servicios = response.data || [];
        } catch (error) {
            console.error('Error loading servicios:', error);
            this.showError('Error al cargar los servicios');
        }
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flehttps://handysolutions.up.railway.app/#/contactox-grow-1 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>${t('services.title')}</h1>
                    ${this.isAuthenticated() ? 
                        `<a href="#/solicitar-servicio" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> ${t('services.request')}
                        </a>` : 
                        `<a href="#/login" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> ${t('services.request')}
                        </a>`
                    }
                </div>

                <div id="serviciosAlert" class="alert alert-danger d-none" role="alert"></div>

                <div class="row g-4" id="serviciosContainer">
                    ${this.renderServicios()}
                </div>
            </main>

            ${Footer.getHTML()}
        `;
    }

    renderServicios() {
        if (this.servicios.length === 0) {
            return `<div class="col-12"><p class="text-center text-muted">${t('services.empty')}</p></div>`;
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
                        <p class="card-text text-muted small">${this.truncateText(servicio.descripcion, 100)}</p>
                        <a href="#/servicios/${servicio.slug}" class="btn btn-outline-primary btn-sm">Ver más</a>
                    </div>
                </div>
            </div>
        `).join('');
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
                            <li class="nav-item"><a class="nav-link" href="#/">${t('nav.home')}</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#/servicios">${t('nav.services')}</a></li>
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

    isAuthenticated() {
        return localStorage.getItem('token') !== null;
    }

    getCurrentUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }

    truncateText(text, maxLength) {
        if (!text) return '';
        return text.length > maxLength ? text.substring(0, maxLength) + '...' : text;
    }

    getPlaceholderImage(servicioNombre) {
        const nombre = servicioNombre.toLowerCase();
        
        if (nombre.includes('plomer') || nombre.includes('agua')) {
            return '1581094794329-c8112a89af12';
        } else if (nombre.includes('electric') || nombre.includes('luz')) {
            return '1581092794329-c8112a89af12';
        } else if (nombre.includes('carpinter') || nombre.includes('madera')) {
            return '1581092794329-c8112a89af12';
        } else if (nombre.includes('pintur') || nombre.includes('color')) {
            return '1581092794329-c8112a89af12';
        } else if (nombre.includes('albañ') || nombre.includes('muro') || nombre.includes('construcc')) {
            return '1581092796363-535d3b8c6d91';
        } else if (nombre.includes('impermeabil') || nombre.includes('techumb')) {
            return '1581092796363-535d3b8c6d91';
        } else if (nombre.includes('baño') || nombre.includes('tina') || nombre.includes('regadera')) {
            return '1581092796363-535d3b8c6d91';
        } else if (nombre.includes('reparac') || nombre.includes('arreglo')) {
            return '1581092794329-c8112a89af12';
        } else {
            return '1581092794329-c8112a89af12';
        }
    }

    showError(message) {
        const alert = document.getElementById('serviciosAlert');
        alert.textContent = message;
        alert.classList.remove('d-none');
        
        setTimeout(() => {
            alert.classList.add('d-none');
        }, 5000);
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
}
