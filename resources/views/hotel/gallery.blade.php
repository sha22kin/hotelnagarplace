@extends('hotel.layouts.app')

@section('title', $page->seo_title ?: websiteTitle($page->name))
@section('description', $page->seo_description ?: general()->meta_description)
@if($page->seo_keyword)@section('keywords', $page->seo_keyword)@endif

@section('content')
{!! $page->description !!}
@php
    // Galleries chosen on the page in the admin; otherwise the gallery whose
    // location is "Gallery Page".
    $galleries = $page->Tags()->where('attributes.type', 4)->where('attributes.status', 'active')->get();
    if ($galleries->isEmpty() && ($fallback = gallery('Gallery Page'))) {
        $galleries = collect([$fallback]);
    }
    $images = $galleries->flatMap(fn ($gal) => $gal->galleryImages);
@endphp
@if($images->count())
<div class="vc_row"><div class="vc_column"><div class="wpb_content_element">
  <div class="bwg-thumbnails">
    @foreach($images as $img)
    @php $label = $img->alt_text ?: pathinfo((string) $img->file_name, PATHINFO_FILENAME); @endphp
    <div class="bwg-item"><a class="bwg_lightbox" href="{{ asset($img->file_url) }}"><div class="bwg-item2"><img src="{{ asset($img->file_url) }}" alt="{{ $label }}" title="{{ $label }}" loading="lazy"></div></a></div>
    @endforeach
  </div>
</div></div></div>
@endif
@endsection
