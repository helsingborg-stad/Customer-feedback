@if($mainQuestion || $mainQuestionSub)
  @element(['classList' => ['c-card__header', 'u-padding__bottom--0']])
    @group(['gap' => 1])
      @icon([
          'icon' => 'forum',
          'size' => 'md',
          'color' => 'black'
      ])
      @endicon
      @element()
          @if($mainQuestion)
            @typography([
                'element' => 'h2',
                'classList' => [
                    'c-typography__variant--h2'
                ]
            ])
              {{ $mainQuestion }} 
            @endtypography
          @endif
          @if($mainQuestionSub)
            @typography([
                'element' => 'p',
                'classList' => [
                  'c-typography__variant--body',
                  'u-margin--0'
                ]
            ])
              {{ $mainQuestionSub }} 
            @endtypography
          @endif
      @endelement
    @endgroup
  @endelement
@endif