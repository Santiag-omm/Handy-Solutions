/**
 * Servicio de imágenes con respaldo automático y múltiples fuentes
 * Garantiza que las imágenes NUNCA fallen
 */
export class ImageFallbackService {
    constructor() {
        this.imageSources = {
            primary: [],
            backup: [],
            fallback: []
        };
        
        this.initializeImageSources();
        this.failedImages = new Set();
        this.retryAttempts = new Map();
        this.maxRetries = 3;
    }

    /**
     * Inicializar fuentes de imágenes con múltiples proveedores
     */
    initializeImageSources() {
        // Imágenes primarias (Unsplash - alta calidad)
        this.imageSources.primary = {
            hero: [
                'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1621905251189-08b3e6a9b1d3?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1578662996442-48f60103fc96?w=1200&h=600&fit=crop&auto=format',
                'https://images.unsplash.com/photo-mGZX2MOPR-s?w=1200&h=600&fit=crop&auto=format'
            ],
            services: {
                'plomería': [
                    'https://images.unsplash.com/photo-1581094794329-c8112a89af12?w=400&h=300&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1548839148-1a0a0a9e8c54?w=400&h=300&fit=crop&auto=format'
                ],
                'electricidad': [
                    'https://images.unsplash.com/photo-1581094358584-9c5e5f9a8f9b?w=400&h=300&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1621905251189-08b3e6a9b1d3?w=400&h=300&fit=crop&auto=format'
                ],
                'carpintería': [
                    'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-mGZX2MOPR-s?w=400&h=300&fit=crop&auto=format'
                ],
                'pintura': [
                    'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format'
                ],
                'default': [
                    'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                    'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format'
                ]
            },
            gallery: [
                'https://images.unsplash.com/photo-1579546929518-9e396f3cc809?w=400&h=300&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1581092796363-535d3b8c6d91?w=400&h=300&fit=crop&auto=format',
                'https://images.unsplash.com/photo-1621905251189-08b3e6a9b1d3?w=400&h=300&fit=crop&auto=format'
            ]
        };

        // Fuentes de respaldo (Pexels)
        this.imageSources.backup = {
            hero: [
                'https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600',
                'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600',
                'https://images.pexels.com/photos/1089438/pexels-photo-1089438.jpeg?auto=compress&cs=tinysrgb&w=1200&h=600'
            ],
            services: {
                'default': [
                    'https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg?auto=compress&cs=tinysrgb&w=400&h=300',
                    'https://images.pexels.com/photos/271639/pexels-photo-271639.jpeg?auto=compress&cs=tinysrgb&w=400&h=300'
                ]
            },
            gallery: [
                'https://images.pexels.com/photos/414837/pexels-photo-414837.jpeg?auto=compress&cs=tinysrgb&w=400&h=300'
            ]
        };

        // Último recurso (Placeholders con datos base64)
        this.imageSources.fallback = {
            hero: this.generatePlaceholderSVG(1200, 600, '#667eea', '#764ba2'),
            services: this.generatePlaceholderSVG(400, 300, '#3498db', '#2980b9'),
            gallery: this.generatePlaceholderSVG(400, 300, '#2c3e50', '#34495e')
        };
    }

    /**
     * Generar SVG placeholder como último recurso
     */
    generatePlaceholderSVG(width, height, color1, color2) {
        return `data:image/svg+xml;base64,${btoa(`
            <svg width="${width}" height="${height}" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="100%">
                        <stop offset="0%" style="stop-color:${color1};stop-opacity:1" />
                        <stop offset="100%" style="stop-color:${color2};stop-opacity:1" />
                    </linearGradient>
                </defs>
                <rect width="100%" height="100%" fill="url(#grad)"/>
                <text x="50%" y="50%" font-family="Arial, sans-serif" font-size="24" fill="white" text-anchor="middle" dy=".3em">
                    Handy Solutions
                </text>
            </svg>
        `)}`;
    }

    /**
     * Obtener imagen con múltiples capas de fallback
     */
    async getImage(type, subtype = null, customUrl = null) {
        // Si hay URL personalizada, intentar primero
        if (customUrl) {
            const result = await this.tryImage(customUrl);
            if (result.success) return result.url;
        }

        // Intentar con fuentes primarias
        const primaryResult = await this.tryPrimarySources(type, subtype);
        if (primaryResult) return primaryResult;

        // Intentar con fuentes de respaldo
        const backupResult = await this.tryBackupSources(type, subtype);
        if (backupResult) return backupResult;

        // Último recurso: placeholder
        return this.getFallbackImage(type);
    }

    /**
     * Intentar con fuentes primarias
     */
    async tryPrimarySources(type, subtype) {
        const sources = this.imageSources.primary[type];
        
        if (Array.isArray(sources)) {
            for (const url of sources) {
                const result = await this.tryImage(url);
                if (result.success) return result.url;
            }
        } else if (subtype && sources[subtype]) {
            for (const url of sources[subtype]) {
                const result = await this.tryImage(url);
                if (result.success) return result.url;
            }
        } else if (sources.default) {
            for (const url of sources.default) {
                const result = await this.tryImage(url);
                if (result.success) return result.url;
            }
        }
        
        return null;
    }

    /**
     * Intentar con fuentes de respaldo
     */
    async tryBackupSources(type, subtype) {
        const sources = this.imageSources.backup[type];
        
        if (Array.isArray(sources)) {
            for (const url of sources) {
                const result = await this.tryImage(url);
                if (result.success) return result.url;
            }
        } else if (sources.default) {
            for (const url of sources.default) {
                const result = await this.tryImage(url);
                if (result.success) return result.url;
            }
        }
        
        return null;
    }

    /**
     * Intentar cargar una imagen específica
     */
    async tryImage(url) {
        if (this.failedImages.has(url)) {
            return { success: false, url: null };
        }

        try {
            const response = await fetch(url, { 
                method: 'HEAD',
                mode: 'cors',
                cache: 'force-cache'
            });
            
            if (response.ok) {
                return { success: true, url };
            } else {
                this.failedImages.add(url);
                return { success: false, url: null };
            }
        } catch (error) {
            this.failedImages.add(url);
            return { success: false, url: null };
        }
    }

    /**
     * Obtener imagen de fallback (último recurso)
     */
    getFallbackImage(type) {
        return this.imageSources.fallback[type] || this.imageSources.fallback.services;
    }

    /**
     * Generar HTML de imagen con fallback automático
     */
    generateImageHTML(src, alt, className, style = '', type = 'services', subtype = null) {
        const fallbackSrc = this.getFallbackImage(type);
        
        return `
            <img 
                src="${src}" 
                alt="${alt}" 
                class="${className}" 
                style="${style}"
                onerror="this.onerror=null; window.imageFallbackService.handleImageError(this, '${type}', '${subtype || ''}');"
                loading="lazy"
                data-type="${type}"
                data-subtype="${subtype || ''}"
            />
        `;
    }

    /**
     * Manejar error de imagen automáticamente
     */
    async handleImageError(imgElement, type, subtype) {
        const currentSrc = imgElement.src;
        
        // Incrementar intentos
        const attempts = this.retryAttempts.get(currentSrc) || 0;
        this.retryAttempts.set(currentSrc, attempts + 1);

        // Si excedió intentos, usar fallback
        if (attempts >= this.maxRetries) {
            imgElement.src = this.getFallbackImage(type);
            return;
        }

        // Intentar con siguiente fuente
        const newSrc = await this.getImage(type, subtype);
        if (newSrc && newSrc !== currentSrc) {
            imgElement.src = newSrc;
        } else {
            imgElement.src = this.getFallbackImage(type);
        }
    }

    /**
     * Precargar imágenes críticas
     */
    async preloadCriticalImages() {
        const criticalTypes = ['hero', 'services'];
        
        for (const type of criticalTypes) {
            const sources = this.imageSources.primary[type];
            
            if (Array.isArray(sources)) {
                // Precargar primeras 2 imágenes de cada tipo
                for (let i = 0; i < Math.min(2, sources.length); i++) {
                    this.preloadImage(sources[i]);
                }
            } else if (sources.default) {
                for (let i = 0; i < Math.min(2, sources.default.length); i++) {
                    this.preloadImage(sources.default[i]);
                }
            }
        }
    }

    /**
     * Precargar imagen individual
     */
    preloadImage(url) {
        const link = document.createElement('link');
        link.rel = 'preload';
        link.as = 'image';
        link.href = url;
        document.head.appendChild(link);
    }

    /**
     * Limpiar caché de imágenes fallidas (periódicamente)
     */
    clearFailedCache() {
        this.failedImages.clear();
        this.retryAttempts.clear();
    }
}

// Exportar singleton global
window.imageFallbackService = new ImageFallbackService();
