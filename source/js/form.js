export default () => {

    function Form() {
        this.handleEvents();
    }

    

    Form.prototype.submitComment = function (target, answerId, postId, commentType, comment, email, gCaptcha, topic) {
       
        let data = {
            action: 'submit_comment',
            postid: postId,
            comment: comment,
            answerid: answerId,
            commenttype: commentType,
            email: email,
            captcha: gCaptcha,
            topicid: topic
        };

        let $target = target;

        $.post(ajaxurl, data, function (response) {
            if (response == 'true') {
                document.querySelector('.customer-feedback-comment').classList.display = 'none';
                document.querySelector('.customer-feedback-thanks').classList.display = 'block';
            } else {
                document.querySelector('.customer-feedback-comment').classList.display = 'none';
                document.querySelector('.customer-feedback-error').classList.display = 'block';
            } 
        });
    }; 

    /**
     * Submits the initail yes or no response
     * @param  {integer} postId Post id
     * @param  {string}  answer Yes or no
     * @return {void}w
     */
    Form.prototype.submitInitialResponse = function (target, postId, answer) {
    
        let data = {
            action: 'submit_response',
            postid: postId, 
            answer: answer
        };

        $.post(ajaxurl, data, function(response) {

            //Status
            if(response.status != 200) {
                document.querySelector('.customer-feedback-js-error').style.display = "block"; 
            }

            if (!isNaN(parseFloat(response)) && isFinite(response)) {

                //Create id holder
                let feedBackIdElement = document.createElement("input"); 
                    feedBackIdElement.type = "hidden"
                    feedBackIdElement.name = "customer-feedback-answer-id"; 
                    feedBackIdElement.value = response;

                document.querySelector('[name="customer-feedback-post-id"]').parentElement.appendChild(feedBackIdElement);

                //Hide current controls 
                document.querySelector('.customer-feedback-topics').style.display = "none";
                document.querySelector('.customer-feedback-comment-email').parentElement.style.display = "none"; 
                document.querySelector('.customer-feedback-answers').style.display = "none";

                //Show comment section
                document.querySelector('.customer-feedback-comment').style.display = "block"; 
            }

            if (data.answer == 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {
                document.querySelector('.feedback-label-yes').style.display = "block";
            }

            if (data.answer == 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {
                document.querySelector('.feedback-label-no').style.display = "block";
            }

        });
    };

    Form.prototype.handleEvents = function () {

        let answerButton = document.querySelectorAll('[data-action=customer-feedback-submit-response]'); 
        let self = this;

        answerButton.forEach(optionButton => {
            optionButton.addEventListener('click', function(e) {

                //Prevent default action
                e.preventDefault();
                
                //Set pressed event
                this.setAttribute("aria-pressed", true);

                //Get submission id
                let FeedBackID = document.getElementById("customer-feedback-post-id").value; 

                //Get submission answer
                let Answer = this.getAttribute('value'); 

                //Submit answer
                self.submitInitialResponse(this, FeedBackID, Answer);

            });
        });

        // Comment submit click
        let submitButton = document.querySelectorAll('[data-action=customer-feedback-submit-comment]'); 

        submitButton.forEach(Submit => {
            Submit.addEventListener('click', function(e) {
                
                e.preventDefault();

                //Target div 
                let $target = document.getElementById('customer-feedback');

                //Reset state
                $target.querySelector('[name="customer-feedback-comment-text"]').setAttribute('aria-invalid', false);

                //Get vars 
                let commentType = 'comment';
                let topic = null; 
                let gCaptcha = null; 
                let answerId = $target.querySelector('[name="customer-feedback-answer-id"]').value;
                let postId = $target.querySelector('[name="customer-feedback-post-id"]').value;
                let comment = $target.querySelector('[name="customer-feedback-comment-text"]').value;
                let email = $target.querySelector('[name="customer-feedback-comment-email"]').value;
                let emailRequired = $target.querySelector('[name="customer-feedback-comment-email"]').getAttribute('required');
                let valid = true;

                //Topic
                if(typeof $target.querySelector('[name="customer-feedback-comment-topic"]:checked') !== 'undefined') {
                    //topic = $target.querySelector('[name="customer-feedback-comment-topic"]:checked').value;
                }
                //Get captcha if not logged in
                if(typeof $target.querySelector('[name="g-recaptcha-response"]') !== 'undefined') {
                    //gCaptcha = $target.querySelector('[name="g-recaptcha-response"]').value;
                }

                //Topics 
                /*if (!(window.getComputedStyle('customer-feedback-topics').display === "none") && !topic) {
                    //$target.querySelector('[name="customer-feedback-comment-topic"]:last').parentNode.insertAfter('<div class="clearfix"></div><div style="margin-top: 5px;" class="notice notice-sm danger">' + feedback.select_topic + '</div>');
                    //valid = false;
                } */ 

                //Check length
                if (comment.length < 15) {

                    let errorMessage = document.createElement('div');
                        errorMessage.id = 'length-error';
                        errorMessage.classList = 'c-textarea-invalid-message'; 
                        errorMessage.style.display = 'block'; 
                        errorMessage.appendChild(
                            document.createTextNode(feedback.comment_min_characters)
                        );  

                    $target.querySelector('[name="customer-feedback-comment-text"]').setAttribute('aria-invalid', true);
                    $target.querySelector('[name="customer-feedback-comment-text"]').after(errorMessage);

                    valid = false;

                }

                //Check email if exists 
                if (email.length === 0 && emailRequired == true) {
                    valid = false;
                }

                //Rurn if not valid, else continitue. 
                if (!valid) {
                    return false;
                }

                //Spin
                //$(e.target).innerHtml('<i class="spinner spinner-dark"></i>');
                
                //Submit
                self.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);

            }); 
        });

    };


    /* 
        $('[name="customer-feedback-comment-topic"]').change(function(e) {
            $target = $(e.target).parents('.customer-feedback-container');
            $target.find('div.customer-feedback-topics div.danger').remove();

            if ($(e.target).attr('topic-description')) {
                $target.find('.topic-description').show().html('<span class="text-sm">' + $(e.target).attr('topic-description') + '</span>');
            } else {
                $target.find('.topic-description').hide();
            }

            if ($(e.target).attr('feedback-capability')) {
                $target.find('[name="customer-feedback-comment-email"]')
                    .prop('required', true)
                        .parent().show();
            } else {
                $target.find('[name="customer-feedback-comment-email"]')
                    .prop('required', false)
                        .parent().hide();
            }
        });
    };    */

    return new Form();

}
