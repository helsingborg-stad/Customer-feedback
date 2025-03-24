
<!-- Topic segment -->
@element([
  'componentElement' => 'div',
  'classList' => [
    'customer-feedback-topics',
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
        'u-margin__top--2'
      ]
    ])
      @foreach ($topics as $key => $topic)
        @option([
          'id' => $key,
          'type' => 'radio',
          'attributeList' => [
            'name' => 'topicid',
            'value' => $topic->id,
            'topic-description' => $topic->description,
            'data-js-cf-has-written-feedback-capability' => $topic->feedbackCapability ? 'true' : 'false',
            'data-js-cf-topic' => $topic->id
          ],
          'label' => $topic->name,
        ])
        @endoption
      @endforeach
    @endelement
@endelement
