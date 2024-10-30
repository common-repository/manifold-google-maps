(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
	 $(document).ready(function(){
	 	 $('.term-type-wrap input[type="radio"]').change(function() {
	 	 	var selectedType = this.value;
		    $('.map-placeholder').hide();
		    if ($(this).prop('checked')) {
		     $('#'+selectedType).fadeIn();
		   }else{  
		      $('#'+selectedType).fadeOut();
		   }
		});
	 	$('.term-theme-wrap input[type="radio"]').change(function() {
	 	 	var selectedType = this.value;
		    $('.theme-placeholder').hide();
		    if ($(this).prop('checked')) {
		     $('#'+selectedType).fadeIn();
		   }else{  
		      $('#'+selectedType).fadeOut();
		   }
		});

	 	$(".map-submit-button .button").attr("disabled","disabled");

		$('#manifold_google_maps_googlekey').blur(function(){
			var key = manifold_google_maps_admin_js.manifold_google_maps_key;
	    	var request = 'https://maps.googleapis.com/maps/api/geocode/json?address=Ahmedabad&key=' + this.value;
			$.get(request, function(data) {
				console.log(data);
				$(".errormsg").remove();
				if(typeof(data.error_message) !== "undefined"){
					
					var error_msg = get_url_from_string(data.error_message);
					if(error_msg == "API keys with referer restrictions cannot be used with this API."){
						error_msg = error_msg+' For geocode API, create a separate API key and restrict that API using the IP address. <a href="https://developers.google.com/maps/faq#switch-key-type" target="_blank">More info</a>'
					}

					
					$("#manifold_google_maps_googlekey").after('<p class="errormsg">'+error_msg+'</p>');
				} else{
					$(".map-submit-button .button").removeAttr('disabled');
				}
			})
			.error(function() {
			    alert("error");
			})
		});

		$(".map-placeholder a[rel^='prettyPhoto']").prettyPhoto({
			animation_speed:'normal',
			theme:'light_square',
			slideshow:3000, 
			social_tools:false,
			deeplinking:false,
			autoplay_slideshow: false
		});
	});

	function get_url_from_string(str) {
		var res = str.split(" ");
		console.log(res);
		$(res).each(function( index ) {
			if(res[index].indexOf('https') != -1 || res[index].indexOf('http') != -1){
		    	console.log(res[index]);
		    	res[index] = '<a href="'+res[index]+'" target="_blank">'+res[index]+'</a>';

			}
		});
		return res.join(" ");
		
	}

	var searchInput = 'manifold-google-maps-address';

	$(document).ready(function () {

	    var autocomplete;
	    autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
	        types: ['geocode']
	       
	    });

	    google.maps.event.addListener(autocomplete, 'place_changed', function () {
	        var near_place = autocomplete.getPlace();
			$('#manifold-google-maps-lat').val(near_place.geometry.location.lat);
			$('#manifold-google-maps-long').val(near_place.geometry.location.lng);
	    });


	    jQuery('#publish').click(function() {
	    	var cats = jQuery('[id^="taxonomy-map"]').find('.selectit').find('input');
	    	var category_selected = false;
		    var counter;
		    for (counter=0; counter<cats.length; counter++){
		        if (cats.get(counter).checked==true) 
		        {
		            category_selected=true;
		            break;
		        }
		    }
		    if(category_selected==false) {
		      alert('You have not selected any maps for the location. Please select map category.');
		      setTimeout("jQuery('#ajax-loading').css('visibility', 'hidden');", 100);
		      jQuery('[id^="taxonomy"]').find('.tabs-panel').css('background', '#F96');
		      setTimeout("jQuery('#publish').removeClass('button-primary-disabled');", 100);
		      return false;
		    }
  		});
	});
})( jQuery );


function copyshortcodetext(InputID){
	var copyText = document.getElementById(InputID);
	/* Select the text field */
	copyText.select();
	copyText.setSelectionRange(0, 99999); /* For mobile devices */
	/* Copy the text inside the text field */
	document.execCommand("copy");
}


