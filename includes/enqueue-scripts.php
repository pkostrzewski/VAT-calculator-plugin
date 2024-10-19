<?php
// Enqueue styles and scripts
add_action('wp_enqueue_scripts', 'vat_enqueue_styles_scripts');

function vat_enqueue_styles_scripts() {
    wp_enqueue_style('vat-styles', plugin_dir_url(__FILE__) . '../assets/css/style.css');
    wp_enqueue_script('vat-ajax-script', plugin_dir_url(__FILE__) . '../assets/js/vat-ajax.js', array('jquery'), null, true);
    wp_localize_script('vat-ajax-script', 'vat_ajax_obj', array('ajax_url' => admin_url('admin-ajax.php')));
}