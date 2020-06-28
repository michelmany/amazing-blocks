<?php
/**
 *  Skinny Blocks Premium Settings Page
 *
 * @package MRKWP\SkinnyBlocksPremium
 */
?>

<?php do_action( 'sbp_settings_header' ); ?>

<div class="wrap sbp-options-page">
	<h1 class="sbp-options-page__title"><?php echo esc_html( get_admin_page_title() ); ?></h1>
	<form action="options.php" method="post">
	<?php settings_fields( 'skinny_blocks_premium_options' ); ?>

	<?php
	do_settings_sections( 'skinny-blocks-premium-settings' );

	submit_button( __( 'Save Settings', 'textdomain' ) );
	?>
	</form>
</div>
