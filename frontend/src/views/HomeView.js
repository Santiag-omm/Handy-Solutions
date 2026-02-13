// Vista principal
import { serviciosService, galeriaService } from '../services/services';
import { BACKEND_URL } from '../services/api.js';
import { t, languageSelectorHTML } from '../i18n.js';

export class HomeView {
    constructor() {
        this.servicios = [];
        this.galeria = [];
        this.init();
    }

    async init() {
        await this.loadData();
        this.render();
        this.bindEvents();
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
                <section class="hero rounded-3 p-5 mb-5 text-center position-relative overflow-hidden" style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&h=600&fit=crop&auto=format'); background-size: cover; background-position: center; color: white;">
                    <h1 class="display-4 fw-bold text-white">${t('home.hero.title')}</h1>
                    <p class="lead text-white">${t('home.hero.subtitle')}</p>
                    <p class="text-white-50">${t('home.hero.desc')}</p>
                    <a href="#/solicitar-servicio" class="btn btn-warning btn-lg mt-3">
                        <i class="bi bi-tools"></i> ${t('nav.request_service')}
                    </a>
                </section>

                <section class="mb-5">
                    <h2 class="h3 mb-4">${t('home.services.title')}</h2>
                    <div class="row g-4" id="serviciosContainer">
                        ${this.renderServicios()}
                    </div>
                </section>

                ${this.galeria.length > 0 ? this.renderGaleria() : ''}
            </main>

            ${this.getFooterHTML()}
        `;
    }

    renderServicios() {
        if (this.servicios.length === 0) {
            return '<div class="col-12"><p class="text-center text-muted">No hay servicios disponibles</p></div>';
        }

        return this.servicios.map(servicio => `
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm">
                    ${servicio.imagen 
                        ? `<img src="${BACKEND_URL}/storage/${servicio.imagen}" class="card-img-top" alt="${servicio.nombre}" style="height:180px;object-fit:cover">`
                        : `<div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:180px">
                            <i class="bi bi-tools display-4 text-white"></i>
                          </div>`
                    }
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
                            <img src="${BACKEND_URL}/storage/${item.imagen}" alt="${item.titulo}" class="img-fluid rounded shadow-sm" style="height:180px;width:100%;object-fit:cover">
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

    truncateText(text, length) {
        if (!text) return '';
        return text.length > length ? text.substring(0, length) + '...' : text;
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
