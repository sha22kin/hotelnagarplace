@foreach($packages->chunk(3) as $row)
<div class="vc_row">
  @foreach($row as $package)
  @php $features = collect(preg_split('/\r\n|\r|\n/', (string) $package->description))->map(fn ($f) => trim($f))->filter(); @endphp
  <div class="vc_column vc_col-4">
    <div class="wpb_text_column wpb_content_element package-box">
      @if($package->short_description)<h2><strong>{{ $package->short_description }}</strong></h2>@endif
      <h3><strong>{{ $package->name }}</strong></h3>
      @if($package->seo_title)<h3>{{ $package->seo_title }}</h3>@endif
      @foreach($features as $feature)
      <p>{{ $feature }}</p>
      @endforeach
    </div>
  </div>
  @endforeach
</div>
@endforeach
