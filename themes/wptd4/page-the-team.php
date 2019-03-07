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
					'post_type'      => array( 'wptd_organizer' ),
					'post_status'    => array( 'publish' ),
					'nopaging'       => true,
					'posts_per_page' => -1,
					'order'          => 'ASC',
					'meta_key'       => 'order',
					'orderby'        => 'meta_value',
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) : //phpcs:ignore ?>
					<div class="entry-content">
						<?php
						while ( $query->have_posts() ) :
							$query->the_post();

							$wporg = get_field( 'username_wporg' );
							$slack = get_field( 'username_slack' );
							$fb    = get_field( 'facebook' );
							$tt    = get_field( 'twitter' );
							$ln    = get_field( 'linkedin' );
							$wb    = get_field( 'website' );
							?>

							<div class="team-member">
								<?php echo get_avatar( esc_attr( get_field( 'e-mail' ) ), 150 ); ?> <br>
								<?php the_title(); ?> <br>
								<?php echo esc_attr( get_field( 'role' ) ); ?> <br>
								<?php echo ( ! empty( $wb ) ) ? '<a href="' . esc_attr( $wb ) . '" target="_blank" title="Website"><i class="fas fa-link"></i></a>' : ''; ?>
								<?php echo ( ! empty( $wporg ) ) ? '<a href="https://profiles.wordpress.org/' . esc_attr( $wporg ) . '" target="_blank" title="WordPress Profile"><i class="fab fa-wordpress"></i></a>' : ''; ?>
								<?php echo ( ! empty( $slack ) ) ? '<a href="https://wordpress.slack.com/team/' . esc_attr( $slack ) . '" target="_blank" title="Slack Profile"><i class="fab fa-slack"></i></a>' : ''; ?>
								<?php echo ( ! empty( $fb ) ) ? '<a href="' . esc_attr( $fb ) . '" target="_blank" title="Facebook Profile"><i class="fab fa-facebook"></i></a>' : ''; ?>
								<?php echo ( ! empty( $tt ) ) ? '<a href="' . esc_attr( $tt ) . '" target="_blank" title="Twitter Profile"><i class="fab fa-facebook"></i></a>' : ''; ?>
								<?php echo ( ! empty( $ln ) ) ? '<a href="' . esc_attr( $ln ) . '" target="_blank" title="LinkedIn Profile"><i class="fab fa-linkedin"></i></a>' : ''; ?>
								<?php echo wp_kses_post( get_field( 'bio' ) ); ?> <br>
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
