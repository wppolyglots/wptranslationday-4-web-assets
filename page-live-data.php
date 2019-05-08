<?php // phpcs:ignore

get_header();

$frontpage_id = get_option( 'page_on_front' );
?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
		<div id="now" class="section current-talk lp-now-it-is lp-live-stream-it-is bg-color-pink text-color-pink--darker">
		<div class="container">
			<div class="row">
				<div class="twelve columns">
					<h2>Live stream</h2>
				</div>
			</div>
			<div class="row">
				<div class="ten columns offset-by-two">
					<iframe src="https://www.crowdcast.io/e/wptranslationday4?navlinks=false&embed=true" width="800" height="600" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allowFullScreen="true"></iframe>
				</div>
			</div>
			<div class="row">
				<div class="bgholder livebgholder"></div>
				<div class="talk-holder">

				</div>
			</div>
			<div class="row">
				<div class="ten columns offset-by-two">
					<div class="six columns viefulllinks" style="margin-top:0 !important;">
						<h4><a href="https://wptranslationday.org/the-schedule/">View the full schedule for upcoming talks</a></h4>
					</div>
					<div class="six columns viefulllinks" style="margin-top:0 !important;">
						<h4><a target="_blank" href="https://www.crowdcast.io/e/wptranslationday4/">Go to CrowdCast for full interaction</a></h4>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div id="data" class="section live-data lp-live-data-it-is bg-color-blue text-color-blue--light">
		<div class="container">
			<div class="row">
				<div class="twelve columns">
					<h2 style="margin:0;" class="text-color-blue--lighter">Some of today's numbers:</h2>
				</div>
				<div class="bgholder streambgholder"></div>
			</div>
			<div class="row">
				<div class="eight columns offset-by-four">
					<h5 style="margin:0;">* data is refreshed every hour</h5>
				</div>
			</div>

			<?php
			// Get livedata stuff
			$translators = gwtd3_get_translators();
			$top120 = gwtd3_get_top120();
			$wptranslations = gwtd3_get_wp_translations();
			?>

			<div class="jbsdata">

				<div class="row" style="margin-top:2rem;">
					<div class="eight columns minor offset-by-four">
						<h3 style="font-weight:100 !important;" class="text-color-blue--lighter">Currently on the WP Polyglots team, we globally count:</h3>
					</div>
				</div>

				<?php if ( intval( $translators->total_pte ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="livedata-counter" data-value="<?php echo intval( $translators->total_pte ); ?>"><?php echo $translators->total_pte; ?></h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--light">PTE - Project Translation Editors</h3>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( intval( $translators->new_pte ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="text-color-blue--lighter livedata--exception-relativetopminus40 livedata-counter">
							<span class="data-number" data-value="<?php echo intval( $translators->new_pte ); ?>">
								+<?php echo $translators->new_pte; ?>
							</span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--lighter livedata--exception-relativetopminus40">since the beginning of WPTD3</h3>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( intval( $translators->total_contrib ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="livedata-counter">
							<span class="data-number" data-value="<?php echo intval( $translators->total_contrib ); ?>">
								<?php echo $translators->total_contrib; ?>
							</span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--light">Translators</h3>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( intval( $translators->new_contrib ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="text-color-blue--lighter livedata--exception-relativetopminus40 livedata-counter">
							<span class="data-number" data-value="<?php echo intval( $translators->new_contrib ); ?>">
								+<?php echo $translators->new_contrib; ?>
							</span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--lighter livedata--exception-relativetopminus40">since the beginning of WPTD3</h3>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( intval( $top120->total_translated_strings ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<?php
						// Lets format this stuff a bit!
						$n = intval( $top120->total_translated_strings );
						if ($n < 1000000) {
							$n_format = number_format($n);
						} elseif ($n < 1000000000) {
							$n_format_number = number_format($n / 1000000);
							$n_format = '<span class="data-number" data-value="' . $n_format_number . '">' . number_format($n / 1000000) . '</span>' . '<abbr title="Millions">M</abbr>';
						} else {
							$n_format = number_format($n / 1000000000) . 'B';
						}
						?>
						<h1 class="livedata-counter"><?php echo $n_format; ?></h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--light livedata--exception-mt1rem">Strings still waiting to be translated in the Top 120 plugins</h3>
					</div>
				</div>
				<?php endif; ?>

				<?php if ( intval( $top120->new_translated_strings ) < 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="text-color-blue--lighter livedata--exception-relativetopminus40 livedata-counter">
							+<span class="data-number" data-value="<?php echo intval( $top120->new_translated_strings ); ?>"><?php echo str_replace("-", "", $top120->new_translated_strings); ?></span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--lighter livedata--exception-relativetopminus40">Strings translated in the Top 120 plugins since the beginning of WPTD3</h3>
					</div>
				</div>
				<?php endif; ?>

				<div class="row">
					<div class="four columns major">
						<h1 class="livedata-counter">
							<span class="data-number" data-value="<?php echo intval( $wptranslations->total_translated_wp ); ?>">
								<?php echo $wptranslations->total_translated_wp; ?>
							</span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--light">Locales at 100% of WordPress 5.2</h3>
					</div>
				</div>

				<?php if ( intval( $wptranslations->new_translated_wp ) > 0 ) : ?>
				<div class="row">
					<div class="four columns major">
						<h1 class="text-color-blue--lighter livedata-counter">
							<span class="data-number" data-value="<?php echo intval( $wptranslations->new_translated_wp ); ?>">
								+<?php echo $wptranslations->new_translated_wp; ?>
							</span>
						</h1>
					</div>
					<div class="eight columns minor borderleft">
						<h3 class="text-color-blue--lighter livedata--exception-relativetopminus40">since the beginning of WP Translation Day 4</h3>
					</div>
				</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<div id="local-events-map"></div>
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

		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();

				$continent = get_field( 'continent' );
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
			}
			?>
			<script>
			var markers = <?php echo json_encode( $markers ); ?>;
			var map_pattern = '<?php echo get_stylesheet_directory_uri(); ?>/assets/images/map-pattern.png';
			</script>
		<?php
		}
		?>

		<?php wp_reset_postdata(); ?>
		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->