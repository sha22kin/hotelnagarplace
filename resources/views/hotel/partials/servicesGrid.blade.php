@foreach($services->chunk(3) as $row)
<div class="vc_row">
  @foreach($row as $service)
  @php $alt = $service->imageFile && $service->imageFile->alt_text ? $service->imageFile->alt_text : $service->name; @endphp
  <div class="vc_column vc_col-4">

<div class="wpb_single_image wpb_content_element vc_align_center padding mb-0">
  <figure class="vc_figure"><div class="vc_single_image-wrapper vc_box_outline"><img width="600" height="600" src="{{ asset($service->image()) }}" class="vc_single_image-img{{ $service->fetured ? ' img-square' : '' }}" alt="{{ $alt }}" loading="lazy"></div></figure>
</div>
    <div class="wpb_text_column wpb_content_element" style="margin-top:35px"><h3 class="text-center"><strong>{{ $service->name }}</strong></h3></div>
  </div>
  @endforeach
</div>
@endforeach
