<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.2
 */

?>

		</div><!-- #content -->
		<div class="stay-tuned">
			<div class="wrap">
				<div class="inner">
					<div class="left">
						<h2>Stay Tuned!</h2>
					</div>
					<div class="right">
						<a target="_blank" title="Stay tuned on Twitter!" href="https://twitter.com/translatewp?lang=en">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/twitter.png" alt="Twitter">
						</a>
						<a target="_blank" title="Stay tuned on Facebook!" href="https://www.facebook.com/WPTranslationDay/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/facebook.png" alt="Twitter">
						</a>
						<a target="_blank" title="Stay tuned on Instagram!" href="https://www.instagram.com/wptranslationday/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/instagram.png" alt="Twitter">
						</a>
						<a target="_blank" title="Stay tuned on LinkedIn!" href="https://www.linkedin.com/company/35627812/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/linkedin.png" alt="Twitter">
						</a>
						<a target="_blank" title="Stay tuned on Slack!" href="https://wordpress.slack.com/messages/polyglots">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/slack.png" alt="Slack">
						</a>
						<a target="_blank" title="Stay tuned on Translating WordPress!" href="https://make.wordpress.org/polyglots/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/wordpress.png" alt="WordPress">
						</a>
						<a target="_blank" title="Start Translating!" href="https://translate.wordpress.org/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/polyglots.png" alt="Translate WordPress">
						</a>
						<a target="_blank" title="Find the Team for your Language!" href="https://make.wordpress.org/polyglots/teams/">
							<img src="https://wptranslationday.org/wp-content/uploads/2019/03/make.png" alt="Polyglots">
						</a>
					</div>
				</div>
			</div>
		</div>
		<div class="menu-footer">
			<div class="wrap">
				<?php
					wp_nav_menu(
						array(
							'theme_location' => 'footer-menu',
							'menu_class'     => 'footer-menu',
							'depth'          => 1,
						)
					);
				?>
			</div>
		</div>
		<div class="footer-sponsors">
			<div class="wrap">
				<h2><?php esc_html_e( 'Meet our Sponsors!', 'wptd4' ); ?></h2>
				<div class="inner">
				<?php
				$args = array(
					'post_type'      => array( 'wptd_sponsor' ),
					'post_status'    => array( 'publish' ),
					'nopaging'       => true,
					'posts_per_page' => -1,
					'orderby'        => 'rand',
				);

				$query = new WP_Query( $args );

				if ( $query->have_posts() ) : //phpcs:ignore ?>
					<?php
					while ( $query->have_posts() ) :
						$query->the_post();

						$url = get_field( 'link' );
						?>
						<div class="sponsor">
							<div class="image">
								<a target="_blank" href="<?php echo esc_url( $url ); ?>"><?php echo wp_get_attachment_image( get_field( 'image' ), 'full' ); ?></a>
							</div>
						</div> <!-- .sponsor -->
					<?php endwhile; ?>
				<?php endif; ?>

				<?php wp_reset_postdata(); ?>
				</div>
			</div>
		</div>
		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="wrap">
				<?php
				get_template_part( 'template-parts/footer/footer', 'widgets' );

				if ( has_nav_menu( 'social' ) ) :
					?>
					<nav class="social-navigation" role="navigation" aria-label="<?php esc_attr_e( 'Footer Social Links Menu', 'twentyseventeen' ); ?>">
						<?php
							wp_nav_menu(
								array(
									'theme_location' => 'social',
									'menu_class'     => 'social-links-menu',
									'depth'          => 1,
									'link_before'    => '<span class="screen-reader-text">',
									'link_after'     => '</span>' . twentyseventeen_get_svg( array( 'icon' => 'chain' ) ),
								)
							);
						?>
					</nav><!-- .social-navigation -->
					<?php
				endif;

				get_template_part( 'template-parts/footer/site', 'info' );
				?>
			</div><!-- .wrap -->
		</footer><!-- #colophon -->
	</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

</body>
</html>
