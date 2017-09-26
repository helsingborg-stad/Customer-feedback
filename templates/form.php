<?php $num = isset($num) && $num > 0 ? $num++ : 1; ?>
<div class="box box-index creamy gutter hidden-print customer-feedback-container">
    <input type="hidden" name="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">

    <div class="grid">
        <div class="grid-xs-12">
            <h4 class="box-title no-padding"><i class="pricon pricon-question-o"></i> <?php echo $mainQuestion ?></h4>
            <?php echo $mainQuestionSub; ?>
        </div>
        <div class="grid-xs-12">
            <div class="gutter gutter-top gutter-sm">
                <?php if (!isset($_COOKIE['customer-feedback']) || !in_array(get_the_id(), unserialize(stripslashes($_COOKIE['customer-feedback'])))) : ?>
                <div class="customer-feedback-answers">
                    <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-submit-response"><?php _e('Yes'); ?></button>
                    <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-submit-response"><?php _e('No'); ?></a>
                </div>
                <div class="customer-feedback-comment text-left gutter gutter-top gutter-sm" style="display: none;">

                    <?php if (!empty($topics)): ?>
                    <div class="form-group">
                        <label for="customer-feedback-comment-topic-<?php echo $num; ?>" class="feedback-label-topic"><?php echo $topicLabel; ?></label>
                        <select id="customer-feedback-comment-topic-<?php echo $num; ?>" name="customer-feedback-comment-topic">
                            <option value=""><?php _e('Select topic', 'customer-feedback'); ?></option>
                            <?php foreach ($topics as $topic): ?>
                                <option value="<?php echo $topic->term_id; ?>" topic-description="<?php echo $topic->description; ?>" feedback-capability="<?php echo $topic->feedback_capability; ?>"><?php echo $topic->name; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="topic-description notice info" style="display:none;">test</div>
                    </div>
                    <?php endif ?>

                    <div class="form-group">
                        <label for="customer-feedback-comment-text-<?php echo $num; ?>" class="feedback-label-yes" style="display: none;"><?php echo $positiveLabel; ?></label>
                        <label for="customer-feedback-comment-text-<?php echo $num; ?>" class="feedback-label-no" style="display: none;"><?php echo $negativeLabel; ?></label>
                        <textarea class="form-control" style="height: 100px;" id="customer-feedback-comment-text-<?php echo $num; ?>" name="customer-feedback-comment-text"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="customer-feedback-comment-email-<?php echo $num; ?>"><?php echo $emailLabel; ?></label>
                        <small class="block-level"><?php echo $emailExplain; ?></small>
                        <input type="email" id="customer-feedback-comment-email-<?php echo $num; ?>" name="customer-feedback-comment-email" value="<?php echo $userEmail; ?>">
                    </div>

                    <?php if ($reCaptcha) : ?>
                    <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="<?php echo $reCaptcha; ?>"></div>
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-submit-comment"><?php _e('Send', 'customer-feedback'); ?></button>
                    </div>
                </div>
                <div class="customer-feedback-thanks" style="display: none;">
                    <div class="notice success"><?php echo $thanksText; ?></div>
                </div>
                <div class="customer-feedback-error" style="display: none;">
                    <div class="notice warning"><?php _e('Something went wrong, please try again later.', 'customer-feedback'); ?></div>
                </div>
                <?php else : ?>
                    <div class="notice success"><?php _e('You have already given feedback for this content.', 'customer-feedback'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
