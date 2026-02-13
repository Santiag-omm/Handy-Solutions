import { t } from '../i18n.js';

export class Footer {
    static getHTML() {
        return `
            <footer class="bg-dark text-light py-5 mt-auto">
                <div class="container">
                    <div class="row gy-4">
                        <!-- Acerca de -->
                        <div class="col-lg-4 col-md-6">
                            <h5 class="text-uppercase mb-3">${t('footer.about')}</h5>
                            <p class="text-light-50">${t('footer.about_text')}</p>
                            <div class="mt-3">
                                <h6 class="text-uppercase small mb-2">${t('footer.follow_us')}</h6>
                                <div class="d-flex gap-3">
                                    <a href="https://facebook.com" target="_blank" class="text-light text-decoration-none hover-primary">
                                        <i class="bi bi-facebook fs-5"></i>
                                    </a>
                                    <a href="https://instagram.com" target="_blank" class="text-light text-decoration-none hover-primary">
                                        <i class="bi bi-instagram fs-5"></i>
                                    </a>
                                    <a href="https://twitter.com" target="_blank" class="text-light text-decoration-none hover-primary">
                                        <i class="bi bi-twitter fs-5"></i>
                                    </a>
                                    <a href="https://wa.me/5551234567" target="_blank" class="text-light text-decoration-none hover-success">
                                        <i class="bi bi-whatsapp fs-5"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Servicios -->
                        <div class="col-lg-4 col-md-6">
                            <h5 class="text-uppercase mb-3">${t('footer.services')}</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Plomería</a></li>
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Electricidad</a></li>
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Carpintería</a></li>
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Pintura</a></li>
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Albañilería</a></li>
                                <li class="mb-2"><a href="#/servicios" class="text-light-50 text-decoration-none hover-primary">Impermeabilización</a></li>
                            </ul>
                        </div>
                        
                        <!-- Contacto -->
                        <div class="col-lg-4 col-md-12">
                            <h5 class="text-uppercase mb-3">${t('footer.contact_info')}</h5>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-geo-alt me-2"></i>
                                    <span class="text-light-50">Calle Principal #123, Colonia Centro</span>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-telephone me-2"></i>
                                    <a href="tel:5551234567" class="text-light-50 text-decoration-none hover-primary">(555) 123-4567</a>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-envelope me-2"></i>
                                    <a href="mailto:info@handysolutions.com" class="text-light-50 text-decoration-none hover-primary">info@handysolutions.com</a>
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-clock me-2"></i>
                                    <span class="text-light-50">Lun-Vie: 8:00 AM - 6:00 PM</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <hr class="border-secondary my-4">
                    
                    <!-- Copyright -->
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <p class="mb-0 text-light-50 small">
                                &copy; ${new Date().getFullYear()} HANDY SOLUTIONS. ${t('footer.rights')}.
                            </p>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <div class="d-flex gap-3 justify-content-md-end justify-content-center mt-3 mt-md-0">
                                <a href="#/privacy" class="text-light-50 small text-decoration-none hover-primary">${t('footer.privacy')}</a>
                                <a href="#/terms" class="text-light-50 small text-decoration-none hover-primary">${t('footer.terms')}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        `;
    }
}
