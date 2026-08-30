<?php get_header(); ?>

<?php if (is_home() || is_front_page()) : ?>
    <div class="hero">
        <div class="hero__shine"></div>
        <div class="container hero__content">
            <div class="hero__icons">
                <i class="fas fa-gamepad"></i>
                <i class="fas fa-microchip"></i>
                <i class="fas fa-box-open"></i>
                <i class="fas fa-download"></i>
                <i class="fas fa-mobile-alt"></i>
            </div>
            <h2 class="hero__title">Bienvenido a <?php bloginfo('name'); ?></h2>
            <?php $blog_description = get_bloginfo('description'); ?>
            <?php if ($blog_description) : ?>
                <p class="hero__subtitle"><?php echo esc_html($blog_description); ?></p>
            <?php endif; ?>
            <div class="hero__search">
                <div class="hero__search-row">
                    <select class="search-select" onchange="window.location.href=this.value">
                        <option value="">Seleccionar Consola</option>
                        <?php
                        $console_cats = array('PSP', 'DS', 'PS2', 'PS3', 'GBA', 'N64', 'GC', 'Wii', '3DS', 'PS4', 'Xbox', 'PC');
                        foreach ($console_cats as $console) {
                            $cat = get_term_by('name', $console, 'category');
                            if ($cat) {
                                echo '<option value="' . get_category_link($cat->term_id) . '">' . esc_html($console) . '</option>';
                            }
                        }
                        ?>
                    </select>
                    <form action="<?php echo esc_url(home_url('/')); ?>" method="get">
                        <input autocomplete="off" name="s" placeholder="Busca juegos, emuladores, roms..." required="required" type="text" value="<?php echo get_search_query(); ?>" />
                        <button type="submit"><i class="fas fa-search"></i> Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<div class="container main" id="main-content" role="main">
    <div class="main__blog">
        <?php if (have_posts()) : ?>
            <div class="posts-grid" id="custom-post-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $meta = emularooms_get_meta_from_categories();
                    $format = $meta['format'];
                    $version = $meta['version'];
                    $rating = $meta['rating'];
                    $categories = get_the_category();
                    $first_label = !empty($categories) ? $categories[0]->name : '';
                    ?>
                    <a class="post-card" href="<?php the_permalink(); ?>" style="text-decoration: none; display: block;">
                        <div class="post-card__img">
                            <?php if (has_post_thumbnail()) : ?>
                                <img src="<?php echo get_the_post_thumbnail_url(null, 'emularooms-card'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="500" height="500" />
                            <?php else : ?>
                                <img src="https://2.bp.blogspot.com/-1J-byOnRoAI/W3Cot79qVUI/AAAAAAAADmE/IwXCcRdJl70_yR7FivfpmM62MVqD4CwbQCLcBGAs/s1600/no-img-blogger.png" alt="No image" loading="lazy" width="500" height="500" />
                            <?php endif; ?>
                            <span class="img-overlay"><i class="fas fa-download"></i></span>
                            <span class="post-card__featured-tag"><?php echo esc_html($first_label); ?></span>
                        </div>
                        <div class="post-card__body">
                            <h3 class="post-card__title" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></h3>
                            <div class="post-card__version">
                                <?php if ($format) : ?>
                                    Formato: <?php echo esc_html($format); ?>
                                <?php elseif ($version) : ?>
                                    Versión: <?php echo esc_html($version); ?>
                                <?php endif; ?>
                            </div>
                            <div class="post-card__date"><?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></div>
                            <?php echo emularooms_render_stars($rating); ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <!-- Paginación -->
            <div id="pagination-wrapper" style="display: flex; justify-content: center; flex-wrap: wrap; gap: 0.4rem; margin: 2rem 0;">
                <?php
                the_posts_pagination(array(
                    'mid_size' => 3,
                    'prev_text' => '&lt; Anterior',
                    'next_text' => 'Siguiente &gt;',
                    'screen_reader_text' => ' ',
                ));
                ?>
            </div>
        <?php else : ?>
            <div class="article text-center">
                <p>No se encontraron entradas.</p>
            </div>
        <?php endif; ?>
    </div>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
