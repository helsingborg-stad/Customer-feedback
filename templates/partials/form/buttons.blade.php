@element([
    'componentElement' => 'div',
    'classList' => [
        'u-display--flex',
        'u-gap-2',
        'u-margin__top--2'
    ]
])
  @button([
      'text' => $labels->positive,
      'color' => 'default',
      'style' => 'filled',
      'icon'  => 'thumb_up',
      'reversePositions' => true,
      'attributeList' => [
        'data-action' => 'customer-feedback-submit-response',
        'value' => 'yes'
      ],
      'classList' => [
        'u-margin--0',
        'customer-feedback-js-response-yes'
      ]
  ])
  @endbutton

  @button([
      'text' => $labels->negative,
      'color' => 'default',
      'style' => 'filled',
      'icon'  => 'thumb_down',
      'reversePositions' => true,
      'attributeList' => [
        'data-action' => 'customer-feedback-submit-response',
        'value' => 'no'
      ],
      'classList' => [
        'u-margin--0',
        'customer-feedback-js-response-no'
      ]
  ])
  @endbutton
@endelement