// Vista de Contacto
import { t, languageSelectorHTML } from '../i18n.js';

export class ContactoView {
    constructor() {
        this.init();
    }

    init() {
        this.render();
        this.bindEvents();
    }

    render() {
        const app = document.getElementById('app');
        app.innerHTML = `
            ${this.getNavbarHTML()}
            
            <main class="container flex-grow-1 py-4">
                <div class="row">
                    <div class="col-md-8">
                        <div class="card shadow">
                            <div class="card-header bg-primary text-white">
                                <h4 class="mb-0">${t('contact.title')}</h4>
                            </div>
                            <div class="card-body">
                                <div id="contactoAlert" class="alert alert-danger d-none" role="alert"></div>
                                <div id="contactoSuccess" class="alert alert-success d-none" role="alert"></div>
                                
                                <form id="contactoForm">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre completo *</label>
                                        <input type="text" name="nombre" class="form-control" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Correo electrónico *</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Teléfono</label>
                                        <input type="tel" name="telefono" class="form-control" placeholder="Opcional">
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Asunto *</label>
                                        <select name="asunto" class="form-select" required>
                                            <option value="">Selecciona un asunto</option>
                                            <option value="consulta">Consulta general</option>
                                            <option value="servicio">Información de servicios</option>
                                            <option value="cotizacion">Solicitud de cotización</option>
                                            <option value="reclamo">Reclamo o queja</option>
                                            <option value="otro">Otro</option>
                                        </select>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label class="form-label">Mensaje *</label>
                                        <textarea name="mensaje" class="form-control" rows="5" required 
                                                placeholder="Escribe tu mensaje aquí..."></textarea>
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
                    
                    <div class="col-md-4">
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <h5 class="card-title">Información de Contacto</h5>
                                <div class="mb-3">
                                    <strong><i class="bi bi-geo-alt"></i> Dirección:</strong><br>
                                    Calle Principal #123, Colonia Centro<br>
                                    Ciudad, Estado, CP 12345
                                </div>
                                <div class="mb-3">
                                    <strong><i class="bi bi-telephone"></i> Teléfono:</strong><br>
                                    (555) 123-4567<br>
                                    (555) 891-0123
                                </div>
                                <div class="mb-3">
                                    <strong><i class="bi bi-envelope"></i> Correo:</strong><br>
                                    info@handysolutions.com<br>
                                    soporte@handysolutions.com
                                </div>
                                <div class="mb-3">
                                    <strong><i class="bi bi-clock"></i> Horario:</strong><br>
                                    Lunes a Viernes: 9:00 AM - 6:00 PM<br>
                                    Sábados: 9:00 AM - 2:00 PM<br>
                                    Domingos: Cerrado
                                </div>
                            </div>
                        </div>
                        
                        <div class="card shadow">
                            <div class="card-body">
                                <h5 class="card-title">Síguenos en Redes</h5>
                                <div class="d-flex justify-content-around">
                                    <a href="#" class="text-primary fs-4"><i class="bi bi-facebook"></i></a>
                                    <a href="#" class="text-info fs-4"><i class="bi bi-twitter"></i></a>
                                    <a href="#" class="text-danger fs-4"><i class="bi bi-instagram"></i></a>
                                    <a href="#" class="text-primary fs-4"><i class="bi bi-linkedin"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            ${this.getFooterHTML()}
        `;
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
                // Simulación de envío (en producción sería una API real)
                await new Promise(resolve => setTimeout(resolve, 1000));
                
                this.showSuccess('Mensaje enviado correctamente. Te responderemos a la brevedad.');
                form.reset();
            } catch (error) {
                console.error('Contacto error:', error);
                this.showError('Error al enviar el mensaje. Intenta nuevamente.');
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
