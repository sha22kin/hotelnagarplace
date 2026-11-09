@php
    $g = general();
    $hotelAsset = fn ($path) => asset('public/hotel/'.$path);

    // Menu links from the admin can be pages, categories or custom links
    // (e.g. "tel:+8801747641419"); turn each into a usable href.
    $menuHref = function ($item) {
        $link = (string) $item->menuLink();
        if ($link === '' || $link === '/' ) {
            return route('index');
        }
        if (preg_match('#^(https?:|tel:|mailto:|\#)#i', $link)) {
            return $link;
        }
        return url($link);
    };
    $isCurrent = function ($href) {
        $current = rtrim(url()->current(), '/');
        $href = rtrim(strtok($href, '?#'), '/');
        if ($href === rtrim(url('home'), '/')) {
            $href = rtrim(route('index'), '/');
        }
        return $href !== '' && $href === $current;
    };

    $headerMenu = menu('Header Menus');
    $menuItems = $headerMenu ? $headerMenu->subMenus : collect();
    $hasSubMenus = $menuItems->contains(fn ($m) => $m->subMenus->count() > 0);

    $tel = preg_replace('/[^0-9+]/', '', (string) $g->mobile);
    $telHref = $tel ? (str_starts_with($tel, '+') ? $tel : '+88'.$tel) : '';
    $socials = [
        'facebook' => [$g->facebook_link, 'Facebook', 'fa-brands fa-facebook-f'],
        'twitter' => [$g->twitter_link, 'Twitter', 'fa-brands fa-twitter'],
        'youtube' => [$g->youtube_link, 'YouTube', 'fa-solid fa-play'],
        'linkedin' => [$g->linkedin_link, 'LinkedIn', 'fa-brands fa-linkedin-in'],
    ];
@endphp
<!DOCTYPE html>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title', $g->title)</title>
<meta name="description" content="@yield('description', $g->meta_description)">
@hasSection('keywords')<meta name="keywords" content="@yield('keywords')">@endif
<link rel="icon" href="{{ $g->favicon ? asset($g->favicon) : $hotelAsset('images/favicon.png') }}">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,700;1,400&family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,400&display=swap">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
<link rel="stylesheet" href="{{ $hotelAsset('css/style.css') }}?v={{ @filemtime(public_path('hotel/css/style.css')) }}">
@if($hasSubMenus)<link rel="stylesheet" href="{{ $hotelAsset('css/submenu.css') }}">@endif
@if($g->custom_css)<style>{!! $g->custom_css !!}</style>@endif
{!! $g->script_head !!}
@stack('head')
</head>
<body class="@yield('body_class', 'page')">
{!! $g->script_body !!}

<div id="Wrapper">

  <div id="Header_wrapper">
    <header id="Header">
      <div id="Action_bar">
       <div class="container">
    <div class="column one">
        <ul class="contact_details">
            <li class="slogan">{{ $g->title }}</li>
            @if($g->mobile)
                <li class="phone"><i class="fa-solid fa-phone"></i><a href="tel:{{ $telHref }}">Cell: {{ $g->mobile }}</a></li>
            @endif
            @if($g->email)
                <li class="mail"><i class="fa-regular fa-envelope"></i><a href="mailto:{{ $g->email }}">Email: {{ $g->email }}</a></li>
            @endif
        </ul>
        @include('hotel.layouts.social')
    </div>
</div>
      </div>

      <div class="header_placeholder"></div>

      <div id="Top_bar">
        <div class="container">
          <div class="column one">
            <div class="top_bar_left">
              <div class="logo">
                <a id="logo" href="{{ route('index') }}" title="{{ $g->title }}">
                  <img class="logo-main" src="{{ $g->logo ? asset($g->logo) : $hotelAsset('images/logo.png') }}" alt="{{ \Illuminate\Support\Str::slug($g->title) }}">
                  <img class="logo-sticky" src="{{ $g->logo ? asset($g->logo) : $hotelAsset('images/logo.png') }}" alt="{{ \Illuminate\Support\Str::slug($g->title) }}">
                  <span class="logo-text">{{ $g->title }}</span>
                </a>
              </div>
              <div class="menu_wrapper">
                <nav id="menu"><ul id="menu-main-menu" class="menu menu-main">@foreach($menuItems as $item)@php $href = $menuHref($item); $children = $item->subMenus; $active = $isCurrent($href) || $children->contains(fn ($c) => $isCurrent($menuHref($c))); @endphp<li class="menu-item{{ $active ? ' current-menu-item' : '' }}"><a href="{{ $href }}"><span>{{ $item->menuName() }}</span></a>@if($children->count())<ul class="sub-menu">@foreach($children as $child)@php $childHref = $menuHref($child); @endphp<li class="menu-item{{ $isCurrent($childHref) ? ' current-menu-item' : '' }}"><a href="{{ $childHref }}"><span>{{ $child->menuName() }}</span></a></li>@endforeach</ul>@endif</li>@endforeach</ul></nav>
              </div>
              <a class="search_button" href="#" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></a>
              <a class="responsive-menu-toggle" href="#" aria-label="Menu"><i class="fa-solid fa-bars"></i></a>
              <div class="search_wrapper">
                <form method="get" id="searchform" action="#" data-site="{{ $g->website ?: request()->getHost() }}">
                  <i class="icon_search fa-solid fa-magnifying-glass"></i>
                  <a href="#" class="icon_close" aria-label="Close search"><i class="fa-solid fa-xmark"></i></a>
                  <input type="text" class="field" name="s" placeholder="Enter your search">
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>

      @yield('slider')
    </header>
  </div>

  <div id="Content">
    <div class="content_wrapper clearfix">
      <div class="sections_group">
        <div class="entry-content">
          <div class="section the_content"><div class="section_wrapper">

@if(session('success'))<div class="hotel-alert hotel-alert-success" style="margin:20px 0 0;padding:12px 16px;background:#e7f6ee;border:1px solid #b7e3c8;color:#1e6b3a;">{{ session('success') }}</div>@endif
@if(session('error'))<div class="hotel-alert hotel-alert-error" style="margin:20px 0 0;padding:12px 16px;background:#fdecec;border:1px solid #f5c2c2;color:#8a1f1f;">{{ session('error') }}</div>@endif

@yield('content')
          </div></div>
        </div>
      </div>
    </div>
  </div>

  @include('hotel.layouts.footer')

</div>

<div id="Side_slide">
  <div class="close-wrapper"><a href="#" class="close" aria-label="Close menu"><i class="fa-solid fa-xmark"></i></a></div>
  <div class="menu_wrapper"></div>
  @include('hotel.layouts.social')
</div>
<div id="body_overlay"></div>

<script src="{{ $hotelAsset('js/main.js') }}?v={{ @filemtime(public_path('hotel/js/main.js')) }}"></script>
@if($g->custom_js)<script>{!! $g->custom_js !!}</script>@endif
@stack('scripts')
</body>
</html>
