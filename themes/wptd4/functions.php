<?php //phpcs:ignore

// Handle Parent Theem Style.
add_action(
	'wp_enqueue_scripts',
	function() {
		$parent_style = 'parent-style';
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); // phpcs:ignore
	},
	10
);

// Handle extra styles & scripts.
add_action(
	'wp_enqueue_scripts',
	function() {
		// Fonts.
		wp_enqueue_style( 'changa-font', 'https://fonts.googleapis.com/css?family=Changa:400,600,700', array(), '1' );

		// Countdown Timers.
		wp_enqueue_script( 'moment-js', get_stylesheet_directory_uri() . '/assets/js/moment.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'moment-tz-js', get_stylesheet_directory_uri() . '/assets/js/moment.timezone.with.data.js', array( 'jquery' ), '1', true );
		wp_enqueue_script( 'moment-cd-js', get_stylesheet_directory_uri() . '/assets/js/jquery.countdown.min.js', array( 'jquery' ), '1', true );

		// Custom scripts.
		wp_enqueue_script( 'child-script', get_stylesheet_directory_uri() . '/assets/js/script.js', array( 'moment-js' ), '1', true );
	},
	15
);

// Maintenance mode.
add_action(
	'template_redirect',
	function() {
		if ( ! is_user_logged_in() ) {
			return wp_die( esc_attr( 'Under Maintenance' ) );
		}
	},
	15
);

// Setup extra menus.
add_action(
	'after_setup_theme',
	function() {
		register_nav_menus(
			array(
				'footer-menu' => __( 'Footer Menu', 'twentyseventeen' ),
			)
		);
	}
);

// Include TGM & Require extra plugins.
require_once get_stylesheet_directory() . '/inc/class-tgm-plugin-activation.php';
add_action(
	'tgmpa_register',
	function() {

		$plugins = array(
			array(
				'name'     => 'Disable Comments',
				'slug'     => 'disable-comments',
				'required' => true,
			),
			array(
				'name'      => 'Advanced Custom Fields',
				'slug'      => 'advanced-custom-fields',
				'required'  => true,
			),
		);

		$config = array(
			'id'           => 'test',                 // Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',                      // Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins', // Menu slug.
			'parent_slug'  => 'themes.php',            // Parent menu slug.
			'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,                    // Show admin notices or not.
			'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,                   // Automatically activate plugins after installation or not.
			'message'      => '',                      // Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}
);