<?php
/**
 * EMTSS theme bootstrap.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

define('EMTSS_VERSION', '1.0.0');
define('EMTSS_THEME_DIR', get_template_directory());
define('EMTSS_THEME_URI', get_template_directory_uri());

require EMTSS_THEME_DIR . '/inc/content.php';
require EMTSS_THEME_DIR . '/inc/inquiries.php';
require EMTSS_THEME_DIR . '/inc/admin.php';

function emtss_setup()
{
    load_theme_textdomain('emtss', EMTSS_THEME_DIR . '/languages');

    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo', array(
        'height'      => 80,
        'width'       => 220,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script'));

    register_nav_menus(array(
        'primary' => __('Primary section links', 'emtss'),
    ));
}
add_action('after_setup_theme', 'emtss_setup');

function emtss_enqueue_assets()
{
    wp_enqueue_style(
        'emtss-fonts',
        'https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@600;700&family=IBM+Plex+Mono:wght@400;600;700&family=Inter:wght@400;600;700;800&display=swap',
        array(),
        null
    );
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css', array(), '5.3.3');
    wp_enqueue_style('bootstrap-icons', 'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css', array(), '1.11.3');
    wp_enqueue_style('intl-tel-input', 'https://cdn.jsdelivr.net/npm/intl-tel-input@29.0.5/dist/css/intlTelInput.min.css', array(), '29.0.5');
    wp_enqueue_style('emtss-theme', EMTSS_THEME_URI . '/assets/css/theme.css', array('bootstrap', 'bootstrap-icons', 'emtss-fonts', 'intl-tel-input'), EMTSS_VERSION);

    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js', array(), '5.3.3', true);
    wp_enqueue_script('intl-tel-input', 'https://cdn.jsdelivr.net/npm/intl-tel-input@29.0.5/dist/js/intlTelInput.min.js', array(), '29.0.5', true);
    wp_enqueue_script('emtss-theme', EMTSS_THEME_URI . '/assets/js/theme.js', array('bootstrap', 'intl-tel-input'), EMTSS_VERSION, true);

    $modal = emtss_get_content_section('modal');
    wp_localize_script('emtss-theme', 'emtssTheme', array(
        'ajaxUrl'     => admin_url('admin-ajax.php'),
        'nonce'       => wp_create_nonce('emtss_inquiry_nonce'),
        'isRtl'       => emtss_is_theme_rtl(),
        'phone'       => array(
            'initialCountry' => 'sa',
            'onlyCountries'  => emtss_allowed_phone_countries(),
            'countryOrder'   => emtss_phone_country_order(),
            'utilsUrl'       => 'https://cdn.jsdelivr.net/npm/intl-tel-input@29.0.5/dist/js/utils.js',
        ),
        'modalTitles' => array(
            'briefing' => $modal['briefing_title'] ?? __('Request a Private Briefing', 'emtss'),
            'contact'  => $modal['contact_title'] ?? __('Contact EMTSS', 'emtss'),
        ),
        'messages'    => array(
            'success'      => $modal['success'] ?? __('Thank you. Our team will contact you shortly.', 'emtss'),
            'error'        => $modal['error'] ?? __('Something went wrong. Please try again.', 'emtss'),
            'sending'      => $modal['sending'] ?? __('Sending...', 'emtss'),
            'phoneInvalid' => $modal['phone_invalid'] ?? __('Please enter a valid phone number.', 'emtss'),
        ),
    ));
}
add_action('wp_enqueue_scripts', 'emtss_enqueue_assets');

function emtss_admin_assets($hook)
{
    if (strpos((string) $hook, 'emtss') === false) {
        return;
    }

    wp_enqueue_media();
    wp_enqueue_editor();
    wp_enqueue_style('emtss-admin', EMTSS_THEME_URI . '/assets/css/admin.css', array(), EMTSS_VERSION);
    wp_enqueue_script('emtss-admin', EMTSS_THEME_URI . '/assets/js/admin.js', array(), EMTSS_VERSION, true);
}
add_action('admin_enqueue_scripts', 'emtss_admin_assets');

function emtss_body_classes($classes)
{
    $classes[] = emtss_is_theme_rtl() ? 'emtss-rtl' : 'emtss-ltr';
    return $classes;
}
add_filter('body_class', 'emtss_body_classes');
