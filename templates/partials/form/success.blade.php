@notice([
  'id' => 'customer-feedback-thanks',
  'type' => 'success',
  'dismissable' => 'immediate',
  'message' => [
    'text' => $labels->notification->success
  ],
  'icon' => [
    'name' => 'verified',
    'size' => 'md'
  ],
  'classList' => [
    'customer-feedback-thanks',
    'u-margin__top--0',
    'u-display--none'
  ],
  'attributeList' => [
    'data-js-cf-notification' => 'success'
  ]
])
@endnotice