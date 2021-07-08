<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Winners
 * @subpackage Winners/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Winners
 * @subpackage Winners/admin
 * @author     Md Junayed <admin@easeare.com>
 */
class Winners_Admin {

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
		if(isset($_GET['page']) && $_GET['page'] == 'winners'){
			wp_enqueue_style( 'dataTable', plugin_dir_url( __FILE__ ) . 'css/dataTable.css', array(), $this->version, 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/winners-admin.css', array(), $this->version, 'all' );
		}
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		if(isset($_GET['page']) && $_GET['page'] == 'winners'){
			wp_enqueue_script( 'dataTable', plugin_dir_url( __FILE__ ) . 'js/dataTable.js', array( 'jquery' ), $this->version, false );
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/winners-admin.js', array( 'jquery' ), $this->version, false );
		}
	}

	function winners_menupage(){
		add_menu_page( 'Winners', 'Winners', 'manage_options', 'winners', [$this,'winners_main_page'], 'dashicons-awards', 45 );
	}

	function winners_main_page(){
		require_once plugin_dir_path( __FILE__ )."partials/winners-mainpage.php";
	}

	function winners_options_api(){
		// winners settings
		add_settings_section( 'winners_settings_section', '', '', 'winners_settings_page' );

		// Defined code
		add_settings_field( 'winners_comparing_code', 'Defined code', [$this,'winners_comparing_code_cb'], 'winners_settings_page', 'winners_settings_section');
		register_setting( 'winners_settings_section', 'winners_comparing_code');
		
		// match text
		add_settings_field( 'winners_winner_text', 'Winner match text', [$this,'winners_winner_text_cb'], 'winners_settings_page', 'winners_settings_section');
		register_setting( 'winners_settings_section', 'winners_winner_text');

		// Special coupon text
		add_settings_field( 'winners_special_coupon_text', 'Special coupon text', [$this,'winners_special_coupon_text_cb'], 'winners_settings_page', 'winners_settings_section');
		register_setting( 'winners_settings_section', 'winners_special_coupon_text');

		// Not match text
		add_settings_field( 'winners_notmatch_text', 'Not match text', [$this,'winners_notmatch_text_cb'], 'winners_settings_page', 'winners_settings_section');
		register_setting( 'winners_settings_section', 'winners_notmatch_text');

		// Check input info
		add_settings_field( 'winners_input_box_headline', 'Check input heading', [$this,'winners_input_box_headline_cb'], 'winners_settings_page', 'winners_settings_section');
		register_setting( 'winners_settings_section', 'winners_input_box_headline');
	}

	function winners_comparing_code_cb(){
		echo '<input  class="widefat" type="text" placeholder="Code" value="'.get_option('winners_comparing_code').'" name="winners_comparing_code">';
	}
	function winners_notmatch_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="text" value="'.get_option('winners_notmatch_text').'" name="winners_notmatch_text">';
	}
	function winners_winner_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="text" value="'.get_option('winners_winner_text').'" name="winners_winner_text">';
	}
	function winners_special_coupon_text_cb(){
		echo '<input  class="widefat" type="text" placeholder="Special coupon text" value="'.get_option('winners_special_coupon_text').'" name="winners_special_coupon_text">';
	}
	function winners_input_box_headline_cb(){
		echo '<input  class="widefat" type="text" placeholder="Box heading" value="'.get_option('winners_input_box_headline').'" name="winners_input_box_headline">';
	}
}
