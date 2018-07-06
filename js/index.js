



/*
   Check to see if the passwords entered in the input boxes are matching 
*/
  function checkPasswords(input) {
	if (input.value != document.getElementById('newPassword').value) {
		input.setCustomValidity('Passwords Must Match.');
	} else {
		// input is valid -- reset the error message
		input.setCustomValidity('');
	}
}


/* 

  These functions handle the clicking and scrolling feature that is seen when you click 
  either the Login or Register buttons on the intial login page. 

*/ 
$(document).ready(function () {
	$('#login-form-link').click(function(e) {
		if ($("#register-form-link").hasClass("active")) {
			$("#login-form").toggle(900).fadeIn(600);
			$("#register-form").fadeOut(600);
			$('#register-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		}

	});

	$('#register-form-link').click(function(e) {
		if ($("#login-form-link").hasClass("active")) {
			$("#register-form").toggle(900).fadeIn(600);
			$("#login-form").fadeOut(600);
			$('#login-form-link').removeClass('active');
			$(this).addClass('active');
			e.preventDefault();
		} 
	});

});
