<?php
/**
 * Profit Systems POS Integration - Inventory
 *
 * @since 1.0,0
 *
 * @package WP_DataSync
 */

namespace WP_DataSync\Profit_Systems;

use WP_DataSync\App\DataSync;
use WP_DataSync\App\Log;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Set product inventory.
 *
 * @param int      $product_id
 * @param mixed    $inventory
 * @param DataSync $data_sync
 */

add_action( 'wp_data_sync_integration_profit_inventory', function( $product_id, $inventory, $data_sync ) {

	if ( ! function_exists( 'get_field' ) ) {
		Log::write( 'profit-inventory', 'Advanced Custom Fields Pro is required to use this plugin.' );
		return;
	}

	if ( is_array( $inventory ) ) {

		$field_key = 'Profit_Inventory_Values';

		/**
		 * Extract.
		 *
		 * $warehouse
		 * $status
		 * $quantity
		 */

		extract( $inventory );

		if ( ! $existing = get_field( $field_key, $product_id ) ) {
			$existing   = [];
		}
			
		$index = array_search( $warehouse, array_column( $existing, 'warehouse' ) );

		if ( 0 !== $index && empty( $index ) ) {
			$index = count( $existing );
		}

		$processed                        = $existing;
		$processed[ $index ]['warehouse'] = $warehouse;
		$processed[ $index ][ $status ]   = intval( $quantity );

		update_field( $field_key, $processed, $product_id );

		$woo_stock_qty = array_sum( array_column( $processed, 'A' ) );

		update_post_meta( $product_id, '_stock', $woo_stock_qty );

		Log::write( 'profit-inventory', [
			'product_id'    => $product_id,
			'index'         => $index,
			'new_data'      => $inventory,
			'existing'      => $existing,
			'processed'     => $processed,
			'woo_stock_qty' => $woo_stock_qty
		], 'Profit_Inventory' );

	}

}, 10, 3 );
