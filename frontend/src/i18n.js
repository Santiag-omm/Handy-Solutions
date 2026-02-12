const translations = {
    es: {
        'app.name': 'HANDY SOLUTIONS',
        'nav.home': 'Inicio',
        'nav.services': 'Servicios',
        'nav.gallery': 'Galería',
        'nav.contact': 'Contacto',
        'nav.faq': 'FAQ',
        'nav.request_service': 'Solicitar servicio',
        'nav.login': 'Iniciar sesión',
        'nav.register': 'Registrarse',
        'nav.logout': 'Cerrar sesión',
        'common.cancel': 'Cancelar',
        'common.save': 'Guardar',
        'home.hero.title': 'HANDY SOLUTIONS',
        'home.hero.subtitle': 'Soluciones profesionales de reparación para tu hogar',
        'home.hero.desc': 'Plomería, electricidad, carpintería, pintura, albañilería e impermeabilización',
        'home.services.title': 'Nuestros servicios',
        'home.gallery.title': 'Trabajos realizados',
        'home.gallery.cta': 'Ver galería',
        'services.title': 'Nuestros Servicios',
        'services.request': 'Solicitar Servicio',
        'services.empty': 'No hay servicios disponibles',
        'gallery.title': 'Galería de Trabajos',
        'gallery.load_more': 'Cargar más trabajos',
        'gallery.empty': 'No hay trabajos disponibles en la galería',
        'auth.login.title': 'Iniciar sesión',
        'auth.register.title': 'Crear cuenta',
        'auth.email': 'Correo electrónico',
        'auth.password': 'Contraseña',
        'auth.remember': 'Recordarme',
        'auth.login.submit': 'Entrar',
        'auth.login.no_account': '¿No tienes cuenta?',
        'auth.login.signup': 'Regístrate aquí',
        'auth.register.submit': 'Registrarse',
        'auth.register.has_account': '¿Ya tienes cuenta?',
        'auth.register.login': 'Inicia sesión aquí',

        'contact.title': 'Contáctanos',
        'contact.send': 'Enviar Mensaje',
        'faq.title': 'Preguntas Frecuentes',
        'faq.subtitle': 'Encuentra respuestas a las dudas más comunes sobre nuestros servicios',
        'faq.empty': 'No hay preguntas frecuentes disponibles',
        'faq.not_found_title': '¿No encontraste lo que buscabas?',
        'faq.not_found_desc': 'Si tienes otra pregunta, no dudes en contactarnos directamente.',
        'faq.contact': 'Contactar',

        'request.title': 'Solicitar Servicio',
        'request.submit': 'Enviar Solicitud',
    },
    en: {
        'app.name': 'HANDY SOLUTIONS',
        'nav.home': 'Home',
        'nav.services': 'Services',
        'nav.gallery': 'Gallery',
        'nav.contact': 'Contact',
        'nav.faq': 'FAQ',
        'nav.request_service': 'Request service',
        'nav.login': 'Log in',
        'nav.register': 'Sign up',
        'nav.logout': 'Log out',
        'common.cancel': 'Cancel',
        'common.save': 'Save',
        'home.hero.title': 'HANDY SOLUTIONS',
        'home.hero.subtitle': 'Professional home repair solutions',
        'home.hero.desc': 'Plumbing, electrical, carpentry, painting, masonry and waterproofing',
        'home.services.title': 'Our services',
        'home.gallery.title': 'Completed work',
        'home.gallery.cta': 'View gallery',
        'services.title': 'Our Services',
        'services.request': 'Request Service',
        'services.empty': 'No services available',
        'gallery.title': 'Work Gallery',
        'gallery.load_more': 'Load more',
        'gallery.empty': 'No gallery items available',
        'auth.login.title': 'Log in',
        'auth.register.title': 'Create account',
        'auth.email': 'Email',
        'auth.password': 'Password',
        'auth.remember': 'Remember me',
        'auth.login.submit': 'Log in',
        'auth.login.no_account': "Don't have an account?",
        'auth.login.signup': 'Sign up here',
        'auth.register.submit': 'Sign up',
        'auth.register.has_account': 'Already have an account?',
        'auth.register.login': 'Log in here',

        'contact.title': 'Contact us',
        'contact.send': 'Send message',
        'faq.title': 'Frequently Asked Questions',
        'faq.subtitle': 'Find answers to the most common questions about our services',
        'faq.empty': 'No FAQs available',
        'faq.not_found_title': "Didn't find what you were looking for?",
        'faq.not_found_desc': "If you have another question, feel free to contact us.",
        'faq.contact': 'Contact',

        'request.title': 'Request Service',
        'request.submit': 'Send request',
    },
};

const normalizeLang = (lang) => {
    const l = (lang || '').toLowerCase();
    if (l.startsWith('es')) return 'es';
    return 'en';
};

export const getLang = () => {
    const stored = localStorage.getItem('lang');
    if (stored) return normalizeLang(stored);
    return normalizeLang(navigator.language);
};

export const setLang = (lang) => {
    localStorage.setItem('lang', normalizeLang(lang));
};

export const t = (key) => {
    const lang = getLang();
    return translations[lang]?.[key] ?? translations.es[key] ?? key;
};

export const languageSelectorHTML = () => {
    const lang = getLang();
    return `
        <select class="form-select form-select-sm" style="width:auto" onchange="window.app && window.app.setLang && window.app.setLang(this.value)">
            <option value="es" ${lang === 'es' ? 'selected' : ''}>ES</option>
            <option value="en" ${lang === 'en' ? 'selected' : ''}>EN</option>
        </select>
    `;
};
