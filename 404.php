<?php get_header(); ?>

<div class="container main" id="main-content" role="main">
    <div class="main__blog">
        <div class="article text-center" style="padding: 4rem 1rem;">
            <h2 style="font-size: 5rem; margin-bottom: 1rem; color: var(--accent);">404</h2>
            <h3 style="margin-bottom: 1rem;">Página no encontrada</h3>
            <p style="margin-bottom: 2rem; color: #9e9e9e;">La página que buscas no existe o ha sido movida.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" style="background: var(--accent); color: #fff; padding: 0.8rem 2rem; border-radius: 40px; text-decoration: none; font-weight: 600; display: inline-block;">Volver al inicio</a>
        </div>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
