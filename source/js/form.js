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

            //Disable loader
            document.getElementById("feedback-loader").style.display = 'none';

            //Handle response
            if (response == 'true') {
                $target.querySelector('.customer-feedback-comment').style.display = 'none';
                $target.querySelector('.customer-feedback-thanks').style.display = 'block';
            } else {
                $target.querySelector('.customer-feedback-comment').style.display = 'none';
                $target.querySelector('.customer-feedback-error').style.display = 'block';
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

        document.getElementById("feedback-loader").style.display = 'block';

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
                //document.querySelector('.customer-feedback-topics').style.display = "none";
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

            //Loading done
            document.getElementById("feedback-loader").style.display = 'none'; 

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

                //Reset state (make fields valid attr)
                $target.querySelector('[name="customer-feedback-comment-text"]').setAttribute('aria-invalid', false);
                $target.querySelector('[name="customer-feedback-comment-topic"]').setAttribute('aria-invalid', false);
                $target.querySelector('[name="customer-feedback-comment-email"]').setAttribute('aria-invalid', false);

                //Reset state (remove messages)
                let errorMessages = $target.querySelectorAll('.feedback-form-dynamic-error'); 
                    errorMessages.forEach(errorMessage => {
                        errorMessage.remove(); 
                    }); 
                    
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
                if($target.querySelectorAll('[name="customer-feedback-comment-topic"]:checked').length == 1) {
                    topic = $target.querySelector('[name="customer-feedback-comment-topic"]:checked').value;
                } else {

                    //Create error node
                    let topicErrorMessage = document.createElement('div');
                        topicErrorMessage.id = 'topic-error';
                        topicErrorMessage.classList = 'c-option__input-invalid-message feedback-form-dynamic-error'; 
                        topicErrorMessage.style.display = 'block'; 
                        topicErrorMessage.appendChild(
                            document.createTextNode(feedback.select_topic)
                        );  

                    //Show invalid notice
                    $target.querySelector('[name="customer-feedback-comment-topic"]').setAttribute('aria-invalid', true);
                    $target.querySelector('.customer-feedback-topics .c-option.c-option__radio:last-child').after(topicErrorMessage);

                    //Prohibit submission
                    valid = false; 
                }

                //Get captcha if not logged in
                if($target.querySelector('[name="g-recaptcha-response"]').length && $target.querySelector('[name="g-recaptcha-response"]').value !== '') {
                //TODO: ERR    gCaptcha = $target.querySelector('[name="g-recaptcha-response"]').value;
                }

                //Check length
                if (comment.length < 15) {

                    //Create error node
                    let errorMessage = document.createElement('div');
                        errorMessage.id = 'length-error';
                        errorMessage.classList = 'c-textarea-invalid-message feedback-form-dynamic-error'; 
                        errorMessage.style.display = 'block'; 
                        errorMessage.appendChild(
                            document.createTextNode(feedback.comment_min_characters)
                        );  

                    //Show invalid notice
                    $target.querySelector('[name="customer-feedback-comment-text"]').setAttribute('aria-invalid', true);
                    $target.querySelector('[name="customer-feedback-comment-text"]').after(errorMessage);

                    //Prohibit submission
                    valid = false;
                }

                //Check email if exists 
                if (email.length === 0 && emailRequired == true) {

                    //Create error node
                    let errorMessage = document.createElement('div');
                        errorMessage.id = 'email-error';
                        errorMessage.classList = 'c-input-invalid-message feedback-form-dynamic-error'; 
                        errorMessage.style.display = 'block'; 
                        errorMessage.appendChild(
                            document.createTextNode(feedback.enter_email)
                        );  

                    //Show invalid notice
                    $target.querySelector('[name="customer-feedback-comment-email"]').setAttribute('aria-invalid', true);
                    $target.querySelector('[name="customer-feedback-comment-email"]').after(errorMessage);

                    //Prohibit submission
                    valid = false;

                }

                //Return if not valid, else continiue. 
                if (!valid) {
                    return false;
                }

                //Spin
                $target.getElementById("#feedback-loader").style.display = 'block'; 
                
                //Submit
                self.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);

            }); 
        });

    };


    // Comment submit click
    let topicListeners = document.querySelectorAll('[name="customer-feedback-comment-topic"]'); 

    topicListeners.forEach(topListener => {
        topListener.addEventListener('change', function(e) {

            let $target = document.getElementById('customer-feedback');



        }); 
    }); 


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
