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
	/*
	* Формы
	* */
	$.fn.dsUI = function(options){
		var self = this;
		/* Apply document listener */
		$(document).mousedown(checkExternalClick);
		/* each form */
		return this.each(function(){
			$('input:submit, input:reset, input:button', this).each(ButtonAdd);
			$('button').focus(function(){ $(this).addClass('dsUIFocus')}).blur(function(){ $(this).removeClass('dsUIFocus')});
			$('input:text:visible, input:password', this).each(TextAdd);

			$('input:checkbox', this).each(CheckAdd);
			$('input:radio', this).each(RadioAdd);
			$('select', this).each(function(index){
				//$(this).attr('size')
				if ($(this).attr('multiple')) {
					MultipleSelectAdd(this, index);
				}
				else
					SelectAdd(this, index);
			});
			/* Add a new handler for the reset action */
			$(this).bind('reset',function(){var action = function(){ Reset(this); }; window.setTimeout(action, 10); });
			$('.dsUIHidden').css({opacity:0});
		});
	};/* End the Plugin */

	var Reset = function(form){
		var sel;
		$('.dsUIWrapper select', form).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; $('.dsUISelectWrapper ul', $(this).parent()).each(function(){  $('a:eq(0)', this).click();});});
		$('.dsUIWrapper select', form).each(function(){sel = (this.selectedIndex<0) ? 0 : this.selectedIndex; $('.dsUIMultipleSelectWrapper ul li', $(this).parent()).each(function(){

			if ($('a:first', this).hasClass('selected'))
				$('a:first', this).click();

		});});
		$('a.dsUICheckbox, a.dsUIRadio', form).removeClass('dsUIChecked');
		$('input:checkbox, input:radio', form).each(function(){if(this.checked){$('a', $(this).parent()).addClass('dsUIChecked');}});
	};

	var RadioAdd = function(){
		var $input = $(this).addClass('dsUIHidden').wrap('<span class="jRadioWrapper dsUIWrapper"></span>');
		var $wrapper = $input.parent();
		var $a = $('<span class="dsUIRadio"></span>');
		$wrapper.prepend($a);
		/* Click Handler */
		$a.click(function(){
			var $input = $(this).addClass('dsUIChecked').siblings('input');
			$input.click();

			/* uncheck all others of same name */
			$('input:radio[name="'+ $input.attr('name') +'"]').not($input).each(function(i,element){
				$(element).attr('checked',false).siblings('.dsUIRadio').removeClass('dsUIChecked');
			});

			$input.attr('checked',true);

			return false;
		});

		$input.click(function(){
			if(this.checked){
				var $input = $(this).siblings('.dsUIRadio').addClass('dsUIChecked').end();
				// uncheck all others of same name
				$('input:radio[name="'+ $input.attr('name') +'"]').not($input).each(function(){
					$(this).attr('checked',false).siblings('.dsUIRadio').removeClass('dsUIChecked');
				});
			}
		}).focus(function(){ $a.addClass('dsUIFocus'); }).blur(function(){ $a.removeClass('dsUIFocus'); });

		/* set the default state */
		if (this.checked){ $a.addClass('dsUIChecked'); }
	};

	var CheckAdd = function(){
		var $input = $(this).addClass('dsUIHidden').wrap('<span class="dsUIWrapper"></span>');
		var $wrapper = $input.parent().append('<span class="dsUICheckbox"></span>');
		/* Click Handler */
		var $a = $wrapper.find('.dsUICheckbox').click(function(){
			var $a = $(this);
			var input = $a.siblings('input')[0];
			if (input.checked===true){
				input.checked = false;
				$a.removeClass('dsUIChecked');
			}
			else {
				input.checked = true;
				$a.addClass('dsUIChecked');
			}
			return false;
		});
		$input.click(function(){
			if(this.checked){ $a.addClass('dsUIChecked'); 	}
			else { $a.removeClass('dsUIChecked'); }
		}).focus(function(){ $a.addClass('dsUIFocus'); }).blur(function(){ $a.removeClass('dsUIFocus'); });

		/* set the default state */
		if (this.checked){$('.dsUICheckbox', $wrapper).addClass('dsUIChecked');}
	};

	var TextAdd = function(){
		var $input = $(this).addClass('dsUIInput').wrap('<div class="dsUIInputWrapper"><div class="dsUIInputInner"></div></div>');
		var $wrapper = $input.parents('.dsUIInputWrapper');
		$input.focus(function(){
			$wrapper.addClass('dsUIInputWrapper_hover');
		}).blur(function(){
				$wrapper.removeClass('dsUIInputWrapper_hover');
			});
	};

	var ButtonAdd = function(){
		var value = $(this).attr('value');
		$(this).replaceWith('<input id="'+ this.id +'" name="'+ this.name +'" type="'+ this.type +'" class="'+ this.className +'" value="'+ value +'">');
	};

	/* Hide all open selects */
	var SelectHide = function(){
		$('.dsUISelectWrapper ul:visible').hide();
	};

	/* Check for an external click */
	var checkExternalClick = function(event) {
		if ($(event.target).parents('.dsUISelectWrapper').length === 0) {  SelectHide(); }
	};

	var SelectAdd = function(element, index){
		var $select = $(element);
		index = index || $select.css('zIndex')*1;
		index = (index) ? index : 0;
		/* First thing we do is Wrap it */
		$select.wrap($('<div class="dsUIWrapper"></div>').css({zIndex: 100-index}));
		var width = $select.width();
		$select.addClass('dsUIHidden').after('<div class="dsUISelectWrapper"><div><span class="dsUISelectText"></span><span class="dsUISelectOpen"></span></div><ul></ul></div>');
		var $wrapper = $(element).siblings('.dsUISelectWrapper').css({width: width +'px'});

		$('.dsUISelectText', $wrapper).width( width - $('.dsUISelectOpen', $wrapper).width());

		/* Now we add the options */
		SelectUpdate(element);
		/* Apply the click handler to the Open */
		$('div', $wrapper).click(function(){
			var $ul = $(this).siblings('ul');
			$ul.css({width: width-2 +'px'});
			if ($ul.css('display')=='none'){ SelectHide(); } /* Check if box is already open to still allow toggle, but close all other selects */
			$ul.slideToggle('fast');
			var offSet = ($('a.selected', $ul).offset().top - $ul.offset().top);
			$ul.animate({scrollTop: offSet});
			return false;
		});
		/* Add the key listener */
		$select.keydown(function(e){
			var selectedIndex = this.selectedIndex;
			switch(e.keyCode){
				case 40: /* Down */
					if (selectedIndex < this.options.length - 1){ selectedIndex+=1; }
					break;
				case 38: /* Up */
					if (selectedIndex > 0){ selectedIndex-=1; }
					break;
				default:
					return;
					break;
			}
			$('ul a', $wrapper).removeClass('selected').eq(selectedIndex).addClass('selected');
			$('span:eq(0)', $wrapper).html($('option:eq('+ selectedIndex +')', $select).attr('selected', 'selected').text());
			return false;
		}).focus(function(){ $wrapper.addClass('dsUIFocus'); }).blur(function(){ $wrapper.removeClass('dsUIFocus'); });
	};

	var MultipleSelectAdd = function(element, index){
		var $select = $(element);
		var size = parseInt($select.attr('size'));
		index = index || $select.css('zIndex')*1;
		index = (index) ? index : 0;
		/* First thing we do is Wrap it */
		$select.wrap($('<div class="dsUIWrapper"></div>').css({zIndex: 100-index}));
		var width = $select.width();
		$select.addClass('dsUIHidden').after('<div class="dsUIMultipleSelectWrapper"><div><span class="dsUISelectText"></span><span class="dsUISelectOpen"></span></div><ul></ul></div>');
		var $wrapper = $(element).siblings('.dsUIMultipleSelectWrapper').css({width: width +'px'});

		$('.dsUISelectText', $wrapper).width( width - $('.dsUISelectOpen', $wrapper).width());

		/* Now we add the options */

		MultipleSelectUpdate(element);
		/* Add the key listener */
		$select.keydown(function(e){
			var selectedIndex = this.selectedIndex;
			switch(e.keyCode){
				case 40: /* Down */
					if (selectedIndex < this.options.length - 1){ selectedIndex+=1; }
					break;
				case 38: /* Up */
					if (selectedIndex > 0){ selectedIndex-=1; }
					break;
				default:
					return;
					break;
			}
			$('ul a', $wrapper).removeClass('selected').eq(selectedIndex).addClass('selected');
			$('span:eq(0)', $wrapper).html($('option:eq('+ selectedIndex +')', $select).attr('selected', 'selected').text());
			return false;
		}).focus(function(){ $wrapper.addClass('dsUIFocus'); }).blur(function(){ $wrapper.removeClass('dsUIFocus'); });
	};

	var MultipleSelectUpdate = function(element){
		var $select = $(element);
		var $wrapper = $select.siblings('.dsUIMultipleSelectWrapper');
		var $ul = $wrapper.find('ul').find('li').remove().end().show();

		$('option', $select).each(function(i){

			if($('option:eq('+i+')',$select).attr('selected'))
				$ul.append('<li><a href="#" index="'+ i +'" class="selected">'+ this.text +'</a></li>');
			else
				$ul.append('<li><a href="#" index="'+ i +'">'+ this.text +'</a></li>');
		});
		/* Add click handler to the a */

		$ul.find('a').click(function(){
			//$('a.selected', $wrapper).removeClass('selected');
			if ($(this).hasClass('selected'))
			{
				$(this).removeClass('selected');
			}
			else
				$(this).addClass('selected');
			/// we make the select in the input also true
			$('option:eq('+$(this).attr('index')+')',$select).attr('selected',true);

			if($(this).attr('index') == 0)
				$('span:eq(0)', $wrapper).html($(this).html());
			return false;
		});
		/* Set the defalut */
		$('a:eq(0)', $ul).click();
	};


	var SelectUpdate = function(element){
		var $select = $(element);
		var $wrapper = $select.siblings('.dsUISelectWrapper');
		var $ul = $wrapper.find('ul').find('li').remove().end().hide();
		$('option', $select).each(function(i){
			$ul.append('<li><a href="#" index="'+ i +'">'+ this.text +'</a></li>');
		});

		/* Add click handler to the a */
		$ul.find('a').click(function(){
			$('a.selected', $wrapper).removeClass('selected');
			$(this).addClass('selected');
			/* Fire the onchange event */
			if ($select[0].selectedIndex != $(this).attr('index') && $select[0].onchange) { $select[0].selectedIndex = $(this).attr('index'); $select[0].onchange(); }
			$select[0].selectedIndex = $(this).attr('index');
			$('span:eq(0)', $wrapper).html($(this).html());
			$ul.hide();
			return false;
		});
		/* Set the defalut */
		$('a:eq('+ $select[0].selectedIndex +')', $ul).click();
	};

	var SelectRemove = function(element){
		var zIndex = $(element).siblings('.dsUISelectWrapper').css('zIndex');
		$(element).css({zIndex: zIndex}).removeClass('dsUIHidden');
		$(element).siblings('.dsUISelectWrapper').remove();
	};

	/* Utilities */
	$.dsUI = {
		SelectAdd : function(element, index){ 	SelectAdd(element, index); },
		MultipleSelectAdd : function(element, index){ 	MultipleSelectAdd(element, index); },
		MultipleSelectUpdate : function(element){ MultipleSelectUpdate(element); },
		SelectRemove : function(element){ SelectRemove(element); },
		SelectUpdate : function(element){ SelectUpdate(element); },
		Reset : function(element) { Reset(element);}
	};/* End Utilities */
	/* Automatically apply to any forms with class dsUI */
	$(function(){$('form.dsUI').dsUI();});
 })(jQuery);
