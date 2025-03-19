<!-- GDPR Notice -->
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