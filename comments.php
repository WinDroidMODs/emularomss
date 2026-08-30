<?php if (post_password_required()) return; ?>

<div class="comments" id="comments">
    <?php if (have_comments()) : ?>
        <h3 class="comments-title">
            <i class="far fa-comments"></i> <?php comments_number('Sin comentarios', '1 comentario', '% comentarios'); ?>
        </h3>

        <div class="comments-content">
            <ol class="comment-list">
                <?php
                wp_list_comments(array(
                    'style' => 'ol',
                    'short_ping' => true,
                    'avatar_size' => 50,
                    'callback' => 'emularooms_custom_comment',
                ));
                ?>
            </ol>
        </div>

        <?php the_comments_pagination(array('prev_text' => '&lt; Anterior', 'next_text' => 'Siguiente &gt;')); ?>
    <?php endif; ?>

    <?php if (comments_open()) : ?>
        <div class="comment-form">
            <div class="reply-notice" id="reply-notice">
                <i class="fas fa-reply"></i> <span id="reply-author-name"></span>
                <button class="cancel-reply-btn" onclick="cancelReply()"><i class="fas fa-times"></i> Cancelar</button>
            </div>
            <?php comment_form(array(
                'comment_field' => '<textarea id="comment" name="comment" class="form-control" rows="4" placeholder="Escribe tu comentario..." required></textarea>',
                'class_submit' => 'submit-btn',
                'label_submit' => 'Enviar comentario',
                'title_reply' => '<i class="far fa-edit"></i> Deja un comentario',
            )); ?>
        </div>
    <?php endif; ?>
</div>
