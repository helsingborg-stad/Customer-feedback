<div class="box box-index creamy gutter hidden-print">
    <input type="hidden" id="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">
    <div class="grid">
        <div class="grid-md-7">
            <h4 class="box-title no-padding"><i class="pricon pricon-question-o"></i> <?php echo $mainQuestion ?></h4>
            <?php echo $mainQuestionSub; ?>
        </div>
        <div class="grid-md-5 text-left-xs text-left-sm text-right-md text-right-lg">
            <div id="customer-feedback-answers">
                <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-submit-response"><?php _e('Yes'); ?></button>
                <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-submit-response"><?php _e('No'); ?></a>
            </div>
            <div id="customer-feedback-comment" class="text-left" style="display: none;">
                <label for="customer-feedback-comment-text"><?php echo $commentLabel; ?></label>
                <textarea class="form-control" style="height: 100px;" id="customer-feedback-comment-text"></textarea>
                <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-submit-comment"><?php _e('Send', 'customer-feedback'); ?></button>
            </div>
            <div id="customer-feedback-thanks" style="display: none;">
                <?php echo $thanksText; ?>
            </div>
        </div>
    </div>
</div>
