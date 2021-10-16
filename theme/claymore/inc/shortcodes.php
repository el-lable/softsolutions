<?php
/** 
*	Theme's shortcodes 
*/

add_shortcode('date', 'show_date');
add_shortcode('intro', 'show_intro');
add_shortcode('about', 'show_about');
add_shortcode('service', 'show_service');
add_shortcode('presentation', 'show_presentation');
add_shortcode('testimonials', 'show_testimonials');
add_shortcode('contacts', 'show_contacts');

// [date]
function show_date( $attr ) {
	return date( isset( $attr['format'] ) ? $attr['format'] : 'Y:d:m' );
}
// [intro]
function show_intro() {
	if( !get_field( 'intro' ) && !get_field( 'intro', 'options' ) ) return;
	
	$block = get_field( 'intro' ) ? get_field( 'intro' ) : get_field( 'intro', 'options' );
	
	ob_start();
?>
<section id="intro">
	<div class="mock"></div>
	<header>
		<h1><?php echo $block['title']; ?></h1>
	</header>
	<p><?php echo $block['description']; ?></p>
	<div class="buttons">
		<a href="#" class="button primary">Purchase now</a>
		<i>Or</i>
		<a href="#" class="button secondary">Learn more</a>
	</div>
</section>
<?php
	return ob_get_clean();
}
// [about]
function show_about() {
	if( !get_field( 'about' ) && !get_field( 'about', 'options' ) ) return;
	
	$block = get_field( 'about' ) ? get_field( 'about' ) : get_field( 'about', 'options' );
	
	ob_start();
?>
<section class="about">
	<?php if( !empty( $block['icon']['url'] ) ) { ?><div class="icon"><img src="<?php echo $block['icon']['url'] ?>" alt=""></div><?php } ?>
	<h2><?php echo $block['title']; ?></h2>
	<?php if( !empty( $block['description'] ) ) { ?><p><?php echo $block['description']; ?></p><?php } ?>
</section>
<?php
	return ob_get_clean();
}
// [service]
function show_service() {
	if( !get_field( 'service' ) && !get_field( 'service', 'options' ) ) return;
	
	$block = get_field( 'service' ) ? get_field( 'service' ) : get_field( 'service', 'options' );
	
	ob_start();
?>
<section class="service">
	<ul>
		<?php foreach( $block as $item ) { ?>
			<li>
				<div class="icon"><img src="<?php echo $item['icon']['sizes']['service'] ?>" alt=""></div>
				<div class="name"><?php echo $item['name']; ?></div>
				<div class="description"><?php echo $item['caption']; ?></div>
			</li>
		<?php } ?>
	</ul>
</section>
<?php
	return ob_get_clean();
}
// [presentation]
function show_presentation() {
	if( !get_field( 'presentation' ) && !get_field( 'presentation', 'options' ) ) return;
	
	$block = get_field( 'presentation' ) ? get_field( 'presentation' ) : get_field( 'presentation', 'options' );
	
	ob_start();
?>
<section class="presentation">
	<ul>
		<?php foreach( $block as $item ) { ?>
			<li>
				<div class="image"><img src="<?php echo $item['image']['url'] ?>" alt=""></div>
				<div class="title"><?php echo $item['title']; ?></div>
				<?php if( !empty( $item['description'] ) ) { ?><div class="description"><?php echo $item['description']; ?>.</div><?php } ?>
			</li>
		<?php } ?>
	</ul>
</section>
<?php
	return ob_get_clean();
}
// [testimonials]
function show_testimonials( $atts ) {
	$atts = shortcode_atts( [
		'title' => 'What People Say',
		'count' => 6
	], $atts );

	$posts = get_posts( array(
		'numberposts' => $atts['count'],
		'orderby'     => 'date',
		'order'       => 'DESC',
		'post_type'   => 'testimonials',
		'suppress_filters' => true, // подавление работы фильтров изменения SQL запроса
	) );
	
	if( !count( $posts ) ) return;

	ob_start();
?>
<section class="testimonials">
	<?php if( !empty( $atts['title'] ) ) { ?><header><h2><?php echo $atts['title']; ?></h2></header><?php } ?>
	<ul>
		<?php foreach( $posts as $post ) { ?>
			<li>
				<i class="hex" <?php if( get_the_post_thumbnail_url( $post->ID ) ) { ?>style="background-image:url('<?php echo get_the_post_thumbnail_url( $post->ID, 'testimonials') ?>');"<?php } ?>></i>
				<div><h3><?php echo $post->post_title; ?></h3><?php echo $post->post_content; ?></div>
			</li>
		<?php } ?>
	</ul>
</section>
<?php
	return ob_get_clean();
}
// [contacts]
function show_contacts() {
	if( !get_field( 'contacts' ) && !get_field( 'contacts', 'options' ) ) return;
	
	$block = get_field( 'contacts' ) ? get_field( 'contacts' ) : get_field( 'contacts', 'options' );
	
	ob_start();
?>
<section class="contacts">
	<div>
		<h2><?php echo $block['name']; ?></h2>
		<p><?php echo $block['description']; ?></p>
		<ul>
			<?php if( !empty( $block['address'] ) ) { ?><li><i class="fa fa-map-marker"></i><?php echo $block['address']; ?></li><?php } ?>
			<?php if( !empty( $block['phones'] ) ) { ?>
				<li>
					<i class="fa fa-phone"></i>
						<?php foreach( $block['phones'] as $n => $item ) { ?>
							<?php if( $n ) { ?> / <?php }  ?>
							<a href="<?php echo $item['phone']['url'] ?>" <?php if( $item['phone']['target'] ) echo ' target="' . $item['phone']['target'] . '"' ?>><?php echo $item['phone']['title'] ?></a>
						<?php }  ?>
					</li>
			<?php } ?>
			<?php if( !empty( $block['emails'] ) ) { ?>
				<li>
					<i class="fa fa-envelope-o"></i>
						<?php foreach( $block['emails'] as $n => $item ) { ?>
							<?php if( $n ) { ?> / <?php }  ?>
							<a href="<?php echo $item['email']['url'] ?>" <?php if( $item['email']['target'] ) echo ' target="' . $item['email']['target'] . '"' ?>><?php echo $item['email']['title'] ?></a>
						<?php }  ?>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php if( !empty( $block['form'] ) ) echo do_shortcode( '[contact-form-7 id="' . $block['form'] . '"]' ); ?>
	
</section>
<?php
	return ob_get_clean();
}

?>