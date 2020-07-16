<?php
get_header();

?>
<div style="text-align: center">
	<h3>Archive: <?php post_type_archive_title(); ?></h3>

	<?php

	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			?>

			<?php
				$newsletter_item_link = get_field( 'newsletter_item_link', 'option' );
				$newsletter_type      = get_field( 'newsletter_type', $post->ID );
				$pdf_file             = get_field( 'pdf_file', $post->ID );
				$link_url             = get_field( 'link', $post->ID );
				$download_link        = $newsletter_type === 'pdf' ? ( $pdf_file ? $pdf_file['url'] : null ) : ( $link_url ? $link_url['url'] : null );
				$link_final           = 'item_page' === $newsletter_item_link ? get_permalink() : $download_link;
			?>

		<h4>
			<a
					href="<?php echo $link_final; ?>"
					<?php
					if ( $newsletter_type === 'pdf' ) {
						echo 'download';
					}
					?>
					title="Permanent Link to <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h4>

		<?php endwhile; ?>
	<?php endif; ?>

</div>

<?php
get_footer();
