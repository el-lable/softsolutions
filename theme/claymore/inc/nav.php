<?php if( function_exists( 'wp_pagenavi' ) ) { ?>
	<?php wp_pagenavi(); ?>
<?php } else { ?>
	<div class="navigation">
		<div class="next-posts"><?php next_posts_link('&laquo; Older Entries') ?></div>
		<div class="prev-posts"><?php previous_posts_link('Newer Entries &raquo;') ?></div>
	</div>
<?php } ?>