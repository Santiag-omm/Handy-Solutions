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
            if (typeof this.currentRoute === 'function') {
                const instance = new this.currentRoute();
                if (instance.init) {
                    await instance.init();
                }
            } else if (typeof this.currentRoute === 'object' && this.currentRoute.init) {
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
