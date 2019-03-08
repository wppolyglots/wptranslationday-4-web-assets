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
		wp_dequeue_style( 'twentyseventeen-fonts' );
		wp_enqueue_style( 'fontawesome', get_stylesheet_directory_uri() . '/assets/fontawesome/css/all.css', array(), '5.7.2' );

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
			return wp_die( esc_attr( 'Under Maintenance', 'wptd4' ) );
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
				'footer-menu' => esc_html__( 'Footer Menu', 'wptd4' ),
			)
		);
	}
);

// Add Page Slug to body class.
add_filter(
	'body_class',
	function ( $classes ) {
		global $post;
		if ( isset( $post ) ) {
			$classes[] = $post->post_type . '-' . $post->post_name;
		}
		return $classes;
	}
);

// Create necessary pages if they don't exist.
add_action(
	'admin_menu',
	function() {
		$pages = array(
			'the-team'     => esc_html__( 'The Team', 'wptd4' ),
			'the-speakers' => esc_html__( 'The Speakers', 'wptd4' ),
			'schedule'     => esc_html__( 'Schedule', 'wptd4' ),
		);

		foreach ( $pages as $page_slug => $page_title ) {

			$args = array(
				'post_type'      => 'page',
				'pagename'       => $page_slug,
				'posts_per_page' => 1,
			);

			$query = new WP_Query( $args );

			if ( ! $query->have_posts() ) {
				wp_insert_post(
					array(
						'post_author'  => '1',
						'post_name'    => $page_slug,
						'post_title'   => $page_title,
						'post_content' => '',
						'post_type'    => 'page',
						'post_status'  => 'publish',
					)
				);
			}
		}
	}
);

// Setup Custom Post Types.
add_action(
	'init',
	function() {
		register_post_type(
			'wptd_local_event',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Local Events' ),
					'singular_name' => esc_html__( 'Local Event' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'local-events' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_speaker',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Speakers', 'wptd4' ),
					'singular_name' => esc_html__( 'Speaker', 'wptd4' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'speakers' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_organizer',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Organizers', 'wptd4' ),
					'singular_name' => esc_html__( 'Organizer', 'wptd4' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'organizers' ),
				'show_in_menu' => true,
			)
		);
	}
);

// Local Events list table headers.
add_filter(
	'manage_edit-wptd_local_event_columns',
	function( $columns ) {
		unset( $columns['date'] );

		$columns['city']                     = esc_html__( 'City', 'wptd4' );
		$columns['country']                  = esc_html__( 'Country', 'wptd4' );
		$columns['continent']                = esc_html__( 'Continent', 'wptd4' );
		$columns['locale']                   = esc_html__( 'Locale', 'wptd4' );
		$columns['organizer_name']           = esc_html__( 'Organizer Name', 'wptd4' );
		$columns['organizer_username_slack'] = esc_html__( 'Slack Username', 'wptd4' );
		$columns['utc_start_time']           = esc_html__( 'UTC Start Time', 'wptd4' );
		$columns['utc_end_time']             = esc_html__( 'UTC End Time', 'wptd4' );
		$columns['announcement_url']         = esc_html__( 'Announcement URL', 'wptd4' );
		$columns['interviewer']              = esc_html__( 'Interviewer', 'wptd4' );

		return $columns;
	}
);

add_action(
	'manage_wptd_local_event_posts_custom_column',
	function( $column, $id ) {
		if ( 'city' === $column ) {
			echo esc_attr( get_field( 'city', $id ) );

		} elseif ( 'country' === $column ) {
			echo esc_attr( get_field( 'country', $id ) );

		} elseif ( 'continent' === $column ) {
			echo esc_attr( get_field( 'continent', $id ) );

		} elseif ( 'locale' === $column ) {
			echo esc_attr( get_field( 'locale', $id ) );

		} elseif ( 'organizer_name' === $column ) {
			echo esc_attr( get_field( 'organizer_name', $id ) );
			$url = ( ! empty( get_field( 'organizer_username_wporg', $id ) ) ) ? ' (<a target="_blank" href="https://profiles.wordpress.org/' . get_field( 'organizer_username_wporg', $id ) . '">' . get_field( 'organizer_username_wporg', $id ) . ')</a>' : '';
			echo wp_kses(
				$url,
				array(
					'a' => array(
						'href'  => array(),
						'title' => array(),
						'target' => array(),
					),
				)
			);

		} elseif ( 'organizer_username_slack' === $column ) {
			echo esc_attr( get_field( 'organizer_username_slack', $id ) );

		} elseif ( 'utc_start_time' === $column ) {
			echo esc_attr( get_field( 'utc_start_time', $id ) );

		} elseif ( 'utc_end_time' === $column ) {
			echo esc_attr( get_field( 'utc_end_time', $id ) );

		} elseif ( 'announcement_url' === $column ) {
			$url = ( ! empty( get_field( 'announcement_url', $id ) ) ) ? '<a target="_blank" href="' . get_field( 'announcement_url', $id ) . '">' . esc_html__( 'Open', 'wptd4' ) . '</a>' : '';
			echo wp_kses(
				$url,
				array(
					'a' => array(
						'href'  => array(),
						'title' => array(),
						'target' => array(),
					),
				)
			);

		} elseif ( 'interviewer' === $column ) {
			echo esc_attr( get_field( 'interviewer', $id ) );

		} else {
			echo '';
		}
	},
	10,
	2
);

// Speakers list table headers.
add_filter(
	'manage_edit-wptd_speaker_columns',
	function( $columns ) {
		unset( $columns['date'] );

		$columns['username_wporg'] = esc_html__( 'wp.org Username', 'wptd4' );
		$columns['username_slack'] = esc_html__( 'Slack Username', 'wptd4' );
		$columns['talk_subject']   = esc_html__( 'Talk subject', 'wptd4' );

		return $columns;
	}
);

add_action(
	'manage_wptd_speaker_posts_custom_column',
	function( $column, $id ) {
		if ( 'username_wporg' === $column ) {
			$url = ( ! empty( get_field( 'username_wporg', $id ) ) ) ? '<a target="_blank" href="https://profiles.wordpress.org/' . get_field( 'username_wporg', $id ) . '">' . get_field( 'username_wporg', $id ) . '</a>' : '';
			echo wp_kses(
				$url,
				array(
					'a' => array(
						'href'  => array(),
						'title' => array(),
						'target' => array(),
					),
				)
			);

		} elseif ( 'username_slack' === $column ) {
			echo esc_attr( get_field( 'username_slack', $id ) );

		} elseif ( 'talk_subject' === $column ) {
			echo esc_attr( get_field( 'talk_subject', $id ) );

		} else {
			echo '';
		}
	},
	10,
	2
);

// Organizers list table headers.
add_filter(
	'manage_edit-wptd_organizer_columns',
	function( $columns ) {
		unset( $columns['date'] );

		$columns['username_wporg'] = esc_html__( 'wp.org Username', 'wptd4' );
		$columns['username_slack'] = esc_html__( 'Slack Username', 'wptd4' );
		$columns['role']           = esc_html__( 'Role', 'wptd4' );
		$columns['order']          = esc_html__( 'Order', 'wptd4' );

		return $columns;
	}
);

add_filter(
	'manage_edit-wptd_organizer_sortable_columns',
	function( $columns ) {
		$columns['username_wporg'] = 'username_wporg';
		$columns['username_slack'] = 'username_slack';
		$columns['role']           = 'role';
		$columns['order']          = 'order';

		return $columns;
	}
);

add_action(
	'pre_get_posts',
	function ( $query ) {
		if ( ! is_admin() ) {
			return;
		}

		$orderby = $query->get( 'orderby' );

		if ( 'username_wporg' === $orderby ) {
			$query->set( 'meta_key', 'username_wporg' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'username_slack' === $orderby ) {
			$query->set( 'meta_key', 'username_slack' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'role' === $orderby ) {
			$query->set( 'meta_key', 'role' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'order' === $orderby ) {
			$query->set( 'meta_key', 'order' );
			$query->set( 'orderby', 'meta_value_num' );
		}
	}
);


add_action(
	'manage_wptd_organizer_posts_custom_column',
	function( $column, $id ) {
		if ( 'username_wporg' === $column ) {
			$url = ( ! empty( get_field( 'username_wporg', $id ) ) ) ? '<a target="_blank" href="https://profiles.wordpress.org/' . get_field( 'username_wporg', $id ) . '">' . get_field( 'username_wporg', $id ) . '</a>' : '';
			echo wp_kses(
				$url,
				array(
					'a' => array(
						'href'  => array(),
						'title' => array(),
						'target' => array(),
					),
				)
			);

		} elseif ( 'username_slack' === $column ) {
			echo esc_attr( get_field( 'username_slack', $id ) );

		} elseif ( 'role' === $column ) {
			echo esc_attr( get_field( 'role', $id ) );

		} elseif ( 'order' === $column ) {
			echo esc_attr( get_field( 'order', $id ) );

		} else {
			echo '';
		}
	},
	10,
	2
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
