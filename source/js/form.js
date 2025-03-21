export default () => {

    const parentDomElement = null;

    let settings = null;
    let initialFeedbackId = null;

    function Form() {
        this.parentDomElement = document.querySelector('[data-js-cf]');
        if (!this.parentDomElement) {
            console.error('No customer feedback form found');
            return;
        }

        //Parse and store the json data
        this.getSettings(this.parentDomElement);

        //Render initial state
        //this.renderInitialState(this.parentDomElement);

        //Handle feedback buttons
        this.handleFeedbackButtons(this.parentDomElement);
    }

    /**
     * Get JSON data from data-js-cf attribute
     * @param {HTMLElement} customerFeedbackInstance
     * @returns {void}
     */
    Form.prototype.getSettings = function (customerFeedbackInstance) {
        try {
            this.settings = JSON.parse(customerFeedbackInstance.getAttribute('data-js-cf'));
        } catch (error) {
            console.error('Invalid settings JSON data in data-js-cf attribute:', error);
        }
    }

    /**
     * Render initial state of the form
     * @param {HTMLElement} customerFeedbackInstance
     * 
     * @returns {void}
     */
    Form.prototype.renderInitialState = function (customerFeedbackInstance) {
        if (this.hasGivenFeedback(this.settings.postId)) {
            this.showNotice('alreadysubmitted');
            this.hidePartial('buttons');
        }
    };

    /**
     * Submits the initail yes or no response
     * @param  {integer} postId Post id
     * @param  {string}  answer Yes or no
     * @return {void}
     */
    Form.prototype.submitInitialResponse = function (target, postId, answer) {

        let data = {
            action: 'submit_response',
            postid: postId,
            answer: answer
        };

        this.showLoader();

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
                throw new Error('Invalid response');
            }
            return response.json();
        }).then(response => {
            if(!response.data.id) {
                throw new Error('Invalid response (no id)');
            }
            return response;
        }).then(response => {
            this.hidePartial('buttons');
            return response;
        }).then(response => {
            this.registerFeedBackGiven(postId);

            if(this.settings.topics) {
                this.initialFeedbackId = response.data.id;
                this.showPartial('topics');
                this.showPartial('send');
            } else {
                this.showNotice('success');
            }

            
            


            /*


            if (!isNaN(parseFloat(response)) && isFinite(response)) {

                //Create id holder for response item
                let feedBackIdElement = document.createElement("input");
                feedBackIdElement.type = "hidden"
                feedBackIdElement.name = "customer-feedback-answer-id";
                feedBackIdElement.value = response;

                document.querySelector('[name="customer-feedback-post-id"]').parentElement.appendChild(feedBackIdElement);

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

            */

        }).catch(err => {
            console.error(err);
            this.showNotice('error');
            this.hidePartial('buttons');
            return false;
        }).finally(() => {
            this.hideLoader();
        });
    };

    /**
     * Show a notice based on the key
     * 
     * @param {string} key
     */
    Form.prototype.showNotice = function (key) {
        this.showHideNotice(key, true);
    };

    /**
     * Hide a notice based on the key
     * 
     * @param {string} key
     */
    Form.prototype.hideNotice = function (key) {
        this.showHideNotice(key, false);
    };

    /**
     * Hide or show a notice based on the key
     * 
     * @param {string} key  What notice to show
     * @param {boolean} state What display state to set (true = show, false = hide)
     */
    Form.prototype.showHideNotice = function (key, state) {
        this.showHideByKey('data-js-cf-notification', key, state);
    };

    Form.prototype.showPartial = function (key) {
        this.showHidePartial(key, true);
    }

    Form.prototype.hidePartial = function (key) {
        this.showHidePartial(key, false);
    }

    Form.prototype.showHidePartial = function (key, state) {
        this.showHideByKey('data-js-cf-part', key, state);
    };

    /**
     * Show or hide an element based on a key
     * 
     * @param {string} dataElement
     * @param {string} key
     * @param {boolean} state
     */
    Form.prototype.showHideByKey = function (dataElement, key, state) {
        const element = this.parentDomElement.querySelector('[' + dataElement + '="' + key + '"]');
        if (element) {
            this.toggleDisplayClass(element, state);
        }
    }

    Form.prototype.toggleDisplayClass = function (element, state) {
        if (!element) return;
    
        const displayClassPattern = /u-display--\S+/g; // Matches any u-display--* class
        const currentClasses = [...element.classList].filter(cls => displayClassPattern.test(cls));
    
        if (state) {
            // Restore previous display class(es) if stored
            const previousDisplay = element.getAttribute('data-display-toggle');
            if (previousDisplay) {
                element.classList.add(...previousDisplay.split(' '));
                element.removeAttribute('data-display-toggle');
            }
            element.classList.remove('u-display--none');
        } else {
            // Store existing u-display--* classes before hiding
            if (currentClasses.length > 0) {
                element.setAttribute('data-display-toggle', currentClasses.join(' '));
                element.classList.remove(...currentClasses);
            }
            element.classList.add('u-display--none');
        }
    }

    /**
     * Show loader 
     */
    Form.prototype.showLoader = function () {
        this.parentDomElement.querySelector('[data-js-cf-loader]').style.display = 'block';
    }

    /**
     * Hide loader
     */
    Form.prototype.hideLoader = function () {
        this.parentDomElement.querySelector('[data-js-cf-loader]').style.display = 'none';
    }

    /**
     * Handle yes/no buttons
     */
    Form.prototype.handleFeedbackButtons = function (customerFeedbackInstance) {
        let     self            = this;
        const   feedbackButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-action]');
    
        if (feedbackButtons.length > 0) {
            feedbackButtons.forEach(feedbackButton => {
                feedbackButton.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();
    
                    // Set pressed state
                    this.setAttribute("aria-pressed", "true");
    
                    // Submit answer
                    self.submitInitialResponse(
                        customerFeedbackInstance, 
                        self.settings.postId, 
                        this.getAttribute('data-js-cf-action')
                    );
                });
            });
        }
    };

    /**
     * Check if post id exists in local storage
     * @param {int} postId 
     * @returns {boolean} True if post id exists in local storage, false if not
     */
    Form.prototype.hasGivenFeedback = function (postId) {
        if (!postId) return false;
        const givenFeedback = JSON.parse(localStorage.getItem('givenFeedback')) || [];
        return givenFeedback.includes(postId);
    };
    
    /**
     * Register post id in local storage
     * @param {int} postId 
     * 
     * @returns {void}
     */
    Form.prototype.registerFeedBackGiven = function (postId) {
        if (!postId) return false;
        let givenFeedback = JSON.parse(localStorage.getItem('givenFeedback')) || [];
        if (!givenFeedback.includes(postId)) {
            givenFeedback.push(postId);
            localStorage.setItem('givenFeedback', JSON.stringify(givenFeedback));
        }
    };

    return new Form();
}
