<?php
/**
 *  Skinny Blocks Premium Settings Page
 *
 * @package MRKWP\SkinnyBlocksPremium
 */
?>

<?php do_action( 'sbp_settings_header' ); ?>

<?php
if ( isset( $_GET['settings-updated'] ) ) {
	add_settings_error( 'sbp_messages', 'sbp_message', __( 'Settings Saved', 'skinny-blocks-premium' ), 'updated' );
}
?>

<div class="wrap sbp-options-page">
	<h1 class="sbp-options-page__title"><?php echo esc_html( get_admin_page_title() ); ?></h1>

	<?php settings_errors( 'sbp_messages' ); ?>

	<form action="options.php" method="post">
		<?php settings_fields( 'skinny_blocks_premium_options' ); ?>
		<h3><?php echo __( 'Post Types', 'skinny-blocks' ); ?></h3>
		<div class="sbp-options-page-grid">
			<div class="sbp-options-page-grid__item">
				<div class="sbp-options-page-grid__item-inner">
					<h3><?php echo __( 'Newsletters', 'skinny-blocks' ); ?></h3>
					<label class="skinny_blocks_switch">
						<input
							type="checkbox"
							name="show_newsletter_cpt_accordion"
							value="1" <?php checked( 1, get_option( 'show_newsletter_cpt_accordion' ), true ); ?>>
						<span class="slider"></span>
					</label>
				</div>
			</div>

			<div class="sbp-options-page-grid__item">
				<div class="sbp-options-page-grid__item-inner">
					<h3><?php echo __( 'People Listing', 'skinny-blocks' ); ?></h3>
					<label class="skinny_blocks_switch">
						<input
							type="checkbox"
							name="show_people_listing_cpt_accordion"
							value="1" <?php checked( 1, get_option( 'show_people_listing_cpt_accordion' ), true ); ?>>
						<span class="slider"></span>
					</label>
				</div>
			</div>
		</div>
		<?php
		do_settings_sections( 'skinny_blocks_premium_options' );
		submit_button( __( 'Save Settings', 'skinny-blocks-premium' ) );
		?>
	</form>
</div>
