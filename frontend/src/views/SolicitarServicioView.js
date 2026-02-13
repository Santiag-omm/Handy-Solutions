// Vista de Solicitar Servicio
import { serviciosService, solicitudesService } from '../services/services';
import { t, languageSelectorHTML } from '../i18n.js';

export class SolicitarServicioView {
    constructor() {
        this.servicios = [];
        this.init();
    }

    async init() {
        if (!this.isAuthenticated()) {
            window.location.hash = '#/login';
            return;
        }
        
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
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">${t('request.title')}</h4>
                            </div>
                            <div class="card-body">
                                <div id="solicitudAlert" class="alert alert-danger d-none" role="alert"></div>
                                <div id="solicitudSuccess" class="alert alert-success d-none" role="alert"></div>
                                
                                <form id="solicitudForm">
                                    <div class="mb-3">
                                        <label class="form-label">${t('request.service')} *</label>
                                        <select name="servicio_id" class="form-select" required>
                                            <option value="">${t('request.service_select')}</option>
                                            ${this.renderServiciosOptions()}
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">${t('request.description')} *</label>
                                        <textarea name="descripcion" class="form-control" rows="4" required 
                                                placeholder="${t('request.description_placeholder')}"></textarea>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">${t('request.address')} *</label>
                                        <input type="text" name="direccion" class="form-control" required 
                                               placeholder="${t('request.address_placeholder')}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">${t('request.phone')} *</label>
                                        <input type="tel" name="telefono" class="form-control" required 
                                               placeholder="${t('request.phone_placeholder')}">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">${t('request.date')} *</label>
                                        <input type="date" name="fecha_preferida" class="form-control" required>
                                        <div class="form-text">${t('request.date_placeholder')}</div>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-send"></i> ${t('request.submit')}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            ${this.getFooterHTML()}
        `;
    }

    renderServiciosOptions() {
        return this.servicios.map(servicio => 
            `<option value="${servicio.id}">${servicio.nombre} - $${servicio.precio_base || '0'}</option>`
        ).join('');
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
                            <li class="nav-item"><a class="nav-link" href="#/servicios">${t('nav.services')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/galeria">${t('nav.gallery')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/contacto">${t('nav.contact')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/faq">FAQ</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#/solicitar-servicio">${t('nav.request_service')}</a></li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item d-flex align-items-center me-2">${languageSelectorHTML()}</li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                    ${this.getCurrentUser().name}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#" id="logoutBtn">${t('nav.logout')}</a></li>
                                </ul>
                            </li>
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

    async bindEvents() {
        const form = document.getElementById('solicitudForm');
        const alert = document.getElementById('solicitudAlert');
        const success = document.getElementById('solicitudSuccess');
        
        // Establecer fecha mínima como mañana
        const fechaInput = form.querySelector('input[name="fecha_preferida"]');
        const tomorrow = new Date();
        tomorrow.setDate(tomorrow.getDate() + 1);
        fechaInput.min = tomorrow.toISOString().split('T')[0];

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const solicitudData = {
                servicio_id: parseInt(formData.get('servicio_id')),
                descripcion: formData.get('descripcion'),
                direccion: formData.get('direccion'),
                telefono: formData.get('telefono'),
                fecha_preferida: formData.get('fecha_preferida')
            };

            try {
                const response = await solicitudesService.create(solicitudData);
                
                if (response.success) {
                    this.showSuccess('Solicitud enviada correctamente. Te contactaremos pronto.');
                    form.reset();
                    
                    setTimeout(() => {
                        window.location.hash = '#/';
                    }, 3000);
                } else {
                    this.showError(response.message || 'Error al enviar la solicitud');
                }
            } catch (error) {
                console.error('Solicitud error:', error);
                if (error.response?.data?.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    this.showError(errors.join(', '));
                } else {
                    this.showError('Error de conexión. Intenta nuevamente.');
                }
            }
        });

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

    showError(message) {
        const alert = document.getElementById('solicitudAlert');
        alert.textContent = message;
        alert.classList.remove('d-none');
        
        setTimeout(() => {
            alert.classList.add('d-none');
        }, 5000);
    }

    showSuccess(message) {
        const success = document.getElementById('solicitudSuccess');
        success.textContent = message;
        success.classList.remove('d-none');
        
        setTimeout(() => {
            success.classList.add('d-none');
        }, 5000);
    }
}
