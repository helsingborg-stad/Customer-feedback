export default () => {

    const parentDomElement = null;

    let settings = null;
    let initialFeedbackId = null;

    function Form() {
        this.parentDomElement = document.querySelector('[data-js-cf]');
        if (!this.parentDomElement) {
            return;
        }

        // Protect against Google Translate DOM manipulation
        this.protectFromGoogleTranslate();

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

        // Set up mutation observer to handle dynamic DOM changes
        this.setupMutationObserver();
    }

    /**
     * Protect the form from Google Translate DOM manipulation
     * @returns {void}
     */
    Form.prototype.protectFromGoogleTranslate = function () {
        // Add translate="no" to critical interactive elements
        this.parentDomElement.setAttribute('translate', 'no');
        
        // Store original DOM structure for recovery
        this.originalStructure = this.parentDomElement.cloneNode(true);
        
        // Override removeChild and insertBefore to prevent crashes
        this.overrideNodeMethods();
    };

    /**
     * Override DOM manipulation methods to handle Google Translate interference
     * @returns {void}
     */
    Form.prototype.overrideNodeMethods = function () {
        const originalRemoveChild = Node.prototype.removeChild;
        const originalInsertBefore = Node.prototype.insertBefore;
        
        Node.prototype.removeChild = function(child) {
            try {
                if (this.contains(child)) {
                    return originalRemoveChild.call(this, child);
                }
                return child;
            } catch (error) {
                console.warn('Google Translate interference detected, skipping removeChild:', error);
                return child;
            }
        };
        
        Node.prototype.insertBefore = function(newNode, referenceNode) {
            try {
                if (!referenceNode || this.contains(referenceNode)) {
                    return originalInsertBefore.call(this, newNode, referenceNode);
                }
                return this.appendChild(newNode);
            } catch (error) {
                console.warn('Google Translate interference detected, using appendChild instead:', error);
                return this.appendChild(newNode);
            }
        };
    };

    /**
     * Set up mutation observer to detect Google Translate changes
     * @returns {void}
     */
    Form.prototype.setupMutationObserver = function () {
        if (!window.MutationObserver) {
            return;
        }

        const observer = new MutationObserver((mutations) => {
            let googleTranslateDetected = false;
            
            mutations.forEach((mutation) => {
                if (mutation.type === 'childList') {
                    mutation.addedNodes.forEach((node) => {
                        if (node.nodeType === Node.ELEMENT_NODE && 
                            (node.tagName === 'FONT' || node.classList?.contains('skiptranslate'))) {
                            googleTranslateDetected = true;
                        }
                    });
                }
            });

            if (googleTranslateDetected) {
                this.handleGoogleTranslateActivation();
            }
        });

        observer.observe(this.parentDomElement, {
            childList: true,
            subtree: true,
            attributes: false
        });

        this.mutationObserver = observer;
    };

    /**
     * Handle Google Translate activation
     * @returns {void}
     */
    Form.prototype.handleGoogleTranslateActivation = function () {
        // Re-bind event listeners that might have been affected
        setTimeout(() => {
            this.rebindEventListeners();
        }, 100);
    };

    /**
     * Rebind event listeners after Google Translate interference
     * @returns {void}
     */
    Form.prototype.rebindEventListeners = function () {
        // Re-handle feedback buttons
        this.handleFeedbackButtons(this.parentDomElement);
        
        // Re-handle topic selection
        this.handleTopicSelection(this.parentDomElement);
        
        // Re-handle form submission
        this.handleCommentFormSubmission(this.parentDomElement);
    };

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

        if (this.hasGivenFeedback(this.settings.postId, this.settings.frequency)) {
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
        let self = this;
        
        // Remove existing event listeners to prevent duplicates
        const existingButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-action]');
        existingButtons.forEach(button => {
            button.removeEventListener('click', this.feedbackButtonHandler);
        });
        
        // Create a bound handler function
        this.feedbackButtonHandler = function (e) {
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
        };
        
        const feedbackButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-action]');
    
        if (feedbackButtons.length > 0) {
            feedbackButtons.forEach(feedbackButton => {
                // Add translate="no" to preserve functionality
                feedbackButton.setAttribute('translate', 'no');
                feedbackButton.addEventListener('click', this.feedbackButtonHandler);
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
        
        // Remove existing event listeners to prevent duplicates
        const existingTopicButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-topic]');
        existingTopicButtons.forEach(button => {
            button.removeEventListener('click', this.topicButtonHandler);
        });
        
        // Create a bound handler function
        this.topicButtonHandler = function (e) {
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
        };
        
        const topicButtons = customerFeedbackInstance.querySelectorAll('[data-js-cf-topic]');
        if (topicButtons.length > 0) {
            topicButtons.forEach(topicButton => {
                // Add translate="no" to preserve functionality
                topicButton.setAttribute('translate', 'no');
                topicButton.addEventListener('click', this.topicButtonHandler);
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

        // Remove existing event listeners to prevent duplicates
        form.removeEventListener('submit', this.formSubmitHandler);
        
        // Create a bound handler function
        this.formSubmitHandler = function (e) {
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
        };

        // Add translate="no" to form to preserve functionality
        form.setAttribute('translate', 'no');
        form.addEventListener('submit', this.formSubmitHandler);
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
            this.registerFeedBackGiven(postId, this.settings.frequency);

            if (Array.isArray(this.settings.topics) && this.settings.topics.length > 1) {
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
    Form.prototype.hasGivenFeedback = function (postId, days = 7) {
        if (!postId) return false;
    
        const givenFeedback = JSON.parse(localStorage.getItem('givenFeedback')) || {};
        const lastGiven = givenFeedback[postId] || 0;
        const now = Date.now();
        const timePassed = (now - lastGiven) / (1000 * 60 * 60 * 24); // Convert milliseconds to days
    
        return timePassed < days; // Returns true if feedback was given within N days
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
