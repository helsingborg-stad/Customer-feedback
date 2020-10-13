export default () => {

    let feedbackResponse = false;

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

        fetch(ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            },
            body: new URLSearchParams(data)
        }).then(response => {

            if (response.status != 200) {
                document.querySelector('.customer-feedback-js-error').style.display = "block";
                return false;
            }

            return response.json();

        }).then(response => {

            //Disable loader
            $target.querySelector("#feedback-loader").style.display = 'none';

            //Handle response
            if (response == true) {
                $target.querySelector('.customer-feedback-comment').style.display = 'none';
                $target.querySelector('.customer-feedback-thanks').style.display = 'block';
            } else {
                $target.querySelector('.customer-feedback-comment').style.display = 'none';
                $target.querySelector('.customer-feedback-error').style.display = 'block';
            }

        }).catch(err => {
            document.querySelector('.customer-feedback-js-error').style.display = "block";
            return false;
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

        document.querySelector("#feedback-loader").style.display = 'block';

        fetch(ajaxurl, {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Cache-Control': 'no-cache',
            },
            body: new URLSearchParams(data)
        }).then(response => {

            if (response.status != 200) {
                document.querySelector('.customer-feedback-js-error').style.display = "block";
                return false;
            }

            return response.json();

        }).then(response => {

            if (response === false) {
                return false;
            }

            if (!isNaN(parseFloat(response)) && isFinite(response)) {

                //Create id holder
                let feedBackIdElement = document.createElement("input");
                feedBackIdElement.type = "hidden"
                feedBackIdElement.name = "customer-feedback-answer-id";
                feedBackIdElement.value = response;

                document.querySelector('[name="customer-feedback-post-id"]').parentElement.appendChild(feedBackIdElement);

                //Hide current controls 
                document.querySelector('.customer-feedback-comment-email').parentElement.style.display = "none";
                document.querySelector('.customer-feedback-answers').style.display = "none";

                //Show comment section
                document.querySelector('.customer-feedback-comment').style.display = "block";
            }

            if (data.answer === 'yes' && !isNaN(parseFloat(response)) && isFinite(response)) {
                document.querySelector('.feedback-answer-yes').style.display = "block";
                feedbackResponse = true;
            }

            if (data.answer === 'no' && !isNaN(parseFloat(response)) && isFinite(response)) {
                for (const negativeAnswer of document.querySelectorAll('.feedback-answer-no')) {
                    negativeAnswer.style.display = "block";
                    feedbackResponse = false;
                }
            }

            //Loading done
            document.getElementById("feedback-loader").style.display = 'none';

        }).catch(err => {
            document.querySelector('.customer-feedback-js-error').style.display = "block";
            return false;
        });

    };

    Form.prototype.removeJsErrorMessages = function () {

        //Target div 
        let $target = document.getElementById('customer-feedback');

        //Reset state (remove messages)
        let errorMessages = $target.querySelectorAll('.feedback-form-dynamic-error');
        errorMessages.forEach(errorMessage => {
            errorMessage.remove();
        });

    }

    Form.prototype.handleEvents = function () {

        let answerButton = document.querySelectorAll('[data-action=customer-feedback-submit-response]');
        let self = this;

        answerButton.forEach(answerButton => {
            answerButton.addEventListener('click', function (e) {

                //Prevent default action
                e.preventDefault();
                e.stopPropagation();

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
            Submit.addEventListener('click', function (e) {

                e.preventDefault();

                //Target div 
                let $target = document.getElementById('customer-feedback');

                //Reset state (make fields valid attr)
                $target.querySelector('[name="customer-feedback-comment-text"]').setAttribute('aria-invalid', false);
                $target.querySelector('[name="customer-feedback-comment-topic"]').setAttribute('aria-invalid', false);
                $target.querySelector('[name="customer-feedback-comment-email"]').setAttribute('aria-invalid', false);

                //Remove all js error messages
                self.removeJsErrorMessages();

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

                if (!feedbackResponse){
                    if ($target.querySelectorAll('[name="customer-feedback-comment-topic"]:checked').length == 1) {
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
                        $target.querySelector('.customer-feedback-topics').after(topicErrorMessage);

                        //Prohibit submission
                        valid = false;
                    }
                }


                //Get captcha if not logged in
                if (feedback.site_key) {
                    if ($target.querySelector('[name="g-recaptcha-response"]') && $target.querySelector('[name="g-recaptcha-response"]').value !== '') {
                        gCaptcha = $target.querySelector('[name="g-recaptcha-response"]').value;
                    }
                }

                //Check length
                if (comment.length < 15) {

                    //Create error node
                    let errorMessage = document.createElement('div');
                    errorMessage.id = 'length-error';
                    errorMessage.classList = 'c-textarea-invalid-message feedback-form-dynamic-error';
                    errorMessage.style.display = 'block';
                    $target.querySelector( '.c-textarea label').remove();
                    comment

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
                if (email.length === 0 && emailRequired == "true") {

                    //Create error node
                    let errorMessage = document.createElement('div');
                    errorMessage.id = 'email-error';
                    errorMessage.classList = 'c-field__input-invalid-message feedback-form-dynamic-error';
                    errorMessage.style.display = 'block';
                    errorMessage.style.marginTop = '0px';
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
                $target.querySelector("#feedback-loader").style.display = 'block';

                //Submit
                self.submitComment($target, answerId, postId, commentType, comment, email, gCaptcha, topic);

            });
        });

    };

    // Comment submit click
    let topicListeners = document.querySelectorAll('[name="customer-feedback-comment-topic"]');
    let self = this;

    topicListeners.forEach(topListener => {
        topListener.addEventListener('change', function (e) {

            //Container 
            let $container = document.querySelector('#customer-feedback');

            if (e.target.getAttribute('feedback-capability')) {
                $container.querySelector('[name="customer-feedback-comment-email"]').setAttribute('required', true);
                $container.querySelector('.customer-feedback-comment-email').style.display = 'block';
            } else {
                $container.querySelector('[name="customer-feedback-comment-email"]').setAttribute('required', false);
                $container.querySelector('.customer-feedback-comment-email').style.display = 'none';
            }

        });
    });

    return new Form();

}
