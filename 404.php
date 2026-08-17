<?php
/**
 * 404 template.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

$section = emtss_get_content_section('not_found');

get_header();
?>
<main id="main" class="emtss-main">
    <section class="emtss-not-found">
        <div class="emtss-not-found-grid"></div>
        <div class="container-xl">
            <div class="emtss-not-found-inner">
                <?php if (!empty($section['eyebrow'])) : ?>
                    <p class="emtss-eyebrow"><?php echo esc_html($section['eyebrow']); ?></p>
                <?php endif; ?>

                <h1><?php echo emtss_format_text($section['title'] ?? __('Page not found', 'emtss')); ?></h1>

                <?php if (!empty($section['subtitle'])) : ?>
                    <div class="emtss-rich-text emtss-not-found-copy"><?php echo emtss_format_rich_text($section['subtitle']); ?></div>
                <?php endif; ?>

                <div class="emtss-hero-actions">
                    <a class="btn emtss-btn emtss-btn-gold" href="<?php echo esc_url(emtss_normalize_link_url($section['primary_url'] ?? '/') ?: home_url('/')); ?>">
                        <i class="bi <?php echo esc_attr(emtss_is_theme_rtl() ? 'bi-arrow-right-short' : 'bi-arrow-left-short'); ?>"></i>
                        <span><?php echo esc_html($section['primary'] ?? __('Back to Home', 'emtss')); ?></span>
                    </a>
                    <?php
                    emtss_link_or_modal_button(
                        $section['secondary'] ?? __('Contact Us', 'emtss'),
                        $section['secondary_url'] ?? '',
                        'contact',
                        'emtss-btn emtss-btn-outline'
                    );
                    ?>
                </div>
            </div>
        </div>
    </section>
</main>
<?php
get_footer();
