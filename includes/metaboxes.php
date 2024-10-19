<?php
// Add metabox to CPT
add_action('add_meta_boxes', 'vat_add_custom_meta_box');
add_action('save_post', 'vat_save_custom_meta_box_data');

function vat_add_custom_meta_box() {
    add_meta_box('vat_details_meta_box', __('Szczegóły wyliczenia', 'vat_calculator'), 'vat_render_meta_box_content', 'vat_calculation', 'normal', 'high');
}

function vat_render_meta_box_content($post) {
    $net_amount = get_post_meta($post->ID, 'net_amount', true);
    $vat_rate = get_post_meta($post->ID, 'vat_rate', true);
    $gross_amount = get_post_meta($post->ID, 'gross_amount', true);
    $client_ip = get_post_meta($post->ID, 'client_ip', true);
    $calculation_date = get_post_meta($post->ID, 'calculation_date', true);

    ?>
    <div>
        <h4><?php echo __('Kwota Netto:', 'vat_calculator'); ?></h4>
        <p><?php echo esc_html($net_amount); ?> PLN</p>
        <h4><?php echo __('Stawka VAT:', 'vat_calculator'); ?></h4>
        <p><?php echo esc_html($vat_rate); ?>%</p>
        <h4><?php echo __('Kwota Brutto:', 'vat_calculator'); ?></h4>
        <p><?php echo esc_html($gross_amount); ?> PLN</p>
        <h4><?php echo __('Adres IP:', 'vat_calculator'); ?></h4>
        <p><?php echo esc_html($client_ip); ?></p>
        <h4><?php echo __('Data wyliczenia:', 'vat_calculator'); ?></h4>
        <p><?php echo esc_html($calculation_date); ?></p>
    </div>
    <?php
}

function vat_save_custom_meta_box_data($post_id) {
    if (!isset($_POST['vat_meta_box_nonce']) || !wp_verify_nonce($_POST['vat_meta_box_nonce'], 'vat_meta_box_nonce_action')) {
        return;
    }
}