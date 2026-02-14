import api from './api.js';

export const heroService = {
    /**
     * Obtener configuración del hero
     */
    async getSettings() {
        try {
            const response = await api.get('/hero-settings');
            return response.data;
        } catch (error) {
            console.error('Error al obtener configuración del hero:', error);
            // Retornar valores por defecto
            return {
                success: true,
                data: {
                    titulo: 'Servicios Profesionales de Mantenimiento',
                    subtitulo: 'Soluciones rápidas y confiables para tu hogar y negocio',
                    descripcion: 'Contamos con técnicos certificados y herramientas modernas para resolver cualquier problema de plomería, electricidad y más.',
                    imagen_fondo: 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format',
                    texto_boton: 'Solicitar Servicio',
                    enlace_boton: '#/solicitar-servicio',
                    activo: true,
                }
            };
        }
    }
};
