var CustomerFeedbackChat = {};

CustomerFeedbackChat.Form = CustomerFeedbackChat.Form || {};
CustomerFeedbackChat.Form = (function ($) {

    function Form() {
        this.handleEvents();
    }

    Form.prototype.handleEvents = function () {
        // Yes or no click
        $('[data-action="customer-feedback-chat-submit-response"]').on('click', function (e) {
            e.preventDefault();

            $(e.target).html('<i class="fa fa-spinner fa-spin"></i>');

            var responsePostId = $('#customer-feedback-chat-post-id').val();
            var responseValue = $(e.target).val();

            this.submitInitialResponse(responsePostId, responseValue);
        }.bind(this));

        // Comment submit click
        $('[data-action="customer-feedback-chat-submit-comment"]').on('click', function (e) {
            e.preventDefault();

            $('#customer-feedback-chat-comment-text').removeClass('invalid');

            var commentType = 'comment';
            var answerId = $('#customer-feedback-chat-answer-id').val();
            var postId = $('#customer-feedback-chat-post-id').val();
            var comment = $('#customer-feedback-chat-comment-text').val();

            if (comment.length === 0) {
                $('#customer-feedback-chat-comment-text').addClass('invalid');
                $('#customer-feedback-chat-comment-text').after('<div class="clearfix"></div><div style="margin-top: 5px;" class="notice notice-sm danger">You need to write a comment before posting it.</div>');
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
                $('#customer-feedback-chat-comment').remove();
                $('#customer-feedback-chat-thanks').show();
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
                $('#customer-feedback-chat-answers').hide();
                $('#customer-feedback-chat-thanks').show();
            }

            if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {
                $('#customer-feedback-chat-post-id').after('<input type="hidden" id="customer-feedback-chat-answer-id" value="' + response + '">');

                $('#customer-feedback-chat-answers').remove();
                $('#customer-feedback-chat-comment').show();
            }
        });
    };

    return new Form();

})(jQuery);
