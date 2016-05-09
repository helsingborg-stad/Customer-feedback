<div class="box box-index creamy gutter">
    <input type="hidden" id="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">
    <div class="grid">
        <div class="grid-md-7">
            <h4 class="box-title no-padding"><i class="fa fa-question-circle"></i> <?php _e('Did the information on this page help you?', 'customer-feedback'); ?></h4>
            <?php _e('Answer the question to help us improve our information.', 'customer-feedback'); ?>
        </div>
        <div class="grid-md-5 text-left-xs text-left-sm text-right-md text-right-lg">
            <div id="customer-feedback-answers">
                <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-submit-response"><?php _e('Yes'); ?></button>
                <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-submit-response"><?php _e('No'); ?></a>
            </div>
            <div id="customer-feedback-comment" class="text-left" style="display: none;">
                <label for="customer-feedback-comment-text"><?php _e('How can we make the information better?', 'customer-feedback'); ?></label>
                <textarea class="form-control" style="height: 100px;" id="customer-feedback-comment-text"></textarea>
                <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-submit-comment"><?php _e('Send', 'customer-feedback'); ?></button>
            </div>
            <div id="customer-feedback-thanks" style="display: none;">
                <?php _e('Thank you', 'customer-feedback'); ?>
            </div>
        </div>
    </div>
</div>
