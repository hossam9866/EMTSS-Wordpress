<?php
/**
 * Fallback template.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="main" class="emtss-main">
    <?php if (is_front_page() || is_home()) : ?>
        <?php echo do_shortcode(emtss_get_section_layout()); ?>
    <?php else : ?>
        <section class="emtss-page-content">
            <div class="container-xl">
                <?php
                if (have_posts()) :
                    while (have_posts()) :
                        the_post();
                        ?>
                        <article <?php post_class('emtss-wp-article'); ?>>
                            <h1><?php the_title(); ?></h1>
                            <?php the_content(); ?>
                        </article>
                        <?php
                    endwhile;
                endif;
                ?>
            </div>
        </section>
    <?php endif; ?>
</main>
<?php
get_footer();
