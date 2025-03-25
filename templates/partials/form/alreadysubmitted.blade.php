@notice([
  'id' => 'customer-feedback-already-submitted',
  'type' => 'info',
  'message' => [
    'text' => $labels->notification->alreadysubmitted
  ],
  'icon' => [
    'name' => 'celebration',
    'size' => 'md'
  ],
  'classList' => [
    'customer-feedback-already-submitted',
    'u-margin__top--0'
  ],
  'attributeList' => [
    'data-js-cf-notification' => 'alreadysubmitted'
  ]
])
@endnotice