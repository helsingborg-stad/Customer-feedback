<div class="box box-index creamy gutter hidden-print" id="customer-feedback">
    <input type="hidden" id="customer-feedback-post-id" value="<?php echo get_the_id(); ?>">

    <div class="grid">
        <div class="grid-xs-12">
            <h4 class="box-title no-padding"><i class="pricon pricon-question-o"></i> <?php echo $mainQuestion ?></h4>
            <?php echo $mainQuestionSub; ?>
        </div>
        <div class="grid-xs-12">
            <div class="gutter gutter-top gutter-sm">
                <?php if (!isset($_COOKIE['customer-feedback']) || !in_array(get_the_id(), unserialize(stripslashes($_COOKIE['customer-feedback'])))) : ?>
                <div id="customer-feedback-answers">
                    <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-submit-response"><?php _e('Yes'); ?></button>
                    <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-submit-response"><?php _e('No'); ?></a>
                </div>
                <div id="customer-feedback-comment" class="text-left gutter gutter-top gutter-sm" style="display: none;">
                    <div class="form-group">
                        <label for="customer-feedback-comment-text"><?php echo $commentLabel; ?></label>
                        <textarea class="form-control" style="height: 100px;" id="customer-feedback-comment-text" name="customer-feedback-comment-text"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="customer-feedback-comment-email"><?php echo $emailLabel; ?> (<?php _e('Optional', 'customer-feedback'); ?>)</label>
                        <small class="block-level"><?php echo $emailExplain; ?></small>
                        <input type="email" id="customer-feedback-comment-email" name="customer-feedback-comment-email" value="<?php echo $userEmail; ?>">
                    </div>
                    <div class="form-group">
                        <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-submit-comment"><?php _e('Send', 'customer-feedback'); ?></button>
                    </div>
                </div>
                <div id="customer-feedback-thanks" style="display: none;">
                    <div class="notice success"><?php echo $thanksText; ?></div>
                </div>
                <?php else : ?>
                    <div class="notice success"><?php _e('You have already given feedback for this content.', 'customer-feedback'); ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
