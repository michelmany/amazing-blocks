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
				$download_link        = $newsletter_type === 'pdf' ? $pdf_file['url'] : $link_url['url'];
				$link                 = $newsletter_item_link === 'item_page' ? get_permalink() : $download_link;
			?>

		<h4>
			<a
					href="<?php echo $link; ?>"
					target="_blank"
					title="Permanent Link to <?php the_title_attribute(); ?>">
					<?php the_title(); ?>
				</a>
			</h4>

		<?php endwhile; ?>
	<?php endif; ?>

</div>

<?php
get_footer();