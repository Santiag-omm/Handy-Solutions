// Vista de Contacto
import { t, languageSelectorHTML } from '../i18n.js';
import { contactoService } from '../services/contactoService.js';
import { contactoInfoService } from '../services/contactoInfoService.js';
import { Footer } from '../components/footer.js';

export class ContactoView {
    constructor() {
        this.contactoInfo = null;
        this.init();
    }

    async init() {
        await this.loadContactoInfo();
        this.render();
        this.bindEvents();
    }

    async loadContactoInfo() {
        try {
            const response = await contactoInfoService.getInfo();
            this.contactoInfo = response.data;
        } catch (error) {
            console.error('Error al cargar información de contacto:', error);
        }
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flex-grow-1 py-4">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">${t('contact.title')}</h4>
                            </div>
                            <div class="card-body">
                                <div id="contactoAlert" class="alert alert-danger d-none" role="alert"></div>
                                <div id="contactoSuccess" class="alert alert-success d-none" role="alert"></div>
                                
                                <form id="contactoForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">${t('contact.name')} *</label>
                                                <input type="text" name="nombre" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">${t('contact.email')} *</label>
                                                <input type="email" name="email" class="form-control" required>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">${t('contact.phone')}</label>
                                                <input type="tel" name="telefono" class="form-control" placeholder="${t('contact.phone_placeholder')}">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">${t('contact.subject')} *</label>
                                                <select name="asunto" class="form-select" required>
                                                    <option value="">${t('contact.subject_select')}</option>
                                                    <option value="consulta">${t('contact.subject_general')}</option>
                                                    <option value="servicio">${t('contact.subject_service')}</option>
                                                    <option value="cotizacion">${t('contact.subject_quote')}</option>
                                                    <option value="reclamo">${t('contact.subject_complaint')}</option>
                                                    <option value="otro">${t('contact.subject_other')}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">${t('contact.message')} *</label>
                                        <textarea name="mensaje" class="form-control" rows="5" required 
                                                placeholder="${t('contact.message_placeholder')}"></textarea>
                                    </div>
                                    
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-primary btn-lg">
                                            <i class="bi bi-send"></i> ${t('contact.send')}
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 class="card-title">${t('contact.info')}</h5>
                                ${this.contactoInfo ? `
                                <div class="mb-3 contact-info-item">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-geo-alt text-primary me-3 mt-1"></i>
                                        <div>
                                            <strong>${t('contact.address')}</strong><br>
                                            <small class="text-muted">${this.contactoInfo.direccion || 'No disponible'}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 contact-info-item">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-telephone text-primary me-3 mt-1"></i>
                                        <div>
                                            <strong>${t('contact.phone_label')}</strong><br>
                                            <small class="text-muted">
                                                ${this.contactoInfo.telefono1 ? `<a href="tel:${this.contactoInfo.telefono1.replace(/[^\d]/g, '')}" class="text-decoration-none">${this.contactoInfo.telefono1}</a>` : 'No disponible'}<br>
                                                ${this.contactoInfo.telefono2 ? `<a href="tel:${this.contactoInfo.telefono2.replace(/[^\d]/g, '')}" class="text-decoration-none">${this.contactoInfo.telefono2}</a>` : ''}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 contact-info-item">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-envelope text-primary me-3 mt-1"></i>
                                        <div>
                                            <strong>${t('contact.email_label')}</strong><br>
                                            <small class="text-muted">
                                                ${this.contactoInfo.email1 ? `<a href="mailto:${this.contactoInfo.email1}" class="text-decoration-none">${this.contactoInfo.email1}</a>` : 'No disponible'}<br>
                                                ${this.contactoInfo.email2 ? `<a href="mailto:${this.contactoInfo.email2}" class="text-decoration-none">${this.contactoInfo.email2}</a>` : ''}
                                            </small>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3 contact-info-item">
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-clock text-primary me-3 mt-1"></i>
                                        <div>
                                            <strong>${t('contact.hours')}</strong><br>
                                            <small class="text-muted">${this.contactoInfo.horario || 'No disponible'}</small>
                                        </div>
                                    </div>
                                </div>
                            ` : `
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </div>
                            `}
                            </div>
                        </div>
                        
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title mb-4">${t('footer.follow_us')}</h5>
                                ${this.contactoInfo ? `
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    ${this.contactoInfo.facebook ? `
                                    <a href="${this.contactoInfo.facebook}" target="_blank" class="btn btn-outline-primary btn-sm social-btn d-flex align-items-center">
                                        <i class="bi bi-facebook me-2"></i>
                                        <span class="d-none d-md-inline">Facebook</span>
                                    </a>` : ''}
                                    ${this.contactoInfo.instagram ? `
                                    <a href="${this.contactoInfo.instagram}" target="_blank" class="btn btn-outline-danger btn-sm social-btn d-flex align-items-center">
                                        <i class="bi bi-instagram me-2"></i>
                                        <span class="d-none d-md-inline">Instagram</span>
                                    </a>` : ''}
                                    ${this.contactoInfo.twitter ? `
                                    <a href="${this.contactoInfo.twitter}" target="_blank" class="btn btn-outline-info btn-sm social-btn d-flex align-items-center">
                                        <i class="bi bi-twitter me-2"></i>
                                        <span class="d-none d-md-inline">Twitter</span>
                                    </a>` : ''}
                                    ${this.contactoInfo.whatsapp ? `
                                    <a href="${this.contactoInfo.whatsapp}" target="_blank" class="btn btn-outline-success btn-sm social-btn d-flex align-items-center">
                                        <i class="bi bi-whatsapp me-2"></i>
                                        <span class="d-none d-md-inline">WhatsApp</span>
                                    </a>` : ''}
                                </div>
                            ` : `
                                <div class="text-center py-3">
                                    <div class="spinner-border text-primary" role="status">
                                        <span class="visually-hidden">Cargando...</span>
                                    </div>
                                </div>
                            `}
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            ${Footer.getHTML()}
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
                            <li class="nav-item"><a class="nav-link" href="#/">${t('nav.home')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/servicios">${t('nav.services')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/galeria">${t('nav.gallery')}</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#/contacto">${t('nav.contact')}</a></li>
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

    
    isAuthenticated() {
        return localStorage.getItem('token') !== null;
    }

    getCurrentUser() {
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }

    bindEvents() {
        const form = document.getElementById('contactoForm');
        const alert = document.getElementById('contactoAlert');
        const success = document.getElementById('contactoSuccess');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const contactoData = {
                nombre: formData.get('nombre'),
                email: formData.get('email'),
                telefono: formData.get('telefono'),
                asunto: formData.get('asunto'),
                mensaje: formData.get('mensaje')
            };

            try {
                const response = await contactoService.enviar(contactoData);
                
                this.showSuccess(t('contact.success'));
                form.reset();
            } catch (error) {
                console.error('Contacto error:', error);
                this.showError(t('contact.error'));
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
        const alert = document.getElementById('contactoAlert');
        alert.textContent = message;
        alert.classList.remove('d-none');
        
        setTimeout(() => {
            alert.classList.add('d-none');
        }, 5000);
    }

    showSuccess(message) {
        const success = document.getElementById('contactoSuccess');
        success.textContent = message;
        success.classList.remove('d-none');
        
        setTimeout(() => {
            success.classList.add('d-none');
        }, 5000);
    }
}
