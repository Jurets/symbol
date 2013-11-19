$(function() {
	$(".fancybox").fancybox({
		openEffect	: 'none',
		closeEffect	: 'none'
	});
	
	$('.product_imgs a').click(function(){
		$('.product_img_big a img').attr('src',$(this).children().attr('rel'));
		$('.product_img_big a').attr('href',$(this).attr('rel'));
	});
	$('.product_imgs  a').click(function(){
		$('.product_imgs a').removeClass('active');
		$(this).addClass('active');
	});
});
				