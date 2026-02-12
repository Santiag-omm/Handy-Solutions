// Vista de Galería
import { galeriaService } from '../services/services';
import { t, languageSelectorHTML } from '../i18n.js';

export class GaleriaView {
    constructor() {
        this.trabajos = [];
        this.currentPage = 1;
        this.perPage = 12;
        // Registrar instancia global para el modal
        window.app.galeriaView = this;
        this.init();
    }

    async init() {
        await this.loadData();
        this.render();
        this.bindEvents();
    }

    async loadData() {
        try {
            const response = await galeriaService.getAll(this.perPage * 2); // Cargar más para paginación
            this.trabajos = response.data || [];
        } catch (error) {
            console.error('Error loading galeria:', error);
            this.showError('Error al cargar la galería');
        }
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flex-grow-1 py-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>${t('gallery.title')}</h1>
                    <span class="badge bg-secondary">${this.trabajos.length} trabajos realizados</span>
                </div>

                <div id="galeriaAlert" class="alert alert-danger d-none" role="alert"></div>

                <div class="row g-4" id="galeriaContainer">
                    ${this.renderTrabajos()}
                </div>

                ${this.trabajos.length > this.perPage ? `
                    <div class="text-center mt-4">
                        <button class="btn btn-outline-primary" id="loadMoreBtn">
                            ${t('gallery.load_more')}
                        </button>
                    </div>
                ` : ''}
            </main>

            ${this.getFooterHTML()}
        `;
    }

    renderTrabajos() {
        if (this.trabajos.length === 0) {
            return `<div class="col-12"><p class="text-center text-muted">${t('gallery.empty')}</p></div>`;
        }

        const trabajosToShow = this.trabajos.slice(0, this.perPage * this.currentPage);
        
        return trabajosToShow.map(trabajo => `
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-sm galeria-card">
                    <img src="/storage/${trabajo.imagen}" 
                         alt="${trabajo.titulo}" 
                         class="card-img-top" 
                         style="height:250px;object-fit:cover;cursor:pointer"
                         onclick="app.galeriaView.showImageModal('${trabajo.imagen}', '${trabajo.titulo}', '${trabajo.descripcion || ''}')">
                    <div class="card-body">
                        <h5 class="card-title">${trabajo.titulo}</h5>
                        ${trabajo.descripcion ? 
                            `<p class="card-text text-muted">${this.truncateText(trabajo.descripcion, 80)}</p>` : ''
                        }
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
                            <li class="nav-item"><a class="nav-link" href="#/servicios">${t('nav.services')}</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#/galeria">${t('nav.gallery')}</a></li>
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
        const alert = document.getElementById('galeriaAlert');
        alert.textContent = message;
        alert.classList.remove('d-none');
        
        setTimeout(() => {
            alert.classList.add('d-none');
        }, 5000);
    }

    showImageModal(image, title, description) {
        const modal = document.createElement('div');
        modal.className = 'modal fade';
        modal.innerHTML = `
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">${title}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-center">
                        <img src="/storage/${image}" alt="${title}" class="img-fluid rounded">
                        ${description ? `<p class="mt-3">${description}</p>` : ''}
                    </div>
                </div>
            </div>
        `;
        
        document.body.appendChild(modal);
        const bsModal = new bootstrap.Modal(modal);
        bsModal.show();
        
        modal.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modal);
        });
    }

    bindEvents() {
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', () => {
                this.currentPage++;
                this.render();
            });
        }

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
