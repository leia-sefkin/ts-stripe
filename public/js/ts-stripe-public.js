//initiate stripe with API key
var stripe = Stripe(stripe_vars.publishable_key);
// Create an instance of Elements.
var elements = stripe.elements();

//Stripe styling for the card element
var style = {
  base: {
    color: '#32325d',
    lineHeight: '18px',
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: 'antialiased',
    fontSize: '16px',
    '::placeholder': {
      color: '#aab7c4'
    }
  },
  invalid: {
    color: '#fa755a',
    iconColor: '#fa755a'
  }
};

function stripeTokenHandler(token) {
  // Insert the token ID into the form so it gets submitted to the server
  var form = document.getElementById('stripe_payment_form');
  var tokenInput = document.createElement('input');
  tokenInput.setAttribute('type', 'hidden');
  tokenInput.setAttribute('name', 'stripe_token');
  tokenInput.setAttribute('value', token.id);

  var cardInput = document.createElement('input');
  cardInput.setAttribute('type', 'hidden');
  cardInput.setAttribute('name', 'stripe_card_last4');
  cardInput.setAttribute('value', token.card.last4);

  form.appendChild(tokenInput);
  form.appendChild(cardInput);
  // Submit the form
  form.submit();
}

jQuery(document).ready(function($) {

	// Create an instance of the card Element.
	var card = elements.create('card', {style: style});
	// Add an instance of the card Element into the `card-element` <div>.
	card.mount('#card_element');

	// Handle real-time validation errors from the card Element.
	card.addEventListener('change', function(event) {
		var displayError = document.getElementById('card_errors');
		if (event.error) {
			displayError.textContent = event.error.message;
	  	} else {
	    	displayError.textContent = '';
	  	}
	});

	// Handle amount validation
	$('#amount').blur(function() {
		var amount = $('#amount').val();
		var minimum = stripe_vars.minimum_amount;

	  	// input type shouldn't allow for this, but just in case
		amount = amount.replace(/\$/g, '').replace(/\,/g, '');
		amount = parseFloat(amount);

		if (isNaN(amount)) {
	    	$('#amount_error').html('<p>Please enter a valid amount in USD ($).</p>');
	  	} 

	  	// if we have a minimum amount set and the amount entered is less than that
	  	else if (minimum && amount < minimum) {
	    	$('#amount_error').html('<p>Donation amount must be at least $' + minimum + '.</p>');
	    }
	  	
	  	else {
	  		$('#amount_error').html('');
	  	}
	});

	// Handle email validation
	$('#donor_email').blur(function() {
		var email = $('#donor_email').val();
	  	var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
	  
		if (!regex.test(email)) {
			$('#email_error').html('<p>Please enter a valid email address.</p>');
		}		
		else {
			$('#email_error').html('');
		}
	});
		
	// Create a token or display an error when the form is submitted.
	var form = document.getElementById('stripe_payment_form');
	
	form.addEventListener('submit', function(event) {
	  	event.preventDefault();

		stripe.createToken(card, {name: name}).then(function(result) {
			if (result.error) {
		  		// Inform the customer that there was an error.
		  		var errorElement = document.getElementById('card_errors');
		  		errorElement.textContent = result.error.message;
			} else {
		  		// Send the token to your server.
		  		stripeTokenHandler(result.token);
			}
		});
	
	});

});
