@php
    $fbPage = $g->facebook_page_url ?: $g->facebook_link;
    $ytUrl = $g->youtube_video_url;
    $ytId = null;
    if ($ytUrl && preg_match('#(?:youtu\.be/|v=|embed/|shorts/)([A-Za-z0-9_-]{6,})#', $ytUrl, $m)) {
        $ytId = $m[1];
    }
    $digits = preg_replace('/\D/', '', (string) $g->mobile);
    // 01747641419 -> 01747-641419 (how the design writes the phone in the footer)
    $footerPhone = strlen($digits) === 11 ? substr($digits, 0, 5).'-'.substr($digits, 5) : $g->mobile;
    $site = $g->website ?: request()->getHost();
@endphp
  <footer id="Footer" class="clearfix">
    <div class="widgets_wrapper">
      <div class="container">
        <div class="column one-fourth">
          <aside class="widget widget_text">
            <h4>Like us on facebook</h4>
            <div class="textwidget fb-embed">
              @if($fbPage)<iframe src="https://www.facebook.com/plugins/page.php?href={{ urlencode($fbPage) }}&amp;tabs&amp;width=250&amp;height=130&amp;small_header=false&amp;adapt_container_width=true&amp;hide_cover=false&amp;show_facepile=true" width="250" height="130" scrolling="no" allowfullscreen="true" loading="lazy" title="{{ $g->title }} on Facebook"></iframe>@endif
            </div>
          </aside>
        </div>
        <div class="column one-fourth">
          <aside class="widget widget_text">
            <h4>{{ $g->title }}@if($g->subtitle) ({{ $g->subtitle }})@endif</h4>
            <div class="textwidget">
              @if($g->address_one)<p>{{ $g->address_one }}</p>@endif
              @if($g->address_two)<p>{{ $g->address_two }}</p>@endif
              @if($g->postal_address)<p>{{ $g->postal_address }}</p>@endif
              @if($g->email)<p>Mail: <a href="mailto:{{ $g->email }}">{{ $g->email }}</a></p>@endif
              @if($g->mobile)<p>Phone: {{ $footerPhone }}</p>@endif
              <p>web: <a href="{{ route('index') }}">{{ $site }}</a></p>
            </div>
          </aside>
        </div>
        <div class="column one-fourth">
          <aside class="widget widget_media_video">
            <h4>Subscribe Our Channel</h4>
            @if($ytId)<a class="yt-embed" href="{{ $ytUrl }}" target="_blank" rel="noopener" title="Watch on YouTube"><img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="{{ $g->title }} video" loading="lazy"><span class="yt-play"><i class="fa-brands fa-youtube"></i></span></a>@endif
          </aside>
          <aside class="widget widget_media_image">
            <img width="300" height="74" src="{{ $g->footer_logo ? asset($g->footer_logo) : asset('public/hotel/images/capture.png') }}" alt="narsingdi hotel" loading="lazy" onerror="this.style.display='none'">
          </aside>
        </div>
        <div class="column one-fourth">
          <aside class="widget widget_text">
            <div class="textwidget">
              @if($g->google_map_url)<iframe src="{{ $g->google_map_url }}" width="100%" height="250" allowfullscreen loading="lazy" title="{{ $g->title }} map"></iframe>@endif
            </div>
          </aside>
        </div>
      </div>
    </div>

    <div class="footer_copy">
      <div class="container">
        <div class="column one">
          <div class="copyright">
            {!! $g->copyright_text !!}
          </div>
          <a id="back_to_top" href="#" aria-label="Back to top"><i class="fa-solid fa-chevron-up"></i></a>
          @include('hotel.layouts.social')
        </div>
      </div>
    </div>
  </footer>
