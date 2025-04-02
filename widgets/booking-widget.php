<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Elementor Booking Widget.
 *
 * This widget allows users to select a booking date using Flatpickr and fetch available packages dynamically.
 *
 * @since 1.0.0
 */
class Elementor_Booking_Widget extends \Elementor\Widget_Base
{
    /**
     * Constructor to enqueue scripts.
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        // Enqueue scripts when Elementor frontend loads
        add_action('elementor/frontend/after_enqueue_scripts', [$this, 'enqueue_booking_scripts']);
    }

    /**
     * Enqueue required scripts and styles.
     */
    public function enqueue_booking_scripts()
    {
        wp_enqueue_style('flatpickr-css', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
        wp_enqueue_script('flatpickr-js', 'https://cdn.jsdelivr.net/npm/flatpickr', [], false, true);

        // Custom JavaScript for widget functionality
        wp_enqueue_script(
            'booking-widget-js',
            plugin_dir_url(__FILE__) . 'assets/js/booking-widget.js',
            ['jquery', 'flatpickr'],
            false,
            true
        );

        // Localize script to use AJAX in WordPress
        wp_localize_script('booking-widget-js', 'booking_ajax', [
            'ajaxurl' => admin_url('admin-ajax.php')
        ]);
    }

    /**
     * Retrieve widget name.
     */
    public function get_name(): string
    {
        return 'booking';
    }

    /**
     * Retrieve widget title.
     */
    public function get_title(): string
    {
        return esc_html__('Booking', 'elementor-booking-widget');
    }

    /**
     * Retrieve widget icon.
     */
    public function get_icon(): string
    {
        return 'eicon-calendar';
    }

    /**
     * Retrieve widget categories.
     */
    public function get_categories(): array
    {
        return ['general'];
    }

    /**
     * Register booking widget controls.
     */
    protected function register_controls(): void
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'elementor-booking-widget'),
                'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'button_text',
            [
                'label'       => esc_html__('Button Text', 'elementor-booking-widget'),
                'type'        => \Elementor\Controls_Manager::TEXT,
                'default'     => esc_html__('Check Packages', 'elementor-booking-widget'),
                'placeholder' => esc_html__('Enter button text', 'elementor-booking-widget'),
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render the widget output on the frontend.
     */
    protected function render(): void
    {
        $settings = $this->get_settings_for_display();
?>
        <div class="booking-widget">
            <input type="text" id="booking-date" placeholder="Select Date">
            <button id="check-packages"><?php echo esc_html($settings['button_text']); ?></button>
            <div id="packages-list"></div>
        </div>
<?php
    }
}
