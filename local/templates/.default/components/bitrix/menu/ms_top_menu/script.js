$(document).ready(function(){
	$(function(){
		$tpMenu = $('#tp-menu');
		$tpMenu.find('>a').click(function(){
			$(this).next().toggle();
		});

		var tpMenuWidth = 0;
		
		$tpMenu.find('li').each(function(){
			tpMenuWidth += $(this).width();
		});

		$tpMenu.attr('data-width',tpMenuWidth);

		menuW = parseInt($tpMenu.data('width'));
		arW = $('.st2 .auth-reg').outerWidth();
		var result = menuW + arW+40;
		
		function tpMenu(){
			if($('body').width() <= result){
				$tpMenu.addClass('responsive');
			}
			else{
				$tpMenu.removeClass('responsive');
				$tpMenu.find('>ul').show();
			}
		}

		tpMenu();

		$(window).resize(function(){
			tpMenu();
		});
	});
});