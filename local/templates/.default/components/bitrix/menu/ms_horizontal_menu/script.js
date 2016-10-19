$(document).ready(function(){
	$(function(){
		$menu = $('.bx_horizontal_menu_advaced');
		
		$('.bx_horizontal_menu_advaced > ul > li:first').addClass('first');

		$menu.find('>a').click(function(){
			$(this).next().slideToggle();
			$('#container').toggleClass('zi');
		});
			

		function copyMenu(){
			var $result = $('<ul></ul>');
			lastIndex = $('.bx_horizontal_menu_advaced > ul > li').length-1;
			$('.bx_horizontal_menu_advaced > ul >li').each(function (i) {
				if (i !== lastIndex){
				$menuCopy = $(this).find('>a').clone();
				$menuCopy.appendTo($result).wrap('<li class="mm_lvl1"/>');
				}
			});
			return $result.html();
		}
		
		function menuWidthOK(reset){
			if(reset){
				$('.bx_horizontal_menu_advaced > ul > li').show().removeClass('rtl');
				$('.mm_dd_in > li').show();
				$('.m_more').hide();
			}
			if($menu.width() < $menu.find('>ul').width()){
				$menu.find('.bx_hma_one_lvl:visible').last().hide();
				$('.m_more').css('display','table-cell');
				menuWidthOK();
			}
			else if($('.bx_hma_one_lvl').not(':visible').length){
				total = $menu.find('.bx_hma_one_lvl').length;
				visibleCount = $menu.find('.bx_hma_one_lvl:visible').length;
				result = visibleCount-total;

				$('.mm_dd').html('<ul class="mm_dd_in">'+copyMenu()+'</ul>');
				$('.mm_dd_in > li').slice(0,result).hide();
			}

			$($menu.find('>ul>li').get().reverse()).each(function(){
				subWidth = 250,
				tmWidth = $menu.width(),
				thisOffsetLeft = parseInt($(this).position().left);
				colCount = $(this).find('.bx_children_block').length;

				if(tmWidth < thisOffsetLeft+ (subWidth*colCount)) $(this).addClass('rtl');
			});
			
			$('.bx_horizontal_menu_advaced > ul > li').removeClass('last');
			$('.bx_horizontal_menu_advaced > ul > li:visible').last().addClass('last');
		}
		
		$('.m_more > span').click(function(){
			$(this).next().toggle();
			return false;
		});

		menuWidthOK();
		
		$menu.find('.bx_hma_one_lvl').hover(function(){
			$('#container').addClass('zi');
		},function(){
			$('#container').removeClass('zi');
		});
		
		$(window).resize(function(){
			if($('body').width() > 744){
				$menu.find('> a').hide().next().css('display','table');
				$menu.find('.bx_hma_one_lvl').css('display','table-cell');
				menuWidthOK(true);
			}
			else{
				$menu.find('> a').css('display','block').next().hide();
				$menu.find('.m_more').hide();
				$menu.find('.bx_hma_one_lvl').css('display','block');
				
			}
		});
	});
});






