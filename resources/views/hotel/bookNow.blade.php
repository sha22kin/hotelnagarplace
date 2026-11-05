@extends('hotel.layouts.app')

@section('title', $page->seo_title ?: websiteTitle($page->name))
@section('description', $page->seo_description ?: general()->meta_description)
@if($page->seo_keyword)@section('keywords', $page->seo_keyword)@endif

@section('content')
{!! $page->description !!}
@php
    // One package per line in the page's "Short Description" (admin panel).
    $packages = collect(preg_split('/\r\n|\r|\n/', strip_tags((string) $page->short_description)))
        ->map(fn ($p) => trim($p))->filter()->values();
@endphp
<div class="vc_row">
  <div class="vc_column vc_col-6">
    <div class="wpb_text_column wpb_content_element">
      <div class="wpforms-container">
        <form id="wpforms-form-71" class="wpforms-form" method="post" action="#" data-mailto="{{ general()->email }}">
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-name">Your Name *</label><input type="text" id="f-name" name="name" placeholder="Your Name" required></div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-email">Your Email *</label><input type="email" id="f-email" name="email" placeholder="Email" required></div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-phone">Phone Number *</label><input type="tel" id="f-phone" name="phone" placeholder="Phone Number" required></div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-package">Dropdown</label>
            <select id="f-package" name="package">
              <option value="Select Package" selected>Select Package</option>
              @foreach($packages as $package)
              <option value="{{ $package }}">{{ $package }}</option>
              @endforeach
            </select>
          </div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-start">Booking Date Start</label><input type="text" id="f-start" name="date_start" placeholder="Booking Date Start( Exp: 01/05/2018 )"></div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-end">Booking Date End</label><input type="text" id="f-end" name="date_end" placeholder="Booking Date End( Exp: 01/05/2018 )"></div>
          <div class="wpforms-field"><label class="wpforms-field-label hide" for="f-msg">Messages</label><textarea id="f-msg" name="message" placeholder="Messages"></textarea></div>
          <div class="wpforms-submit-container"><button type="submit" class="wpforms-submit">Submit</button></div>
        </form>
        <div class="wpforms-confirmation">Thanks for contacting us! We will be in touch with you shortly.</div>
      </div>
    </div>
  </div>
  <div class="vc_column vc_col-6"></div>
</div>
@endsection
