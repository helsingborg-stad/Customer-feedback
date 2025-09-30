@paper([
  'id' => 'customer-feedback',
  'classList' => [
    'c-paper--feedback',
    'u-margin__y--3'
  ],
  'attributeList' => [
    'data-js-cf' => $jsonData
  ]
])

  @form(['id' => 'customer-feedback-form', 'validate' => true])

    <!-- Main question -->
    @include(
      'partials.section', 
      ['section' => 'heading', 'isHidden' => false, 'hasBorder' => false, 'icon' => 'forum', 'shouldRender' => ($question->title || $question->description)]
    )

    <!-- Notification -->
    @include(
      'partials.section', 
      ['section' => 'notices', 'isHidden' => true, 'hasBorder' => false, 'icon' => false, 'shouldRender' => true]
    )

    <!-- Buttons -->
    @include(
      'partials.section', 
      ['section' => 'buttons', 'isHidden' => true, 'hasBorder' => false, 'icon' => false, 'shouldRender' => true]
    )

    <!-- Topics -->
    @include(
      'partials.section', 
      ['section' => 'topics', 'isHidden' => true, 'hasBorder' => true, 'icon' => 'category', 'shouldRender' => (bool) $topics]
    )

    <!-- Comment -->
    @include(
      'partials.section', 
      ['section' => 'comment', 'isHidden' => true, 'hasBorder' => true, 'icon' => 'edit_document', 'shouldRender' => true, 'customClasses' => ['u-gap-2']]
    )

    <!-- GDPR -->
    @include(
      'partials.section', 
      ['section' => 'gdpr', 'isHidden' => true, 'hasBorder' => false, 'icon' => false, 'shouldRender' => $gdpr->enabled]
    )

    <!-- Loader -->
    <div class="customer-feedback-loader" data-js-cf-loader="" style="display: none;"></div>

  @endform

@endpaper