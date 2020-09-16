<?php $num = isset($num) && $num > 0 ? $num++ : 1; ?>
<div id="customer-feedback" class="customer-feedback-container c-paper c-paper--padding-3 u-margin__top--6">
    
    <input type="hidden" id="customer-feedback-post-id" name="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">

    <h4 id="" class="c-typography c-typography__variant--h3">
        <i class="c-icon c-icon--color-primary c-icon--size-inherit material-icons">
            question_answer
        </i>
        <?php echo $mainQuestion ?>
    </h4>

    <p class="c-typography c-typography__variant--byline u-margin__top--0"><?php echo $mainQuestionSub; ?></p>

    <div class="gutter gutter-top gutter-sm">
        <?php if (!isset($_COOKIE['customer-feedback']) || !in_array(get_the_id(), unserialize(base64_decode(stripslashes($_COOKIE['customer-feedback']))))) : ?>
            
            <!-- Booelan answer section -->
            <div class="customer-feedback-answers">

                <!-- Submission Error -->
                <div class="customer-feedback-js-error u-margin__bottom--3 u-margin__top--3" style="display: none;">
                    <div id="" class="c-notice c-notice--danger">
                        <span class="c-notice__icon">
                            <i id="" class="c-icon c-icon--color- c-icon--size-md material-icons">
                                error_outline
                            </i>
                        </span>
                        <span class="c-notice__message--sm">
                            <?php _e('Something went wrong, please try again later. You might have lost your internet connection or there is an issue with our server.', 'customer-feedback'); ?>
                        </span>
                    </div>
                </div>

                <button rel="nofollow" class="c-button c-button__filled c-button__filled--default c-button--md u-margin__right--1" aria-pressed="false" type="button" value="yes" data-action="customer-feedback-submit-response">
                    <span class="c-button__label">
                        <span class="c-button__label-text">
                            <i class="c-icon c-icon--color-primary c-icon--size-inherit material-icons">
                                thumb_up
                            </i>
                            <?php _e('Yes', 'customer-feedback'); ?>
                        </span>
                    </span>
                </button>

                <button rel="nofollow" class="c-button c-button__filled c-button__filled--default c-button--md" aria-pressed="false" type="button" value="no" data-action="customer-feedback-submit-response">
                    <span class="c-button__label">
                        <span class="c-button__label-text">
                            <i class="c-icon c-icon--color-primary c-icon--size-inherit material-icons">
                                thumb_down
                            </i>
                            <?php _e('No', 'customer-feedback'); ?>
                        </span>
                    </span>
                </button>

            </div> <!-- // End boolean answer section --> 

            <!-- Comment section -->
            <div class="customer-feedback-comment" style="display: none;">
                
                <?php if (!empty($topics) && count($topics) > 1): ?>
                    
                    <!-- Topic segment --> 
                    <div id="customer-feedback-topics" class="customer-feedback-topics u-margin__top--4">
                        
                        <label for="customer-feedback-comment-topic-<?php echo $num; ?>" class="c-typography c-typography__variant--h3">
                            <?php echo $topicLabel; ?>
                        </label>

                        <p class="c-typography typography__variant--small u-margin__top--0">
                            <?php echo $addComment; ?>
                        </p>
                        
                        <?php foreach ($topics as $key => $topic): ?>
                            <div class="c-option c-option__radio">
                                <input 
                                    id="<?php echo $key; ?>__customer-feedback-comment-topic"
                                    name="customer-feedback-comment-topic" 
                                    class="c-option__radio--hidden-box" placeholder="<?php echo $topic->name; ?>"
                                    type="radio" value="<?php echo $topic->term_id; ?>"
                                    topic-description="<?php echo $topic->description; ?>"
                                    feedback-capability="<?php echo $topic->feedback_capability; ?>"
                                >
                                <label for="<?php echo $key; ?>__customer-feedback-comment-topic" class="c-option__radio--label">
                                    <span class="c-option__radio--label-box"></span>
                                    <span class="c-option__radio--label-text"><?php echo $topic->name; ?></span>
                                </label>
                                <div class="js-error">

                                </div>
                            </div>
                        <?php endforeach ?>

                    </div>

                <?php endif ?>

                <div class="u-margin__top--4">

                    <!-- Headings -->
                    <label 
                        for="customer-feedback-comment-text-<?php echo $num; ?>" 
                        class="c-typography c-typography__variant--h3 feedback-label-yes"
                        style="display: none;">
                        <?php echo $positiveLabel; ?>
                    </label>

                    <label 
                        for="customer-feedback-comment-text-<?php echo $num; ?>" 
                        class="c-typography c-typography__variant--h3 feedback-label-no"
                        style="display: none;">
                        <?php echo $negativeLabel; ?>
                    </label>
                    
                    <!-- Explainer -->
                    <p class="c-typography c-typography__variant--byline u-margin__top--0"><?php echo $commentExplain; ?></p>

                    <!-- Text input field for comments -->
                    <div class="c-textarea">
                        <textarea 
                            id="customer-feedback-comment-text-<?php echo $num; ?>"
                            type="textarea" 
                            name="customer-feedback-comment-text" 
                            placeholder="<?php _e("What do you want to give feedback on?", 'customer-feedback'); ?>"></textarea> 
                        <label class="c-textarea--label"><?php _e("What do you want to give feedback on?", 'customer-feedback'); ?></label>
                    </div>

                    <!-- GDPR Notice -->
                    <?php if (!empty($gdpr_complience_notice_content)): ?>
                        <p class="c-typography c-typography__variant--meta">
                            <?php echo $gdpr_complience_notice_content; ?>
                        </p>
                    <?php endif; ?>
                
                </div>

                <div class="customer-feedback-comment-email u-margin__top--4" style="display: none;">
                    
                    <!-- Email -->
                    <label 
                        for="customer-feedback-comment-email-<?php echo $num; ?>" 
                        class="c-typography c-typography__variant--h3">
                        <?php echo $emailLabel; ?>
                    </label>

                    <!-- Explainer -->
                    <p class="c-typography c-typography__variant--byline u-margin__top--0"><?php echo $emailExplain; ?></p>

                    <!-- Email input -->
                    <div class="c-field c-field__text">
                        <input  
                            placeholder="<?php _e("Enter your email."); ?>"
                            type="email" 
                            id="customer-feedback-comment-email-<?php echo $num; ?>"
                            name="customer-feedback-comment-email" 
                            value="<?php echo $userEmail; ?>">
                            <label class="c-field__text--label"><?php _e("Enter your email."); ?></label>
                    </div>

                </div>

                <?php if (!is_user_logged_in()) : ?>

                    <script type="text/javascript">
                        function CaptchaCallback() {
                            if(feedback.site_key !== "") {
                                $captchaContainer = document.getElementById('customer-feedback');
                                $captchaContainer.querySelectorAll(".g-recaptcha").forEach(ReCaptchaInstance => {
                                    grecaptcha.render(ReCaptchaInstance, {'sitekey' : feedback.site_key});
                                }); 
                            }
                        }
                    </script>

                    <div class="g-recaptcha"></div>

                <?php endif; ?>

                <!-- Submission section -->
                <button rel="nofollow" class="c-button c-button__filled c-button__filled--primary c-button--lg u-margin__top--4" aria-pressed="false" type="button" value="send" data-action="customer-feedback-submit-comment">
                    <span class="c-button__label">
                        <span class="c-button__label-text">
                            <i class="c-icon c-icon--color-white c-icon--size-inherit material-icons">
                                send
                            </i>
                            <?php _e('Send'); ?>
                        </span>
                    </span>
                </button>
            </div>
        
            <!-- Submission success -->
            <div id="customer-feedback-thanks" class="customer-feedback-thanks" style="display: none;">
                <div class="c-notice c-notice--success">
                    <span class="c-notice__icon">
                        <i class="c-icon c-icon--color- c-icon--size-md material-icons">
                            check
                        </i>
                    </span>
                    <span class="c-notice__message--sm">
                        <?php echo $thanksText; ?>
                    </span>
                </div>
            </div>
                
            <!-- Submission Error -->
            <div id="customer-feedback-error" class="customer-feedback-error" style="display: none;">
                <div id="" class="c-notice c-notice--danger">
                    <span class="c-notice__icon">
                        <i id="" class="c-icon c-icon--color- c-icon--size-md material-icons">
                            error_outline
                        </i>
                    </span>
                    <span class="c-notice__message--sm">
                        <?php _e('Something went wrong, please try again later. Could not store your response.', 'customer-feedback'); ?>
                    </span>
                </div>
            </div>

        <?php else : ?>

            <!-- Submission already done -->
            <div class="customer-feedback-already-submitted">
                <div class="c-notice c-notice--info">
                    <span class="c-notice__icon">
                        <i id="" class="c-icon c-icon--color- c-icon--size-md material-icons">
                            error_outline
                        </i>
                    </span>
                    <span class="c-notice__message--sm">
                        <?php _e('You have already given feedback for this content.','customer-feedback'); ?>
                    </span>
                </div>
            </div>

        <?php endif; ?>

        <div id="feedback-loader" class="feedback-loader c-loader c-loader__circular--color--primary c-loader__circular c-loader__circular--md"></div>

    </div>

</div>