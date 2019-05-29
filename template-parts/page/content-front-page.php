<?php // phpcs:ignore
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

$pid = get_the_ID();
?>
<article id="post-<?php the_ID(); ?>">
	<?php
	if ( get_field( 'final_numbers_wptd', $pid ) ) :

		wp_enqueue_script( 'wptd4-map-vendor', get_stylesheet_directory_uri() . '/assets/js/ammap.js', array( 'jquery' ), '1', true );
			wp_enqueue_script( 'wptd4-map-worldhigh', get_stylesheet_directory_uri() . '/assets/js/continentsHigh.js', array( 'jquery' ), '1', true );
			wp_enqueue_script( 'wptd4-map-init', get_stylesheet_directory_uri() . '/assets/js/map-init.js', array( 'wptd4-map-worldhigh' ), '1', true );

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

			$event_counter = 0;

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {
					$query->the_post();

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
							'link'           => esc_attr( $evenlink ),
							'organizer'      => esc_attr( get_field( 'organizer_name' ) ),
						);
					}

					$event_counter++;
				}
			}

		?>
		<div class="separator live-separator"></div>

		<div class="panel live-streaming">
			<div class="wrap">
				<h2 class="panel-heading"><?php echo get_field( 'final_panel_heading', $pid ); ?></h2>
				<div class="panel-content openfont">
					<?php echo get_field( 'final_panel_text', $pid ); ?>
				</div>
			</div>
		</div>

		<div class="separator live-separator sepa-blue"></div>

		<div class="panel final-numbers">
			<div class="wrap">
				<h2 class="panel-heading">WPTD4: the numbers.</h2>
				<div class="panel-content finalnumbersfont">
					<div class="num"></div><div class="btext">here are some statistics for the day</div>
					<div class="num">81</div><div>Local events worldwide</div>
					<div class="num">46653</div><div>Translated strings</div>
					<div class="num">612</div><div>Logged in users on GlotPress</div>
					<div class="num">221</div><div>New Translators</div>
					<div class="num">24</div><div>New PTEs</div>
					<div class="num">12</div><div>New GTEs</div>
					<div class="num">71</div><div>Locales impacted</div>
					<div class="num">364</div><div>Language packs created</div>
					<div class="num">1181</div><div>Total number of projects modified</div>
				</div>
			</div>
		</div>

		<div class="separator live-separator sepa-burg"></div>

		<div id="local-events-map-wrapper">
			<div class="local-events-map-header">
					<?php echo $event_counter . ' Local Events'; ?>
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

		<div class="separator live-separator sepa-lt-blue"></div>

		<script>
			var markers = <?php echo json_encode( $markers ); ?>;
			var map_pattern = '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/map-pattern.png';
		</script>
		<style>
			.panel.live-streaming iframe {
				width: 100% !important;
				height: 800px;
			}
			.panel.live-streaming .panel-content {
				grid-template-columns: 1fr !important;
				grid-gap: 0px !important;
			}
			.live-streaming h2 {
				color: #dbaeba !important;
				font-weight: 700;
			}
			.final-numbers h2 {
				color: #21759b !important
			}
			.local-events-map-header {
				color: #fff !important;
				font-size: 55px;
				font-weight: 700;
			}
			.live-streaming {
				background:url( 'https://wptranslationday.org/wp-content/themes/wptd4/assets/images/media_bg.png' );
				background-size: 100%;
				background-repeat: repeat-y;
				padding: 2em;
				/* text-align: center; */
			}
			.final-numbers {
				background:url( 'https://wptranslationday.org/wp-content/themes/wptd4/assets/images/blog_bg.png' );
				background-size: 100%;
				background-repeat: repeat-y;
				padding: 2em;
				/* text-align: center; */
			}
			#local-events-map-wrapper {
				background:url( 'https://wptranslationday.org/wp-content/themes/wptd4/assets/images/internal-pages-background.png' );
				background-size: 100%;
				background-repeat: repeat-y;
			}
			.live-separator {
				background-color: #dbaeba !important;
			}
			.live-separator.sepa-blue {
				background-color:#21759b !important;
			}
			.live-separator.sepa-burg {
				background-color:#5e1b42 !important;
			}
			.live-separator.sepa-lt-blue {
				background-color:#90c3d3 !important;
			}
			.openfont {
				color: #fff;
				font-weight: normal;
				color: #f4e9ed;
			}
			.finalnumbersfont {
				font-weight: bold;
				color: #5e1b42;
				grid-template-columns: 300px 1fr !important;
				grid-gap: 0px !important;
				font-size: 35px !important;
			}
			.finalnumbersfont .btext {
				color: #21759b;
			}
			.finalnumbersfont .num {
				font-size: 80px !important;
			}
			.finalnumbersfont div {
				padding: 10px;
				margin: 0;
			}
			.finalnumbersfont div:nth-child(odd) {
				text-align: right;
			}
			.finalnumbersfont div:nth-child(even) {
				border-left: 2px solid #21759b;
				padding-top: 30px;
			}
			@media ( max-width: 768px ) {
				.finalnumbersfont {
					grid-template-columns: 200px 1fr !important;
					font-size: 28px !important;
				}
				.finalnumbersfont .num {
					font-size: 50px !important;
				}
			.finalnumbersfont div:nth-child(even) {
				padding-top: 20px;
			}
			@media (max-width: 425px ) {
				.finalnumbersfont {
					grid-template-columns: 1fr !important;
				}
				.finalnumbersfont div:nth-child(odd) {
					text-align: left;
				}
				.finalnumbersfont div:nth-child(even) {
					border-left: unset;
				}
			}
		</style>
	<?php else: ?>
		<?php
		if ( get_field( 'go_live_wptd', $pid ) ) :

			wp_enqueue_script( 'wptd4-map-vendor', get_stylesheet_directory_uri() . '/assets/js/ammap.js', array( 'jquery' ), '1', true );
			wp_enqueue_script( 'wptd4-map-worldhigh', get_stylesheet_directory_uri() . '/assets/js/continentsHigh.js', array( 'jquery' ), '1', true );
			wp_enqueue_script( 'wptd4-map-init', get_stylesheet_directory_uri() . '/assets/js/map-init.js', array( 'wptd4-map-worldhigh' ), '1', true );

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

			$event_counter = 0;

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {
					$query->the_post();

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
							'link'           => esc_attr( $evenlink ),
							'organizer'      => esc_attr( get_field( 'organizer_name' ) ),
						);
					}

					$event_counter++;
				}
			}
			?>

		<div class="panel live-streaming">
			<div class="wrap">
				<h2 class="panel-heading">The Livestream</h2>
				<div class="panel-content">
				<iframe src="https://www.crowdcast.io/e/wptranslationday4?navlinks=false&embed=true" width="800" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
				<div class="links">
					<a target="_blank" href="https://wptranslationday.org/the-schedule/">View the full schedule for upcoming talks</a><br>
					<a target="_blank" href="https://www.crowdcast.io/e/wptranslationday4/">Go to CrowdCast for full interaction</a>
				</div>
				</div>
			</div>
		</div>

		<div class="separator live-separator"></div>

		<div id="local-events-map-wrapper">
			<div class="local-events-map-header">
					<?php echo $event_counter . ' Local Events'; ?>
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

		<script>
			var markers = <?php echo json_encode( $markers ); ?>;
			var map_pattern = '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/map-pattern.png';
		</script>
		<style>
			.panel.live-streaming iframe {
				width: 100% !important;
				height: 800px;
			}
			.panel.live-streaming .panel-content {
				grid-template-columns: 1fr !important;
				grid-gap: 0px !important;
			}
			.live-streaming h2 {
				color: #dbaeba !important;
				font-weight: 700;
			}
			.local-events-map-header {
				color: #fff !important;
				font-size: 55px;
				font-weight: 700;
			}
			.live-streaming {
				background:url( 'https://wptranslationday.org/wp-content/themes/wptd4/assets/images/media_bg.png' );
				background-size: 100%;
				background-repeat: repeat-y;
				padding: 2em;
				/* text-align: center; */
			}
			#local-events-map-wrapper {
				background:url( 'https://wptranslationday.org/wp-content/themes/wptd4/assets/images/internal-pages-background.png' );
				background-size: 100%;
				background-repeat: repeat-y;
			}
			.live-separator {
				background-color: #dbaeba !important;
			}
		</style>

		<?php else : ?>
			<?php if ( get_field( 'panel_1_active', $pid ) ) : ?>
				<div class="separator separator-0"></div>

				<div id="<?php echo esc_attr( get_field( 'panel_1_anchor_id', $pid ) ); ?>" class="panel panel-1" style="background-image:url('<?php echo esc_url( get_field( 'panel_1_background', $pid ) ); ?>');">
					<div class="wrap">
						<h2 class="panel-heading">
							<?php echo esc_attr( get_field( 'panel_1_heading', $pid ) ); ?>
						</h2>
						<div class="panel-content">
							<div class="left">
							</div>
							<div class="right">
								<?php echo wp_kses_post( get_field( 'panel_1_text', $pid ) ); ?>
							</div>
						</div>
					</div>
					<div class="drop-image">
						<?php echo wp_get_attachment_image( get_field( 'panel_1_image', $pid ), 'full' ); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( get_field( 'panel_2_active', $pid ) ) : ?>
				<div class="separator separator-1"></div>

				<div id="<?php echo esc_attr( get_field( 'panel_2_anchor_id', $pid ) ); ?>" class="panel panel-2" style="background-image:url('<?php echo esc_url( get_field( 'panel_2_background', $pid ) ); ?>');">
					<div class="wrap">
						<h2 class="panel-heading">
							<?php echo esc_attr( get_field( 'panel_2_heading', $pid ) ); ?>
						</h2>
						<div class="panel-content">
							<div class="left">
							</div>
							<div class="right">
								<?php echo wp_kses_post( get_field( 'panel_2_text', $pid ) ); ?>
							</div>
						</div>
					</div>
					<div class="drop-image">
						<?php echo wp_get_attachment_image( get_field( 'panel_2_image', $pid ), 'full' ); ?>
					</div>
				</div>
			<?php endif; ?>

			<?php if ( get_field( 'panel_3_active', $pid ) ) : ?>
			<div class="separator separator-2"></div>

			<div id="<?php echo esc_attr( get_field( 'panel_3_anchor_id', $pid ) ); ?>" class="panel panel-3" style="background-image:url('<?php echo esc_url( get_field( 'panel_3_background', $pid ) ); ?>');">
				<div class="wrap">
					<h2 class="panel-heading">
						<?php echo esc_attr( get_field( 'panel_3_heading', $pid ) ); ?>
					</h2>
					<div class="panel-content">
						<div class="left">
						</div>
						<div class="right">
							<?php echo wp_kses_post( get_field( 'panel_3_text', $pid ) ); ?>
						</div>
					</div>
				</div>
				<div class="drop-image">
					<?php echo wp_get_attachment_image( get_field( 'panel_3_image', $pid ), 'full' ); ?>
				</div>
			</div>
			<?php endif; ?>

			<?php if ( get_field( 'panel_4_active', $pid ) ) : ?>
			<div class="separator separator-3"></div>

			<div id="<?php echo esc_attr( get_field( 'panel_4_anchor_id', $pid ) ); ?>" class="panel panel-4" style="background-image:url('<?php echo esc_url( get_field( 'panel_4_background', $pid ) ); ?>');">
				<div class="wrap">
					<h2 class="panel-heading">
						<?php echo esc_attr( get_field( 'panel_4_heading', $pid ) ); ?>
					</h2>
					<div class="panel-content">
						<div class="left">
						</div>
						<div class="right">
							<?php echo wp_kses_post( get_field( 'panel_4_text', $pid ) ); ?>
							<div id="countdown"></div>
						</div>
					</div>
				</div>
				<div class="drop-image">
					<?php echo wp_get_attachment_image( get_field( 'panel_4_image', $pid ), 'full' ); ?>
				</div>
			</div>

			<script>
			( function( $ ) {
				$( 'document' ).ready( function() {
					var wptdTime = moment.tz("<?php echo esc_attr( get_field( 'countdown_date', $pid ) ); ?> 00:00:00", "Etc/UTC");

					$( '#countdown' )
						.countdown( wptdTime.toDate(), { elapse: true } )
						.on( 'update.countdown', function( e ) {
							if ( e.elapsed ) {
								$(this).html( e.strftime( "<h2><?php echo esc_attr( get_field( 'countdown_finished_message', $pid ) ); ?></h2>" ) );
							} else {
								$(this).html( '<div><span class="count">' + e.strftime('%D') + '</span><span class="time">days</span></div>' +
									'<div><span class="count">' + e.strftime('%H') + '</span><span class="time">hours</span></div>' +
									'<div><span class="count">' + e.strftime('%M') + '</span><span class="time">minutes</span></div>' +
									'<div><span class="count">' + e.strftime('%S') + '</span><span class="time">seconds</span></div>'
								);
							}
						} );
				} );
			} ( jQuery ) );
			</script>
			<?php endif; ?>

			<?php if ( get_field( 'panel_5_active', $pid ) ) : ?>
			<div class="separator separator-4"></div>

			<div id="<?php echo esc_attr( get_field( 'panel_5_anchor_id', $pid ) ); ?>" class="panel panel-5" style="background-image:url('<?php echo esc_url( get_field( 'panel_5_background', $pid ) ); ?>');">
				<div class="wrap">
					<h2 class="panel-heading">
						<?php echo esc_attr( get_field( 'panel_5_heading', $pid ) ); ?>
					</h2>
					<div class="panel-content">
						<div class="left">
						</div>
						<div class="right">
							<?php echo wp_kses_post( get_field( 'panel_5_text', $pid ) ); ?>
						</div>
					</div>
				</div>
				<div class="drop-image">
					<?php echo wp_get_attachment_image( get_field( 'panel_5_image', $pid ), 'full' ); ?>
				</div>
			</div>
			<div class="separator separator-5"></div>
			<?php endif; ?>

		<?php endif; ?>
	<?php endif; ?>
</article>
