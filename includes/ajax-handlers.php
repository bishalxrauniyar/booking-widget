<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

// Hook AJAX handlers for logged-in and logged-out users
add_action('wp_ajax_get_packages', 'get_available_packages');
add_action('wp_ajax_nopriv_get_packages', 'get_available_packages');

function get_available_packages()
{
    // Get the selected date from the AJAX request
    $selected_date = isset($_POST['date']) ? sanitize_text_field($_POST['date']) : '';

    if (empty($selected_date)) {
        wp_send_json_error(['message' => 'Date is required.']);
    }

    // Simulated package data (Replace this with a real database query)
    $packages = [
        ['name' => 'Basic Package'],
        ['name' => 'Premium Package'],
        ['name' => 'VIP Package']
    ];

    // Send JSON response back to AJAX
    wp_send_json_success($packages);
}
