// Side News
$(function(){
	$('.side-news').each(function(){
		var itemWrap = $(this);
		var itemCarousel = $(this).find('.jcarousel');
		
		itemCarousel.jcarousel({
			//wrap:'both',
			animation: 600
		});

		itemWrap
			.find('.jcarousel-control-prev')
			.on('jcarouselcontrol:active', function() {
				$(this).removeClass('inactive');
			})
			.on('jcarouselcontrol:inactive', function() {
				$(this).addClass('inactive');
			})
			.jcarouselControl({
				target: '-=1'
			});
		
		itemWrap
			.find('.jcarousel-control-next')
			.on('jcarouselcontrol:active', function() {
				$(this).removeClass('inactive');
			})
			.on('jcarouselcontrol:inactive', function() {
				$(this).addClass('inactive');
			})
			.jcarouselControl({
				target: '+=1'
			});
		
	});
});
