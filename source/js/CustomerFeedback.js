var CustomerFeedback = {};

var CaptchaCallback = function() {
    if(!feedback.site_key) {
        return;
    }
    jQuery('.g-recaptcha').each(function(index, el) {
        grecaptcha.render(el, {'sitekey' : feedback.site_key});
    });
};
