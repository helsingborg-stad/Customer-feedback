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

    <!-- Detailed submission -->
    @form(['classList' => ['customer-feedback-comment']])

      <!-- Topics -->
      @includeWhen(count($topics), 'partials.form.topics')

      <!-- Comment -->
      @include('partials.form.comment')

      <!-- GDPR -->
      @include('partials.form.gdpr')

    @endform

  @endelement
@endcard