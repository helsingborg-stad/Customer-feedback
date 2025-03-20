
  <!-- Topic segment -->
  <div id="customer-feedback-topics" class="customer-feedback-topics feedback-answer-no u-margin__top--4">

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
      ],
      'attributeList' => [
        'style' => 'line-height: 1;'
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
            'feedback-capability' => $topic->feedback_capability
          ],
          'label' => $topic->name,
        ])
        @endoption
      @endforeach
    @endelement
  </div>
