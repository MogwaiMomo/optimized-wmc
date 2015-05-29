jQuery(document).ready(

	function() {
		jQuery("#rcp-stripe-fields > p").append("<div class='credit_card'><img src='http://localhost:8888/watchmecode/wp-content/uploads/2015/05/us_credit_cards.png' alt='us credit card icons'></div>");

		jQuery( ".discount-link" ).click(function() {
	  		jQuery( ".rcp_discount_code" ).toggleClass( "hide" );
		});
	}
);



