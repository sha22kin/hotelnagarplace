@extends('hotel.layouts.app')

@section('title', $page && $page->seo_title ? $page->seo_title : websiteTitle())
@section('description', $page && $page->seo_description ? $page->seo_description : general()->meta_description)
@if($page && $page->seo_keyword)@section('keywords', $page->seo_keyword)@endif
@section('body_class', 'home')

@section('slider')
@php
    $homeSlider = slider('Front Page Slider');
    $slides = $homeSlider ? $homeSlider->subSliders : collect();
@endphp
@if($slides->count())
      <div class="mfn-main-slider" id="mfn-rev-slider">
        <div class="hero-slider">
          @foreach($slides as $i => $slide)
          <div class="slide{{ $i === 0 ? ' active' : '' }}" style="background-image:url('{{ asset($slide->image()) }}')" role="img" aria-label="{{ $slide->name }}"></div>
          @endforeach
          @if($slides->count() > 1)
          <a class="slider-arrow prev" href="#" onclick="return false" aria-label="Previous slide"><i class="fa-solid fa-chevron-left"></i></a>
          <a class="slider-arrow next" href="#" onclick="return false" aria-label="Next slide"><i class="fa-solid fa-chevron-right"></i></a>
          @endif
        </div>
      </div>
@endif
@endsection

@section('content')
{!! $page ? $page->description : '' !!}
@endsection
