<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="loading-overlay" style="position:fixed;top:0;left:0;width:100%;height:100%;background:#0a0a0f;display:flex;flex-direction:column;align-items:center;justify-content:center;z-index:99999;transition:opacity .5s ease">
    <div class="loading-spinner" style="width:40px;height:40px;border:3px solid rgba(56,142,60,0.3);border-top:3px solid #388E3C;border-radius:50%;animation:spin .8s linear infinite"></div>
    <div class="loading-text" style="margin-top:12px;font-size:.8rem;color:#aaa;font-family:'Roboto',sans-serif;letter-spacing:.5px">Cargando EmulaROOMs...</div>
</div>

<script>
    function hideLoadingOverlay(){
        var overlay=document.getElementById('loading-overlay');
        if(overlay){overlay.style.opacity='0';setTimeout(function(){overlay.style.display='none';},500);}
    }
    window.addEventListener('load',hideLoadingOverlay);
    setTimeout(hideLoadingOverlay,5000);
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var body = document.body;
        var savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'light') {
            body.classList.add('light-theme');
            var checkbox = document.getElementById('theme-toggle');
            if (checkbox) checkbox.checked = true;
        }
    });
</script>

<input id="nav-check" type="checkbox" />
<input id="search-check" type="checkbox" />

<header class="header" id="header">
    <div class="container header__inner">
        <label aria-label="Menu" class="nav__toggle" for="nav-check">
            <span></span><span></span><span></span>
        </label>

        <!-- LOGO: SOLO LOGO (SI EXISTE) + NOMBRE CLICABLE, SIN ICONO -->
        <div class="logo <?php echo has_custom_logo() ? 'has-image' : ''; ?>">
            <?php if (has_custom_logo()) : ?>
                <div class="logo__img">
                    <?php the_custom_logo(); ?>
                </div>
            <?php endif; ?>
            <a href="<?php echo esc_url(home_url('/')); ?>" style="text-decoration: none; color: inherit;">
                <span class="logo__text"><?php bloginfo('name'); ?></span>
            </a>
        </div>

        <nav class="nav__menu" id="navMenu" aria-label="Menú principal">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'nav__menu-list',
                'fallback_cb' => 'wp_page_menu',
                'items_wrap' => '%3$s',
                'walker' => new EmulaROOMs_Menu_Walker(),
            ));
            ?>
        </nav>

        <form action="<?php echo esc_url(home_url('/')); ?>" class="header__search" method="get">
            <input aria-label="Buscar en el blog" autocomplete="off" name="s" placeholder="Buscar y presiona Enter" required="required" type="text" value="<?php echo get_search_query(); ?>" />
            <button aria-label="Buscar" type="submit"><i class="fas fa-search"></i></button>
        </form>

        <label class="theme-switch" aria-label="Cambiar tema">
            <input id="theme-toggle" type="checkbox" />
            <span class="slider">
                <span class="icon sun">
                    <svg fill="currentColor" height="16" viewBox="0 0 24 24" width="16">
                        <circle cx="12" cy="12" r="5"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="12" y1="1" x2="12" y2="3"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="12" y1="21" x2="12" y2="23"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="1" y1="12" x2="3" y2="12"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="21" y1="12" x2="23" y2="12"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                        <line stroke="currentColor" stroke-linecap="round" stroke-width="2" x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                    </svg>
                </span>
                <span class="icon moon">
                    <svg fill="currentColor" height="16" viewBox="0 0 24 24" width="16">
                        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" fill="none" stroke="currentColor" stroke-width="1.5"/>
                    </svg>
                </span>
                <span class="toggle-knob"></span>
            </span>
        </label>

        <label aria-label="Buscar" class="search-btn" for="search-check">
            <i class="fas fa-search"></i>
        </label>
    </div>
</header>

<!-- Ticker -->
<div class="ticker-wrapper" id="ticker-wrapper">
    <span class="ticker-label"><i class="fas fa-fire" style="margin-right: 6px;"></i> Lo Nuevo</span>
    <div class="ticker-track">
        <div class="ticker-content" id="ticker-content">
            <?php
            $ticker_posts = get_posts(array('posts_per_page' => 5, 'post_status' => 'publish'));
            if ($ticker_posts) {
                foreach ($ticker_posts as $ticker_post) {
                    $thumb = get_the_post_thumbnail_url($ticker_post->ID, 'thumbnail');
                    if (!$thumb) $thumb = 'https://2.bp.blogspot.com/-1J-byOnRoAI/W3Cot79qVUI/AAAAAAAADmE/IwXCcRdJl70_yR7FivfpmM62MVqD4CwbQCLcBGAs/s1600/no-img-blogger.png';
                    echo '<a href="' . get_permalink($ticker_post->ID) . '" class="ticker-item">';
                    echo '<img src="' . esc_url($thumb) . '" alt="' . esc_attr(get_the_title($ticker_post->ID)) . '" loading="lazy" />';
                    echo '<span>' . esc_html(get_the_title($ticker_post->ID)) . '</span>';
                    echo '</a>';
                }
            } else {
                echo '<span style="color:#9e9e9e;font-size:0.8rem;">No hay destacados aún.</span>';
            }
            ?>
        </div>
    </div>
</div>

<div class="nav-search" id="navSearch">
    <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
        <input autocomplete="off" placeholder="Buscar..." name="s" required="required" type="text" value="<?php echo get_search_query(); ?>" />
        <button type="submit"><i class="fas fa-search"></i></button>
    </form>
    <label for="search-check" style="position:absolute;inset:0;z-index:-1"></label>
</div>
