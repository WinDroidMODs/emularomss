<?php get_header(); ?>

<div class="container main" id="main-content" role="main">
    <div class="main__blog">
        <?php if (have_posts()) : ?>
            <div class="widget" style="margin-bottom:1.5rem">
                <div class="widget__title">
                    <i class="fas fa-search"></i>
                    Resultados para: <strong style="color:var(--accent)"><?php echo esc_html(get_search_query()); ?></strong>
                </div>
            </div>

            <div class="posts-grid" id="custom-post-grid">
                <?php while (have_posts()) : the_post(); ?>
                    <?php
                    $meta = emularooms_get_meta_from_categories();
                    $categories = get_the_category();
                    $first_label = !empty($categories) ? $categories[0]->name : '';
                    ?>
                    <a class="post-card" href="<?php the_permalink(); ?>">
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
                            <h3 class="post-card__title"><?php the_title(); ?></h3>
                            <div class="post-card__version"><?php if ($meta['format']) echo 'Formato: ' . esc_html($meta['format']); elseif ($meta['version']) echo 'Versión: ' . esc_html($meta['version']); ?></div>
                            <div class="post-card__date"><?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></div>
                            <?php echo emularooms_render_stars($meta['rating']); ?>
                        </div>
                    </a>
                <?php endwhile; ?>
            </div>

            <div id="pagination-wrapper">
                <?php the_posts_pagination(array('mid_size' => 3, 'prev_text' => '&lt; Anterior', 'next_text' => 'Siguiente &gt;')); ?>
            </div>
        <?php else : ?>
            <div class="article text-center">
                <h2>No se encontraron resultados para: "<?php echo esc_html(get_search_query()); ?>"</h2>
                <p>Prueba con otra búsqueda.</p>
            </div>
        <?php endif; ?>
    </div>
    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
