<?php
/**
 * Page template.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="main" class="emtss-main">
    <section class="emtss-page-content">
        <div class="container-xl">
            <?php
            while (have_posts()) :
                the_post();
                ?>
                <article <?php post_class('emtss-wp-article'); ?>>
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </article>
                <?php
            endwhile;
            ?>
        </div>
    </section>
</main>
<?php
get_footer();
