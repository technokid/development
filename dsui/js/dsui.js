/**
 * Author: Dudman
 * Date: 16.09.13
 * Time: 20:11
 * version 0.1
 */
(function($){
	jQuery.fn.popup = function(options){
		options = $.extend({
			opacity:"0.6", // прозрачность заднего фона
			defaultWidth:"300", // стандартная ширина
			defaultHeight: "300" // стандартная высота
		}, options);
		var make = function(){
			/*
			* Фиксируем окно
			* */
			var popupInt = jQuery(this);
			popupInt.addClass('popupWindow').prepend('<div class="close-label">X</div>');
			popupInt.css({"width": options.defaultWidth+"px", "height":options.defaultHeight+"px"}).wrap('<div class="wrap_popup"></div>');
			jQuery('.wrap_popup').prepend('<div class="popup-bg"></div>');
			/*
			*  выставляем окно по центру(по высоте)
			* */
			var width = popupInt.css('width');
			var topPadding = (jQuery(window).height() - popupInt.height())/2;
			popupInt.stop().animate({top: jQuery(window).scrollTop() + topPadding});
			jQuery(window).scroll(function() {
				popupInt.stop().animate({top: jQuery(window).scrollTop() + topPadding});
			});
			/*
			* выставляем окно по центру(по ширине)
			* */
			var mainWidth = (jQuery(window).width() - popupInt.width()) / 2;
			popupInt.css({"margin-left":mainWidth+'px'});
			/*
			* Событие для закрытия окна
			* */
			jQuery('.popup-bg, .close-label').click(function(){
				jQuery('.popup-bg').css('display', 'none');
				jQuery(this).css('display', 'none');
				jQuery('.close-label, .popup-bg').remove();
				popupInt.unwrap();
			});
			/**/
			if(jQuery('body').width() > jQuery(window).width())
				jQuery('.popup-bg').width(jQuery('body').width());
			else
				jQuery('.popup-bg').width(jQuery(window).width());

			if(jQuery(document).height() > jQuery(window).height())
				jQuery('.popup-bg').height(jQuery(document).height());
			else
				jQuery('.popup-bg').height(jQuery(window).height());

			jQuery('.popup-bg').css('opacity',options.opacity);
			jQuery('.popup-bg').css('display', 'block');
			popupInt.css('display', 'block');
 		};
		return this.each(make);
	};
	/*
	* Скролл страници вверх
	* */
	jQuery.fn.scrollToTop = function(){
		return this.each(function(i){
			jQuery(this).addClass('totopButton');
			jQuery(this).click(function() {
				jQuery('html, body').animate({ scrollTop:0 }, 'slow}');
				return false;
			});
		});
	};
})(jQuery);
