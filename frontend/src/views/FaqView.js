// Vista de FAQ
import { faqService } from '../services/services';
import { t, languageSelectorHTML } from '../i18n.js';

export class FaqView {
    constructor() {
        this.faqs = [];
        this.init();
    }

    async init() {
        await this.loadData();
        this.render();
        this.bindEvents();
    }

    async loadData() {
        try {
            const response = await faqService.getAll();
            this.faqs = response.data || [];
        } catch (error) {
            console.error('Error loading FAQs:', error);
            this.showError('Error al cargar las preguntas frecuentes');
        }
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flex-grow-1 py-4">
                <div class="row">
                    <div class="col-md-8 mx-auto">
                        <div class="text-center mb-5">
                            <h1 class="mb-3">${t('faq.title')}</h1>
                            <p class="lead text-muted">${t('faq.subtitle')}</p>
                        </div>

                        <div id="faqAlert" class="alert alert-danger d-none" role="alert"></div>

                        <div class="accordion" id="faqAccordion">
                            ${this.renderFAQs()}
                        </div>

                        ${this.faqs.length === 0 ? 
                            `<div class="text-center"><p class="text-muted">${t('faq.empty')}</p></div>` : ''
                        }

                        <div class="card shadow mt-5">
                            <div class="card-body text-center">
                                <h5 class="card-title">${t('faq.not_found_title')}</h5>
                                <p class="card-text">${t('faq.not_found_desc')}</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="#/contacto" class="btn btn-primary">
                                        <i class="bi bi-envelope"></i> ${t('faq.contact')}
                                    </a>
                                    <a href="#/solicitar-servicio" class="btn btn-outline-primary">
                                        <i class="bi bi-tools"></i> ${t('nav.request_service')}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            ${this.getFooterHTML()}
        `;
    }

    renderFAQs() {
        if (this.faqs.length === 0) return '';

        return this.faqs.map((faq, index) => `
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button ${index > 0 ? 'collapsed' : ''}" 
                            type="button" 
                            data-bs-toggle="collapse" 
                            data-bs-target="#faq${index}">
                        ${faq.pregunta}
                    </button>
                </h2>
                <div id="faq${index}" class="accordion-collapse collapse ${index === 0 ? 'show' : ''}" 
                     data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        ${faq.respuesta}
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
                            <li class="nav-item"><a class="nav-link" href="#/galeria">${t('nav.gallery')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/contacto">${t('nav.contact')}</a></li>
                            <li class="nav-item"><a class="nav-link active" href="#/faq">FAQ</a></li>
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

    showError(message) {
        const alert = document.getElementById('faqAlert');
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
