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
  'name' => 'customer-feedback-comment-email',
  'autocomplete' => 'email',
  'invalidMessage' => 'Please enter a valid email',
  'label' => "Add your e-mail",
  'required' => false,
  'classList' => [
    'u-margin__top--2'
  ]
])
@endfield

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
  'classList' => [
    'u-margin__top--2'
  ]
])
@endbutton