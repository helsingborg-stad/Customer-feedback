var CustomerFeedback = {};

CustomerFeedback.Form = CustomerFeedback.Form || {};
CustomerFeedback.Form = (function ($) {

    function Form() {
        this.handleEvents();
    }

    Form.prototype.handleEvents = function () {
        // Yes or no click
        $('[data-action="customer-feedback-submit-response"]').on('click', function (e) {
            e.preventDefault();

            $target = $(e.target).parents('.customer-feedback-container');
            $(e.target).html('<i class="spinner spinner-dark"></i>');

            var responsePostId = $target.find('[name="customer-feedback-post-id"]').val();
            var responseValue = $(e.target).val();

            this.submitInitialResponse($target, responsePostId, responseValue);
        }.bind(this));

        // Comment submit click
        $('[data-action="customer-feedback-submit-comment"]').on('click', function (e) {
            e.preventDefault();

            $target = $(e.target).parents('.customer-feedback-container');
            $target.find('[name="customer-feedback-comment-text"]').removeClass('invalid');
            $target.find('div.danger').remove();

            var commentType = 'comment';
            var answerId = $target.find('[name="customer-feedback-answer-id"]').val();
            var postId = $target.find('[name="customer-feedback-post-id"]').val();
            var comment = $target.find('[name="customer-feedback-comment-text"]').val();
            var gCaptcha = $target.find('[name="g-recaptcha-response"]').val();
            var email = $target.find('[name="customer-feedback-comment-email"]').val();
            var emailRequired = $target.find('[name="customer-feedback-comment-email"]').prop('required');
            var topic = $target.find('[name="customer-feedback-comment-topic"]').val();

            if (comment.length < 15) {
                $target.find('[name="customer-feedback-comment-text"]').addClass('invalid');
                $target.find('[name="customer-feedback-comment-text"]').after('<div class="clearfix"></div><div style="margin-top: 5px;" class="notice notice-sm danger">' + feedback.comment_min_characters + '</div>');
                return false;
            }

            if (email.length === 0 && emailRequired == true) {
                return false;
            }

            $(e.target).html('<i class="spinner spinner-dark"></i>');
            this.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);

        }.bind(this));

        $('[name="customer-feedback-comment-topic"]').change(function(e) {
            $target = $(e.target).parents('.customer-feedback-container');

            if ($(e.target).val()) {
                $(e.target).parents('.form-group').siblings().show();
                $selected = $(e.target).find('option:selected');
                $target.find('.topic-description').show().html($selected.attr('topic-description'));

                if ($selected.attr('feedback-capability')) {
                    $target.find('[name="customer-feedback-comment-email"]')
                        .prop('required', true)
                            .parent().show();
                } else {
                    $target.find('[name="customer-feedback-comment-email"]')
                        .prop('required', false)
                            .parent().hide();
                }
            } else {
                $(e.target).parents('.form-group').siblings().hide();
            }
        });
    };

    Form.prototype.submitComment = function (target, answerId, postId, commentType, comment, email, gCaptcha, topic) {
        var data = {
            action: 'submit_comment',
            postid: postId,
            comment: comment,
            answerid: answerId,
            commenttype: commentType,
            email: email,
            captcha: gCaptcha,
            topicid: topic
        };

        var $target = target;

        $.post(ajaxurl, data, function (response) {
            if (response == 'true') {
                $target.find('.customer-feedback-comment').remove();
                $target.find('.customer-feedback-thanks').show();
            } else {
                $target.find('.customer-feedback-comment').remove();
                $target.find('.customer-feedback-error').show();
            }
        });
    };

    /**
     * Submits the initail yes or no response
     * @param  {integer} postId Post id
     * @param  {string}  answer Yes or no
     * @return {void}
     */
    Form.prototype.submitInitialResponse = function (target, postId, answer) {
        var $target = target;

        var data = {
            action: 'submit_response',
            postid: postId,
            answer: answer
        };

        $.post(ajaxurl, data, function (response) {
            if (data.answer == 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {
                $target.find('[name="customer-feedback-comment-topic"]').parent().hide();
                $target.find('[name="customer-feedback-comment-email"]').parent().hide();
                $target.find('[name="customer-feedback-post-id"]').after('<input type="hidden" name="customer-feedback-answer-id" value="' + response + '">');
                $target.find('.customer-feedback-answers').remove();
                $target.find('.customer-feedback-comment').show().find('.feedback-label-yes').show();
            }

            if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {
                $target.find('[name="customer-feedback-comment-topic"]').trigger('change');
                $target.find('[name="customer-feedback-post-id"]').after('<input type="hidden" name="customer-feedback-answer-id" value="' + response + '">');
                $target.find('.customer-feedback-answers').remove();
                $target.find('.customer-feedback-comment').show().find('.feedback-label-no').show();
            }
        });
    };

    return new Form();

})(jQuery);
