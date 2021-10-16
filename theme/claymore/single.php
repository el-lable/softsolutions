<?php get_header(); ?>

<?php /*get_sidebar();*/ ?>

<?php //print_r(get_queried_object()); ?>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

	<h1><?php the_title(); ?></h1>
	
	<?php if( has_post_thumbnail() ) { ?>
		
		<div class="page_thumbnail"><?php the_post_thumbnail(); ?></div>
	
	<?php } ?>
	
	<?php /*include (TEMPLATEPATH . '/inc/meta.php' );*/ ?>

	<?php /*<div class="entry">*/ ?>

		<?php the_content(); ?>

		<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>

	<?php /*</div>*/ ?>

	<?php /*edit_post_link('Редактировать страницу.', '<p>', '</p>');*/ ?>
				
	<?php // comments_template(); ?>

<?php endwhile; endif; ?>

<?php get_footer(); ?>
