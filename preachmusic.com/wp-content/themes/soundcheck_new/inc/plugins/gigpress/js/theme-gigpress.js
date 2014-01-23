(function($) {

	/** 
	 * Scroll Animation
	 *
	 */
	$( ".scroll" ).click( function( event ){
		//prevent the default action for the click event
		event.preventDefault();

		//get the full url - like mysitecom/index.htm#home
		var full_url = this.href;

		//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
		var parts = full_url.split( "#" );
		var trgt = parts[1];

		//get the top offset of the target anchor
		var target_offset = $( "#" + trgt ).offset();
		var target_top = target_offset.top;

		//goto that anchor by setting the body scroll top to anchor top
		$('html, body').animate({
			scrollTop: target_top
		}, 500);
	});	
	
	
	/** 
	 * Formats & Styles
	 *
	 */
	// GigPress
	$('.gigpress-tickets-link, .gigpress-sidebar-more a').addClass( 'button');
	$('.gigpress-header').append( '<th scope="col" class="gigpress-details">Details</th>');
	$('.gigpress-heading').attr( 'colspan', '5');
	$('.gigpress-info .description').attr( 'colspan', '4');
	$('.vevent .gigpress-row').append( '<td class="gigpress-info-trigger"><a href="#">More +</a></td>' );
	$('.gigpress-info-trigger a').click( function() {
		$( this ).parent().parent().next().fadeToggle();
		return false;
	})
	
})(window.jQuery);
