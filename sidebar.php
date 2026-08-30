<aside class="sidebar">
    <?php if (is_active_sidebar('sidebar-main')) : ?>
        <?php dynamic_sidebar('sidebar-main'); ?>
    <?php else : ?>
        <!-- Widgets por defecto -->
        <div class="widget">
            <div class="widget__title"><i class="fas fa-clock"></i> Recién Actualizado</div>
            <div class="widget-content">
                <?php
                $recent_posts = new WP_Query(array('posts_per_page' => 3, 'post_status' => 'publish'));
                if ($recent_posts->have_posts()) :
                    while ($recent_posts->have_posts()) : $recent_posts->the_post();
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
                    <?php endwhile;
                    wp_reset_postdata();
                endif; ?>
            </div>
        </div>

        <div class="widget">
            <div class="widget__title"><i class="fas fa-tags"></i> Categorías</div>
            <div class="widget-content tag-cloud">
                <?php wp_tag_cloud(array('smallest' => 0.75, 'largest' => 0.75, 'unit' => 'rem', 'format' => 'flat', 'number' => 20, 'taxonomy' => 'category')); ?>
            </div>
        </div>
    <?php endif; ?>
</aside>
