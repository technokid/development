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
			jQuery(this).addClass('popupWindow');
			jQuery(this).css({"width": options.defaultWidth+"px", "height":options.defaultHeight+"px"});
 			jQuery(this).wrap('<div class="wrap_popup"></div>');
			jQuery('.wrap_popup').prepend('<div class="popup-bg"></div>');
 			var element = jQuery(this);
			var width = element.css('width');
			var topPadding = (jQuery(window).height() - element.height())/2;
			element.stop().animate({top: jQuery(window).scrollTop() + topPadding});
			jQuery(window).scroll(function() {
				element.stop().animate({top: jQuery(window).scrollTop() + topPadding});
			});
			var mainWidth = (jQuery(window).width() - jQuery(this).width()) / 2;
			jQuery(this).css({"margin-left":mainWidth+'px'});
			/*
			* Событие для закрытия окна
			* */
			jQuery('.popup-bg, .close-label').click(function(){
				jQuery('.popup-bg').css('display', 'none');
				jQuery(this).css('display', 'none');
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
			jQuery(this).css('display', 'block');
 		};
		return this.each(make);
	};
})(jQuery);
