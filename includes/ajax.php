<?php
// Handle the AJAX request for VAT calculation
add_action('wp_ajax_vat_calculate_tax', 'vat_handle_tax_calculation');
add_action('wp_ajax_nopriv_vat_calculate_tax', 'vat_handle_tax_calculation');

function vat_handle_tax_calculation() {
    // Nonce verification
    check_ajax_referer('vat_calculator_nonce_action', 'vat_calculator_nonce');

    $product_name = sanitize_text_field($_POST['product_name']);
    $net_amount = floatval($_POST['net_amount']);
    $vat_rate = sanitize_text_field($_POST['vat_rate']);

    // Data validation
    if (empty($product_name) || $net_amount <= 0 || (!is_numeric($vat_rate) && !in_array($vat_rate, ['ZW', 'NP', 'OO']))) {
        wp_send_json_error(array('message' => __('Invalid input data', 'vat_calculator')));
        wp_die();
    }    

    $vat_value = 0;
    $gross_amount = $net_amount;
    $client_ip = $_SERVER['REMOTE_ADDR'];

    // Attempt to create a post
    $post_id = wp_insert_post(array(
        'post_title' => $product_name,
        'post_type' => 'vat_calculation',
        'post_status' => 'publish'
    ));

    // Error checking when creating a post
    if (is_wp_error($post_id)) {
        wp_send_json_error(array('message' => sprintf(__('Error creating post: %s', 'vat_calculator'), esc_html($post_id->get_error_message()))));
        wp_die();
    }

    // VAT calculations
    if (is_numeric($vat_rate)) {
        $vat_value = $net_amount * ($vat_rate / 100);
        $gross_amount = $net_amount + $vat_value;
        update_post_meta($post_id, 'vat_value', number_format($vat_value, 2, '.', ''));
    } elseif (strtoupper($vat_rate) == 'ZW') {
        update_post_meta($post_id, 'vat_value', 0);
        $gross_amount = number_format($net_amount, 2); // Kwota brutto to po prostu kwota netto w tym przypadku
        $response_message = sprintf(__('The product <strong>%s</strong> is VAT exempt (0%%). The gross amount is <strong>%s zł</strong>.', 'vat_calculator'), esc_html($product_name), $gross_amount);
    } elseif (strtoupper($vat_rate) == 'NP') {
        update_post_meta($post_id, 'vat_value', 0);
        $gross_amount = number_format($net_amount, 2); // Kwota brutto to również kwota netto
        $response_message = sprintf(__('The product <strong>%s</strong> is not subject to VAT. The gross amount is <strong>%s zł</strong>.', 'vat_calculator'), esc_html($product_name), $gross_amount);
    } elseif (strtoupper($vat_rate) == 'OO') {
        update_post_meta($post_id, 'vat_value', 0);
        $gross_amount = number_format($net_amount, 2); // Kwota brutto pozostaje taka sama
        $response_message = sprintf(__('The product <strong>%s</strong> is taxable but does not incur VAT. The gross amount is <strong>%s zł</strong>.', 'vat_calculator'), esc_html($product_name), $gross_amount);
    }    

    // Saving meta data
    update_post_meta($post_id, 'net_amount', number_format($net_amount, 2, '.', ''));
    update_post_meta($post_id, 'vat_rate', $vat_rate);
    update_post_meta($post_id, 'gross_amount', number_format($gross_amount, 2, '.', ''));
    update_post_meta($post_id, 'client_ip', $client_ip);
    update_post_meta($post_id, 'calculation_date', current_time('mysql'));

    // Preparing the response
    if (!isset($response_message)) {
        $response_message = sprintf(
            __('The price of the product <strong>%s</strong> is: <strong>%s zł gross</strong>, the tax amount is <strong>%s zł</strong>.', 'vat_calculator'),
            esc_html($product_name),
            number_format($gross_amount, 2),
            number_format($vat_value, 2)
        );
    }

    $response = array(
        'message' => $response_message
    );

    // Returning results in JSON format
    wp_send_json_success($response);
    wp_die();
}