<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Code_checker
 * @subpackage Code_checker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Code_checker
 * @subpackage Code_checker/admin
 * @author     Md Junayed <admin@easeare.com>
 */
class Code_checker_Admin {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		if(isset($_GET['page']) && $_GET['page'] == 'code-checker'){
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/code_checker-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if(isset($_GET['page']) && $_GET['page'] == 'code-checker'){
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/code_checker-admin.js', array( 'jquery' ), $this->version, false );
			wp_localize_script($this->plugin_name, "resetcounter", array(
				'ajaxurl' 	=> 	admin_url('admin-ajax.php'),
			));
		}
	}

	function code_checker_menupage(){
		add_menu_page( 'Code checker', 'Code checker', 'manage_options', 'code-checker', [$this,'code_checker_main_page'], 'dashicons-awards', 45 );
	}

	function code_checker_main_page(){
		require_once plugin_dir_path( __FILE__ )."partials/code_checker-mainpage.php";
	}

	function code_checker_options_api(){
		// code_checker settings
		add_settings_section( 'code_checker_settings_section', '', '', 'code_checker_settings_page' );

		// Defined code
		add_settings_field( 'code_checker_comparing_code', 'Defined code', [$this,'code_checker_comparing_code_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_comparing_code');
		
		// match text
		add_settings_field( 'code_checker_winner_text', 'Winner match text', [$this,'code_checker_winner_text_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_winner_text');

		// Special coupon text
		add_settings_field( 'code_checker_special_coupon_text', 'Special coupon text', [$this,'code_checker_special_coupon_text_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_special_coupon_text');

		// Not match text
		add_settings_field( 'code_checker_notmatch_text', 'Not match text', [$this,'code_checker_notmatch_text_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_notmatch_text');

		// Check input info
		add_settings_field( 'code_checker_input_box_headline', 'Check input heading', [$this,'code_checker_input_box_headline_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_input_box_headline');

		// Counter Limit
		add_settings_field( 'code_checker_counter_limit', 'Counter Limits', [$this,'code_checker_counter_limit_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_counter_limit');

		// Special user position
		add_settings_field( 'code_checker_special_pos', 'Special position', [$this,'code_checker_special_pos_cb'], 'code_checker_settings_page', 'code_checker_settings_section');
		register_setting( 'code_checker_settings_section', 'code_checker_special_pos');
	}

	function code_checker_comparing_code_cb(){
		echo '<input  class="widefat" type="text" placeholder="Code" value="'.get_option('code_checker_comparing_code').'" name="code_checker_comparing_code">';
	}
	function code_checker_notmatch_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="text" value="'.get_option('code_checker_notmatch_text').'" name="code_checker_notmatch_text">';
	}
	function code_checker_winner_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="text" value="'.get_option('code_checker_winner_text').'" name="code_checker_winner_text">';
	}
	function code_checker_special_coupon_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="Special coupon text" value="'.get_option('code_checker_special_coupon_text').'" name="code_checker_special_coupon_text">';
	}
	function code_checker_input_box_headline_cb(){
		echo '<input  class="widefat" type="text" placeholder="Box heading" value="'.get_option('code_checker_input_box_headline').'" name="code_checker_input_box_headline">';
	}
	function code_checker_counter_limit_cb(){
		echo '<input  class="widefat" type="number" placeholder="Max limit" value="'.get_option('code_checker_counter_limit').'" name="code_checker_counter_limit">';
	}
	function code_checker_special_pos_cb(){
		echo '<input  class="widefat" type="number" placeholder="Special position" value="'.get_option('code_checker_special_pos').'" name="code_checker_special_pos">';
	}

	function reset_counters(){
		update_option('winner_pos', 0);
		echo 'reseted';
		die;
	}
}
