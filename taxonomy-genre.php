<?php
/**
 * Task 4.2: Genre Taxonomy Template
 * 
 * Displays list of books from specific genre
 * 5 books per page with pagination
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

        <main id="main" class="site-main container">
            <header class="archive-header">
                <h1 class="archive-title"><?php single_term_title(); ?></h1>
            </header>

            <?php if (have_posts()): ?>
                <div class="books-list">
                    <?php while (have_posts()):
                        the_post(); ?>
                        <article <?php post_class(); ?>>
                            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                            <div class="excerpt"><?php the_excerpt(); ?></div>
                        </article>
                    <?php endwhile; ?>
                </div>

                <div class="pagination">
                    <?php echo paginate_links(); ?>
                </div>
            <?php else: ?>
                <p><?php _e('No books found in this genre.', 'fooz'); ?></p>
            <?php endif; ?>
        </main>

        <?php block_template_part('footer'); ?>
    </div>

    <?php wp_footer(); ?>
</body>

</html>
