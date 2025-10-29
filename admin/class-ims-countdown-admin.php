<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://github.com/amanwebexp/
 * @since      1.0.0
 *
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/admin
 * @author     Aman 
 */
class Ims_Countdown_Admin
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ims_Countdown_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ims_Countdown_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		wp_enqueue_style('ims-countdown-admin-css', plugin_dir_url(__FILE__) . 'css/ims-countdown-admin.css', array(), $this->version, 'all');
		wp_enqueue_style('ims-countdown-admin-css_style', plugin_dir_url(__FILE__) . '/css/admin.css', array(), $this->version, 'all');
		wp_enqueue_style('ims-countdown-datapicker-admin', plugin_dir_url(__FILE__) . '/css/jquery.datetimepicker.css', array(), $this->version, 'all');
		wp_enqueue_style('ims-countdown-admin-spectrum', plugin_dir_url(__FILE__) . '/css/spectrum.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ims_Countdown_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ims_Countdown_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ims-countdown-admin.js', array('jquery'), $this->version, false);
		$screen = get_current_screen();
		if (!($screen->base == 'post' && $screen->post_type == 'ims_countdown')) return;
		wp_enqueue_script('ims-countdown-datepicker-js', plugin_dir_url(__FILE__) . '/js/jquery.datetimepicker.full.min.js', array('jquery'), $this->version, false);
		wp_enqueue_script('ims-countdown-spectrum-js', plugin_dir_url(__FILE__) . '/js/spectrum.js', array('jquery'), $this->version, false);
		wp_enqueue_script('ims-countdown-admin-js', plugin_dir_url(__FILE__) . '/js/admin-custom.js', array('jquery'), $this->version, false);
	}
	function ims_install()
	{
		// Add default timezone
		add_option('imsc_timezone', 'Asia/Kolkata', '', 'yes');

		$labels = array(
			'name' 			=> 'IMS Countdown',
			'singular_name' => 'IMS Countdown',
			'add_new' 		=> 'Add New',
			'all_items' 	=> 'All Countdowns',
			'add_new_item' 	=> 'Add New',
			'edit_item' 	=> 'Edit Countdown',
			'new_item' 		=> 'New Countdown',
			'view_item' 	=> 'View Countdown',
			'search_items' 	=> 'Search Countdowns',
			'not_found' 	=> 'No Countdown found',
			'not_found_in_trash' => 'No Countdown found in trash',
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 				=> false, // it's not public, it shouldn't have it's own permalink, and so on
			'show_ui' 				=> true,  // you should be able to edit it in wp-admin
			'exclude_from_search' 	=> true,  // you should exclude it from search results
			'show_in_nav_menus' 	=> false,  // you shouldn't be able to add it to menus
			'has_archive' 			=> false,  // it shouldn't have archive page
			'publicly_queryable' 	=> true,
			'rewrite' 				=> false,  // it shouldn't have rewrite rules
			'query_var' 			=> true,
			'capability_type' 		=> 'post',
			'hierarchical' 			=> false,
			'menu_icon'  			=> 'dashicons-clock',
			'supports' 				=> array('title', 'editor'),
		);

		register_post_type('ims_countdown', $args);
	}

	function imsCountDown_rowMeta($links, $file)
	{

		if (strpos($file, 'imsCountdown.php') !== false) {
			$new_links = array(
				'imsAjaxCartCount_setting' => '<a href="edit.php?post_type=ims_countdown&page=imsc_countdown_settings">Settings</a>',
			);

			$links = array_merge($links, $new_links);
		}

		return $links;
	}
	function imsc_menu()
	{
		add_submenu_page(
			'edit.php?post_type=ims_countdown',
			__('Settings', 'imsc_countdown_settings'),
			__('Settings', 'imsc_countdown_settings'),
			'manage_options',
			'imsc_countdown_settings',
			array($this, 'imsc_countdown_settings_callback')
		);
	}
	function imsc_register_settings()
	{
		register_setting('imsc_settings', 'imsc_timezone');
		register_setting('ims_countdown_info_settings', 'ims_countdown_info');
	}

	function imsc_countdown_settings_callback()
	{
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ims-countdown-timezone.php';
		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/partials/ims-countdown-admin-display.php';
		if (!function_exists("update_ims_countdown_info")) {
			function update_ims_countdown_info()
			{
				register_setting('ims_countdown-info-settings', 'ims_countdown_info');
			}
		}
	}

	function imsc_countdown_type()
	{
		add_meta_box(
			'wdm_sectionid',
			'Countdown Options',
			array($this, 'imsc_meta_box_callback'),
			'ims_countdown'
		);
	}

	function imsc_sanitize_hex_color($color)
	{
		if ('' === $color) {
			return '';
		}
		if (preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color)) {
			return $color;
		}
		return '';
	}
	function imsc_meta_box_callback($post)
	{
		wp_nonce_field('wdm_meta_box', 'wdm_meta_box_nonce');

		// Sanitize and escape values when retrieving them
		$countdown_type   = esc_attr(get_post_meta($post->ID, 'countdown_type', true));
		$countdown_value  = esc_attr(get_post_meta($post->ID, 'countdown_value', true));

		$ds  = esc_attr(get_post_meta($post->ID, 'ds', true));
		$hr  = esc_attr(get_post_meta($post->ID, 'hr', true));
		$mn  = esc_attr(get_post_meta($post->ID, 'mn', true));
		$sc  = esc_attr(get_post_meta($post->ID, 'sc', true));

		$expire_action  = esc_attr(get_post_meta($post->ID, 'expire_action', true));
		$redirect_url   = esc_url_raw(get_post_meta($post->ID, 'redirect_url', true));

		$theme           = esc_attr(get_post_meta($post->ID, 'theme', true));
		$font_face       = esc_attr(get_post_meta($post->ID, 'font_face', true));
		$title_color     = esc_attr(get_post_meta($post->ID, 'title_color', true));
		$timer_color     = esc_attr(get_post_meta($post->ID, 'timer_color', true));
		$timer_background = esc_attr(get_post_meta($post->ID, 'timer_background', true));
		$timer_border    = esc_attr(get_post_meta($post->ID, 'timer_border', true));
		$hide_title      = esc_attr(get_post_meta($post->ID, 'hide_title', true));

		$days     = esc_attr(get_post_meta($post->ID, 'days', true));
		$hours    = esc_attr(get_post_meta($post->ID, 'hours', true));
		$minutes  = esc_attr(get_post_meta($post->ID, 'minutes', true));
		$seconds  = esc_attr(get_post_meta($post->ID, 'seconds', true));

		// Determine default checked state for countdown type/radio or checkbox
		$checked = '';
		if (empty($countdown_type) && empty($countdown_value)) {
			$checked = "checked='checked'";
		}

		require_once plugin_dir_path(dirname(__FILE__)) . 'admin/class-ims-countdown-timezone.php';
		require plugin_dir_path(dirname(__FILE__)) . 'admin/partials/class-ims-countdown-meta-boxes.php';
	}

	// Callback to save meta data
	function imsc_save_meta_box_data($post_id, $post)
	{
		// Verify nonce
		if (! isset($_POST['wdm_meta_box_nonce'])) {
			return;
		}
		if (! wp_verify_nonce($_POST['wdm_meta_box_nonce'], 'wdm_meta_box')) {
			return;
		}

		// Check autosave
		if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
			return;
		}

		// Check user permissions
		if (! current_user_can('edit_post', $post_id)) {
			return;
		}

		// Sanitize and save Countdown Timer fields
		$countdown_type  = isset($_POST['countdown_type']) ? sanitize_text_field($_POST['countdown_type']) : '';
		$countdown_value = isset($_POST['countdown_value']) ? sanitize_text_field($_POST['countdown_value']) : '';

		$ds = isset($_POST['ds']) ? sanitize_text_field($_POST['ds']) : '';
		$hr = isset($_POST['hr']) ? sanitize_text_field($_POST['hr']) : '';
		$mn = isset($_POST['mn']) ? sanitize_text_field($_POST['mn']) : '';
		$sc = isset($_POST['sc']) ? sanitize_text_field($_POST['sc']) : '';

		$expire_action = isset($_POST['expire_action']) ? sanitize_text_field($_POST['expire_action']) : '';
		$redirect_url  = isset($_POST['redirect_url']) ? esc_url_raw($_POST['redirect_url']) : '';

		// Sanitize and save Countdown Style fields
		$theme            = isset($_POST['theme']) ? sanitize_text_field($_POST['theme']) : '';
		$font_face        = isset($_POST['font_face']) ? sanitize_text_field($_POST['font_face']) : '';
		$title_color      = isset($_POST['title_color']) ? sanitize_hex_color($_POST['title_color']) : '';
		$timer_color      = isset($_POST['timer_color']) ? sanitize_hex_color($_POST['timer_color']) : '';
		$timer_background = isset($_POST['timer_background']) ? sanitize_hex_color($_POST['timer_background']) : '';
		$timer_border     = isset($_POST['timer_border']) ? sanitize_hex_color($_POST['timer_border']) : '';
		$hide_title       = isset($_POST['hide_title']) ? sanitize_text_field($_POST['hide_title']) : '';

		// Sanitize and save Countdown Language fields
		$days    = isset($_POST['days']) ? sanitize_text_field($_POST['days']) : '';
		$hours   = isset($_POST['hours']) ? sanitize_text_field($_POST['hours']) : '';
		$minutes = isset($_POST['minutes']) ? sanitize_text_field($_POST['minutes']) : '';
		$seconds = isset($_POST['seconds']) ? sanitize_text_field($_POST['seconds']) : '';


		// Save sanitized meta
		update_post_meta($post_id, 'countdown_type', $countdown_type);
		update_post_meta($post_id, 'countdown_value', $countdown_value);

		update_post_meta($post_id, 'ds', $ds);
		update_post_meta($post_id, 'hr', $hr);
		update_post_meta($post_id, 'mn', $mn);
		update_post_meta($post_id, 'sc', $sc);

		update_post_meta($post_id, 'expire_action', $expire_action);
		update_post_meta($post_id, 'redirect_url', $redirect_url);

		update_post_meta($post_id, 'theme', $theme);
		update_post_meta($post_id, 'font_face', $font_face);
		update_post_meta($post_id, 'title_color', $title_color);
		update_post_meta($post_id, 'timer_color', $timer_color);
		update_post_meta($post_id, 'timer_background', $timer_background);
		update_post_meta($post_id, 'timer_border', $timer_border);
		update_post_meta($post_id, 'hide_title', $hide_title);

		update_post_meta($post_id, 'days', $days);
		update_post_meta($post_id, 'hours', $hours);
		update_post_meta($post_id, 'minutes', $minutes);
		update_post_meta($post_id, 'seconds', $seconds);
	}
}
