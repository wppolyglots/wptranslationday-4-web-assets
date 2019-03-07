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

	<?php if ( get_field( 'panel_1_active', $pid ) ) : ?>
		<div id="<?php echo esc_attr( get_field( 'panel_1_anchor_id', $pid ) ); ?>" class="panel panel-1" style="background-image:url('<?php echo esc_url( get_field( 'panel_1_background', $pid ) ); ?>');">
			<div class="wrap">
				<h2 class="panel-heading">
					<?php echo esc_attr( get_field( 'panel_1_heading', $pid ) ); ?>
				</h2>
				<div class="panel-content">
					<div class="left">
						<?php echo wp_get_attachment_image( get_field( 'panel_1_image', $pid ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo wp_kses_post( get_field( 'panel_1_text', $pid ) ); ?>
					</div>
				</div>
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
						<?php echo wp_get_attachment_image( get_field( 'panel_2_image', $pid ), 'full' ); ?>
					</div>
					<div class="right">
						<?php echo wp_kses_post( get_field( 'panel_2_text', $pid ) ); ?>
					</div>
				</div>
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
					<?php echo wp_get_attachment_image( get_field( 'panel_3_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo wp_kses_post( get_field( 'panel_3_text', $pid ) ); ?>
				</div>
			</div>
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
					<?php echo wp_get_attachment_image( get_field( 'panel_4_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo wp_kses_post( get_field( 'panel_4_text', $pid ) ); ?>
					<div id="countdown"></div>
				</div>
			</div>
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
					<?php echo wp_get_attachment_image( get_field( 'panel_5_image', $pid ), 'full' ); ?>
				</div>
				<div class="right">
					<?php echo wp_kses_post( get_field( 'panel_5_text', $pid ) ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php endif; ?>

</article>
