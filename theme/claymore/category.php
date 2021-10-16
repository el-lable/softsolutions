<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

	<?php if( is_category() ) { ?><h1><?php echo get_queried_object()->name; ?></h1><?php } ?>
	
	<section id="articles">
					
		<?php 
		while ( have_posts() ) : the_post();
			$preview = get_field( 'article-preview' );
		?>

			<article>
				
				<div class="thumbnail"><a href="<?php the_permalink(); ?>"><img src="<?php echo $preview['thumb']['sizes']['article-thumbnail']; ?>"></a></div>
				
				<div class="preview">
				
					<h2><a href="<?php the_permalink(); ?>"><?php echo $preview['title']; ?></a></h2>
					
					<?php echo $preview['caption']; ?>
				
				</div>
				
			</article>
			
		<?php endwhile; ?>
	
	</section><!-- /#articles -->
	
	<?php include( TEMPLATEPATH . '/inc/nav.php' ); ?>

<?php else : ?>

	<h2>Статей нет.</h2>

<?php endif; ?>

<?php get_footer(); ?>