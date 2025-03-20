@card([
  'classList' => [
    'c-card--feedback'
  ]
])
  <!-- Main question -->
  @include('partials.form.heading')

  <!-- Body -->
  @element(['classList' => ['c-card__body']])
  
    <!-- Notices -->
    @include('partials.form.success')
    @include('partials.form.error')
    @include('partials.form.alreadysubmitted')

    <!-- Buttons -->
    @include('partials.form.buttons')

    <!-- Detailed submission (if any topics defined) -->
    @if($topics)
      @form(['classList' => ['customer-feedback-comment']])

        <!-- Topics -->
        @include('partials.form.topics')

        <!-- Comment -->
        @include('partials.form.comment')

        <!-- GDPR -->
        @include('partials.form.gdpr')
      @endform
    @endif

  @endelement
@endcard