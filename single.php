<?php get_header(); ?>

<div class="container main" id="main-content" role="main">
    <div class="main__blog">
        <?php while (have_posts()) : the_post(); ?>
            <?php $post_id = get_the_ID(); ?>

            <article class="article">
                <?php $categories = get_the_category(); if (!empty($categories)) : ?>
                    <div class="post-card__tags" style="margin-bottom:1rem">
                        <?php foreach ($categories as $cat) : ?>
                            <a href="<?php echo get_category_link($cat->term_id); ?>" style="background: rgba(56,142,60,0.1); padding: 0.3rem 0.8rem; border-radius: 20px; font-size: 0.75rem; text-decoration: none; color: #388E3C; margin-right: 0.3rem;"><?php echo esc_html($cat->name); ?></a>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <h1 class="article__title"><?php the_title(); ?></h1>

                <div class="article__meta">
                    <span><i class="far fa-clock"></i> <?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></span>
                    <span><i class="far fa-comment"></i> <?php comments_number('0 comentarios', '1 comentario', '% comentarios'); ?></span>
                </div>

                <div class="article__body">
                    <?php the_content(); ?>
                </div>

                <div class="share-buttons">
                    <a href="https://www.facebook.com/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" rel="nofollow" target="_blank"><i class="fab fa-facebook-f"></i> Facebook</a>
                    <a href="https://api.whatsapp.com/send?text=<?php echo urlencode(get_permalink()); ?>" rel="nofollow" target="_blank"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                    <a href="https://t.me/share/url?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" rel="nofollow" target="_blank"><i class="fab fa-telegram-plane"></i> Telegram</a>
                </div>
            </article>

            <!-- Contenido relacionado -->
            <?php if (!empty($categories)) : ?>
                <div id="related-posts-root">
                    <div class="related-posts">
                        <h2 class="section-title" style="color: #e0e0e0;"><span class="title-underline"></span>Contenido Relacionado</h2>
                        <div class="related-grid" id="related-posts-grid">
                            <?php
                            $related_args = array(
                                'category__in' => wp_list_pluck($categories, 'term_id'),
                                'post__not_in' => array($post_id),
                                'posts_per_page' => 6,
                            );
                            $related_posts = new WP_Query($related_args);
                            if ($related_posts->have_posts()) :
                                while ($related_posts->have_posts()) : $related_posts->the_post();
                                    $meta = emularooms_get_meta_from_categories();
                                    ?>
                                    <a class="post-card" href="<?php the_permalink(); ?>" style="text-decoration: none; display: block;">
                                        <div class="post-card__img">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <img src="<?php echo get_the_post_thumbnail_url(null, 'emularooms-card'); ?>" alt="<?php the_title_attribute(); ?>" loading="lazy" width="500" height="500" />
                                            <?php else : ?>
                                                <img src="https://2.bp.blogspot.com/-1J-byOnRoAI/W3Cot79qVUI/AAAAAAAADmE/IwXCcRdJl70_yR7FivfpmM62MVqD4CwbQCLcBGAs/s1600/no-img-blogger.png" alt="No image" loading="lazy" width="500" height="500" />
                                            <?php endif; ?>
                                            <span class="img-overlay"><i class="fas fa-download"></i></span>
                                        </div>
                                        <div class="post-card__body">
                                            <h3 class="post-card__title"><?php the_title(); ?></h3>
                                            <div class="post-card__version"><?php if ($meta['format']) echo 'Formato: ' . esc_html($meta['format']); elseif ($meta['version']) echo 'Versión: ' . esc_html($meta['version']); ?></div>
                                            <div class="post-card__date"><?php echo emularooms_date_es(get_the_date('Y-m-d')); ?></div>
                                            <?php echo emularooms_render_stars($meta['rating']); ?>
                                        </div>
                                    </a>
                                <?php endwhile;
                                wp_reset_postdata();
                            else : ?>
                                <p style="color:#9e9e9e;text-align:center;width:100%;">No hay entradas relacionadas aún.</p>
                            <?php endif; ?>
                        </div>
                        <div class="carousel-controls">
                            <button aria-label="Ver anterior" class="carousel-btn" id="carousel-prev"><i class="fas fa-arrow-left"></i> <span>Anterior</span></button>
                            <button aria-label="Ver siguiente" class="carousel-btn" id="carousel-next"><span>Siguiente</span> <i class="fas fa-arrow-right"></i></button>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Comentarios -->
            <?php if (comments_open() || get_comments_number()) : ?>
                <div class="post-comments">
                    <?php comments_template(); ?>
                </div>
            <?php endif; ?>

        <?php endwhile; ?>
    </div>

    <?php get_sidebar(); ?>
</div>

<?php get_footer(); ?>
