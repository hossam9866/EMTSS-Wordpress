<?php
/**
 * Theme header.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

$header = emtss_get_content_section('header');
$nav    = $header['nav'] ?? array();
$links  = $header['links'] ?? array();
$logo_link = emtss_normalize_link_url($header['logo_link'] ?? '/');
$logo_tagline = trim(wp_strip_all_tags((string) ($header['logo_tagline'] ?? '')));
$menu_items = $header['menu_items'] ?? array();

if (!$menu_items) {
    $menu_items = array(
        array('label' => $nav['solutions'] ?? __('Solutions', 'emtss'), 'url' => $links['solutions'] ?? '#solutions'),
        array('label' => $nav['ecosystem'] ?? __('Ecosystem', 'emtss'), 'url' => $links['ecosystem'] ?? '#ecosystem'),
        array('label' => $nav['partners'] ?? __('Partners', 'emtss'), 'url' => $links['partners'] ?? '#partners'),
        array('label' => $nav['contact'] ?? __('Contact', 'emtss'), 'url' => $links['contact'] ?? '#contact'),
    );
}
?>
<!doctype html>
<html <?php language_attributes(); ?> dir="<?php echo esc_attr(emtss_is_theme_rtl() ? 'rtl' : 'ltr'); ?>">
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="emtss-header navbar navbar-expand-lg fixed-top" id="site-header">
    <nav class="container-xl emtss-nav" aria-label="<?php esc_attr_e('Primary navigation', 'emtss'); ?>">
        <a class="navbar-brand emtss-logo" href="<?php echo esc_url($logo_link ?: home_url('/')); ?>" aria-label="<?php bloginfo('name'); ?>">
            <?php if (has_custom_logo()) : ?>
                <?php echo wp_get_attachment_image(get_theme_mod('custom_logo'), 'full', false, array('class' => 'custom-logo')); ?>
            <?php else : ?>
                <img src="<?php echo esc_url(emtss_asset_url($header['logo'] ?? 'assets/images/logo-header.png')); ?>" alt="<?php echo esc_attr(get_bloginfo('name')); ?>">
            <?php endif; ?>
            <?php if ($logo_tagline !== '') : ?>
                <span class="emtss-logo-tagline"><?php echo esc_html($logo_tagline); ?></span>
            <?php endif; ?>
        </a>

        <button class="navbar-toggler emtss-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#emtssPrimaryNav" aria-controls="emtssPrimaryNav" aria-expanded="false" aria-label="<?php esc_attr_e('Toggle navigation', 'emtss'); ?>">
            <i class="bi bi-list"></i>
        </button>

        <div class="collapse navbar-collapse" id="emtssPrimaryNav">
            <ul class="navbar-nav mx-auto emtss-menu">
                <?php foreach ($menu_items as $item) : ?>
                    <?php
                    $label = is_array($item) ? ($item['label'] ?? '') : '';
                    $url   = is_array($item) ? emtss_normalize_link_url($item['url'] ?? '#') : '#';
                    if ($label === '') {
                        continue;
                    }
                    ?>
                    <li class="nav-item"><a class="nav-link" href="<?php echo esc_url($url ?: '#'); ?>"><?php echo esc_html($label); ?></a></li>
                <?php endforeach; ?>
            </ul>

            <div class="emtss-header-actions">
                <?php emtss_polylang_switcher(); ?>
                <?php emtss_link_or_modal_button($header['cta'] ?? __('Request Briefing', 'emtss'), $header['cta_url'] ?? '', 'briefing', 'emtss-btn emtss-btn-primary'); ?>
            </div>
        </div>
    </nav>
</header>
