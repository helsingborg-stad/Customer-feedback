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
      'id' => 'customer-feedback-topic-' . $topic->id,
      'type' => 'radio',
      'value' => $topic->id,
      'attributeList' => [
        'name' => 'topicid',
        'data-js-cf-topic-description' => $topic->description,
        'data-js-cf-has-written-feedback-capability'  => $topic->feedbackCapability ? 'true' : 'false',
        'data-js-cf-has-written-feedback-email'       => $topic->feedbackCapability && $topic->feedbackCapabilityEmail ? 'true' : 'false',
        'data-js-cf-topic' => $topic->id
      ],
      'label' => $topic->name,
    ])
    @endoption
  @endforeach
@endelement
