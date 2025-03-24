@paper([
  'id' => 'customer-feedback',
  'classList' => [
    'c-card--feedback'
  ],
  'attributeList' => [
    'data-js-cf' => $jsonData
  ]
])
  <!-- Main question -->
  @include(
    'partials.section', 
    ['section' => 'heading', 'isHidden' => false, 'icon' => 'forum', 'shouldRender' => ($question->title || $question->description)]
  )

  <!-- Buttons -->
  @include(
    'partials.section', 
    ['section' => 'buttons', 'isHidden' => false, 'icon' => 'unknown_med', 'shouldRender' => true]
  )

  <!-- Notification -->
  @include(
    'partials.section', 
    ['section' => 'notices', 'isHidden' => false, 'icon' => 'unknown_med', 'shouldRender' => true]
  )

  <!-- Topics -->
  @include(
    'partials.section', 
    ['section' => 'topics', 'isHidden' => false, 'icon' => 'topic', 'shouldRender' => (bool) $topics]
  )

  <!-- Comment -->
  @include(
    'partials.section', 
    ['section' => 'comment', 'isHidden' => false, 'icon' => 'forum', 'shouldRender' => true]
  )

  <!-- GDPR -->
  @include(
    'partials.section', 
    ['section' => 'gdpr', 'isHidden' => false, 'icon' => 'forum', 'shouldRender' => true]
  )

  <!-- Loader -->
  <div class="customer-feedback-loader" data-js-cf-loader="" style="display: none;"></div>
@endpaper