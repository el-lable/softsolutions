jQuery(function($){
	
	var isTouchDevice = !!('ontouchstart' in window);
	if(isTouchDevice)$('body').addClass('touch_device');
	
	/* Mobile menu */
	$('#header .menu').clone().appendTo('#mobile_menu');
	$('#header [href="#mobile_menu"]').click(function(e){
		e.preventDefault();
		$('#mobile_menu').addClass('opened');
	});
	$('#mobile_menu [href="#mobile_menu"]').click(function(e){
		e.preventDefault();
		$('#mobile_menu').removeClass('opened');
	});
	
	/* Presentation's carousel */
	$('#content .presentation ul').each(function(n){
		$(this).owlCarousel({
			loop:true,
			nav:true,
			dots:false,
			autoplay:true,
			autoplayTimeout:5000,
			items:1
		});
	});
	
});