/**
 * Router hash-based minimalista para SPA.
 *
 * Convención:
 * - Las rutas se expresan sin el símbolo `#` (ej: `/login`).
 * - El render se dispara en `load` y `hashchange`.
 */
export class Router {
    constructor() {
        /** @type {Map<string, any>} */
        this.routes = new Map();
        /** @type {any} */
        this.currentRoute = null;
        this.init();
    }

    /** Inicializa listeners del navegador. */
    init() {
        window.addEventListener('hashchange', () => this.handleRoute());
        window.addEventListener('load', () => this.handleRoute());
    }

    /**
     * Registrar una ruta.
     * @param {string} path
     * @param {any} component
     */
    addRoute(path, component) {
        this.routes.set(path, component);
    }

    /** Resuelve la ruta actual y dispara render si cambia. */
    handleRoute() {
        const hash = window.location.hash.slice(1) || '/';
        const route = this.routes.get(hash) || this.routes.get('/404');
        
        if (route && route !== this.currentRoute) {
            this.currentRoute = route;
            this.render();
        }
    }

    /** Renderiza el componente asociado a la ruta actual. */
    async render() {
        const app = document.getElementById('app');
        if (!app) return;

        try {
            // Si es una clase (constructor function), crear instancia
            if (typeof this.currentRoute === 'function' && this.currentRoute.prototype) {
                const instance = new this.currentRoute();
                if (typeof instance.init === 'function') {
                    await instance.init();
                }
            } 
            // Si es una función simple, ejecutarla
            else if (typeof this.currentRoute === 'function') {
                this.currentRoute();
            }
            // Si es un objeto con método init
            else if (typeof this.currentRoute === 'object' && typeof this.currentRoute.init === 'function') {
                await this.currentRoute.init();
            }
        } catch (error) {
            console.error('Error rendering route:', error);
            app.innerHTML = '<div class="container"><h1>Error</h1><p>Ha ocurrido un error al cargar la página.</p></div>';
        }
    }

    /**
     * Navega a una ruta.
     * @param {string} path
     */
    navigate(path) {
        window.location.hash = path;
    }
}
