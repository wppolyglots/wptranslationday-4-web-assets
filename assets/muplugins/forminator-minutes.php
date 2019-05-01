<?php
/**
 * Plugin Name: Forminator - Filter the Hour & Minutes of forms.
 * Plugin URI: https://premium.wpmudev.org/
 * Description: adds customized hours & minutes on forms.
 * Version: 1.0.0
 * Author: Konstantinos Xenos
 * Author URI: https://profiles.wordpress.org/xkon
 * License: GPLv2 or later
 */

add_filter(
	'forminator_field_time_get_hours',
	function( $array ) {
		$array = array(
			array(
				'label' => '00',
				'value' => '00',
			),
			array(
				'label' => '01',
				'value' => '01',
			),
			array(
				'label' => '02',
				'value' => '02',
			),
			array(
				'label' => '03',
				'value' => '03',
			),
			array(
				'label' => '04',
				'value' => '04',
			),
			array(
				'label' => '05',
				'value' => '05',
			),
			array(
				'label' => '06',
				'value' => '06',
			),
			array(
				'label' => '07',
				'value' => '07',
			),
			array(
				'label' => '08',
				'value' => '08',
			),
			array(
				'label' => '09',
				'value' => '09',
			),
			array(
				'label' => '10',
				'value' => '10',
			),
			array(
				'label' => '11',
				'value' => '11',
			),
			array(
				'label' => '12',
				'value' => '12',
			),
			array(
				'label' => '13',
				'value' => '13',
			),
			array(
				'label' => '14',
				'value' => '14',
			),
			array(
				'label' => '15',
				'value' => '15',
			),
			array(
				'label' => '16',
				'value' => '16',
			),
			array(
				'label' => '17',
				'value' => '17',
			),
			array(
				'label' => '18',
				'value' => '18',
			),
			array(
				'label' => '19',
				'value' => '19',
			),
			array(
				'label' => '20',
				'value' => '20',
			),
			array(
				'label' => '21',
				'value' => '21',
			),
			array(
				'label' => '22',
				'value' => '22',
			),
			array(
				'label' => '23',
				'value' => '23',
			),
		);

		return $array;
	},
	15
);

add_filter(
	'forminator_field_time_get_minutes',
	function( $array ) {
		$array = array(
			array(
				'label' => '00',
				'value' => '00',
			),
			array(
				'label' => '15',
				'value' => '15',
			),
			array(
				'label' => '30',
				'value' => '30',
			),
			array(
				'label' => '45',
				'value' => '45',
			),
		);

		return $array;
	},
	15
);
