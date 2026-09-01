<?php
/**
 * EmulaROOMs Theme Functions
 * Autor: Robinson Avila
 * Complete functions.php with Menu Walker integrated
 */

if (!defined('ABSPATH')) {
    exit;
}

define('EMULA_VERSION', '1.0.0');

// --- Configuración del Tema ---
function emularooms_setup() {
    // Soporte de idiomas
    load_theme_textdomain('emularooms', get_template_directory() . '/languages');

    // Título dinámico
    add_theme_support('title-tag');

    // Imágenes destacadas
    add_theme_support('post-thumbnails');
    set_post_thumbnail_size(500, 500, true);
    add_image_size('emularooms-card', 500, 500, true);
    add_image_size('emularooms-popular', 200, 200, true);

    // Feed RSS
    add_theme_support('automatic-feed-links');

    // HTML5
    add_theme_support('html5', array(
        'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
    ));

    // Logotipo personalizado
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Menús de navegación
    register_nav_menus(array(
        'primary' => __('Menú Principal', 'emularooms'),
        'footer' => __('Menú Footer', 'emularooms'),
    ));

    // Widgets
    add_theme_support('widgets');
}
add_action('after_setup_theme', 'emularooms_setup');

// --- Cargar Estilos y Scripts ---
function emularooms_scripts() {
    // Estilos
    wp_enqueue_style('emularooms-fonts', 'https://fonts.googleapis.com/css2?family=Oswald:wght@700&family=Playfair+Display:wght@700&family=Roboto:wght@400;500;700&display=swap', array(), null);
    wp_enqueue_style('emularooms-fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css', array(), '6.5.0');
    wp_enqueue_style('emularooms-main', get_template_directory_uri() . '/assets/css/emularooms.css', array(), EMULA_VERSION);
    wp_enqueue_style('emularooms-card', get_template_directory_uri() . '/assets/css/emularooms-card.css', array(), EMULA_VERSION);

    // Scripts
    wp_enqueue_script('emularooms-script', get_template_directory_uri() . '/assets/js/emularooms.js', array(), EMULA_VERSION, true);
}
add_action('wp_enqueue_scripts', 'emularooms_scripts');

// --- Registrar Sidebar ---
function emularooms_widgets_init() {
    register_sidebar(array(
        'name' => __('Sidebar Principal', 'emularooms'),
        'id' => 'sidebar-main',
        'before_widget' => '<div class="widget %2$s">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget__title">',
        'after_title' => '</h3>',
    ));
}
add_action('widgets_init', 'emularooms_widgets_init');

// --- Personalizar Excerpt ---
function emularooms_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'emularooms_excerpt_more');

// --- Agregar clases al body ---
function emularooms_body_classes($classes) {
    $classes[] = 'emularooms-theme';
    return $classes;
}
add_filter('body_class', 'emularooms_body_classes');

// --- Mostrar fecha en formato español ---
function emularooms_date_es($date) {
    return mysql2date('d M Y', $date);
}

// --- Función para obtener la etiqueta de versión o formato desde categorías ---
function emularooms_get_meta_from_categories() {
    $categories = get_the_category();
    $version = null;
    $format = null;
    $rating = null;

    foreach ($categories as $cat) {
        if (preg_match('/^w/', $cat->name)) {
            $format = substr($cat->name, 1);
            break;
        }
    }
    if (!$format) {
        foreach ($categories as $cat) {
            if (preg_match('/^v\d+(\.\d+)*/', $cat->name)) {
                $version = $cat->name;
                break;
            }
        }
    }
    foreach ($categories as $cat) {
        if (preg_match('/^z(\d+(?:\.\d+)?)/', $cat->name, $matches)) {
            $rating = floatval($matches[1]);
            break;
        }
    }

    return array('version' => $version, 'format' => $format, 'rating' => $rating);
}

// --- Funciones de rating ---
function emularooms_render_stars($rating) {
    if ($rating === null || !is_numeric($rating)) return '';
    $html = '';
    $full = floor($rating);
    $partial = $rating - $full;
    for ($s = 0; $s < 5; $s++) {
        if ($s < $full) {
            $html .= '<div class="rating-star full"></div>';
        } elseif ($s === $full && $partial > 0) {
            $pct = round($partial * 100);
            $html .= '<div class="rating-star" style="background: linear-gradient(to right, #ffd700 ' . $pct . '%, #e0e0e0 ' . $pct . '%);"></div>';
        } else {
            $html .= '<div class="rating-star empty"></div>';
        }
    }
    return '<div class="rating-stars">' . $html . '</div>';
}

// --- Widget de posts recientes (personalizado) ---
class EmulaROOMs_Recent_Posts extends WP_Widget {
    function __construct() {
        parent::__construct('emularooms_recent', __('EmulaROOMs: Recientes', 'emularooms'), array('description' => __('Últimas entradas', 'emularooms')));
    }
    function widget($args, $instance) {
        echo $args['before_widget'];
        echo '<div class="widget__title"><i class="fas fa-clock"></i> Recién Actualizado</div>';
        $query = new WP_Query(array('posts_per_page' => 3, 'post_status' => 'publish'));
        if ($query->have_posts()) {
            echo '<div class="widget-content">';
            while ($query->have_posts()) {
                $query->the_post();
                $meta = emularooms_get_meta_from_categories();
                ?>
                <a class="popular-post-link" href="<?php the_permalink(); ?>">
                    <div class="popular-post__img-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <img class="popular-post__img" src="<?php echo get_the_post_thumbnail_url(null, 'emularooms-popular'); ?>" alt="<?php the_title_attribute(); ?>" width="65" height="65" loading="lazy" />
                        <?php else : ?>
                            <img class="popular-post__img" src="https://2.bp.blogspot.com/-1J-byOnRoAI/W3Cot79qVUI/AAAAAAAADmE/IwXCcRdJl70_yR7FivfpmM62MVqD4CwbQCLcBGAs/s1600/no-img-blogger.png" alt="No image" width="65" height="65" loading="lazy" />
                        <?php endif; ?>
                        <?php $cats = get_the_category(); if (!empty($cats)) : ?>
                            <div class="popular-post__featured-tag"><?php echo esc_html($cats[0]->name); ?></div>
                        <?php endif; ?>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="popular-post__title"><?php the_title(); ?></div>
                        <?php if (!empty($meta['format'])) : ?>
                            <div class="popular-post__version">Formato: <span class="version-value"><?php echo esc_html($meta['format']); ?></span></div>
                        <?php elseif (!empty($meta['version'])) : ?>
                            <div class="popular-post__version">Versión: <span class="version-value"><?php echo esc_html($meta['version']); ?></span></div>
                        <?php endif; ?>
                        <div class="popular-post__date"><?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></div>
                        <?php echo emularooms_render_stars($meta['rating']); ?>
                    </div>
                </a>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        } else {
            echo '<p>No hay entradas.</p>';
        }
        echo $args['after_widget'];
    }
}
register_widget('EmulaROOMs_Recent_Posts');

// --- Widget de posts populares (reemplazo de PopularPosts) ---
class EmulaROOMs_Popular_Posts extends WP_Widget {
    function __construct() {
        parent::__construct('emularooms_popular', __('EmulaROOMs: Populares', 'emularooms'), array('description' => __('Entradas más vistas', 'emularooms')));
    }
    function widget($args, $instance) {
        echo $args['before_widget'];
        echo '<div class="widget__title"><i class="fas fa-download"></i> Lo más Descargado</div>';
        $query = new WP_Query(array('posts_per_page' => 3, 'meta_key' => '_post_views', 'orderby' => 'meta_value_num', 'order' => 'DESC', 'post_status' => 'publish'));
        if (!$query->have_posts()) {
            $query = new WP_Query(array('posts_per_page' => 3, 'post_status' => 'publish'));
        }
        if ($query->have_posts()) {
            echo '<div class="widget-content">';
            while ($query->have_posts()) {
                $query->the_post();
                $meta = emularooms_get_meta_from_categories();
                ?>
                <a class="popular-post-link" href="<?php the_permalink(); ?>">
                    <div class="popular-post__img-wrapper">
                        <?php if (has_post_thumbnail()) : ?>
                            <img class="popular-post__img" src="<?php echo get_the_post_thumbnail_url(null, 'emularooms-popular'); ?>" alt="<?php the_title_attribute(); ?>" width="65" height="65" loading="lazy" />
                        <?php else : ?>
                            <img class="popular-post__img" src="https://2.bp.blogspot.com/-1J-byOnRoAI/W3Cot79qVUI/AAAAAAAADmE/IwXCcRdJl70_yR7FivfpmM62MVqD4CwbQCLcBGAs/s1600/no-img-blogger.png" alt="No image" width="65" height="65" loading="lazy" />
                        <?php endif; ?>
                        <?php $cats = get_the_category(); if (!empty($cats)) : ?>
                            <div class="popular-post__featured-tag"><?php echo esc_html($cats[0]->name); ?></div>
                        <?php endif; ?>
                    </div>
                    <div style="flex:1;min-width:0;">
                        <div class="popular-post__title"><?php the_title(); ?></div>
                        <?php if (!empty($meta['format'])) : ?>
                            <div class="popular-post__version">Formato: <span class="version-value"><?php echo esc_html($meta['format']); ?></span></div>
                        <?php elseif (!empty($meta['version'])) : ?>
                            <div class="popular-post__version">Versión: <span class="version-value"><?php echo esc_html($meta['version']); ?></span></div>
                        <?php endif; ?>
                        <div class="popular-post__date"><?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></div>
                        <?php echo emularooms_render_stars($meta['rating']); ?>
                    </div>
                </a>
                <?php
            }
            echo '</div>';
            wp_reset_postdata();
        }
        echo $args['after_widget'];
    }
}
register_widget('EmulaROOMs_Popular_Posts');

// --- Contador de vistas ---
function emularooms_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    $views = get_post_meta($post_id, '_post_views', true);
    if (empty($views)) {
        update_post_meta($post_id, '_post_views', 1);
    } else {
        update_post_meta($post_id, '_post_views', (int)$views + 1);
    }
}
add_action('wp_head', function() {
    if (is_single()) {
        emularooms_track_post_views(get_the_ID());
    }
});

// ============================================================
//  CLASE WALKER PARA EL MENÚ (PUNTO 4) - INTEGRADA AQUÍ
// ============================================================
class EmulaROOMs_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $output .= '<div class="dropdown__menu">';
    }
    function end_lvl(&$output, $depth = 0, $args = null) {
        $output .= '</div>';
    }
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'dropdown';
        }
        $class_names = implode(' ', array_filter($classes));
        $output .= '<div class="' . esc_attr($class_names) . '">';
        $atts = array(
            'href' => !empty($item->url) ? $item->url : '#',
            'title' => !empty($item->attr_title) ? $item->attr_title : '',
            'target' => !empty($item->target) ? $item->target : '',
            'rel' => !empty($item->xfn) ? $item->xfn : '',
        );
        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $attributes .= ' ' . $attr . '="' . esc_attr($value) . '"';
            }
        }
        $item_output = '<a' . $attributes . '>';
        $item_output .= esc_html($item->title);
        $item_output .= '</a>';
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
    function end_el(&$output, $item, $depth = 0, $args = null) {
        $output .= '</div>';
    }
}

// ============================================================
//  FUNCIÓN CALLBACK PARA LOS COMENTARIOS (CORREGIDO)
// ============================================================
function emularooms_comment_callback($comment, $args, $depth) {
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <div class="comment-body">
            <div class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar($comment, 50); ?>
                    <cite class="fn"><?php comment_author_link(); ?></cite>
                </div>
                <div class="comment-metadata">
                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                        <time datetime="<?php comment_time('c'); ?>">
                            <?php comment_date(); ?> a las <?php comment_time(); ?>
                        </time>
                    </a>
                </div>
            </div>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
            <div class="reply">
                <?php comment_reply_link(array_merge($args, array(
                    'reply_text' => 'Responder',
                    'depth'      => $depth,
                    'max_depth'  => $args['max_depth'],
                ))); ?>
            </div>
        </div>
    </li>
    <?php
}
