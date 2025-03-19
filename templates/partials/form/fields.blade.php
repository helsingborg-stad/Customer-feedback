 <!-- Text input field for comments -->
 <div class="c-textarea">
  <textarea
      id="customer-feedback-comment-text-<?php echo $num; ?>"
      type="textarea" name="customer-feedback-comment-text"
      placeholder="<?php _e("What do you want to give feedback on?", 'customer-feedback'); ?>"></textarea>
  <label
      class="c-textarea--label"><?php _e("What do you want to give feedback on?", 'customer-feedback'); ?></label>
</div>