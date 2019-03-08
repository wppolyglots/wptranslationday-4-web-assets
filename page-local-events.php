<?php // phpcs:ignore

get_header(); ?>

<div class="wrap">
	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); // phpcs:ignore ?>

			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					<?php twentyseventeen_edit_link( get_the_ID() ); ?>
				</header><!-- .entry-header -->
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
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>

			</article><!-- #post-## -->

			<?php endwhile; // End of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->
</div><!-- .wrap -->

<?php
get_footer();
