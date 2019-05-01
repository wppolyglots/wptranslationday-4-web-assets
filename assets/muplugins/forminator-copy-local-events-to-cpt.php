<?php
/**
 * Plugin Name: Forminator - Update Local Events ( cron hourly ).
 * Plugin URI: https://premium.wpmudev.org/
 * Description: mu-plugin for updating local events CPT from Forminator Entries.
 * Version: 1.0.0
 * Author: Konstantinos Xenos
 * Author URI: https://profiles.wordpress.org/xkon
 * License: GPLv2 or later
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'WPMUDEV_Forminator_Update_CPT_Local_Events' ) ) {
	/**
	 * WPMUDEV_Forminator_Update_CPT_Local_Events Class
	 */
	class WPMUDEV_Forminator_Update_CPT_Local_Events {
		/**
		 * The Form ID.
		 * Edit number 5 to the Form ID that you like to check.
		 *
		 */
		private static $_form_id = 275;

		// DO NOT EDIT AFTER THIS LINE.
		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action(
				'init',
				array( $this, 'hook_scheduled_event' )
			);
			add_action(
				'wpmudev_forminator_update_cpt_le',
				array( $this, 'update_cpt_local_events' )
			);
		}
		/**
		 * Adds the scheduled event.
		 *
		 * @return void
		 */
		public function hook_scheduled_event() {
			if ( ! wp_next_scheduled( 'wpmudev_forminator_update_cpt_le' ) ) {
				wp_schedule_event( time(), 'hourly', 'wpmudev_forminator_update_cpt_le' );
			}
		}
		/**
		 * Updates the CPT.
		 *
		 * @return void
		 */
		public function update_cpt_local_events() {
			// Load the checked entries.
			$updated_localevents = maybe_unserialize( get_option( 'custom_frm_updt_cpt_le', array() ) );

			$entries = Forminator_API::get_entries( self::$_form_id );

			// Loop through the results to see if we have attachments.
			foreach ( $entries as $entry ) {
				// If the entry is not in $updated_localevents then we haven't deleted a file for it.
				if ( ! in_array( $entry->entry_id, $updated_localevents, true ) ) {

					$post_id = wp_insert_post(
						array(
							'post_author'  => '1',
							'post_name'    => $entry->meta_data['address-1']['value']['city'],
							'post_title'   => $entry->meta_data['address-1']['value']['city'],
							'post_content' => '',
							'post_type'    => 'wptd_local_event',
							'post_status'  => 'publish',
						)
					);

					if ( $post_id ) {
						if ( ! empty( $entry->meta_data['address-1']['value']['city'] ) ) {
							update_field( 'city', $entry->meta_data['address-1']['value']['city'], $post_id );
						}

						if ( ! empty( $entry->meta_data['address-2']['value']['country'] ) ) {
							update_field( 'country', $entry->meta_data['address-2']['value']['country'], $post_id );
						}

						if ( ! empty( $entry->meta_data['text-1']['value'] ) ) {
							update_field( 'continent', $entry->meta_data['text-1']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['text-2']['value'] ) ) {
							update_field( 'locale', $entry->meta_data['text-2']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['name-1']['value'] ) ) {
							update_field( 'organizer_name', $entry->meta_data['name-1']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['text-3']['value'] ) ) {
							update_field( 'organizer_username_wporg', $entry->meta_data['text-3']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['text-4']['value'] ) ) {
							update_field( 'organizer_username_slack', $entry->meta_data['text-4']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['name-2']['value'] ) ) {
							update_field( 'coorganizers', $entry->meta_data['name-2']['value'], $post_id );
						}
						if ( ! empty( $entry->meta_data['time-1']['value']['hours'] ) && ! empty( $entry->meta_data['time-1']['value']['minutes'] ) ) {
							$start_time = $entry->meta_data['time-1']['value']['hours'] . ':' . $entry->meta_data['time-1']['value']['minutes'];
							update_field( 'utc_start_time', $start_time, $post_id );
						}
						if ( ! empty( $entry->meta_data['url-1']['value'] ) ) {
							update_field( 'announcement_url', $entry->meta_data['url-1']['value'], $post_id );
						}
					}
				}
				// Add the entry ID into the array.
				array_push( $updated_localevents, $entry->entry_id );
				// Clean up the array.
				$update_localevents = array_unique( $updated_localevents );
				// Update the option with the cleaned up array.
				update_option( 'custom_frm_updt_cpt_le', $update_localevents );
			}
		}
	}
	new WPMUDEV_Forminator_Update_CPT_Local_Events();
}
