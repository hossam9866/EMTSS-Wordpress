<?php
/**
 * Theme footer.
 *
 * @package EMTSS
 */

if (!defined('ABSPATH')) {
    exit;
}

$modal = emtss_get_content_section('modal');
?>

<?php
if (function_exists('emtss_render_site_footer') && empty($GLOBALS['emtss_site_footer_rendered'])) {
    echo emtss_render_site_footer();
}
?>

<div class="modal fade emtss-modal" id="emtssInquiryModal" tabindex="-1" aria-labelledby="emtssInquiryTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title" id="emtssInquiryTitle"><?php echo esc_html($modal['briefing_title'] ?? __('Request a Private Briefing', 'emtss')); ?></h2>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="<?php esc_attr_e('Close', 'emtss'); ?>"></button>
            </div>
            <form class="emtss-inquiry-form" method="post">
                <div class="modal-body">
                    <input type="hidden" name="action" value="emtss_submit_inquiry">
                    <input type="hidden" name="nonce" value="<?php echo esc_attr(wp_create_nonce('emtss_inquiry_nonce')); ?>">
                    <input type="hidden" name="inquiry_type" value="briefing" data-emtss-inquiry-type>
                    <input type="hidden" name="phone_country" value="sa" data-emtss-phone-country>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label" for="emtss-name"><?php echo esc_html($modal['name'] ?? __('Full name', 'emtss')); ?></label>
                            <input class="form-control" id="emtss-name" type="text" name="name" required aria-required="true">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="emtss-email"><?php echo esc_html($modal['email'] ?? __('Email', 'emtss')); ?></label>
                            <input class="form-control" id="emtss-email" type="email" name="email" required aria-required="true">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="emtss-phone"><?php echo esc_html($modal['phone'] ?? __('Phone', 'emtss')); ?></label>
                            <input class="form-control" id="emtss-phone" type="tel" name="phone" required aria-required="true" autocomplete="tel">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="emtss-organization"><?php echo esc_html($modal['organization'] ?? __('Organization', 'emtss')); ?></label>
                            <input class="form-control" id="emtss-organization" type="text" name="organization" required aria-required="true">
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="emtss-message"><?php echo esc_html($modal['message'] ?? __('Message', 'emtss')); ?></label>
                            <textarea class="form-control" id="emtss-message" name="message" rows="4" required aria-required="true"></textarea>
                        </div>
                    </div>
                    <div class="emtss-form-response" role="status" aria-live="polite"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn emtss-btn emtss-btn-muted" data-bs-dismiss="modal"><?php echo esc_html($modal['cancel'] ?? __('Cancel', 'emtss')); ?></button>
                    <button type="submit" class="btn emtss-btn emtss-btn-primary">
                        <i class="bi bi-send"></i>
                        <span><?php echo esc_html($modal['send'] ?? __('Send request', 'emtss')); ?></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php wp_footer(); ?>
</body>
</html>
