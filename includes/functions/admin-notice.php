<?php
/**
 * Admin Notice
 *
 * Add an admin notice when the WP Data Sync plugin and ACF is not actove.
 *
 * @since   1.0.0
 *
 * @package WP_DataSync
 */

namespace WP_DataSync\Profit_Systems;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Admin notice error message.
 */

function admin_notice__error() {

	$message = __( 'NOTICE: The WP Data Sync plugin is required to use WP Data Sync - Profit Systems POS Integration', 'wp-data-sync-menu-item' );
	$url     = 'https://wordpress.org/plugins/wp-data-sync/';

	printf(
		'<div class="notice notice-error"><p>%s</p><p><a href="%s" target="_blank">%s</a></p></div>',
		esc_html( $message ),
		esc_url( $url ),
		esc_html( 'WP Data Sync Plugin' )
	);

}

if ( ! defined( 'WPDSYNC_VERSION' ) ) {
	add_action( 'admin_notices', 'WP_DataSync\Profit_Systems\admin_notice__error' );
}

/**
 * Admin notice ACF.
 */

function admin_notice_ACF() {

	$message = __( 'NOTICE: The ACF Pro plugin is required to use WP Data Sync - Profit Systems POS Integration', 'wp-data-sync-menu-item' );
	$url     = 'https://www.advancedcustomfields.com/pro/';

	printf(
		'<div class="notice notice-error"><p>%s</p><p><a href="%s" target="_blank">%s</a></p></div>',
		esc_html( $message ),
		esc_url( $url ),
		esc_html( 'Advanced Custom Fields Pro' )
	);

}

if ( ! class_exists( 'acf_pro' ) ) {
	add_action( 'admin_notices', 'WP_DataSync\Profit_Systems\admin_notice_ACF' );
}
