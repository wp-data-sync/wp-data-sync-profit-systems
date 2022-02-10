<?php
/**
 * ACF JSON
 *
 * @since   1.0.0
 *
 * @package WP_DataSync_Api
 */

namespace WP_DataSync\Profit_Systems;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_filter( 'acf/settings/save_json', 'WP_DataSync\Profit_Systems\save_point' );

/**
 * Save point.
 *
 * @param $path
 *
 * @return mixed|string
 */

function save_point( $path ) {

	if ( ! defined( 'WPDS_LOCAL_DEV' ) ) {
		return $path;
	}

	return WPDSYNC_PROFIT_SYSTEMS_ASSETS . 'acf-json';

}

add_filter( 'acf/settings/load_json', 'WP_DataSync\Profit_Systems\load_point' );

/**
 * Load point.
 *
 * @param $paths
 *
 * @return mixed
 */

function load_point( $paths ) {
	$paths[] = WPDSYNC_PROFIT_SYSTEMS_ASSETS . 'acf-json';

	return $paths;
}