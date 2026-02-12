// Vista de Registro
import { authService } from '../services/services';
import { t, languageSelectorHTML } from '../i18n.js';

export class RegisterView {
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
                <div class="row justify-content-center">
                    <div class="col-md-5">
                        <div class="card shadow">
                            <div class="card-body p-4">
                                <h2 class="card-title mb-4 text-center">${t('auth.register.title')}</h2>
                                
                                <div id="registerAlert" class="alert alert-danger d-none" role="alert"></div>
                                
                                <form id="registerForm">
                                    <div class="mb-3">
                                        <label class="form-label">Nombre completo</label>
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">${t('auth.email')}</label>
                                        <input type="email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">${t('auth.password')}</label>
                                        <input type="password" name="password" class="form-control" required minlength="8">
                                        <div class="form-text">Mínimo 8 caracteres</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Confirmar contraseña</label>
                                        <input type="password" name="password_confirmation" class="form-control" required>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100">${t('auth.register.submit')}</button>
                                </form>
                                
                                <p class="mt-3 mb-0 text-center small">
                                    ${t('auth.register.has_account')} <a href="#/login">${t('auth.register.login')}</a>
                                </p>
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
                            <li class="nav-item"><a class="nav-link" href="#/contacto">${t('nav.contact')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/faq">FAQ</a></li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item d-flex align-items-center me-2">${languageSelectorHTML()}</li>
                            <li class="nav-item"><a class="nav-link" href="#/login">${t('nav.login')}</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/register">${t('nav.register')}</a></li>
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

    async bindEvents() {
        const form = document.getElementById('registerForm');
        const alert = document.getElementById('registerAlert');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = new FormData(form);
            const userData = {
                name: formData.get('name'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            };

            // Validar que las contraseñas coincidan
            if (userData.password !== userData.password_confirmation) {
                this.showError('Las contraseñas no coinciden');
                return;
            }

            try {
                const response = await authService.register(userData);
                
                if (response.success) {
                    localStorage.setItem('token', response.data.token);
                    localStorage.setItem('user', JSON.stringify(response.data.user));
                    
                    window.location.hash = '#/';
                    location.reload();
                } else {
                    this.showError(response.message || 'Error al registrar usuario');
                }
            } catch (error) {
                console.error('Register error:', error);
                if (error.response?.data?.errors) {
                    const errors = Object.values(error.response.data.errors).flat();
                    this.showError(errors.join(', '));
                } else {
                    this.showError('Error de conexión. Intenta nuevamente.');
                }
            }
        });
    }

    showError(message) {
        const alert = document.getElementById('registerAlert');
        alert.textContent = message;
        alert.classList.remove('d-none');
        
        setTimeout(() => {
            alert.classList.add('d-none');
        }, 5000);
    }
}
