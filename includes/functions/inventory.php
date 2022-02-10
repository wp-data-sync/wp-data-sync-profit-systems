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

add_action( 'wp_data_sync_post_meta_Profit_Inventory', function( $product_id, $inventory, $data_sync ) {

	if ( is_array( $inventory ) ) {

		/**
		 * Extract.
		 *
		 * $warehouse
		 * $status
		 * $quantity
		 */

		extract( $inventory );

		if ( ! $Profit_Inventory = get_field( 'Profit_Inventory', $product_id ) ) {
			$Profit_Inventory = [];
		}

		$key = array_search( $warehouse, array_column( $Profit_Inventory, 'warehouse' ) );

		if ( empty( $key ) ) {
			$key = count( $Profit_Inventory );
		}

		$Profit_Inventory[ $key ]['warehouse'] = $warehouse;
		$Profit_Inventory[ $key ][ $status ]   = $quantity;

		update_field( 'Profit_Inventory', $Profit_Inventory, $product_id );

		$woo_stock_qty = array_sum( array_column( $Profit_Inventory, 'A' ) );

		update_post_meta( $product_id, '_stock', $woo_stock_qty );

		Log::write( 'profit-inventory', [
			'raw_data'      => $inventory,
			'processed'     => $Profit_Inventory,
			'woo_stock_qty' => $woo_stock_qty
		], 'Profit_Inventory' );

	}

}, 10, 3 );
