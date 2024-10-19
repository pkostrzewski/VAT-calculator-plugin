<?php
/*
Plugin Name: VAT Calculator
Description: VAT calculator with calculating different tax rates and saving calculations to Custom Post Type 'VAT Calculations'
Version: 1.0
Author: Iron Brand Piotr Kostrzewski
*/

// Plugin initialization
add_action('init', 'vat_register_custom_post_type');

add_action('plugins_loaded', 'vat_load_textdomain');
function vat_load_textdomain() {
    load_plugin_textdomain('vat_calculator', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}

// Include necessary files
require_once plugin_dir_path(__FILE__) . 'includes/cpt.php';
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';
require_once plugin_dir_path(__FILE__) . 'includes/ajax.php';
require_once plugin_dir_path(__FILE__) . 'includes/metaboxes.php';