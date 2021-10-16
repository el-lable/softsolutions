<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>" />
<?php if ( is_search() ) { ?>
	<meta name="robots" content="noindex, nofollow" /> 
<?php } ?>
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<?php if( get_field( 'metas', 'options' ) ) foreach( get_field( 'metas', 'options' ) as $meta ) { ?>
	<meta name="<?php echo $meta['name']; ?>" content="<?php echo $meta['content']; ?>" />
<?php } ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrap_outer">
	<div id="wrap">
		<section id="header">
			<a href="#mobile_menu">
				<i class="fa fa-bars"></i>
			</a>
			<?php the_custom_logo(); ?>
			<?php if ( is_active_sidebar( 'header' ) ) { ?><?php dynamic_sidebar('header'); ?><?php } ?>
			<div class="login"><a href="<?php echo wp_login_url(); ?>">Login</a></div>
		</section><!-- /#header -->
		
		<section id="content">