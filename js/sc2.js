
var Sc2 = {

	/**
	 * Display or hide the video.
	 */
	toggleInterceptVideo: function() {
		$("#video, #play-trailer").toggle();

		Blackout.show(null, function() {
			$(this).hide();
			$("#video, #play-trailer").toggle();
		});

		return false;
	},

	/**
	 * Holds the showcase timer.
	 */
	showcase: null,

	/**
	 * Automatically rotate the showcase.
	 */
	beginShowcaseRotation: function() {
		window.clearTimeout(Sc2.showcase);

		Sc2.showcase = window.setTimeout(function() {
			Sc2.rotateShowcase(1);
		}, 5500);
	},

	/**
	 * Rotate between the showcased achievements.
	 *
	 * @param object node
	 * @param int direction
	 */
	rotateShowcase: function(direction) {
		Sc2.beginShowcaseRotation();

		var wrapper = $('#showcase-wrapper .showcase-tile');
		var index 	= $('#showcase-wrapper .showcase-tile:visible').index();
		var length	= wrapper.length - 1;

		index += direction;

		if (index < 0) {
			index = length;
		} else if (index > length) {
			index = 0;
		}

		wrapper.fadeOut();
		wrapper.eq(index).fadeIn();

		return false;
	},

	/**
	 * Open up an achievements additional content.
	 *
	 * @param string target
	 * @param object node
	 */
	openAchievement: function(target, node) {
		target = $('#'+ target);
		node = $(node);
		var expander = $('.series-expander', node);

		if (target.is(':visible')) {
			target.hide();
			node.removeClass('opened');
			expander.removeClass('minus').addClass('plus');

		} else {
			target.show();
			node.addClass('opened');
			expander.removeClass('plus').addClass('minus');
		}
	},

	/**
	 * Display or hide content based on filter settings.
	 *
	 * @param string wrapper
	 * @param string baseClass
	 * @param string targetClass
	 */
	filterContent: function(wrapper, baseClass, targetClass) {
		if (targetClass == 'all')
			targetClass = false;

		if (targetClass) {
			$(wrapper +" ."+ baseClass).hide();
			$(wrapper +" ."+ targetClass).show();
		} else {
			$(wrapper +" ."+ baseClass).show();
		}
	},

	/**
	 * Make a rollover effect for a div link.
	 * Should use .button-rollover class name for this function setting.
	 */
	initRolloverEffect: function() {
		$('.button-rollover')
			.mouseover(function() {
				$(this).addClass('rollover-on');
			})
			.mouseout(function() {
				$(this).removeClass('rollover-on');
			});
	},

	/**
	 * Switch between the alternate modes in the unit viewer.
	 *
	 * @param string tab
	 * @param string mode
	 */
	switchUnitMode: function(tab, mode) {
		if (!$(tab).parent().hasClass('ui-tabs-selected')) {
			var holo = $(".unit-holography");
			var active = holo.find(".model:visible");

			active.hide();
			active.siblings('.model').fadeIn(1000);
		}
	}

}

/*
 * Temporarily fixes the ratings images for the ko_KR region in the Heart of the
 * Swarm Digital Deluxe and Collector's Edition Pre-sales pages
 */
function overwriteLegalImage(region, locale) {
	if (location.pathname == '/sc2/' + region + '/buy-now/digital-deluxe' || location.pathname == '/sc2/' + region + '/buy-now/collectors-edition') {
		$('.legal-image').attr('src', '/sc2/static/local-common/images/legal/'+ locale + '/sc2-hots.png');		
	}
}
overwriteLegalImage('ko', 'kr');