<?php // phpcs:ignore

get_header(); ?>

<style>
#local-events-map-wrapper > .local-events-map-header {
	position: absolute;
	top: 1.5em;
	left: 1.5em;
}
#local-events-map {
  width: 100%;
  height: 700px;
}
.local-events-infobox {
	display: none;	
}
@media screen and (min-width: 48em) {
	.site-content {
		padding-top: 0;
	}	
}
.map-marker {
    margin-left: -8px;
    margin-top: -8px;
}
.map-marker.map-clickable {
    cursor: pointer;
}
.pulse {
    width: 10px;
    height: 10px;
    border: 5px solid #f7f14c;
    -webkit-border-radius: 30px;
    -moz-border-radius: 30px;
    border-radius: 30px;
    background-color: #716f42;
    z-index: 10;
    position: absolute;
  }
.map-marker .dot {
    border: 10px solid #fff601;
    background: transparent;
    -webkit-border-radius: 60px;
    -moz-border-radius: 60px;
    border-radius: 60px;
    height: 50px;
    width: 50px;
    -webkit-animation: pulse 3s ease-out;
    -moz-animation: pulse 3s ease-out;
    animation: pulse 3s ease-out;
    -webkit-animation-iteration-count: infinite;
    -moz-animation-iteration-count: infinite;
    animation-iteration-count: infinite;
    position: absolute;
    top: -20px;
    left: -20px;
    z-index: 1;
    opacity: 0;
  }
  @-moz-keyframes pulse {
   0% {
      -moz-transform: scale(0);
      opacity: 0.0;
   }
   25% {
      -moz-transform: scale(0);
      opacity: 0.1;
   }
   50% {
      -moz-transform: scale(0.1);
      opacity: 0.3;
   }
   75% {
      -moz-transform: scale(0.5);
      opacity: 0.5;
   }
   100% {
      -moz-transform: scale(1);
      opacity: 0.0;
   }
  }
  @-webkit-keyframes "pulse" {
   0% {
      -webkit-transform: scale(0);
      opacity: 0.0;
   }
   25% {
      -webkit-transform: scale(0);
      opacity: 0.1;
   }
   50% {
      -webkit-transform: scale(0.1);
      opacity: 0.3;
   }
   75% {
      -webkit-transform: scale(0.5);
      opacity: 0.5;
   }
   100% {
      -webkit-transform: scale(1);
      opacity: 0.0;
   }
  }
</style>

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
		<button class="local-events-infobox-close">Close</button>
		<div class="area">Country, City, Locale</div>
		<div class="time"><?php echo esc_html__( 'Event Time:', 'wptd' ); ?> Time</div>
		<div class="organizer">
			<?php echo esc_html__( 'Organizer:', 'wptf4' ); ?>
			<a href="https://profiles.wordpress.org/' . esc_attr( $wporg ) . '" target="_blank" title="WordPress Profile"><i class="fab fa-wordpress"></i></a>
		</div>
		<div class="link">
			<a href="' . esc_attr( $evenlink ) . '" target="_blank" title="Announcement URL">
				<?php esc_html_e( 'Check it out!', 'wptd' ); ?>
			</a>
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
					<div class="entry-content">
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
									'event_link'     => esc_attr( $evenlink ),
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
									<?php echo esc_html__( 'Organizer:', 'wptf4' ) . ' ' . esc_attr( get_field( 'organizer_name' ) ); ?>
									<?php echo ( ! empty( $wporg ) ) ? '<a href="https://profiles.wordpress.org/' . esc_attr( $wporg ) . '" target="_blank" title="WordPress Profile"><i class="fab fa-wordpress"></i></a>' : ''; ?>
									<?php echo ( ! empty( $slack ) ) ? '<a href="https://profiles.wordpress.org/' . esc_attr( $slack ) . '" target="_blank" title="Slack  Profile"><i class="fab fa-slack"></i></a>' : ''; ?><br>
								</div>
								<div class="link">
									<?php echo ( ! empty( $evenlink ) ) ? '<a href="' . esc_attr( $evenlink ) . '" target="_blank" title="Announcement URL">' . esc_html__( 'Check it out!', 'wptd' ) . '</a>' : ''; ?>
								</div>
							</div>

						<?php endwhile; ?>
					</div><!-- .entry-content -->
					<script>var markers = <?php echo json_encode( $markers ); ?>;</script>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

			</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
