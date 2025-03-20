@element(['classList' => ['customer-feedback-comment-section']])
  @field([
    'id' => 'customer-feedback-comment-text-' . ($num ?? 0),
    'type' => 'text',
    'name' => 'customer-feedback-comment-text',
    'autocomplete' => 'off',
    'label' => $labels->comment->label,
    'placeholder' => $labels->comment->placeholder,
    'validationRegexp' => '^(?!(?:.*(.)\1{3,}))[a-zA-Z0-9\s!?,.]{15,}$', // Minimum 15 characters, no more than 3 repeating characters
    'invalidMessage' => $labels->comment->error,
    'helperText' => $labels->comment->explain,
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
    'placeholder' => $labels->email->placeholder,
    'value' => $userEmail ?? '',
    'name' => 'customer-feedback-comment-email',
    'autocomplete' => 'email',
    'invalidMessage' => $labels->email->error,
    'label' => $labels->email->label,
    'required' => false,
    'helperText' => $labels->email->explain,
    'classList' => [
      'u-margin__top--2'
    ]
  ])
  @endfield

  @button([
    'icon' => 'send',
    'reversePositions' => true,
    'id' => 'customer-feedback-submit-comment',
    'text' => $labels->submit,
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
@endelement