<?php get_header(); ?>
    <main id="content">
        <article id="post-0" class="post not-found">
            <header class="header notfound">
                <h1 class="entry-title"><?php esc_html_e('A keresett oldal nem található', 'blankslate'); ?></h1>
            </header>
            <div class="entry-content notfound-subtitle">
                <p><?php esc_html_e('Segíthetünk?', 'blankslate'); ?></p>
            </div>
            <?php echo do_shortcode("[products limit='4' columns='4' orderby='popularity' class='quick-sale' on_sale='false' ]") ?>
        </article>
    </main>
<?php get_sidebar(); ?>
<?php get_footer(); ?>
