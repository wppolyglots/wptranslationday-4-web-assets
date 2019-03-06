<?php
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

	<?php if ( get_field( 'panel_1_active', $pid ) ) : ?>
		<div class="panel panel-1" style="background-image:url('<?php echo get_field( 'panel_1_background', $pid );?>');">
			<div class="wrap">
				<h2 class="panel-heading">
					<?php echo get_field( 'panel_1_heading', $pid ); ?>
				</h2>
				<div class="panel-content">
					<div class="left">
						<?php echo wp_get_attachment_image( get_field( 'panel_1_image', $pid ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo get_field( 'panel_1_text', $pid ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_2_active', $pid ) ) : ?>
		<div class="separator separator-1"></div>

		<div class="panel panel-2" style="background-image:url('<?php echo get_field( 'panel_2_background', $pid );?>');">
			<div class="wrap">
				<h2 class="panel-heading">
					<?php echo get_field( 'panel_2_heading', $pid ); ?>
				</h2>
				<div class="panel-content">
					<div class="left">
						<?php echo wp_get_attachment_image( get_field( 'panel_2_image', $pid ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo get_field( 'panel_2_text', $pid ); ?>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_3_active', $pid ) ) : ?>
	<div class="separator separator-2"></div>

	<div class="panel panel-3" style="background-image:url('<?php echo get_field( 'panel_3_background', $pid );?>');">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_3_heading', $pid ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_3_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_3_text', $pid ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_4_active', $pid ) ) : ?>
	<div class="separator separator-3"></div>

	<div class="panel panel-4" style="background-image:url('<?php echo get_field( 'panel_4_background', $pid );?>');">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_4_heading', $pid ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_4_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_4_text', $pid ); ?>
					<div id="countdown"></div>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

	<?php if ( get_field( 'panel_5_active', $pid ) ) : ?>
	<div class="separator separator-4"></div>

	<div class="panel panel-5" style="background-image:url('<?php echo get_field( 'panel_5_background', $pid );?>');">
		<div class="wrap">
			<h2 class="panel-heading">
				<?php echo get_field( 'panel_5_heading', $pid ); ?>
			</h2>
			<div class="panel-content">
				<div class="left">
					<?php echo wp_get_attachment_image( get_field( 'panel_5_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo get_field( 'panel_5_text', $pid ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

</article>
