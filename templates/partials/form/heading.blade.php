@if($question->title || $question->description)
  @element(['classList' => ['c-card__header', 'u-padding__bottom--0']])
    @group(['gap' => 1])
      @icon([
          'icon' => 'forum',
          'size' => 'md',
          'color' => 'black'
      ])
      @endicon
      @element()
          @if($question->title)
            @typography([
                'element' => 'h2',
                'classList' => [
                    'c-typography__variant--h2'
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
                  'u-margin--0'
                ]
            ])
              {{ $question->description }} 
            @endtypography
          @endif
      @endelement
    @endgroup
  @endelement
@endif