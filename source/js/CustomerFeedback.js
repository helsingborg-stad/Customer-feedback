var CustomerFeedback = {};

var CaptchaCallback = function() {
    jQuery('.g-recaptcha').each(function(index, el) {
        grecaptcha.render(el, {'sitekey' : feedback.site_key});
    });
};
