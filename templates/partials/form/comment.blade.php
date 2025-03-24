  @field([
    'id' => 'customer-feedback-comment-text',
    'type' => 'text',
    'name' => 'comment',
    'autocomplete' => 'off',
    'label' => $labels->comment->label,
    'placeholder' => $labels->comment->placeholder,
    'validationRegexp' => '^(?!(?:.*(.)\1{3,}))[a-zA-Z0-9\s!?,.]{15,}$', // Minimum 15 characters, no more than 3 repeating characters
    'invalidMessage' => $labels->comment->error,
    'helperText' => $labels->comment->explain,
    'required' => true,
    'multiline' => 6,
    'classList' => [
    ],
    'attributeList' => [
      'data-js-cf-comment' => 'text'
    ]
  ])
  @endfield

  @field([
    'id' => "customer-feedback-comment-email",
    'type' => 'email',
    'placeholder' => $labels->email->placeholder,
    'value' => $userEmail ?? '',
    'name' => 'email',
    'autocomplete' => 'email',
    'invalidMessage' => $labels->email->error,
    'label' => $labels->email->label,
    'required' => false,
    'helperText' => $labels->email->explain,
    'classList' => [
      'u-margin__top--3'
    ],
    'attributeList' => [
      'data-js-cf-comment' => 'email'
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
      'data-js-cf-comment' => 'submit',
      'data-action' => 'customer-feedback-submit-comment',
      'rel' => 'nofollow',
      'aria-pressed' => 'false',
      'type' => 'submit',
    ],
    'classList' => [
      'u-margin__top--3'
    ]
  ])
  @endbutton
