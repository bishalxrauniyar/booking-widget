<?php

/**
 * Plugin Name: Elementor Booking Widget
 * Description: Auto embed any embeddable content from external URLs into Elementor.
 * Plugin URI:  https://github.com/bishalxrauniyar
 * Version:     1.0.0
 * Author:      Elementor Developer
 * Author URI:  https://github.com/bishalxrauniyar
 * Text Domain: elementor-booking-widget
 *
 * Requires Plugins: elementor
 * Elementor tested up to: 3.25.0
 * Elementor Pro tested up to: 3.25.0
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Register Elementor Booking Widget.
 */
function register_booking_widget($widgets_manager)
{
    require_once __DIR__ . '/widgets/booking-widget.php';
    $widgets_manager->register(new \Elementor_Booking_Widget());
}
add_action('elementor/widgets/register', 'register_booking_widget');

// Include AJAX handlers
require_once __DIR__ . '/includes/ajax-handlers.php';
