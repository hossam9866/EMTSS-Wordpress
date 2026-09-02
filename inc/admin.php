<?php
/**
 * Admin screens for theme controls and inquiries.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

function emtss_admin_menu()
{
    add_menu_page(
        __('EMTSS Theme', 'emtss'),
        __('EMTSS Theme', 'emtss'),
        'manage_options',
        'emtss-theme',
        'emtss_render_theme_settings_page',
        'dashicons-admin-customizer',
        58
    );

    add_submenu_page(
        'emtss-theme',
        __('Inquiries', 'emtss'),
        __('Inquiries', 'emtss'),
        'manage_options',
        'emtss-inquiries',
        'emtss_render_inquiries_page'
    );
}
add_action('admin_menu', 'emtss_admin_menu');

function emtss_sanitize_deep($value)
{
    if (is_array($value)) {
        $clean = array();
        foreach ($value as $key => $child) {
            $clean[sanitize_key((string) $key)] = emtss_sanitize_deep($child);
        }
        return $clean;
    }

    return wp_kses_post(trim((string) $value));
}

function emtss_cleanup_repeaters($value)
{
    if (!is_array($value)) {
        return $value;
    }

    $is_repeater = array_key_exists('_emtss_repeater', $value);
    unset($value['_emtss_repeater']);

    foreach ($value as $key => $child) {
        $value[$key] = emtss_cleanup_repeaters($child);
    }

    if ($is_repeater || emtss_is_list_array($value)) {
        return array_values($value);
    }

    return $value;
}

function emtss_admin_field_id($name)
{
    return 'emtss-' . sanitize_title(str_replace(array('[', ']'), '-', $name));
}

function emtss_admin_editor_id($name)
{
    return 'emtss_editor_' . substr(md5((string) $name), 0, 12);
}

function emtss_admin_rich_text_name_matches($name)
{
    $name = (string) $name;

    return (bool) (
        preg_match('/\[(body|subtitle|description|copyright)\]$/i', $name)
        || preg_match('/\[thank_you_email\]\[message\]$/i', $name)
    );
}

function emtss_admin_is_rich_text_field($name)
{
    $name = (string) $name;

    return strpos($name, '__INDEX__') === false && emtss_admin_rich_text_name_matches($name);
}

function emtss_admin_is_rich_text_template_field($name)
{
    $name = (string) $name;

    return strpos($name, '__INDEX__') !== false && emtss_admin_rich_text_name_matches($name);
}

function emtss_admin_blank_value($value)
{
    if (!is_array($value)) {
        return '';
    }

    $blank = array();
    foreach ($value as $key => $child) {
        $blank[$key] = emtss_admin_blank_value($child);
    }

    return $blank;
}

function emtss_admin_label($label)
{
    if (is_numeric($label)) {
        return sprintf(__('Item %d', 'emtss'), ((int) $label) + 1);
    }

    return ucwords(str_replace(array('_', '-'), ' ', (string) $label));
}

function emtss_admin_group_label($label, $value)
{
    if (is_numeric($label) && is_array($value)) {
        foreach (array('title', 'label', 'name') as $key) {
            if (!empty($value[$key]) && !is_array($value[$key])) {
                return sprintf(__('Item %d: %s', 'emtss'), ((int) $label) + 1, wp_strip_all_tags((string) $value[$key]));
            }
        }
    }

    return emtss_admin_label($label);
}

function emtss_admin_default_child($default_value, $key)
{
    if (!is_array($default_value)) {
        return null;
    }

    if (array_key_exists($key, $default_value)) {
        return $default_value[$key];
    }

    if (emtss_is_list_array($default_value) && array_key_exists(0, $default_value)) {
        return $default_value[0];
    }

    return null;
}

function emtss_admin_render_repeat_item_contents($name, $value, $depth, $default_value = null)
{
    if (!is_array($value) || emtss_is_list_array($value)) {
        emtss_admin_render_nested_fields($name, $value, __('Item', 'emtss'), $depth, $default_value);
        return;
    }

    foreach ($value as $key => $child) {
        emtss_admin_render_nested_fields($name . '[' . $key . ']', $child, (string) $key, $depth, emtss_admin_default_child($default_value, $key));
    }
}

function emtss_admin_render_nested_fields($name, $value, $label = '', $depth = 0, $default_value = null)
{
    if (!is_array($value)) {
        $id          = emtss_admin_field_id($name);
        $label       = $label ? $label : basename((string) $name);
        $is_media    = preg_match('/\[(image|logo|background|icon)\]$/i', (string) $name);
        $is_url      = preg_match('/\[(url|link|logo_link|primary_url|secondary_url|button_url|contact_button_url)\]$/i', (string) $name);
        $rich_editor = !$is_media && !$is_url && emtss_admin_is_rich_text_field($name);
        $rich_template = !$is_media && !$is_url && emtss_admin_is_rich_text_template_field($name);
        $textarea    = !$is_media && !$is_url && (strlen((string) $value) > 70 || preg_match('/body|subtitle|description|message|copyright|title/i', (string) $name) || strpos((string) $value, "\n") !== false);
        $label_clean = ucwords(str_replace(array('_', '-'), ' ', (string) $label));

        if ($rich_editor) {
            $editor_id = emtss_admin_editor_id($name);
            ?>
            <div class="emtss-admin-field is-rich-editor">
                <span><label for="<?php echo esc_attr($editor_id); ?>"><?php echo esc_html($label_clean); ?></label></span>
                <?php
                wp_editor((string) $value, $editor_id, array(
                    'textarea_name' => $name,
                    'textarea_rows' => 5,
                    'media_buttons' => false,
                    'teeny'         => false,
                    'quicktags'     => true,
                    'tinymce'       => array(
                        'toolbar1' => 'formatselect,bold,italic,bullist,numlist,link,unlink,undo,redo',
                        'toolbar2' => '',
                    ),
                ));
                ?>
            </div>
            <?php
            return;
        }

        if ($rich_template) {
            ?>
            <div class="emtss-admin-field is-rich-editor is-rich-editor-template">
                <span><label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label_clean); ?></label></span>
                <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" rows="5" data-rich-editor-template><?php echo esc_textarea($value); ?></textarea>
            </div>
            <?php
            return;
        }
        ?>
        <label class="emtss-admin-field <?php echo $is_media ? 'is-media-field' : ''; ?>" for="<?php echo esc_attr($id); ?>">
            <span><?php echo esc_html($label_clean); ?></span>
            <?php if ($is_media) : ?>
                <div class="emtss-media-control">
                    <input id="<?php echo esc_attr($id); ?>" type="text" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" data-media-input>
                    <button type="button" class="button" data-media-select><?php esc_html_e('Choose image', 'emtss'); ?></button>
                </div>
                <div class="emtss-media-preview" data-media-preview>
                    <?php if ($value !== '') : ?>
                        <img src="<?php echo esc_url(emtss_asset_url($value)); ?>" alt="">
                    <?php endif; ?>
                </div>
            <?php elseif ($textarea) : ?>
                <textarea id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" rows="3"><?php echo esc_textarea($value); ?></textarea>
            <?php else : ?>
                <input id="<?php echo esc_attr($id); ?>" type="<?php echo $is_url ? 'text' : 'text'; ?>" name="<?php echo esc_attr($name); ?>" value="<?php echo esc_attr($value); ?>" <?php echo $is_url ? 'placeholder="#section, /page, https://, mailto:, tel:"' : ''; ?>>
            <?php endif; ?>
        </label>
        <?php
        return;
    }

    $is_list = emtss_is_list_array($value) || (is_array($default_value) && emtss_is_list_array($default_value));
    $summary = emtss_admin_group_label($label !== '' ? $label : __('Group', 'emtss'), $value);
    $template_source = null;

    if ($is_list) {
        $template_source = $value[0] ?? (is_array($default_value) ? ($default_value[0] ?? '') : '');
    }
    ?>
    <details class="emtss-admin-group depth-<?php echo esc_attr($depth); ?> <?php echo $is_list ? 'is-repeat-group' : ''; ?>" <?php echo $depth < 2 ? 'open' : ''; ?> <?php echo $is_list ? 'data-repeat-group data-repeat-name="' . esc_attr($name) . '"' : ''; ?>>
        <summary>
            <span><?php echo esc_html($summary); ?></span>
            <?php if ($is_list) : ?>
                <span class="emtss-repeat-badge"><?php esc_html_e('Add / remove items', 'emtss'); ?></span>
            <?php endif; ?>
        </summary>
        <div class="emtss-admin-group-body">
            <?php if ($is_list) : ?>
                <input type="hidden" name="<?php echo esc_attr($name . '[_emtss_repeater]'); ?>" value="1">
                <div class="emtss-repeat-items" data-repeat-items>
                    <?php foreach (array_values($value) as $key => $child) : ?>
                        <div class="emtss-repeat-item" data-repeat-item>
                            <div class="emtss-repeat-item-toolbar">
                                <strong><?php echo esc_html(emtss_admin_group_label($key, $child)); ?></strong>
                                <button type="button" class="button-link-delete" data-repeat-remove><?php esc_html_e('Remove', 'emtss'); ?></button>
                            </div>
                            <?php emtss_admin_render_repeat_item_contents($name . '[' . $key . ']', $child, $depth + 1, emtss_admin_default_child($default_value, $key)); ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <?php if ($template_source !== null) : ?>
                    <template data-repeat-template>
                        <div class="emtss-repeat-item" data-repeat-item>
                            <div class="emtss-repeat-item-toolbar">
                                <strong><?php esc_html_e('New item', 'emtss'); ?></strong>
                                <button type="button" class="button-link-delete" data-repeat-remove><?php esc_html_e('Remove', 'emtss'); ?></button>
                            </div>
                            <?php emtss_admin_render_repeat_item_contents($name . '[__INDEX__]', emtss_admin_blank_value($template_source), $depth + 1, $template_source); ?>
                        </div>
                    </template>
                    <button type="button" class="button emtss-repeat-add" data-repeat-add><?php esc_html_e('Add item', 'emtss'); ?></button>
                <?php endif; ?>
            <?php else : ?>
                <?php foreach ($value as $key => $child) : ?>
                    <?php emtss_admin_render_nested_fields($name . '[' . $key . ']', $child, (string) $key, $depth + 1, emtss_admin_default_child($default_value, $key)); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </details>
    <?php
}

function emtss_render_theme_settings_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['emtss_reset_defaults'])) {
        check_admin_referer('emtss_save_theme_settings');

        update_option('emtss_theme_options', emtss_default_options());
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('Initial EMTSS values restored.', 'emtss') . '</p></div>';
    } elseif (isset($_POST['emtss_save_settings'])) {
        check_admin_referer('emtss_save_theme_settings');

        $incoming = array(
            'settings' => emtss_sanitize_deep(wp_unslash($_POST['emtss_settings'] ?? array())),
            'content'  => emtss_sanitize_deep(wp_unslash($_POST['emtss_content'] ?? array())),
        );
        $incoming = emtss_cleanup_repeaters($incoming);

        $new_options = emtss_array_merge_recursive_distinct($incoming, emtss_default_options());
        update_option('emtss_theme_options', $new_options);
        echo '<div class="notice notice-success is-dismissible"><p>' . esc_html__('EMTSS theme settings saved.', 'emtss') . '</p></div>';
    }

    $options  = emtss_get_theme_options();
    $defaults = emtss_default_options();
    $settings = $options['settings'];
    $content  = $options['content'];
    ?>
    <div class="wrap emtss-admin-wrap">
        <h1><?php esc_html_e('EMTSS Theme Control', 'emtss'); ?></h1>
        <p class="emtss-admin-lede"><?php esc_html_e('Control section order with shortcodes, edit English and Arabic content, and configure inquiry email handling.', 'emtss'); ?></p>

        <form method="post">
            <?php wp_nonce_field('emtss_save_theme_settings'); ?>

            <div class="emtss-admin-layout">
                <section class="emtss-admin-card">
                    <h2><?php esc_html_e('General', 'emtss'); ?></h2>
                    <label class="emtss-admin-field" for="emtss-lead-recipient">
                        <span><?php esc_html_e('Lead recipient email', 'emtss'); ?></span>
                        <input id="emtss-lead-recipient" type="email" name="emtss_settings[lead_recipient]" value="<?php echo esc_attr($settings['lead_recipient'] ?? ''); ?>">
                    </label>
                    <label class="emtss-admin-field" for="emtss-from-name">
                        <span><?php esc_html_e('Outgoing email from name', 'emtss'); ?></span>
                        <input id="emtss-from-name" type="text" name="emtss_settings[from_name]" value="<?php echo esc_attr($settings['from_name'] ?? ''); ?>">
                    </label>
                    <label class="emtss-admin-field" for="emtss-from-email">
                        <span><?php esc_html_e('Outgoing email from address', 'emtss'); ?></span>
                        <input id="emtss-from-email" type="email" name="emtss_settings[from_email]" value="<?php echo esc_attr($settings['from_email'] ?? ''); ?>">
                    </label>
                    <fieldset class="emtss-admin-field">
                        <span><?php esc_html_e('Header logo tagline font size (px)', 'emtss'); ?></span>
                        <div class="emtss-admin-size-controls">
                            <label for="emtss-logo-tagline-font-desktop">
                                <span><?php esc_html_e('Desktop', 'emtss'); ?></span>
                                <input id="emtss-logo-tagline-font-desktop" type="number" min="4" max="30" step="0.5" name="emtss_settings[logo_tagline_font_desktop]" value="<?php echo esc_attr($settings['logo_tagline_font_desktop'] ?? '7'); ?>">
                            </label>
                            <label for="emtss-logo-tagline-font-tablet">
                                <span><?php esc_html_e('Tablet', 'emtss'); ?></span>
                                <input id="emtss-logo-tagline-font-tablet" type="number" min="4" max="30" step="0.5" name="emtss_settings[logo_tagline_font_tablet]" value="<?php echo esc_attr($settings['logo_tagline_font_tablet'] ?? '7'); ?>">
                            </label>
                            <label for="emtss-logo-tagline-font-mobile">
                                <span><?php esc_html_e('Mobile', 'emtss'); ?></span>
                                <input id="emtss-logo-tagline-font-mobile" type="number" min="4" max="30" step="0.5" name="emtss_settings[logo_tagline_font_mobile]" value="<?php echo esc_attr($settings['logo_tagline_font_mobile'] ?? '6'); ?>">
                            </label>
                        </div>
                        <small><?php esc_html_e('Desktop: above 991px. Tablet: 576–991px. Mobile: up to 575px.', 'emtss'); ?></small>
                    </fieldset>
                </section>

                <section class="emtss-admin-card">
                    <h2><?php esc_html_e('Section Order', 'emtss'); ?></h2>
                    <p><?php esc_html_e('Reorder or remove sections by moving these shortcodes. You can also place any shortcode inside a normal WordPress page.', 'emtss'); ?></p>
                    <label class="emtss-admin-field" for="emtss-section-layout">
                        <span><?php esc_html_e('Homepage shortcode layout', 'emtss'); ?></span>
                        <textarea id="emtss-section-layout" name="emtss_settings[section_layout]" rows="12"><?php echo esc_textarea($settings['section_layout'] ?? ''); ?></textarea>
                    </label>
                    <div class="emtss-shortcode-list">
                        <code>[emtss_hero]</code>
                        <code>[emtss_mission]</code>
                        <code>[emtss_alert_hub]</code>
                        <code>[emtss_domains]</code>
                        <code>[emtss_field]</code>
                        <code>[emtss_standards]</code>
                        <code>[emtss_partners]</code>
                        <code>[emtss_cta]</code>
                        <code>[emtss_why]</code>
                        <code>[emtss_site_footer]</code>
                    </div>
                </section>
            </div>

            <section class="emtss-admin-card">
                <h2><?php esc_html_e('Section Content', 'emtss'); ?></h2>
                <p><?php esc_html_e('Open a section, edit text/images/links, then use Add item or Remove on repeatable lists like cards, partners, features, footer links, and stats.', 'emtss'); ?></p>

                <div class="emtss-language-columns">
                    <?php foreach (array('en' => __('English', 'emtss'), 'ar' => __('Arabic', 'emtss')) as $lang => $label) : ?>
                        <div class="emtss-language-panel" dir="<?php echo $lang === 'ar' ? 'rtl' : 'ltr'; ?>">
                            <h3><?php echo esc_html($label); ?></h3>
                            <?php foreach (($content[$lang] ?? array()) as $section_key => $section_value) : ?>
                                <?php emtss_admin_render_nested_fields('emtss_content[' . $lang . '][' . $section_key . ']', $section_value, (string) $section_key, 0, $defaults['content'][$lang][$section_key] ?? null); ?>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </section>

            <p class="submit">
                <button type="submit" name="emtss_save_settings" class="button button-primary button-hero"><?php esc_html_e('Save Theme Controls', 'emtss'); ?></button>
                <button type="submit" name="emtss_reset_defaults" class="button button-secondary" onclick="return confirm('<?php echo esc_js(__('Restore all initial text, image, and link values?', 'emtss')); ?>');"><?php esc_html_e('Restore Initial Values', 'emtss'); ?></button>
            </p>
        </form>
    </div>
    <?php
}

function emtss_render_inquiries_page()
{
    if (!current_user_can('manage_options')) {
        return;
    }

    if (isset($_POST['emtss_send_reply'])) {
        check_admin_referer('emtss_send_reply');

        $subject = sanitize_text_field(wp_unslash($_POST['reply_subject'] ?? ''));
        $body    = wp_kses_post(wp_unslash($_POST['reply_body'] ?? ''));
        $send_all = !empty($_POST['send_all']);
        $ids = $send_all ? wp_list_pluck(emtss_get_inquiries(), 'ID') : array_map('absint', (array) ($_POST['inquiry_ids'] ?? array()));

        if ($subject && $body && $ids) {
            $sent = emtss_send_reply_to_inquiries($ids, $subject, $body);
            echo '<div class="notice notice-success is-dismissible"><p>' . esc_html(sprintf(_n('Sent %d email.', 'Sent %d emails.', $sent, 'emtss'), $sent)) . '</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>' . esc_html__('Choose at least one inquiry and enter both subject and message.', 'emtss') . '</p></div>';
        }
    }

    $inquiries  = emtss_get_inquiries();
    $focus_id   = absint($_GET['inquiry'] ?? 0);
    ?>
    <div class="wrap emtss-admin-wrap">
        <h1><?php esc_html_e('EMTSS Inquiries', 'emtss'); ?></h1>
        <p class="emtss-admin-lede"><?php esc_html_e('Review collected request/contact submissions and reply to one, selected, or all contacts.', 'emtss'); ?></p>

        <form method="post" id="emtss-reply-form">
            <?php wp_nonce_field('emtss_send_reply'); ?>

            <div class="emtss-admin-layout">
                <section class="emtss-admin-card">
                    <h2><?php esc_html_e('Compose Reply', 'emtss'); ?></h2>
                    <label class="emtss-admin-field" for="reply-subject">
                        <span><?php esc_html_e('Subject', 'emtss'); ?></span>
                        <input id="reply-subject" data-email-subject type="text" name="reply_subject" placeholder="<?php esc_attr_e('Your briefing request', 'emtss'); ?>">
                    </label>
                    <label class="emtss-admin-field" for="reply-body">
                        <span><?php esc_html_e('Email message', 'emtss'); ?></span>
                        <textarea id="reply-body" data-email-body name="reply_body" rows="8" placeholder="<?php esc_attr_e('Write the message before sending...', 'emtss'); ?>"></textarea>
                    </label>
                    <label class="emtss-admin-check">
                        <input type="checkbox" name="send_all" value="1" data-send-all>
                        <span><?php esc_html_e('Send to all collected inquiries', 'emtss'); ?></span>
                    </label>
                    <button type="submit" name="emtss_send_reply" class="button button-primary button-hero"><?php esc_html_e('Send Email', 'emtss'); ?></button>
                </section>

                <section class="emtss-admin-card emtss-preview-card">
                    <h2><?php esc_html_e('Email Look Before Send', 'emtss'); ?></h2>
                    <div class="emtss-email-preview">
                        <div class="emtss-email-preview-header">
                            <img src="<?php echo esc_url(emtss_asset_url('assets/images/logo-header.png')); ?>" alt="EMTSS">
                        </div>
                        <div class="emtss-email-preview-body">
                            <h3 data-preview-subject><?php esc_html_e('Subject preview', 'emtss'); ?></h3>
                            <div data-preview-body><?php esc_html_e('Your email body preview will appear here.', 'emtss'); ?></div>
                        </div>
                        <div class="emtss-email-preview-recipients">
                            <strong><?php esc_html_e('Recipients:', 'emtss'); ?></strong>
                            <span data-preview-recipients><?php esc_html_e('None selected', 'emtss'); ?></span>
                        </div>
                    </div>
                </section>
            </div>

            <section class="emtss-admin-card">
                <h2><?php esc_html_e('Collected Data', 'emtss'); ?></h2>
                <table class="widefat striped emtss-inquiry-table">
                    <thead>
                        <tr>
                            <th><input type="checkbox" data-select-visible aria-label="<?php esc_attr_e('Select all visible inquiries', 'emtss'); ?>"></th>
                            <th><?php esc_html_e('Name', 'emtss'); ?></th>
                            <th><?php esc_html_e('Email', 'emtss'); ?></th>
                            <th><?php esc_html_e('Phone', 'emtss'); ?></th>
                            <th><?php esc_html_e('Organization', 'emtss'); ?></th>
                            <th><?php esc_html_e('Type', 'emtss'); ?></th>
                            <th><?php esc_html_e('Message', 'emtss'); ?></th>
                            <th><?php esc_html_e('Status', 'emtss'); ?></th>
                            <th><?php esc_html_e('Date', 'emtss'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($inquiries) : ?>
                            <?php foreach ($inquiries as $inquiry) : ?>
                                <?php
                                $name   = emtss_inquiry_meta($inquiry->ID, 'name');
                                $email  = emtss_inquiry_meta($inquiry->ID, 'email');
                                $status = emtss_inquiry_meta($inquiry->ID, 'status', 'new');
                                ?>
                                <tr class="<?php echo $focus_id === $inquiry->ID ? 'is-focused' : ''; ?>">
                                    <td>
                                        <input
                                            type="checkbox"
                                            name="inquiry_ids[]"
                                            value="<?php echo esc_attr($inquiry->ID); ?>"
                                            data-recipient
                                            data-email="<?php echo esc_attr($email); ?>"
                                            data-name="<?php echo esc_attr($name); ?>"
                                            <?php checked($focus_id, $inquiry->ID); ?>
                                        >
                                    </td>
                                    <td><?php echo esc_html($name); ?></td>
                                    <td><a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a></td>
                                    <td><?php echo esc_html(emtss_inquiry_meta($inquiry->ID, 'phone')); ?></td>
                                    <td><?php echo esc_html(emtss_inquiry_meta($inquiry->ID, 'organization')); ?></td>
                                    <td><?php echo esc_html(emtss_inquiry_type_label(emtss_inquiry_meta($inquiry->ID, 'type', 'briefing'))); ?></td>
                                    <td><?php echo esc_html(wp_trim_words(emtss_inquiry_meta($inquiry->ID, 'message'), 18)); ?></td>
                                    <td><span class="emtss-status emtss-status-<?php echo esc_attr($status); ?>"><?php echo esc_html(ucfirst($status)); ?></span></td>
                                    <td><?php echo esc_html(get_the_date('', $inquiry)); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="9"><?php esc_html_e('No inquiries collected yet.', 'emtss'); ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </form>
    </div>
    <?php
}
