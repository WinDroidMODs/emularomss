<footer class="footer">
    <div class="container footer-container">
        <div class="footer-left">
            <div class="footer__copy">
                <p>&copy; <?php echo date('Y'); ?> <a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a>. Todos los derechos reservados.</p>
                <p class="footer__trademarks">Todos los logotipos, marcas comerciales e imágenes pertenecen a sus respectivos propietarios.</p>
            </div>
            <div class="footer__links" id="footer-legal-links">
                <a href="<?php echo esc_url(home_url('/')); ?>politica-privacidad/">Política de Privacidad</a> <span class="footer-separator">/</span>
                <a href="<?php echo esc_url(home_url('/')); ?>politica-cookies/">Política de Cookies</a> <span class="footer-separator">/</span>
                <a href="<?php echo esc_url(home_url('/')); ?>terminos-condiciones/">Términos y Condiciones</a> <span class="footer-separator">/</span>
                <a href="<?php echo esc_url(home_url('/')); ?>politica-dmca/">Política de DMCA</a> <span class="footer-separator">/</span>
                <a href="<?php echo esc_url(home_url('/')); ?>contacto/">Contacto</a>
            </div>
        </div>
        <div class="footer-right" id="footer-brand">
            <div class="logo">
                <span class="logo__text"><?php bloginfo('name'); ?></span>
            </div>
        </div>
    </div>
</footer>

<button aria-label="Volver arriba" id="back-to-top"><i class="fas fa-arrow-up"></i></button>

<div class="cookie-banner" id="cookie-banner">
    <p class="cookie-banner__text">
        En <?php bloginfo('name'); ?> utilizamos cookies para mejorar tu experiencia. Al continuar navegando, aceptas nuestra
        <a href="<?php echo esc_url(home_url('/')); ?>politica-cookies/" rel="nofollow" style="white-space: nowrap;">Política de Cookies</a>.
    </p>
    <div class="cookie-banner__actions">
        <button aria-label="Aceptar cookies" class="cookie-banner__btn cookie-banner__btn--accept" id="cookie-accept">Aceptar</button>
        <button aria-label="Rechazar cookies" class="cookie-banner__btn cookie-banner__btn--reject" id="cookie-reject">Rechazar</button>
    </div>
</div>

<div id="telegram-floating-widget">
    <a aria-label="Únete a nuestro canal de Telegram" href="https://t.me/EmulaROOMsCommunity" rel="noopener noreferrer" target="_blank">
        <svg class="telegram-icon" fill="#fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.894 8.221-1.97 9.28c-.145.658-.537.818-1.084.508l-3-2.21-1.446 1.394c-.14.18-.357.295-.6.295-.002 0-.003 0-.005 0l.213-3.054 5.56-5.022c.24-.213-.054-.334-.373-.121l-6.869 4.326-2.96-.924c-.64-.203-.658-.64.135-.954l11.566-4.458c.538-.196 1.006.128.832.941z"/>
        </svg>
        <span class="tooltip">Únete a la comunidad</span>
    </a>
</div>

<?php wp_footer(); ?>
</body>
</html>
