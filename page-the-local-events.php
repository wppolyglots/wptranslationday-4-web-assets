<?php // phpcs:ignore

get_header(); ?>

<div id="local-events-map-wrapper">
	<div class="local-events-map-header">
		<div class="wrap">
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->
		</div>
	</div>
	<div id="local-events-map"></div>
	<div class="local-events-infobox">
		<button class="local-events-infobox-close"><?php esc_html_e( 'Close', 'wptd' ); ?></button>
		<div class="local-events-infobox-inner">
			<div class="area">
				<span class="infobox-country">Country</span>, 
				<span class="infobox-city">City</span>, 
				<span class="infobox-locale">Locale</span>
			</div>
			<div class="time">
				<?php esc_html_e( 'Event Time:', 'wptd' ); ?> 
				<span class="infobox-time">17:26 - 10:00 UTC</span>
			</div>
			<div class="organizer">
				<?php esc_html_e( 'Organizer:', 'wptd' ); ?>
				<span class="infobox-organizer">xkon</span>
			</div>
			<div class="link">
				<a class="infobox-link" href="" target="_blank" title="Announcement URL">
					<?php esc_html_e( 'Check it out!', 'wptd' ); ?>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="wrap">
	<div id="primary" class="content-area">

		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); // phpcs:ignore ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<div class="entry-content">
					<?php the_content(); ?>
				</div><!-- .entry-content -->
				<?php
				$args = array(
					'post_type'      => array( 'wptd_local_event' ),
					'post_status'    => array( 'publish' ),
					'nopaging'       => true,
					'posts_per_page' => -1,
					'orderby'        => 'meta_value',
					'meta_key'       => 'continent_country_city',
					'order'          => 'ASC',
				);

				$query = new WP_Query( $args );

				$markers = array();
				$previous_continent = 'Empty';

				if ( $query->have_posts() ) : //phpcs:ignore ?>
					<div class="entry-content local-event-container">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();

							$continent = get_field( 'continent' );
							if ( $previous_continent !== $continent ) {
								$previous_continent = $continent;
								echo '<h2>' . esc_attr( $continent ) . '</h2>';
							}

							$wporg    = get_field( 'organizer_username_wporg' );
							$slack    = get_field( 'organizer_username_slack' );
							$evenlink = get_field( 'announcement_url' );

							$coordinates = get_field( 'coordinates' );
							if ( ! empty( $coordinates['lat'] ) && ! empty( $coordinates['lng'] ) ) {
								$markers[] = array(
									'id'             => get_the_id(),
									'title'          => get_the_title(),
									'scale'          => 0.5,
									'selectable'     => true,
									'zoomLevel'      => 5,
									'scale'          => 2,
									'latitude'       => floatval( $coordinates['lat'] ),
									'longitude'      => floatval( $coordinates['lng'] ),
									'country'        => esc_attr( get_field( 'country' ) ),
									'city'           => esc_attr( get_field( 'city' ) ),
									'locale'         => esc_attr( get_field( 'locale' ) ),
									'utc_start_time' => esc_attr( get_field( 'utc_start_time' ) ),
									'utc_end_time'   => esc_attr( get_field( 'utc_end_time' ) ),
									'link'     => esc_attr( $evenlink ),
									'organizer'      => esc_attr( get_field( 'organizer_name' ) ),
								);
							}
							?>

							<div class="local-event">
								<div class="area">
									<?php echo esc_attr( get_field( 'country' ) ) . ' - ' . esc_attr( get_field( 'city' ) ) . ' (' . esc_attr( get_field( 'locale' ) ) . ')'; ?>
								</div>
								<div class="time">
									<?php echo esc_html__( 'Event Time:', 'wptd' ) . ' ' . esc_attr( get_field( 'utc_start_time' ) ) . ' - ' . esc_attr( get_field( 'utc_end_time' ) ) . ' ' . esc_html__( 'UTC', 'wptd' ); ?><br>
								</div>
								<div class="organizer">
									<?php echo esc_html__( 'Organizer:', 'wptd' ) . ' ' . esc_attr( get_field( 'organizer_name' ) ); ?>
									<?php echo ( ! empty( $wporg ) ) ? '<a href="https://profiles.wordpress.org/' . esc_attr( $wporg ) . '" target="_blank" title="WordPress Profile"><i class="fab fa-wordpress"></i></a>' : ''; ?>
									<?php echo ( ! empty( $slack ) ) ? '<a href="https://profiles.wordpress.org/' . esc_attr( $slack ) . '" target="_blank" title="Slack  Profile"><i class="fab fa-slack"></i></a>' : ''; ?><br>
								</div>
								<div class="link">
									<?php echo ( ! empty( $evenlink ) ) ? '<a href="' . esc_attr( $evenlink ) . '" target="_blank" title="Announcement URL">' . esc_html__( 'Check it out!', 'wptd' ) . '</a>' : ''; ?>
								</div>
							</div>

						<?php endwhile; ?>
					</div><!-- .entry-content -->
					<script>
					var markers = <?php echo json_encode( $markers ); ?>;
					var map_pattern = '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/map-pattern.png';
					</script>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

			</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
