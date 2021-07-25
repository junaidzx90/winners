<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Code_checker
 * @subpackage Code_checker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Code_checker
 * @subpackage Code_checker/public
 * @author     Md Junayed <admin@easeare.com>
 */
class Code_checker_Public {

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
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_shortcode( 'code_checker', [$this,'code_checker_input_view'] );
		add_shortcode( 'check_counter', [$this,'code_checker_check_counter'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/code_checker-public.css', array(), microtime(), 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/code_checker-public.js', array( 'jquery' ), microtime(), false );
		wp_localize_script($this->plugin_name, "check_my_code", array(
			'ajaxurl' 	=> 	admin_url('admin-ajax.php'),
			'nonce'		=>	wp_create_nonce( 'code_checker_nonce' )
		));
	}
	
	function code_checker_input_view($param){
		ob_start();
		require_once plugin_dir_path( __FILE__ ).'partials/code_checker-public-display.php';
		$output = ob_get_contents();
		ob_get_clean();

		return $output;
	}

	function check_my_code_validity(){
		if(!wp_verify_nonce( $_POST['nonce'], 'code_checker_nonce' )){
			die("Hey! what are you doing here.");
		}

		if(isset($_POST['code']) && !empty($_POST['code'])){
			$mycode = strtolower($_POST['code']);
			$code = strtolower(get_option('code_checker_comparing_code'));
			
			if($mycode === $code){
				global $wpdb;
				
				$position = 0;
				$position = get_option('winner_pos');

				if($position == intval(get_option( 'code_checker_counter_limit' ))){
					$position = 0;
				}

				update_option('winner_pos', $position+1);

				if(intval(get_option('winner_pos')) == intval(get_option('code_checker_special_pos'))){
					echo json_encode(array('success' => '<p class="success"><i class="fas fa-check-circle"></i> '.get_option('code_checker_special_coupon_text').'</p>','counter' => $position+1));
				}else{
					echo json_encode(array('success' => '<p class="success"><i class="fas fa-check-circle"></i> '.get_option('code_checker_winner_text').'</p>','counter' => $position+1));
				}
				die;
			}else{
				echo json_encode(array('error' => '<p class="warning"><i class="fas fa-warning"></i> '.get_option('code_checker_notmatch_text').'</p>'));
				die;
			}
			
			die;
		}

		die;
	}

	function code_checker_check_counter(){
		$output = '<div class="counter-box"><span id="checkCounter">';
		$output .= get_option('winner_pos');
		$output .= '</span></div>';
		return $output;
	}

}
