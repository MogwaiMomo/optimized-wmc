jQuery(document).ready(

	function() {
		var url = window.location.href;
		url = url.replace('indie-signup/', '');
		url = url.replace('teams/', '');

		var element = "<div class='credit_card'><img src='" + url + "wp-content/uploads/2015/05/us_credit_cards.png' alt='us credit card icons'></div>"
		
		jQuery("#rcp-stripe-fields > p").append(element);
		
		jQuery( ".discount-link" ).click(function() {
	  		jQuery( ".rcp_discount_code" ).toggleClass( "hide" );
		});

	}
);
