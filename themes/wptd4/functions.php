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

// Setup Custom Post Types.
add_action(
	'init',
	function() {
		register_post_type(
			'wptd_local_event',
			array(
				'labels'      => array(
					'name'          => __( 'Local Events' ),
					'singular_name' => __( 'Local Event' ),
				),
				'public'      => true,
				'has_archive' => true,
				'rewrite'     => array( 'slug' => 'local-events' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_speaker',
			array(
				'labels'      => array(
					'name'          => __( 'Speakers' ),
					'singular_name' => __( 'Speaker' ),
				),
				'public'      => true,
				'has_archive' => true,
				'rewrite'     => array( 'slug' => 'speakers' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_organizer',
			array(
				'labels'      => array(
					'name'          => __( 'Organizers' ),
					'singular_name' => __( 'Organizer' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'organizers' ),
				'show_in_menu' => true,
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
				'name'     => 'Advanced Custom Fields',
				'slug'     => 'advanced-custom-fields',
				'required' => true,
			),
			array(
				'name'     => 'Classic Editor',
				'slug'     => 'classic-editor',
				'required' => true,
			),
		);

		$config = array(
			'id'           => 'wptd',
			'default_path' => '',
			'menu'         => 'tgmpa-install-plugins',
			'parent_slug'  => 'themes.php',
			'capability'   => 'edit_theme_options',
			'has_notices'  => true,
			'dismissable'  => true,
			'dismiss_msg'  => '',
			'is_automatic' => false,
			'message'      => '',
		);

		tgmpa( $plugins, $config );
	}
);
