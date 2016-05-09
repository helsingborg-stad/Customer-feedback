<div class="box box-index creamy gutter">
    <input type="hidden" id="customer-feedback-chat-post-id" value="<?php echo get_the_id(); ?>">
    <div class="grid">
        <div class="grid-md-7">
            <h4 class="box-title no-padding"><i class="fa fa-question-circle"></i> Fick du hjälp av informationen på denna sidan?</h4>
            Svara på frågan för att hjälpa oss att förbättra vår information.
        </div>
        <div class="grid-md-5 text-left-xs text-left-sm text-right-md text-right-lg">
            <div id="customer-feedback-chat-answers">
                <button rel="nofollow" class="btn btn-success" value="yes" data-action="customer-feedback-chat-submit-response"><?php _e('Yes'); ?></button>
                <button rel="nofollow" class="btn btn-error" value="no" data-action="customer-feedback-chat-submit-response"><?php _e('No'); ?></a>
            </div>
            <div id="customer-feedback-chat-comment" class="text-left" style="display: none;">
                <label for="customer-feedback-chat-comment-text"><?php _e('How can we make the information better?'); ?></label>
                <textarea class="form-control" style="height: 100px;" id="customer-feedback-chat-comment-text"></textarea>
                <button rel="nofollow" style="margin-top:5px;" class="btn btn-submit" data-action="customer-feedback-chat-submit-comment">Skicka</button>
            </div>
            <div id="customer-feedback-chat-thanks" style="display: none;">
                <?php _e('Thank you for your answer.'); ?>
            </div>
        </div>
    </div>
</div>
