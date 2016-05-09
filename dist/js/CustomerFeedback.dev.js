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

            $(e.target).html('<i class="fa fa-spinner fa-spin"></i>');

            var responsePostId = $('#customer-feedback-post-id').val();
            var responseValue = $(e.target).val();

            this.submitInitialResponse(responsePostId, responseValue);
        }.bind(this));

        // Comment submit click
        $('[data-action="customer-feedback-submit-comment"]').on('click', function (e) {
            e.preventDefault();

            $('#customer-feedback-comment-text').removeClass('invalid');

            var commentType = 'comment';
            var answerId = $('#customer-feedback-answer-id').val();
            var postId = $('#customer-feedback-post-id').val();
            var comment = $('#customer-feedback-comment-text').val();

            if (comment.length === 0) {
                $('#customer-feedback-comment-text').addClass('invalid');
                $('#customer-feedback-comment-text').after('<div class="clearfix"></div><div style="margin-top: 5px;" class="notice notice-sm danger">You need to write a comment before posting it.</div>');
                return false;
            }

            this.submitComment(answerId, postId, commentType, comment);

        }.bind(this));
    };

    Form.prototype.submitComment = function (answerId, postId, commentType, comment) {
        var data = {
            action: 'submit_comment',
            postid: postId,
            comment: comment,
            answerid: answerId,
            commenttype: commentType
        };

        $.post(ajaxurl, data, function (response) {
            if (response == 'true') {
                $('#customer-feedback-comment').remove();
                $('#customer-feedback-thanks').show();
            }
        });
    };

    /**
     * Submits the initail yes or no response
     * @param  {integer} postId Post id
     * @param  {string}  answer Yes or no
     * @return {void}
     */
    Form.prototype.submitInitialResponse = function (postId, answer) {
        var data = {
            action: 'submit_response',
            postid: postId,
            answer: answer
        };

        $.post(ajaxurl, data, function (response) {
            if (data.answer == 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {
                $('#customer-feedback-answers').hide();
                $('#customer-feedback-thanks').show();
            }

            if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {
                $('#customer-feedback-post-id').after('<input type="hidden" id="customer-feedback-answer-id" value="' + response + '">');

                $('#customer-feedback-answers').remove();
                $('#customer-feedback-comment').show();
            }
        });
    };

    return new Form();

})(jQuery);
