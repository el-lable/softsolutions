		</section><!-- /#content -->	

		<section id="footer">			
			<?php if ( is_active_sidebar( 'footer' ) ) { ?><?php dynamic_sidebar( 'footer' ); ?><?php } ?>
		</section><!-- /#footer -->
		
	</div><!-- /#wrap -->
</div><!-- /#wrap_outer -->

<nav id="mobile_menu">
	<a href="#mobile_menu">
		<i class="fa fa-times"></i><!-- /#mobile_menu -->
	</a>
</nav>

<div id="popup_overlay"></div>


<?php wp_footer(); ?>

</body>
</html>