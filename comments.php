<?php
if (post_password_required()) {
    return;
}
?>

<div id="comments" class="post-comments">
    <?php if (have_comments()) : ?>
        <h3 class="widget__title">
            <i class="far fa-comments"></i>
            <?php
            $comment_count = get_comments_number();
            printf(
                esc_html(_n('%s comentario', '%s comentarios', $comment_count, 'emularooms')),
                number_format_i18n($comment_count)
            );
            ?>
        </h3>

        <div class="comments-content">
            <ol class="comment-list">
                <?php
                wp_list_comments(array(
                    'style'       => 'ol',
                    'short_ping'  => true,
                    'avatar_size' => 50,
                    'callback'    => 'emularooms_comment_callback',
                ));
                ?>
            </ol>
        </div>

        <?php the_comments_pagination(array(
            'prev_text' => '&lt; Anterior',
            'next_text' => 'Siguiente &gt;',
        )); ?>
    <?php endif; ?>

    <?php if (comments_open()) : ?>
        <div class="comment-form">
            <?php comment_form(array(
                'class_form'         => 'comment-form',
                'title_reply'        => '<i class="far fa-edit"></i> Deja un comentario',
                'title_reply_before' => '<h3 class="comment-reply-title">',
                'title_reply_after'  => '</h3>',
                'label_submit'       => 'Enviar comentario',
                'class_submit'       => 'submit-btn',
                'comment_field'      => '<p class="comment-form-comment"><textarea id="comment" name="comment" rows="4" required placeholder="Escribe tu comentario aquí..."></textarea></p>',
                'fields'             => array(
                    'author' => '<p class="comment-form-author"><label for="author">Nombre <span class="required">*</span></label><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" required /></p>',
                    'email'  => '<p class="comment-form-email"><label for="email">Correo electrónico <span class="required">*</span></label><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" required /></p>',
                    'url'    => '<p class="comment-form-url"><label for="url">Web</label><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" /></p>',
                ),
                'comment_notes_before' => '<p class="comment-notes">Tu dirección de correo electrónico no será publicada. Los campos obligatorios están marcados con <span class="required">*</span></p>',
            )); ?>
        </div>
    <?php endif; ?>
</div>

<style>
    /* Estilos para el formulario de comentarios */
    .comment-form {
        margin-top: 2rem;
        background: #13131d;
        border: 1px solid #1e1e2e;
        border-radius: 12px;
        padding: 1.5rem;
    }
    .comment-reply-title {
        font-size: 1.2rem;
        color: #f5f5f5;
        margin-bottom: 1rem;
        font-family: 'Oswald', sans-serif;
    }
    .comment-notes {
        font-size: 0.85rem;
        color: #9e9e9e;
        margin-bottom: 1rem;
    }
    .comment-form label {
        display: block;
        font-size: 0.85rem;
        color: #aaa;
        margin-bottom: 0.3rem;
        font-weight: 600;
    }
    .comment-form input[type="text"],
    .comment-form input[type="email"],
    .comment-form input[type="url"],
    .comment-form textarea {
        width: 100%;
        padding: 0.7rem 1rem;
        background: #1e1e2e;
        border: 1px solid #2a2a3a;
        border-radius: 8px;
        color: #fff;
        font-size: 0.95rem;
        transition: border-color 0.2s;
    }
    .comment-form input:focus,
    .comment-form textarea:focus {
        border-color: #388E3C;
        outline: none;
    }
    .comment-form .submit-btn {
        background: #388E3C;
        color: #fff;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 40px;
        font-weight: 600;
        cursor: pointer;
        font-size: 0.95rem;
        margin-top: 0.5rem;
        transition: background 0.2s;
    }
    .comment-form .submit-btn:hover {
        background: #2E7D32;
    }
    .comment-form p {
        margin-bottom: 1rem;
    }
    .comment-form .required {
        color: #e53935;
    }
    /* Estilos para la lista de comentarios */
    .comment-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    .comment-list .comment {
        margin-bottom: 1.5rem;
    }
    .comment-list .comment-body {
        background: #13131d;
        border: 1px solid #1e1e2e;
        border-radius: 10px;
        padding: 1rem;
    }
    .comment-list .comment-meta {
        display: flex;
        gap: 0.5rem;
        align-items: center;
        margin-bottom: 0.5rem;
        flex-wrap: wrap;
    }
    .comment-list .comment-author {
        font-weight: 700;
        color: #f5f5f5;
    }
    .comment-list .comment-metadata {
        font-size: 0.75rem;
        color: #9e9e9e;
    }
    .comment-list .comment-content {
        font-size: 0.9rem;
        line-height: 1.6;
        color: #e0e0e0;
    }
    .comment-list .reply {
        margin-top: 0.5rem;
    }
    .comment-list .reply a {
        font-size: 0.85rem;
        color: #388E3C;
        text-decoration: none;
        font-weight: 600;
    }
    .comment-list .reply a:hover {
        color: #2E7D32;
        text-decoration: underline;
    }
    /* Tema claro */
    body.light-theme .comment-form,
    body.light-theme .comment-list .comment-body {
        background: #ffffff;
        border-color: #e2e8f0;
    }
    body.light-theme .comment-reply-title {
        color: #0f172a;
    }
    body.light-theme .comment-form input[type="text"],
    body.light-theme .comment-form input[type="email"],
    body.light-theme .comment-form input[type="url"],
    body.light-theme .comment-form textarea {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #1e293b;
    }
    body.light-theme .comment-form label {
        color: #334155;
    }
    body.light-theme .comment-list .comment-author {
        color: #0f172a;
    }
    body.light-theme .comment-list .comment-content {
        color: #1e293b;
    }
    body.light-theme .comment-list .comment-metadata {
        color: #64748b;
    }
    /* Responsive */
    @media (max-width: 600px) {
        .comment-form {
            padding: 1rem;
        }
        .comment-form input[type="text"],
        .comment-form input[type="email"],
        .comment-form input[type="url"],
        .comment-form textarea {
            font-size: 0.9rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var replyLinks = document.querySelectorAll('.comment-reply-link');
        replyLinks.forEach(function(link) {
            link.addEventListener('click', function(e) {
                var parentComment = this.closest('.comment');
                if (parentComment) {
                    var authorName = parentComment.querySelector('.comment-author') ? parentComment.querySelector('.comment-author').textContent.trim() : '';
                    var notice = document.getElementById('reply-notice');
                    var authorSpan = document.getElementById('reply-author-name');
                    if (notice && authorSpan) {
                        authorSpan.textContent = 'Respondiendo a ' + authorName;
                        notice.classList.add('show');
                    }
                    var commentTextarea = document.getElementById('comment');
                    if (commentTextarea) {
                        commentTextarea.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                }
            });
        });
    });
</script>
