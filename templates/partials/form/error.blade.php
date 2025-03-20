@notice([
  'id' => 'customer-feedback-error',
  'type' => 'danger',
  'dismissable' => 'immediate',
  'message' => [
    'text' => $labels->notification->error
  ],
  'icon' => [
    'name' => 'falling',
    'size' => 'md'
  ],
  'classList' => [
    'customer-feedback-error',
    'u-margin__top--0'
  ],
  'attributeList' => [
    'data-js-cf-notification' => 'error',
    'style' => 'display: none;'
  ]
])
@endnotice