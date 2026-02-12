import api from './api';

/**
 * Capa de servicios para consumir endpoints del backend.
 *
 * Convención:
 * - Cada método retorna `response.data` (payload JSON del backend).
 * - Los errores se propagan al caller para manejo en la vista.
 */
export const serviciosService = {
    /**
     * Obtener todos los servicios.
     * @returns {Promise<any>}
     */
    getAll: async () => {
        const response = await api.get('/servicios');
        return response.data;
    },

    /**
     * Obtener un servicio por slug.
     * @param {string} slug
     * @returns {Promise<any>}
     */
    getBySlug: async (slug) => {
        const response = await api.get(`/servicios/${slug}`);
        return response.data;
    }
};

export const galeriaService = {
    /**
     * Obtener trabajos de galería.
     * @param {number} limit
     * @returns {Promise<any>}
     */
    getAll: async (limit = 12) => {
        const response = await api.get(`/galeria?limit=${limit}`);
        return response.data;
    }
};

export const solicitudesService = {
    /**
     * Crear una nueva solicitud del cliente autenticado.
     * @param {Record<string, any>} data
     * @returns {Promise<any>}
     */
    create: async (data) => {
        const response = await api.post('/solicitudes', data);
        return response.data;
    },

    /**
     * Obtener las solicitudes del usuario autenticado.
     * @returns {Promise<any>}
     */
    getUserSolicitudes: async () => {
        const response = await api.get('/user/solicitudes');
        return response.data;
    }
};

export const authService = {
    /**
     * Login.
     * @param {{email: string, password: string}} credentials
     * @returns {Promise<any>}
     */
    login: async (credentials) => {
        const response = await api.post('/login', credentials);
        return response.data;
    },

    /**
     * Registro.
     * @param {{name: string, email: string, password: string, password_confirmation: string}} userData
     * @returns {Promise<any>}
     */
    register: async (userData) => {
        const response = await api.post('/register', userData);
        return response.data;
    },

    /**
     * Cierra la sesión del token actual.
     * @returns {Promise<any>}
     */
    logout: async () => {
        const response = await api.post('/logout');
        return response.data;
    },

    /**
     * Obtener el usuario autenticado actual.
     * @returns {Promise<any>}
     */
    getCurrentUser: async () => {
        const response = await api.get('/user');
        return response.data;
    }
};

export const faqService = {
    /**
     * Obtener FAQs.
     * @returns {Promise<any>}
     */
    getAll: async () => {
        const response = await api.get('/faq');
        return response.data;
    }
};
