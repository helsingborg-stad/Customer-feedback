@element([
  'classList' => [
    'customer-feedback-section',
    'customer-feedback-section-' . $section,
    $isHidden ? 'u-display--none' : 'u-display--flex',
  ],
  'attributeList' => [
    'data-js-cf-part' => $section
  ]
])
  @element(['classList' => ['customer-feedback-section-icon']])
    @if($icon)
      @icon([
        'icon' => $icon,
        'size' => 'md',
      ])
      @endicon
    @else
      @icon([
        'icon' => 'unknown_med',
        'size' => 'md',
        'attributeList' => [
          'aria-hidden' => 'true',
          'aria-label' => ''
        ],
        'classList' => [
          'u-visibly--hidden'
        ]
      ])
      @endicon
    @endif
  @endelement
  @element(['classList' => ['customer-feedback-section-content']])
    @include('partials.form.' . $section)
  @endelement
@endelement