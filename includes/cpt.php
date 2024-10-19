<?php
// Register Custom Post Type 'VAT Calculations' for saving form data
function vat_register_custom_post_type() {
    $labels = array(
        'name' => __('Kalkulacje VAT', 'vat_calculator'),
        'singular_name' => __('Kalkulacje VAT', 'vat_calculator'),
        'menu_name' => __('Kalkulacje VAT', 'vat_calculator'),
        'name_admin_bar' => __('Kalkulacja VAT', 'vat_calculator'),
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
        'title' => __('Tytuł', 'vat_calculator'),
        'net_amount' => __('Kwota Netto', 'vat_calculator'),
        'gross_amount' => __('Kwota Brutto', 'vat_calculator'),
        'vat_rate' => __('Stawka VAT', 'vat_calculator'),
        'client_ip' => __('Adres IP', 'vat_calculator'),
        'date' => __('Data publikacji', 'vat_calculator')
    );
}

// Display VAT values in custom post type columns.
function vat_custom_vat_calculation_column($column, $post_id) {
    switch ($column) {
        case 'net_amount':
            echo esc_html(get_post_meta($post_id, 'net_amount', true)) . ' PLN';
            break;
        case 'gross_amount':
            echo esc_html(get_post_meta($post_id, 'gross_amount', true)) . ' PLN';
            break;
        case 'vat_rate':
            $vat_rate = get_post_meta($post_id, 'vat_rate', true);
            if (is_numeric($vat_rate)) {
                echo esc_html($vat_rate) . '%';
            } else {
                echo esc_html($vat_rate);
            }
            break;
        case 'client_ip':
            echo esc_html(get_post_meta($post_id, 'client_ip', true));
            break;
    }
}