<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.fiverr.com/junaidzx90
 * @since      1.0.0
 *
 * @package    Winners
 * @subpackage Winners/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Winners
 * @subpackage Winners/includes
 * @author     Md Junayed <admin@easeare.com>
 */
class Winners_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		global $wpdb;
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

		$winners_list = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}winners_list` (
			`ID` INT NOT NULL AUTO_INCREMENT,
			`user_id` INT NOT NULL,
			`position` INT NOT NULL,
			`code` VARCHAR(255) NOT NULL,
			`create_date` DATE NOT NULL,
			PRIMARY KEY (`ID`)) ENGINE = InnoDB";
			dbDelta($winners_list);
	}

}
