<?php
/**
 * Displays content for front page
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<article id="post-<?php the_ID(); ?>">

	<?php if ( get_field( 'panel_1_active', get_the_ID() ) ) : ?>
		<div class="panel panel-1">
			<div class="wrap">
				<h2 class="panel-heading">
					<?php echo get_field( 'panel_1_heading', get_the_ID() ); ?>
				</h2>
				<div class="panel-content">
					<div class="left">
						<?php echo wp_get_attachment_image( get_field( 'panel_1_image', get_the_ID() ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo get_field( 'panel_1_text', get_the_ID() ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_2_active', get_the_ID() ) ) : ?>
		<div class="separator separator-1"></div>

		<div class="panel panel-2">
			<div class="wrap">
				<h2 class="panel-heading">
					<?php echo get_field( 'panel_2_heading', get_the_ID() ); ?>
				</h2>
				<div class="panel-content">
					<div class="left">
						<?php echo wp_get_attachment_image( get_field( 'panel_2_image', get_the_ID() ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo get_field( 'panel_2_text', get_the_ID() ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_3_active', get_the_ID() ) ) : ?>
	<div class="separator separator-2"></div>

	<div class="panel panel-3">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_3_heading', get_the_ID() ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_3_image', get_the_ID() ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_3_text', get_the_ID() ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_4_active', get_the_ID() ) ) : ?>
	<div class="separator separator-3"></div>

	<div class="panel panel-4">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_4_heading', get_the_ID() ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_4_image', get_the_ID() ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_4_text', get_the_ID() ); ?>
					<div id="countdown"></div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_5_active', get_the_ID() ) ) : ?>
	<div class="separator separator-4"></div>

	<div class="panel panel-5">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_5_heading', get_the_ID() ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_5_image', get_the_ID() ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_5_text', get_the_ID() ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

</article>
