import api from './api.js';

export const contactoInfoService = {
    /**
     * Obtener información de contacto
     */
    async getInfo() {
        try {
            const response = await api.get('/contacto-info');
            return response.data;
        } catch (error) {
            console.error('Error al obtener información de contacto:', error);
            // Retornar valores por defecto
            return {
                success: true,
                data: {
                    direccion: 'Calle Principal #123, Colonia Centro',
                    telefono1: '(555) 123-4567',
                    telefono2: '(555) 891-0123',
                    email1: 'info@handysolutions.com',
                    email2: 'soporte@handysolutions.com',
                    horario: 'Lunes a Viernes: 8:00 AM - 6:00 PM',
                    facebook: 'https://facebook.com',
                    instagram: 'https://instagram.com',
                    twitter: 'https://twitter.com',
                    whatsapp: 'https://wa.me/5551234567',
                }
            };
        }
    }
};
