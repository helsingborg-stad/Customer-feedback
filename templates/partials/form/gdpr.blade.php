<!-- GDPR Notice -->
@element([
  'classList' => [
    'customer-feedback-gdpr-section'
  ], 
  'attributeList' => [
    'data-js-cf-part' => 'gdpr',
    'style' => 'display: none;'
  ]
])
  @if($gdpr->enabled)
    @typography([
        'element' => 'p',
        'variant' => 'meta',
        'classList' => [
            'c-typography--meta'
        ]
    ])
      {{ $gdpr->content }}
    @endtypography
  @endif
@endelement