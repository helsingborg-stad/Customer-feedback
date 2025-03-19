@field([
  'id' => 'customer-feedback-comment-text-' . ($num ?? 0),
  'type' => 'text',
  'name' => 'customer-feedback-comment-text',
  'autocomplete' => 'off',
  'label' => __("What do you want to give feedback on?", 'customer-feedback'),
  'required' => true,
  'multiline' => 8,
  'classList' => [
    'u-margin__top--2'
  ]
])
@endfield

@field([
  'id' => "customer-feedback-comment-email-" . ($num ?? 0),
  'type' => 'email',
  'placeholder' => 'email@email.com',
  'value' => $userEmail ?? '',
  'name' => 'email',
  'autocomplete' => 'email',
  'invalidMessage' => 'Please enter a valid email',
  'label' => "Add your e-mail",
  'required' => false,
  'classList' => [
    'u-margin__top--2'
  ]
])
@endfield

<!-- Submission section -->
<button rel="nofollow"
class="c-button c-button__filled c-button__filled--primary c-button--md u-margin__top--4"
aria-pressed="false" type="button" value="send" data-action="customer-feedback-submit-comment">
<span class="c-button__label">
    <span class="c-button__label-text">
        <i aria-hidden="true" class="c-icon c-icon--color-white c-icon--size-inherit material-icons">
            send
        </i>
        <?php _e('Send', 'customer-feedback'); ?>
    </span>
</span>
</button>

@button([
  'icon' => 'send',
  'reversePositions' => true,
  'id' => 'customer-feedback-submit-comment',
  'text' => 'Submit',
  'color' => 'primary',
  'type' => 'basic',
  'attributeList' => [
    'data-action' => 'customer-feedback-submit-comment',
    'rel' => 'nofollow',
    'aria-pressed' => 'false',
    'type' => 'submit',
  ],
])
@endbutton