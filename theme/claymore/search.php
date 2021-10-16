<?php get_header(); ?>

<?php /*get_sidebar();*/ ?>


<div id="search_results">

	<?php if (have_posts()) : ?>

		<h2 class="styled_title"><span>Результаты поиска по запросу «<?php the_search_query(); ?>»</span></h2>
		
		<?php echo do_shortcode( '[smart_search id="1"]' ); ?>

		<ol>
			
			<?php 
				global $wp_query;
				$list_counter = $wp_query->query_vars['posts_per_page'] * ($wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] - 1 : 0); 
			?>
			<?php while (have_posts()) : the_post(); ?>

				<li <?php post_class() ?> id="post-<?php the_ID(); ?>">
					
					<i><?php echo ++$list_counter; ?></i>
					
					<?php if( has_post_thumbnail() ) { ?>
						<div class="thumb"><a href="<?php the_permalink() ?>"><?php the_post_thumbnail(); ?></a></div>
					<?php } ?>
					
					<div class="entry">
						
						<div>
							<h3><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
							<p><?php the_excerpt(); ?></p>
						</div>
					</div>

					<?php /*include (TEMPLATEPATH . '/inc/meta.php' );*/ ?>

					<?php /*<div class="readmore">
						<a href="<?php the_permalink(); ?>">Читать подробнее</a>
					</div>*/ ?>
					
				</li>

			<?php endwhile; ?>
		
		</ol>

		<?php include (TEMPLATEPATH . '/inc/nav.php' ); ?>

	<?php else : ?>

		<h2>По запросу «<?php the_search_query(); ?>» результатов не найдено.</h2>

	<?php endif; ?>
</div>
	
		


<?php get_footer(); ?>