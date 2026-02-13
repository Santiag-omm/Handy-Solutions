import api from './api.js';

export const contactoService = {
    /**
     * Enviar formulario de contacto
     */
    async enviar(datos) {
        try {
            const response = await api.post('/contacto', datos);
            return response.data;
        } catch (error) {
            console.error('Error al enviar contacto:', error);
            throw error;
        }
    }
};
