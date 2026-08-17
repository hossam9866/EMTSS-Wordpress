<?php
/**
 * Front page.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();
?>
<main id="main" class="emtss-main">
    <?php echo do_shortcode(emtss_get_section_layout()); ?>
</main>
<?php
get_footer();
