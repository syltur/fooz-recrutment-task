<?php
/**
 * Task 4.1: Single Book Template
 * 
 * Displays: title, featured image, genre, publication date
 * Plus: AJAX-loaded list of 20 latest books (excluding current)
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <div class="wp-site-blocks">
        <?php block_template_part('header'); ?>

        <main id="main" class="wp-block-group site-main container" style="margin-top:var(--wp--preset--spacing--60)">
            <div class="wp-block-group__inner-container">
                <?php while (have_posts()):
                    the_post(); ?>
                    <article <?php post_class(); ?>>
                        <header class="entry-header">
                            <h1 class="entry-title"><?php the_title(); ?></h1>
                            <?php if (has_post_thumbnail()): ?>
                                <div class="book-featured-image">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>
                        </header>

                        <div class="book-meta">
                            <p><strong><?php _e('Genre:', 'fooz'); ?></strong>
                                <?php echo get_the_term_list(get_the_ID(), 'genre', '', ', '); ?></p>
                            <p><strong><?php _e('Publication Date:', 'fooz'); ?></strong> <?php echo get_the_date(); ?></p>
                        </div>

                        <div class="entry-content">
                            <?php the_content(); ?>
                        </div>

                        <section class="related-books-section">
                            <hr>
                            <h2><?php _e('Latest 20 Books', 'fooz'); ?></h2>
                            <div id="latest-books-container" data-exclude-id="<?php the_ID(); ?>">
                                <p class="loading"><?php _e('Loading...', 'fooz'); ?></p>
                            </div>
                        </section>
                    </article>
                <?php endwhile; ?>
            </div>
        </main>

        <?php block_template_part('footer'); ?>
    </div>

    <?php wp_footer(); ?>
</body>

</html>