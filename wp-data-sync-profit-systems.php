<?php
/**
 * Plugin Name: WP Data Sync - Profit Systems POS Integration
 * Plugin URI:  https://wpdatasync.com/products/
 * Description: Integrates Profit Systems POS with WP Data Sync
 * Version:     1.0.0
 * Author:      WP Data Sync
 * Author URI:  https://wpdatasync.com
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-data-sync
 *
 * Package:     WP_DataSync
*/

namespace WP_DataSync\Profit_Systems;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$defines = [
	'WPDSYNC_PROFIT_SYSTEMS_VERSION' => '1.0.0',
	'WPDSYNC_PROFIT_SYSTEMS_ASSETS'  => plugin_dir_path( __FILE__ ) . 'assets/',
];

foreach ( $defines as $define => $value ) {
	if ( ! defined( $define ) ) {
		define( $define, $value );
	}
}

add_action( 'plugins_loaded', function() {

	foreach ( glob( plugin_dir_path( __FILE__ ) . 'includes/**/*.php' ) as $file ) {
		require_once $file;
	}

} );
