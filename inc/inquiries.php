<?php
/**
 * Inquiry capture, storage, and mail helpers.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

function emtss_register_inquiry_post_type()
{
    register_post_type('emtss_inquiry', array(
        'labels'       => array(
            'name'          => __('EMTSS Inquiries', 'emtss'),
            'singular_name' => __('EMTSS Inquiry', 'emtss'),
        ),
        'public'       => false,
        'show_ui'      => false,
        'show_in_menu' => false,
        'supports'     => array('title'),
        'capability_type' => 'post',
    ));
}
add_action('init', 'emtss_register_inquiry_post_type');

function emtss_inquiry_type_label($type)
{
    if ($type === 'contact') {
        return __('Contact', 'emtss');
    }

    return __('Private Briefing', 'emtss');
}

function emtss_mail_headers($reply_to = '')
{
    $options    = emtss_get_theme_options();
    $from_name  = sanitize_text_field($options['settings']['from_name'] ?? get_bloginfo('name'));
    $from_email = sanitize_email($options['settings']['from_email'] ?? get_option('admin_email'));
    $headers    = array('Content-Type: text/html; charset=UTF-8');

    if ($from_email) {
        $headers[] = 'From: ' . $from_name . ' <' . $from_email . '>';
    }

    if ($reply_to && is_email($reply_to)) {
        $headers[] = 'Reply-To: ' . $reply_to;
    }

    return $headers;
}

function emtss_email_shell($title, $body_html)
{
    $logo = emtss_asset_url('assets/images/logo-header.png');

    return '<!doctype html><html><body style="margin:0;background:#f4f6f3;font-family:Inter,Arial,sans-serif;color:#202b20;">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f4f6f3;padding:28px 12px;"><tr><td align="center">'
        . '<table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:640px;background:#ffffff;border:1px solid #dee3e8;border-radius:10px;overflow:hidden;">'
        . '<tr><td style="height:6px;background:#d4a017;font-size:0;line-height:0;">&nbsp;</td></tr>'
        . '<tr><td style="padding:24px 28px;border-bottom:1px solid #dee3e8;background:#ffffff;"><img src="' . esc_url($logo) . '" alt="EMSS" style="max-width:160px;height:auto;"></td></tr>'
        . '<tr><td style="padding:28px;"><h1 style="margin:0 0 18px;font-family:Arial,sans-serif;font-size:28px;line-height:1.1;color:#445840;text-transform:uppercase;">' . esc_html($title) . '</h1>'
        . $body_html
        . '</td></tr></table></td></tr></table></body></html>';
}

function emtss_apply_email_tokens($text, $data)
{
    return strtr((string) $text, array(
        '{name}'         => $data['name'] ?? '',
        '{email}'        => $data['email'] ?? '',
        '{phone}'        => $data['phone'] ?? '',
        '{organization}' => $data['organization'] ?? '',
        '{type}'         => emtss_inquiry_type_label($data['type'] ?? 'briefing'),
    ));
}

function emtss_store_inquiry($data)
{
    $title = sprintf(
        /* translators: 1: inquiry type, 2: name */
        __('%1$s from %2$s', 'emtss'),
        emtss_inquiry_type_label($data['type']),
        $data['name']
    );

    $post_id = wp_insert_post(array(
        'post_type'   => 'emtss_inquiry',
        'post_status' => 'private',
        'post_title'  => $title,
    ), true);

    if (is_wp_error($post_id)) {
        return $post_id;
    }

    foreach ($data as $key => $value) {
        update_post_meta($post_id, '_emtss_' . $key, $value);
    }

    update_post_meta($post_id, '_emtss_status', 'new');
    update_post_meta($post_id, '_emtss_language', emtss_get_current_language());

    return $post_id;
}

function emtss_notify_admin_about_inquiry($post_id, $data)
{
    $options   = emtss_get_theme_options();
    $recipient = sanitize_email($options['settings']['lead_recipient'] ?? get_option('admin_email'));

    if (!$recipient) {
        return false;
    }

    $subject = sprintf('[EMSS] %s - %s', emtss_inquiry_type_label($data['type']), $data['name']);
    $rows    = array(
        __('Name', 'emtss')         => $data['name'],
        __('Email', 'emtss')        => $data['email'],
        __('Phone', 'emtss')        => $data['phone'],
        __('Phone country', 'emtss') => strtoupper($data['phone_country'] ?? ''),
        __('Organization', 'emtss') => $data['organization'],
        __('Type', 'emtss')         => emtss_inquiry_type_label($data['type']),
        __('Language', 'emtss')     => emtss_get_current_language(),
    );

    $body = '<p style="margin:0 0 18px;color:#4a5a68;">' . esc_html__('A new inquiry has been submitted from the EMTSS website.', 'emtss') . '</p>';
    $body .= '<table role="presentation" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">';
    foreach ($rows as $label => $value) {
        $body .= '<tr><th align="left" style="padding:10px;border-bottom:1px solid #dee3e8;color:#445840;width:180px;">' . esc_html($label) . '</th><td style="padding:10px;border-bottom:1px solid #dee3e8;color:#202b20;">' . esc_html($value) . '</td></tr>';
    }
    $body .= '</table>';

    if (!empty($data['message'])) {
        $body .= '<h2 style="margin:24px 0 8px;font-size:18px;color:#445840;">' . esc_html__('Message', 'emtss') . '</h2>';
        $body .= '<div style="color:#4a5a68;line-height:1.6;">' . wpautop(esc_html($data['message'])) . '</div>';
    }

    $body .= '<p style="margin:24px 0 0;"><a href="' . esc_url(admin_url('admin.php?page=emtss-inquiries&inquiry=' . absint($post_id))) . '" style="display:inline-block;background:#445840;color:#ffffff;text-decoration:none;padding:12px 18px;border-radius:4px;">' . esc_html__('Open inquiry dashboard', 'emtss') . '</a></p>';

    return wp_mail($recipient, $subject, emtss_email_shell($subject, $body), emtss_mail_headers($data['email']));
}

function emtss_send_thank_you_email($post_id, $data)
{
    if (empty($data['email']) || !is_email($data['email'])) {
        return false;
    }

    $email_content = emtss_get_content_section('thank_you_email');
    $subject       = emtss_apply_email_tokens($email_content['subject'] ?? __('Thank you for contacting EMSS', 'emtss'), $data);
    $title         = emtss_apply_email_tokens($email_content['title'] ?? __('Thank you for your request', 'emtss'), $data);
    $message       = emtss_apply_email_tokens($email_content['message'] ?? '', $data);
    $button        = emtss_apply_email_tokens($email_content['button'] ?? '', $data);
    $button_url    = emtss_normalize_link_url($email_content['button_url'] ?? '/');
    $footer        = emtss_apply_email_tokens($email_content['footer'] ?? '', $data);

    $body = '<p style="margin:0 0 16px;color:#4a5a68;font-size:15px;line-height:1.7;">' . esc_html(sprintf(__('Hello %s,', 'emtss'), $data['name'])) . '</p>';
    $body .= '<div style="margin:0 0 20px;color:#4a5a68;font-size:15px;line-height:1.7;">' . wpautop(esc_html($message)) . '</div>';
    $body .= '<table role="presentation" cellspacing="0" cellpadding="0" style="width:100%;margin:20px 0;border-collapse:collapse;background:#f4f6f3;border:1px solid #dee3e8;border-radius:8px;">';
    $body .= '<tr><td style="padding:14px 16px;color:#445840;font-weight:700;">' . esc_html__('Request type', 'emtss') . '</td><td style="padding:14px 16px;color:#202b20;">' . esc_html(emtss_inquiry_type_label($data['type'])) . '</td></tr>';
    $body .= '<tr><td style="padding:14px 16px;color:#445840;font-weight:700;border-top:1px solid #dee3e8;">' . esc_html__('Phone', 'emtss') . '</td><td style="padding:14px 16px;color:#202b20;border-top:1px solid #dee3e8;">' . esc_html($data['phone']) . '</td></tr>';
    $body .= '<tr><td style="padding:14px 16px;color:#445840;font-weight:700;border-top:1px solid #dee3e8;">' . esc_html__('Organization', 'emtss') . '</td><td style="padding:14px 16px;color:#202b20;border-top:1px solid #dee3e8;">' . esc_html($data['organization']) . '</td></tr>';
    $body .= '</table>';

    if ($button && $button_url) {
        $body .= '<p style="margin:24px 0;"><a href="' . esc_url($button_url) . '" style="display:inline-block;background:#445840;color:#ffffff;text-decoration:none;padding:13px 20px;border-radius:4px;font-weight:700;">' . esc_html($button) . '</a></p>';
    }

    if ($footer) {
        $body .= '<p style="margin:22px 0 0;color:#d4a017;font-family:Arial,sans-serif;font-size:13px;font-weight:700;">' . esc_html($footer) . '</p>';
    }

    $sent = wp_mail($data['email'], $subject, emtss_email_shell($title, $body), emtss_mail_headers());
    update_post_meta($post_id, '_emtss_thank_you_sent', $sent ? 'yes' : 'no');

    return $sent;
}

function emtss_submit_inquiry_ajax()
{
    check_ajax_referer('emtss_inquiry_nonce', 'nonce');

    $data = array(
        'type'         => sanitize_key(wp_unslash($_POST['inquiry_type'] ?? 'briefing')),
        'name'         => sanitize_text_field(wp_unslash($_POST['name'] ?? '')),
        'email'        => sanitize_email(wp_unslash($_POST['email'] ?? '')),
        'phone'        => sanitize_text_field(wp_unslash($_POST['phone'] ?? '')),
        'phone_country' => sanitize_key(wp_unslash($_POST['phone_country'] ?? '')),
        'organization' => sanitize_text_field(wp_unslash($_POST['organization'] ?? '')),
        'message'      => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
    );

    if (!in_array($data['type'], array('briefing', 'contact'), true)) {
        $data['type'] = 'briefing';
    }

    if (!$data['phone_country']) {
        $data['phone_country'] = 'sa';
    }

    if (!in_array($data['phone_country'], emtss_allowed_phone_countries(), true)) {
        wp_send_json_error(array('message' => __('Please select an allowed Arab or GCC country.', 'emtss')), 422);
    }

    if (!$data['name'] || !$data['email'] || !is_email($data['email']) || !$data['phone'] || !$data['organization'] || !$data['message']) {
        wp_send_json_error(array('message' => __('Please complete all required fields with a valid email and phone number.', 'emtss')), 422);
    }

    $post_id = emtss_store_inquiry($data);
    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => $post_id->get_error_message()), 500);
    }

    emtss_notify_admin_about_inquiry($post_id, $data);
    emtss_send_thank_you_email($post_id, $data);

    wp_send_json_success(array(
        'message' => __('Thank you. Our team will contact you shortly.', 'emtss'),
        'id'      => $post_id,
    ));
}
add_action('wp_ajax_emtss_submit_inquiry', 'emtss_submit_inquiry_ajax');
add_action('wp_ajax_nopriv_emtss_submit_inquiry', 'emtss_submit_inquiry_ajax');

function emtss_get_inquiries($args = array())
{
    return get_posts(wp_parse_args($args, array(
        'post_type'      => 'emtss_inquiry',
        'post_status'    => 'private',
        'posts_per_page' => -1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    )));
}

function emtss_inquiry_meta($post_id, $key, $default = '')
{
    $value = get_post_meta($post_id, '_emtss_' . $key, true);
    return $value === '' ? $default : $value;
}

function emtss_send_reply_to_inquiries($inquiry_ids, $subject, $body)
{
    $sent = 0;

    foreach ($inquiry_ids as $inquiry_id) {
        $inquiry_id = absint($inquiry_id);
        $email      = sanitize_email(emtss_inquiry_meta($inquiry_id, 'email'));

        if (!$email || !is_email($email)) {
            continue;
        }

        $html_body = '<div style="font-size:15px;line-height:1.7;color:#4a5a68;">' . wpautop(wp_kses_post($body)) . '</div>';
        $success   = wp_mail($email, $subject, emtss_email_shell($subject, $html_body), emtss_mail_headers());

        if ($success) {
            $sent++;
            $replies = get_post_meta($inquiry_id, '_emtss_replies', true);
            if (!is_array($replies)) {
                $replies = array();
            }
            $replies[] = array(
                'sent_at' => current_time('mysql'),
                'subject' => $subject,
                'body'    => $body,
                'user_id' => get_current_user_id(),
            );
            update_post_meta($inquiry_id, '_emtss_replies', $replies);
            update_post_meta($inquiry_id, '_emtss_status', 'replied');
        }
    }

    return $sent;
}
