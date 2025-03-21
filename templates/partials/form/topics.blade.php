
<!-- Topic segment -->
@element([
  'componentElement' => 'div',
  'classList' => [
    'customer-feedback-topics',
    'u-display--none'
  ],
  'attributeList' => [
    'data-js-cf-part' => 'topics'
  ]
])
    @typography([
      'element' => 'h2',
      'variant' => 'h3',
    ])
      {{ $labels->topic->heading }}
    @endtypography

    @typography([
      'element' => 'p',
      'variant' => 'small',
      'classList' => [
        'u-margin__top--0'
      ]
    ])
      {{ $labels->topic->description }}
    @endtypography

    @element([
      'classList' => [
        'u-margin__top--2', 
        'u-padding--2', 
        'u-border', 
        'u-border--1', 
        'u-border__color--secondary', 
        'u-rounded', 
        'u-color__bg--complementary-lightest'
      ]
    ])
      @foreach ($topics as $key => $topic)
        @option([
          'id' => $key,
          'type' => 'radio',
          'attributeList' => [
            'name' => 'customer-feedback-comment-topic',
            'value' => $topic->id,
            'topic-description' => $topic->description,
            'feedback-capability' => $topic->feedbackCapability,
            'data-js-cf-topic' => $topic->id
          ],
          'label' => $topic->name,
        ])
        @endoption
      @endforeach
    @endelement
@endelement
