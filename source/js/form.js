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
        this.renderInitialState(this.parentDomElement);

        //Handle feedback buttons
        this.handleFeedbackButtons(this.parentDomElement);

        //Handle topic selection
        this.handleTopicSelection(this.parentDomElement);

        //Handle form submission
        this.handleCommentFormSubmission(this.parentDomElement);
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

        this.hidePartial('notices');
        this.hidePartial('topics');
        this.hidePartial('comment');
        this.hidePartial('gdpr');
        
        this.hideNotice('error');
        this.hideNotice('success');

        if (this.hasGivenFeedback(this.settings.postId)) {
            this.showNotice('alreadysubmitted');
            this.hidePartial('buttons');
        } else {
            this.hideNotice('alreadysubmitted');
            this.showPartial('buttons');
        }
    };

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
     * Handle topic selection, toggles comment section
     * 
     * @param {HTMLElement} customerFeedbackInstance
     * @returns {void} 
     */
    Form.prototype.handleTopicSelection = function (customerFeedbackInstance) {
        let self = this;
        const topicButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-topic]');
        if (topicButtons.length > 0) {
            topicButtons.forEach(topicButton => {
                topicButton.addEventListener('click', function (e) {
                    self.showPartial('comment');

                    if(this.getAttribute('data-js-cf-has-written-feedback-capability') === 'true') {
                        self.showPartial('gdpr');
                        self.showSubPartial('text');
                        self.showSubPartial('submit');

                        if(this.getAttribute('data-js-cf-has-written-feedback-email') === 'true') {
                            self.showSubPartial('email');
                        } else {
                            self.hideSubPartial('email');
                        }
                    } else { 
                        self.hidePartial('gdpr');

                        self.hideSubPartial('text');
                        self.hideSubPartial('email');
                        self.showSubPartial('submit');
                    }
                });
            });
        }
    }

    /**
     * Handle comment form submission
     * 
     * @param {HTMLElement} customerFeedbackInstance 
     * @returns 
     */
    Form.prototype.handleCommentFormSubmission = function (customerFeedbackInstance) {

        let self = this;
        const form = customerFeedbackInstance.querySelector('form');
        if (!form) return;

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopPropagation();

            self.showLoader();
            self.hideNotice('error');
            self.hideNotice('success');

            let data = new FormData(form);
            data.append('action', 'submit_comment');
            data.append('answerid', self.initialFeedbackId);
            data.append('postid', self.settings.postId);

            fetch(ajaxurl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Cache-Control': 'no-cache',
                },
                body: data
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
                self.showNotice('success');
                self.hidePartial('topics');
                self.hidePartial('comment');
                self.hidePartial('gdpr');
            }).catch(err => {
                console.error(err);
                self.showNotice('error');
            }).finally(() => {
                self.hideLoader();
            });
        });
    }

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
        if(state == false) {
            this.hidePartial('notices');
        } else {
            this.showPartial('notices');
        }
        this.showHideByKey('data-js-cf-notification', key, state);
    };

    /**
     * Displays a partial based on a key
     * 
     * @param {string} key 
     */
    Form.prototype.showPartial = function (key) {
        this.showHidePartial(key, true);
    }

    /**
     * Hides a partial based on a key
     * 
     * @param {string} key 
     */
    Form.prototype.hidePartial = function (key) {
        this.showHidePartial(key, false);
    }


    /**
     * Displays a partial based on a key
     * 
     * @param {string} key 
     */
    Form.prototype.showSubPartial = function (key) {
        this.showHideSubPartial(key, true);
    }

    /**
     * Hides a partial based on a key
     * 
     * @param {string} key 
     */
    Form.prototype.hideSubPartial = function (key) {
        this.showHideSubPartial(key, false);
    }

     /**
     * Shows and hides a partial based on a key
     * 
     * @param {string} key 
     * @param {boolean} state 
     */
     Form.prototype.showHideSubPartial = function (key, state) {
        this.showHideByKey('data-js-cf-sub-part', key, state);
    };

    /**
     * Shows and hides a partial based on a key
     * 
     * @param {string} key 
     * @param {boolean} state 
     */
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
            this.toggleDisplay(element, state);
        }
    }

    /**
     * Toggle display class, to show or hide an element
     * 
     * @param {HTMLElement} element 
     * @param {boolean} state 
     * @returns 
     */
    Form.prototype.toggleDisplay = function (element, state) {
        if (!element) {
            return;
        }
    
        const displayClassPattern = /u-display--\S+/g;
        const currentClasses = [...element.classList].filter(cls => displayClassPattern.test(cls));
    
        if (state) {
            const previousDisplay = element.getAttribute('data-display-toggle');
            if (previousDisplay) {
                element.classList.add(...previousDisplay.split(' '));
                element.removeAttribute('data-display-toggle');
            }
            element.classList.remove('u-display--none');

            //If there are any form elements in this element, enable them
            const formElements = element.querySelectorAll('input, textarea, button, select');
            if (formElements.length > 0) {
                formElements.forEach(formElement => {
                    formElement.disabled = false;
                });
            }

        } else {
            if (currentClasses.length > 0) {
                element.setAttribute('data-display-toggle', currentClasses.join(' '));
                element.classList.remove(...currentClasses);
            }
            element.classList.add('u-display--none');

            //If there are any form elements in this element, reset them and disable them
            const formElements = element.querySelectorAll('input, textarea, button, select');
            if (formElements.length > 0) {
                formElements.forEach(formElement => {
                    formElement.value = '';
                    formElement.disabled = true;
                });
            }
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
    Form.prototype.registerFeedBackGiven = function (postId, days = 7) {
        if (!postId) {
            return false;
        }

        if(days == 0) {
            return true;
        }
    
        let givenFeedback = JSON.parse(localStorage.getItem('givenFeedback')) || {};
    
        let now = Date.now();
        let lastGiven = givenFeedback[postId] || 0;
        let timePassed = (now - lastGiven) / (1000 * 60 * 60 * 24);
    
        if (timePassed >= days) {
            givenFeedback[postId] = now;
            localStorage.setItem('givenFeedback', JSON.stringify(givenFeedback));
            return true;
        }
        return false;
    };

    return new Form();
}
