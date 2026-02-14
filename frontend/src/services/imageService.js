/**
 * Servicio robusto para manejo de imágenes con múltiples fallbacks
 */
export class ImageService {
    constructor() {
        this.fallbackImages = {
            handyman: [
                'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1621905251189-08b3e6a9b1d3?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1200&h=600&fit=crop&auto=format'
            ],
            services: {
                'plomería': 'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop&auto=format',
                'electricidad': 'https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=400&h=300&fit=crop&auto=format',
                'aire acondicionado': 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop&auto=format',
                'carpintería': 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                'pintura': 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                'jardinería': 'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=400&h=300&fit=crop&auto=format',
                'default': 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format'
            },
            gallery: 'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format',
            placeholder: 'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format'
        };
    }

    /**
     * Obtener imagen de servicio con fallback inteligente
     */
    getServiceImage(serviceName, backendUrl = null) {
        if (backendUrl) {
            return backendUrl;
        }

        const serviceNameLower = (serviceName || '').toLowerCase();
        
        // Buscar coincidencia exacta
        for (const [key, value] of Object.entries(this.fallbackImages.services)) {
            if (serviceNameLower.includes(key)) {
                return value;
            }
        }
        
        // Fallback a imagen por defecto
        return this.fallbackImages.services.default;
    }

    /**
     * Obtener imagen de hero con fallback
     */
    getHeroImage(backendUrl = null) {
        if (backendUrl && this.isValidUrl(backendUrl)) {
            return backendUrl;
        }
        
        // Rotar entre imágenes de handyman
        const randomIndex = Math.floor(Math.random() * this.fallbackImages.handyman.length);
        return this.fallbackImages.handyman[randomIndex];
    }

    /**
     * Obtener imagen de galería con fallback
     */
    getGalleryImage(backendUrl = null) {
        if (backendUrl && this.isValidUrl(backendUrl)) {
            return backendUrl;
        }
        
        return this.fallbackImages.gallery;
    }

    /**
     * Generar HTML de imagen con múltiples fallbacks
     */
    generateImageHTML(src, alt, className, style = '', onError = null) {
        const fallbackSrc = this.getFallbackImage(src);
        
        return `
            <img 
                src="${src}" 
                alt="${alt}" 
                class="${className}" 
                style="${style}"
                onerror="this.onerror=null; this.src='${fallbackSrc}'; ${onError || ''}"
                loading="lazy"
            />
        `;
    }

    /**
     * Obtener fallback apropiado según el contexto
     */
    getFallbackImage(originalSrc) {
        if (!originalSrc || originalSrc.includes('storage/')) {
            return this.fallbackImages.placeholder;
        }
        
        // Si es una URL externa que falló, usar placeholder
        return this.fallbackImages.placeholder;
    }

    /**
     * Validar URL
     */
    isValidUrl(string) {
        try {
            new URL(string);
            return true;
        } catch (_) {
            return false;
        }
    }

    /**
     * Precargar imágenes críticas
     */
    preloadCriticalImages() {
        const criticalImages = [
            this.fallbackImages.handyman[0],
            this.fallbackImages.services.default,
            this.fallbackImages.gallery
        ];

        criticalImages.forEach(src => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = src;
            document.head.appendChild(link);
        });
    }
}

// Exportar singleton
export const imageService = new ImageService();
