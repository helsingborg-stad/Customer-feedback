@notice([
  'id' => 'customer-feedback-thanks',
  'type' => 'success',
  'dismissable' => 'immediate',
  'message' => [
    'text' => $submittedText ?: $labels->success
  ],
  'icon' => [
    'name' => 'verified',
    'size' => 'md'
  ],
  'classList' => [
    'customer-feedback-thanks'
  ]
])
@endnotice