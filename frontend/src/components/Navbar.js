// Componente de navegación
export class Navbar {
    constructor() {
        this.user = null;
        this.init();
    }

    init() {
        this.render();
        this.checkAuth();
    }

    render() {
        return `
            <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
                <div class="container">
                    <a class="navbar-brand fw-bold" href="#/">HANDY SOLUTIONS</a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item"><a class="nav-link" href="#/">Inicio</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/servicios">Servicios</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/galeria">Galería</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/contacto">Contacto</a></li>
                            <li class="nav-item"><a class="nav-link" href="#/faq">FAQ</a></li>
                            <li class="nav-item auth-only" style="display: none;">
                                <a class="nav-link" href="#/solicitar-servicio">Solicitar servicio</a>
                            </li>
                            <li class="nav-item admin-only" style="display: none;">
                                <a class="nav-link" href="#/admin">Panel admin</a>
                            </li>
                        </ul>
                        <ul class="navbar-nav">
                            <li class="nav-item guest-only">
                                <a class="nav-link" href="#/login">Iniciar sesión</a>
                            </li>
                            <li class="nav-item guest-only">
                                <a class="nav-link" href="#/register">Registrarse</a>
                            </li>
                            <li class="nav-item auth-only" style="display: none;">
                                <div class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" id="userDropdown">
                                        <span id="userName">Usuario</span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="#" id="logoutBtn">Cerrar sesión</a></li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        `;
    }

    async checkAuth() {
        try {
            const token = localStorage.getItem('token');
            if (token) {
                // Aquí podrías verificar el token con el backend
                this.updateUI(true);
            } else {
                this.updateUI(false);
            }
        } catch (error) {
            console.error('Error checking auth:', error);
            this.updateUI(false);
        }
    }

    updateUI(isAuthenticated) {
        const guestElements = document.querySelectorAll('.guest-only');
        const authElements = document.querySelectorAll('.auth-only');
        const adminElements = document.querySelectorAll('.admin-only');

        guestElements.forEach(el => {
            el.style.display = isAuthenticated ? 'none' : 'block';
        });

        authElements.forEach(el => {
            el.style.display = isAuthenticated ? 'block' : 'none';
        });

        // Aquí podrías verificar si es admin
        adminElements.forEach(el => {
            el.style.display = isAuthenticated ? 'block' : 'none';
        });
    }

    bindEvents() {
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) {
            logoutBtn.addEventListener('click', (e) => {
                e.preventDefault();
                localStorage.removeItem('token');
                localStorage.removeItem('user');
                window.location.hash = '#/login';
                this.checkAuth();
            });
        }
    }
}
