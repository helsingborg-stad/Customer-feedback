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
        'data-js-cf-action' => 'yes',
        'value' => 'yes'
      ],
      'classList' => [
        'u-margin--0',
        'customer-feedback-response-yes'
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
        'data-js-cf-action' => 'no',
        'value' => 'no'
      ],
      'classList' => [
        'u-margin--0',
        'customer-feedback-response-no'
      ]
  ])
  @endbutton
@endelement