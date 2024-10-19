<?php
// Handle the AJAX request for VAT calculation
add_action('wp_ajax_vat_calculate_tax', 'vat_handle_tax_calculation');
add_action('wp_ajax_nopriv_vat_calculate_tax', 'vat_handle_tax_calculation');

function vat_handle_tax_calculation() {
    $product_name = sanitize_text_field($_POST['product_name']);
    $net_amount = floatval($_POST['net_amount']);
    $vat_rate = $_POST['vat_rate'];

    $vat_value = 0;
    $gross_amount = $net_amount;
    $client_ip = $_SERVER['REMOTE_ADDR'];

    $post_id = wp_insert_post(array(
        'post_title' => $product_name,
        'post_type' => 'vat_calculation',
        'post_status' => 'publish'
    ));

    if (is_numeric($vat_rate)) {
        $vat_value = $net_amount * ($vat_rate / 100);
        $gross_amount = $net_amount + $vat_value;
        update_post_meta($post_id, 'vat_value', number_format($vat_value, 2, '.', ''));
    } elseif (in_array($vat_rate, ['zw', 'np', 'oo'])) {
        update_post_meta($post_id, 'vat_value', 0);
    }

    update_post_meta($post_id, 'net_amount', number_format($net_amount, 2, '.', ''));
    update_post_meta($post_id, 'vat_rate', $vat_rate);
    update_post_meta($post_id, 'gross_amount', number_format($gross_amount, 2, '.', ''));
    update_post_meta($post_id, 'client_ip', $client_ip);
    update_post_meta($post_id, 'calculation_date', current_time('mysql'));

    $response = array(
        'message' => sprintf(
            __('Cena produktu <strong>%s</strong>, wynosi:&nbsp;<strong>%s zł brutto</strong>, kwota&nbsp;podatku&nbsp;to&nbsp;<strong>%s&nbsp;zł</strong>.', 'vat_calculator'),
            esc_html($product_name),
            number_format($gross_amount, 2),
            number_format($vat_value, 2)
        )
    );

    echo json_encode($response);
    wp_die();
}