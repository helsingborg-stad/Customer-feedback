<div class="box box-index creamy gutter hidden-print" id="customer-feedback">
    <input type="hidden" id="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">

    <div class="grid grid-table-lg no-margin no-padding">
        <div class="grid-xs-12 grid-sm-12 grid-md-12 grid-lg-auto">
            <h4 class="box-title no-padding"><i class="pricon pricon-question-o"></i> <?php echo $mainQuestion ?></h4>
            <?php echo $mainQuestionSub; ?>
        </div>
        <div class="grid-xs-12 grid-sm-12 grid-md-12 grid-lg-fit-content text-left-xs text-left-sm text-left-md text-right-lg">
            <div id="customer-feedback-answers">
                <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-submit-response"><?php _e('Yes'); ?></button>
                <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-submit-response"><?php _e('No'); ?></a>
            </div>
            <div id="customer-feedback-comment" class="text-left gutter gutter-top gutter-sm" style="display: none;">
                <div class="form-group">
                    <label for="customer-feedback-comment-text"><?php echo $commentLabel; ?></label>
                    <textarea class="form-control" style="height: 100px;" id="customer-feedback-comment-text"></textarea>
                </div>
                <div class="form-group">
                    <label for="customer-feedback-comment-email"><?php _e('Email address', 'customer-feedback'); ?> (<?php _e('Optional', 'customer-feedback'); ?>)</label>
                    <small class="block-level"><?php _e('Please give us your email address if you want an answer.', 'customer-feedback'); ?></small>
                    <input type="email" id="customer-feedback-comment-email">
                </div>

                <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-submit-comment"><?php _e('Send', 'customer-feedback'); ?></button>
            </div>
            <div id="customer-feedback-thanks" style="display: none;">
                <?php echo $thanksText; ?>
            </div>
        </div>
    </div>
</div>
