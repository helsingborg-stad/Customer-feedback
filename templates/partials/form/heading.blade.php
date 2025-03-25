@if($shouldRender ?? true)
  @if($question->title)
    @typography([
        'element' => 'h2',
        'classList' => [
            'c-typography__variant--h2',
            'customer-feedback-main-heading'
        ]
    ])
      {{ $question->title }} 
    @endtypography
  @endif
  @if($question->description)
    @typography([
        'element' => 'p',
        'classList' => [
          'c-typography__variant--body',
          'u-margin__top--1'
        ]
    ])
      {!! $question->description !!} 
    @endtypography
  @endif
@endif