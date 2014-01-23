//jQuery.noConflict();

(function($) {

	/** 
	 * Animate down on subpages
	 *
	 */
	jQuery.fn.exists = function(){
		return $( this ).length > 0;
	}
	if( $( 'body:not(.home)' ).exists() ) {
		$( 'html, body' ).animate({ 
			scrollTop: 399 
		}, 500 );
	}
	
	
	
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
		$( 'html, body' ).animate({
			scrollTop: target_top
		}, 500);
	});	




	/** 
	 * Formats & Styles
	 *
	 */
	// GigPress
	$( '.gigpress-subscribe a' ).addClass( 'tooltip' ).attr( 'title', 'Subscribe' );
	$( '.gigpress-tickets-link' ).addClass( 'button' );
	$( '.gigpress-header' ).append( '<th scope="col" class="gigpress-details">Details</th>' );
	$( '.gigpress-heading' ).attr( 'colspan', '5' );
	$( '.gigpress-info .description' ).attr( 'colspan', '4' );
	$( '.vevent .gigpress-row' ).append( '<td class="gigpress-info-trigger"><a href="#">More +</a></td>' );
	$( '.gigpress-info-trigger a' ).click( function() {
		$( this ).parent().parent().next().fadeToggle();
		return false;
	})
	
	// Featured Thumbnail Images - Fade In/Out
	$( '.thumbnail-icon' ).hide();
	$( '.entry-thumbnail, .gallery-item' ).hover(function() {
		$( '.thumbnail-icon', this).fadeTo( "fast", 1 ).addClass( 'box-hover' );
	}, function() {
		$( '.thumbnail-icon', this ).fadeTo( "fast", 0 ).removeClass( 'box-hover' );
	});
	
	// Gallery / Fade
    $('.fade, .gallery-item a img').hover( function() {
      $( this ).fadeTo( "fast", 0.7 );
    }, function() {
      $( this ).fadeTo( "fast", 1 );
    });
	 	
	
	
	
	/**
	 * Tooltip
	 *	
	 * @link http://cssglobe.com/post/1695/easiest-tooltip-and-image-preview-using-jquery
	 */
	this.tooltip = function(){	

			xTooltipOffset = 25;
			yTooltipOffset = 5;		

		$("a.tooltip").hover(function(e){											  
			this.t = this.title;
			this.title = "";									  
			$("body").append("<p id='tooltip'>"+ this.t +"</p>");
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px")
				.fadeIn("fast");		
	    },
		function(){
			this.title = this.t;		
			$("#tooltip").remove();
	    });	
		$("a.tooltip").mousemove(function(e){
			$("#tooltip")
				.css("top",(e.pageY - xTooltipOffset) + "px")
				.css("left",(e.pageX + yTooltipOffset) + "px");
		});			
	};
	
	
	/**
	 * Audio Player Plugin Track Toggle/Display stuff
	 *	
	 */
	$('.single-discography .track-title').click( function() {
		$(this).nextAll('p').slideToggle();
	});
	
	$('.single-discography .all-track-previews-trigger').click( function(e) {
		e.preventDefault();
		
		var audioPlayerContainer = '.single-discography .audioplayer_container';
		
		if( $(this).hasClass('show-all-track-previews') ) {
			$.each( audioPlayerContainer, function( index, value ) {
				$(audioPlayerContainer).slideDown();
			});
			$(this).removeClass('show-all-track-previews').text('Hide Audio');
		} 
		else {
			$.each( audioPlayerContainer, function( index, value ) {
				$(audioPlayerContainer).slideUp();
			});
			$(this).addClass('show-all-track-previews').text('Show Audio');
		}
	});
	

	
})(window.jQuery);




jQuery(document).ready(function($) {

	/**
	 * Tooltip Init
	 *	
 	 */
	tooltip();
	
	
	/**
	 * Equal Height
	 *	
 	 */
	function sortNumber(a,b)    {
		return a - b;
	}
	
	function maxHeight() {
		var heights = new Array();
		
		$( '.post-gallery .entry' ).each( function(){
			$( this ).css( 'height', 'auto' );
			heights.push( $( this ).height() );
			heights = heights.sort( sortNumber ).reverse();
			$( this ).css( 'height', heights[0] );
		});        
	}
	
	maxHeight();
	
	$(window).resize(maxHeight);
	

});
