// Vista de Servicios
import { serviciosService } from '../services/services';
import { BACKEND_URL } from '../services/api.js';
import { t, languageSelectorHTML } from '../i18n.js';

export class ServiciosView {
    constructor() {
        this.servicios = [];
        this.init();
    }

    async init() {
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
            
            <main class="container flex-grow-1 py-4">
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

            ${this.getFooterHTML()}
        `;
    }

    renderServicios() {
        if (this.servicios.length === 0) {
            return `<div class="col-12"><p class="text-center text-muted">${t('services.empty')}</p></div>`;
        }

        return this.servicios.map(servicio => `
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 shadow-sm servicio-card">
                    ${servicio.imagen 
                        ? `<img src="${BACKEND_URL}/storage/${servicio.imagen}" class="card-img-top" alt="${servicio.nombre}" style="height:200px;object-fit:cover">`
                        : `<div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height:200px">
                            <i class="bi bi-tools display-4 text-white"></i>
                          </div>`
                    }
                    <div class="card-body">
                        <h5 class="card-title">${servicio.nombre}</h5>
                        <p class="card-text">${this.truncateText(servicio.descripcion, 120)}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">$${servicio.precio_base || '0'}</span>
                            <a class="btn btn-outline-primary btn-sm" href="#/solicitar-servicio">
                                ${t('services.request')}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        `).join('');
    }

    getNavbarHTML() {
        return `
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
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

    truncateText(text, length) {
        if (!text) return '';
        return text.length > length ? text.substring(0, length) + '...' : text;
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
