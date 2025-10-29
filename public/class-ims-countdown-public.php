<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://github.com/amanwebexp/
 * @since      1.0.0
 *
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ims_Countdown
 * @subpackage Ims_Countdown/public
 * @author     Aman 
 */
class Ims_Countdown_Public
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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/ims-countdown-public.css', array(), $this->version, 'all');
		wp_enqueue_style('frontend-style', plugin_dir_url(__FILE__) . 'css/frontend.css', array(), $this->version, 'all');
		wp_enqueue_style('countdown-script', plugin_dir_url(__FILE__) . 'css/frontend.css', array(), $this->version, false);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/ims-countdown-public.js', array('jquery'), $this->version, false);
		wp_enqueue_script('plugin-script', plugin_dir_url(__FILE__) . 'js/jquery.plugin.js', array('jquery'), $this->version, false);
		wp_enqueue_script('countdown-script', plugin_dir_url(__FILE__) . 'js/jquery.countdown.js', array('jquery'), $this->version, false);
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-countdown', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-countdown/2.2.0/jquery.countdown.min.js', array('jquery'), null, true);

		wp_enqueue_script('imsc_custom', plugin_dir_url(__FILE__) . 'js/custom.js', array('jquery'), null, true);
	}
	public function shortcode($atts)
	{
		ob_start();
		require_once plugin_dir_path(dirname(__FILE__)) . 'public/partials/ims-countdown-public-display.php';
		return ob_get_clean();
	}
}
