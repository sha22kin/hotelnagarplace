@extends('hotel.layouts.app')

@section('title', $page->seo_title ?: websiteTitle($page->name))
@section('description', $page->seo_description ?: general()->meta_description)
@if($page->seo_keyword)@section('keywords', $page->seo_keyword)@endif

@section('content')
{!! $page->description !!}
@php
    // Admin > Rooms (attributes.type = 20), three per row like the design.
    $rooms = \App\Models\Attribute::where('type', 20)->where('status', 'active')
        ->with('imageFile')->orderBy('view')->orderBy('id')->get();
    $roomLink = function ($link) {
        $link = trim((string) $link);
        if ($link === '') return route('index');
        return preg_match('#^(https?:|tel:|mailto:|\#)#i', $link) ? $link : url($link);
    };
@endphp
@foreach($rooms->chunk(3) as $row)
<div class="vc_row">
  @foreach($row as $room)
  @php
      $features = collect(preg_split('/\r\n|\r|\n/', (string) $room->description))->map(fn ($f) => trim($f))->filter();
      $alt = $room->imageFile && $room->imageFile->alt_text ? $room->imageFile->alt_text : $room->name;
  @endphp
  <div class="vc_column vc_col-4">
    <div class="wpb_text_column wpb_content_element"><h3 class="text-center"><strong>{{ $room->name }}</strong></h3></div>

<div class="wpb_single_image wpb_content_element vc_align_center mb-0">
  <figure class="vc_figure"><div class="vc_single_image-wrapper vc_box_border"><img width="600" height="600" src="{{ asset($room->image()) }}" class="vc_single_image-img{{ $room->fetured ? ' img-square' : '' }}" alt="{{ $alt }}" loading="lazy"></div></figure>
</div>
    <div class="wpb_text_column wpb_content_element" style="margin-top:35px">
      @if($room->short_description)<h4>{{ $room->short_description }}</h4>@endif
      @if($features->count())
      <ol>
        @foreach($features as $feature)
        <li>{{ $feature }}</li>
        @endforeach
      </ol>
      @endif
    </div>
    @if($room->seo_title)<div class="vc_btn3-container"><a class="vc_btn3" href="{{ $roomLink($room->seo_description) }}">{{ $room->seo_title }}</a></div>@endif
  </div>
  @endforeach
</div>
@endforeach
@endsection
