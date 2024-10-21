<?php
add_action('wp_enqueue_scripts', 'vat_enqueue_styles_scripts');

function vat_enqueue_styles_scripts() {
    // Enqueue the styles
    wp_enqueue_style('vat-styles', plugin_dir_url(__FILE__) . '../assets/css/style.css');
    
    // Enqueue the script
    wp_enqueue_script('vat-ajax-script', plugin_dir_url(__FILE__) . '../assets/js/vat-ajax.js', array('jquery'), null, true);
    
    // Localize the script with error messages and ajax_url
    wp_localize_script('vat-ajax-script', 'vat_ajax_obj', array(
        'error_message' => __('Please fill in all fields correctly.', 'vat_calculator'),
        'ajax_url' => admin_url('admin-ajax.php'),
        'calculation_error' => __('Error during calculations.', 'vat_calculator')
    ));
}