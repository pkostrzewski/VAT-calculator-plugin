<?php
// Register Custom Post Type 'VAT Calculations' for saving form data
function vat_register_custom_post_type() {
    $labels = array(
        'name' => __('VAT Calculations', 'vat_calculator'),
        'singular_name' => __('VAT Calculation', 'vat_calculator'),
        'menu_name' => __('VAT Calculations', 'vat_calculator'),
        'name_admin_bar' => __('VAT Calculation', 'vat_calculator'),
    );

    $args = array(
        'labels' => $labels,
        'public' => false,
        'show_ui' => true,
        'supports' => array('title'),
        'capability_type' => 'post',
    );

    register_post_type('vat_calculation', $args);
}

// Add custom columns to CPT
add_filter('manage_vat_calculation_posts_columns', 'vat_set_custom_edit_vat_calculation_columns');
add_action('manage_vat_calculation_posts_custom_column', 'vat_custom_vat_calculation_column', 10, 2);

function vat_set_custom_edit_vat_calculation_columns($columns) {
    return array(
        'cb' => '<input type="checkbox" />',
        'title' => __('Title', 'vat_calculator'),
        'net_amount' => __('Net Amount', 'vat_calculator'),
        'gross_amount' => __('Gross Amount', 'vat_calculator'),
        'vat_rate' => __('VAT Rate', 'vat_calculator'),
        'client_ip' => __('Client IP', 'vat_calculator'),
        'date' => __('Date', 'vat_calculator')
    );
}

// Display VAT values in custom post type columns.
function vat_custom_vat_calculation_column($column, $post_id) {
    switch ($column) {
        case 'net_amount':
            $net_amount = get_post_meta($post_id, 'net_amount', true);
            echo esc_html($net_amount !== '' ? $net_amount . ' PLN' : 'N/A');
            break;
        case 'gross_amount':
            $gross_amount = get_post_meta($post_id, 'gross_amount', true);
            echo esc_html($gross_amount !== '' ? $gross_amount . ' PLN' : 'N/A');
            break;
        case 'vat_rate':
            $vat_rate = get_post_meta($post_id, 'vat_rate', true);
            if (is_numeric($vat_rate)) {
                echo esc_html($vat_rate) . '%';
            } else {
                echo esc_html($vat_rate !== '' ? $vat_rate : 'N/A');
            }
            break;
        case 'client_ip':
            $client_ip = get_post_meta($post_id, 'client_ip', true);
            echo esc_html($client_ip !== '' ? $client_ip : 'N/A');
            break;
    }
}