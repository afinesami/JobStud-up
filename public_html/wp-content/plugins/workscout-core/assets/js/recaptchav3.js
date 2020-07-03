	/* ----------------- Start Document ----------------- */
(function($) {


   	window.getRecaptcha = function() {
    grecaptcha.ready(function() {
        grecaptcha.execute(workscout_core.recaptcha_sitekey3, {action: 'login'}).then(function(token) {
            $('.register.workscout_form #token').val(token);
        });
    });
	}
	

// ------------------ End Document ------------------ //


})(jQuery);