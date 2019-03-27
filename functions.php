<?php //phpcs:ignore

// Handle Parent Theem Style.
add_action(
	'wp_enqueue_scripts',
	function() {
		$parent_style = 'parent-style';
		wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' ); // phpcs:ignore
		wp_enqueue_style( 'twentyseventeen-style', get_stylesheet_directory_uri() . '/style.css', array( $parent_style ), time() ); // phpcs:ignore
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

		// Local Events Map
		if ( is_page( 'the-local-events' ) ) {
			wp_enqueue_script( 'wptd4-map-vendor', get_stylesheet_directory_uri() . '/assets/js/ammap.js', array( 'jquery' ) );
			wp_enqueue_script( 'wptd4-map-worldhigh', get_stylesheet_directory_uri() . '/assets/js/continentsHigh.js', array( 'jquery' ) );
			wp_enqueue_script( 'wptd4-map-init', get_stylesheet_directory_uri() . '/assets/js/map-init.js', array( 'jquery' ), '50', true );
		}
	},
	15
);

// Maintenance mode.
add_action(
	'template_redirect',
	function() {
		$frontpage_id = get_option( 'page_on_front' );
		$maintenance  = get_field( 'maintenance_mode', $frontpage_id );
		if ( $maintenance && ! is_user_logged_in() ) {
			return wp_die( esc_attr( 'Under Maintenance', 'wptd' ) );
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
				'footer-menu' => esc_html__( 'Footer Menu', 'wptd' ),
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

// Add GA tag.
add_action(
	'wp_head',
	function() {
		?>
		<!-- Global site tag (gtag.js) - Google Analytics -->
		<script async src="https://www.googletagmanager.com/gtag/js?id=UA-136408846-1"></script>
		<script>
			window.dataLayer = window.dataLayer || [];
			function gtag(){dataLayer.push(arguments);}
			gtag('js', new Date());

			gtag('config', 'UA-136408846-1');
		</script>
		<?php
	},
	999
);

// Create necessary pages if they don't exist.
add_action(
	'admin_menu',
	function() {
		$pages = array(
			'the-team'         => esc_html__( 'The Team', 'wptd' ),
			'the-speakers'     => esc_html__( 'The Speakers', 'wptd' ),
			'the-schedule'     => esc_html__( 'Schedule', 'wptd' ),
			'the-local-events' => esc_html__( 'Local Events', 'wptd' ),
			'social-mentions'  => esc_html__( 'Social Mentions', 'wptd' ),
			'media-kit'        => esc_html__( 'Media Kit', 'wptd' ),
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
					'name'          => esc_html__( 'Speakers', 'wptd' ),
					'singular_name' => esc_html__( 'Speaker', 'wptd' ),
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
					'name'          => esc_html__( 'Organizers', 'wptd' ),
					'singular_name' => esc_html__( 'Organizer', 'wptd' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'organizers' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_talk',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Talks', 'wptd' ),
					'singular_name' => esc_html__( 'Talk', 'wptd' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'talks' ),
				'show_in_menu' => true,
			)
		);

		register_post_type(
			'wptd_sponsor',
			array(
				'labels'       => array(
					'name'          => esc_html__( 'Sponsors', 'wptd' ),
					'singular_name' => esc_html__( 'Sponsor', 'wptd' ),
				),
				'public'       => true,
				'has_archive'  => true,
				'rewrite'      => array( 'slug' => 'sponsors' ),
				'show_in_menu' => true,
			)
		);
	}
);

// Popuplate local event sorting field.
add_action(
	'acf/save_post',
	function( $post_id ) {
		if ( 'wptd_local_event' !== $_POST['post_type'] || empty( $_POST['acf'] ) ) {
			return;
		}

		$continent = sanitize_text_field( $_POST['acf']['field_5c8059b3bc23c'] );
		$country   = sanitize_text_field( $_POST['acf']['field_5c8059a8bc23b'] );
		$city      = sanitize_text_field( $_POST['acf']['field_5c80599cbc23a'] );

		$continent_country_city = $continent . ' ' . $country . ' ' . $city;

		update_field( 'field_5c82a4c7529c9', $continent_country_city, $post_id );

	},
	20
);

// Local Events list table headers.
add_filter(
	'manage_edit-wptd_local_event_columns',
	function( $columns ) {
		unset( $columns['date'] );

		$columns['continent_country_city']   = esc_html__( 'Location', 'wptd' );
		$columns['locale']                   = esc_html__( 'Locale', 'wptd' );
		$columns['organizer_name']           = esc_html__( 'Organizer Name', 'wptd' );
		$columns['organizer_username_slack'] = esc_html__( 'Slack Username', 'wptd' );
		$columns['utc_start_time']           = esc_html__( 'UTC Start Time', 'wptd' );
		$columns['utc_end_time']             = esc_html__( 'UTC End Time', 'wptd' );
		$columns['announcement_url']         = esc_html__( 'Announcement URL', 'wptd' );
		$columns['interviewer']              = esc_html__( 'Interviewer', 'wptd' );

		return $columns;
	}
);

add_filter(
	'manage_edit-wptd_local_event_sortable_columns',
	function( $columns ) {
		$columns['continent_country_city']   = 'continent_country_city';
		$columns['locale']                   = 'locale';
		$columns['organizer_name']           = 'organizer_name';
		$columns['organizer_username_slack'] = 'organizer_username_slack';
		$columns['utc_start_time']           = 'utc_start_time';
		$columns['utc_end_time']             = 'utc_end_time';
		$columns['interviewer']              = 'interviewer';

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

		if ( 'continent_country_city' === $orderby ) {
			$query->set( 'meta_key', 'continent_country_city' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'locale' === $orderby ) {
			$query->set( 'meta_key', 'locale' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'organizer_name' === $orderby ) {
			$query->set( 'meta_key', 'organizer_name' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'organizer_username_slack' === $orderby ) {
			$query->set( 'meta_key', 'organizer_username_slack' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'utc_start_time' === $orderby ) {
			$query->set( 'meta_key', 'utc_start_time' );
			$query->set( 'orderby', 'meta_value_num' );
		}

		if ( 'utc_end_time' === $orderby ) {
			$query->set( 'meta_key', 'utc_end_time' );
			$query->set( 'orderby', 'meta_value_num' );
		}

		if ( 'interviewer' === $orderby ) {
			$query->set( 'meta_key', 'interviewer' );
			$query->set( 'orderby', 'meta_value' );
		}
	}
);

add_action(
	'manage_wptd_local_event_posts_custom_column',
	function( $column, $id ) {
		if ( 'continent_country_city' === $column ) {
			echo esc_attr( get_field( 'continent_country_city', $id ) );

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
			$url = ( ! empty( get_field( 'announcement_url', $id ) ) ) ? '<a target="_blank" href="' . get_field( 'announcement_url', $id ) . '">' . esc_html__( 'Open', 'wptd' ) . '</a>' : '';
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

		$columns['username_wporg'] = esc_html__( 'wp.org Username', 'wptd' );
		$columns['username_slack'] = esc_html__( 'Slack Username', 'wptd' );
		$columns['talk_subject']   = esc_html__( 'Talk subject', 'wptd' );

		return $columns;
	}
);

add_filter(
	'manage_edit-wptd_speaker_sortable_columns',
	function( $columns ) {
		$columns['username_wporg'] = 'username_wporg';
		$columns['username_slack'] = 'username_slack';

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

		$columns['username_wporg'] = esc_html__( 'wp.org Username', 'wptd' );
		$columns['username_slack'] = esc_html__( 'Slack Username', 'wptd' );
		$columns['role']           = esc_html__( 'Role', 'wptd' );

		return $columns;
	}
);

add_filter(
	'manage_edit-wptd_organizer_sortable_columns',
	function( $columns ) {
		$columns['username_wporg'] = 'username_wporg';
		$columns['username_slack'] = 'username_slack';
		$columns['role']           = 'role';

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

		} else {
			echo '';
		}
	},
	10,
	2
);

// Talks list table headers.
add_filter(
	'manage_edit-wptd_talk_columns',
	function( $columns ) {
		unset( $columns['date'] );

		$columns['speaker']             = esc_html__( 'Speaker', 'wptd' );
		$columns['utc_start_time']      = esc_html__( 'UTC Start Time', 'wptd' );
		$columns['duration']            = esc_html__( 'Duration', 'wptd' );
		$columns['live_or_prerecorded'] = esc_html__( 'Live or Prerecorded', 'wptd' );
		$columns['target_audience']     = esc_html__( 'Target Audience', 'wptd' );
		$columns['target_language']     = esc_html__( 'Target Language', 'wptd' );

		return $columns;
	}
);

add_filter(
	'manage_edit-wptd_talk_sortable_columns',
	function( $columns ) {
		$columns['utc_start_time']      = 'utc_start_time';
		$columns['duration']            = 'duration';
		$columns['live_or_prerecorded'] = 'live_or_prerecorded';
		$columns['target_audience']     = 'target_audience';
		$columns['target_language']     = 'target_language';

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

		if ( 'utc_start_time' === $orderby ) {
			$query->set( 'meta_key', 'utc_start_time' );
			$query->set( 'orderby', 'meta_value_num' );
		}

		if ( 'duration' === $orderby ) {
			$query->set( 'meta_key', 'duration' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'live_or_prerecorded' === $orderby ) {
			$query->set( 'meta_key', 'live_or_prerecorded' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'target_audience' === $orderby ) {
			$query->set( 'meta_key', 'target_audience' );
			$query->set( 'orderby', 'meta_value' );
		}

		if ( 'target_language' === $orderby ) {
			$query->set( 'meta_key', 'target_language' );
			$query->set( 'orderby', 'meta_value' );
		}
	}
);

add_action(
	'manage_wptd_talk_posts_custom_column',
	function( $column, $id ) {
		if ( 'speaker' === $column ) {
			$speakers      = get_field( 'speaker', $id );
			$speaker_names = array();
			foreach ( $speakers as $speaker ) {
				array_push( $speaker_names, get_the_title( $speaker ) );
			}
			echo esc_attr( implode( ', ', $speaker_names ) );

		} elseif ( 'utc_start_time' === $column ) {
			echo esc_attr( get_field( 'utc_start_time', $id ) );

		} elseif ( 'duration' === $column ) {
			echo esc_attr( get_field( 'duration', $id ) );

		} elseif ( 'live_or_prerecorded' === $column ) {
			echo esc_attr( get_field( 'live_or_prerecorded', $id ) );

		} elseif ( 'target_audience' === $column ) {
			echo esc_attr( get_field( 'target_audience', $id ) );

		} elseif ( 'target_language' === $column ) {
			echo esc_attr( get_field( 'target_language', $id ) );

		} else {
			echo '';
		}
	},
	10,
	2
);

// Include TGM & Require extra plugins.
require_once get_stylesheet_directory() . '/assets/class-tgm-plugin-activation.php';

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
				'name'     => 'Advanced Custom Fields - Leaflet Map',
				'slug'     => 'acf-leaflet-map-field',
				'required' => true,
			),
			array(
				'name'     => 'Classic Editor',
				'slug'     => 'classic-editor',
				'required' => true,
			),
			array(
				'name'     => 'Forminator',
				'slug'     => 'forminator',
				'required' => true,
			),
			array(
				'name'     => 'Tagregator',
				'slug'     => 'tagregator',
				'required' => true,
			),
			array(
				'name'     => 'Post Types Order',
				'slug'     => 'post-types-order',
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
