<!-- GDPR Notice -->
@element([
  'classList' => [
    'customer-feedback-gdpr-section',
    'u-display--none'
  ], 
  'attributeList' => [
    'data-js-cf-part' => 'gdpr'
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