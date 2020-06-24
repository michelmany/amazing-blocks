<?php
get_header();

if ( have_posts() ) :
	while ( have_posts() ) :
		the_post(); ?>

		<?php
			$newsletter_item_link = get_field( 'newsletter_item_link', 'option' );
			$newsletter_type      = get_field( 'newsletter_type', $post->ID );
			$pdf_file             = get_field( 'pdf_file', $post->ID );
			$link_url             = get_field( 'link', $post->ID );
			$download_link        = $newsletter_type === 'pdf' ? $pdf_file['url'] : $link_url['url'];
			$link                 = $newsletter_item_link === 'item_page' ? get_permalink() : $download_link;
		?>

	 <h2>
		 <a href="<?php echo $link; ?>"
			 rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>">
				 <?php the_title(); ?>
			</a>
		</h2>

		<?php // the_content(); ?>
	 <?php endwhile; ?>
	<?php
 endif;

get_footer();
