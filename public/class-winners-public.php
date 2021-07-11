<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Winners
 * @subpackage Winners/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Winners
 * @subpackage Winners/public
 * @author     Md Junayed <admin@easeare.com>
 */
class Winners_Public {

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

		add_shortcode( 'winners', [$this,'wiiners_input_view'] );
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/winners-public.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/winners-public.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name, "check_my_code", array(
			'ajaxurl' 	=> 	admin_url('admin-ajax.php'),
			'nonce'		=>	wp_create_nonce( 'winners_nonce' )
		));
	}
	
	function wiiners_input_view($param){
		ob_start();
		require_once plugin_dir_path( __FILE__ ).'partials/winners-public-display.php';
		$output = ob_get_contents();
		ob_get_clean();

		return $output;
	}

	function check_my_code_validity(){
		if(!wp_verify_nonce( $_POST['nonce'], 'winners_nonce' )){
			die("Hey! what are you doing here.");
		}

		if(isset($_POST['code']) && !empty($_POST['code'])){
			$mycode = $_POST['code'];
			$code = get_option('winners_comparing_code');
			
			if($mycode == $code){
				global $wpdb;
				if(!isset($_COOKIE['winner_user'])){
					setcookie('winner_user','0',time()+60*60*24*30, '/');
				}
				
				$position = 0;
				$position = get_option('winner_pos');

				if($_COOKIE['winner_user'] !== $mycode){
					setcookie('winner_user',$mycode,time()+60*60*24*30, '/');
					update_option('winner_pos', $position+1);
				}

				if($position == 10){
					$position = 1;
					update_option('winner_pos', $position);
				}

				if(intval(get_option('winner_pos')) == 10){
					echo json_encode(array('success' => '<p class="success"><i class="fas fa-check-circle"></i> '.get_option('winners_special_coupon_text').'</p>'));
					setcookie('winner_notification','You already won a special coupon.',time()+60*60*24*30, '/');
				}else{
					echo json_encode(array('success' => '<p class="success"><i class="fas fa-check-circle"></i> '.get_option('winners_winner_text').'</p>'));
					setcookie('winner_notification','You already won a coupon.',time()+60*60*24*30, '/');
				}
				die;
			}else{
				echo json_encode(array('error' => '<p class="warning"><i class="fas fa-warning"></i> '.get_option('winners_notmatch_text').'</p>'));
				die;
			}
			
			die;
		}

		die;
	}

}
