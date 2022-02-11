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

	if ( ! function_exists( 'get_field' ) ) {
		Log::write( 'profit-inventory', 'Advanced Custom Fields Pro is required to use this plugin.' );
		return;
	}

	if ( is_array( $inventory ) ) {

		$field_key = 'Profit_Inventory_Totals';

		/**
		 * Extract.
		 *
		 * $warehouse
		 * $status
		 * $quantity
		 */

		extract( $inventory );

		if ( ! $Profit_Inventory = get_field( $field_key, $product_id ) ) {
			$Profit_Inventory   = [];
		}
			
		$index = array_search( $warehouse, array_column( $Profit_Inventory, 'warehouse' ) );

		if ( empty( $index ) ) {
			$index = rand();
		}

		$_Profit_Inventory                       = $Profit_Inventory;
		$_Profit_Inventory[ $index ]['warehouse'] = $warehouse;
		$_Profit_Inventory[ $index ][ $status ]   = intval( $quantity );

		update_field( $field_key, $_Profit_Inventory, $product_id );

		$woo_stock_qty = 'NA';

		$woo_stock_qty = array_sum( array_column( $_Profit_Inventory, 'A' ) );

		update_post_meta( $product_id, '_stock', $woo_stock_qty );

		Log::write( 'profit-inventory', [
			'product_id'    => $product_id,
			'index'         => $index,
			'new_data'      => $inventory,
			'existing'      => $Profit_Inventory,
			'processed'     => $_Profit_Inventory,
			'woo_stock_qty' => $woo_stock_qty
		], 'Profit_Inventory' );

	}

}, 10, 3 );
