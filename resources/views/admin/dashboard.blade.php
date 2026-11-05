@extends(adminTheme().'layouts.app') @section('title')
<title>{{websiteTitle('Dashboard')}}</title>
@endsection @push('css')
<style type="text/css">
    /* Dashboard only — uses the admin theme colours (#4859b9 indigo, #009688 teal). */
    .hd-hero {
        background: linear-gradient(120deg, #4859b9 0%, #3949a3 45%, #009688 100%);
        color: #fff;
        border-radius: 6px;
        padding: 28px 30px;
        margin-bottom: 1.8rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 6px 18px rgba(72, 89, 185, .25);
    }
    .hd-hero::after {
        content: "\f594";
        font-family: "Font Awesome 6 Free";
        font-weight: 900;
        position: absolute;
        right: 30px;
        bottom: -22px;
        font-size: 150px;
        opacity: .08;
        line-height: 1;
    }
    .hd-hero h2 { color: #fff; font-weight: 600; margin: 0 0 6px; font-size: 1.7rem; }
    .hd-hero p { margin: 0; opacity: .9; font-size: 15px; }
    .hd-hero .hd-date { font-size: 13px; opacity: .8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
    .hd-hero .hd-hero-actions { margin-top: 18px; position: relative; z-index: 1; }
    .hd-hero .btn { border-radius: 4px; margin: 4px 8px 4px 0; font-weight: 500; }
    .hd-hero .btn-light { color: #4859b9; background: #fff; border-color: #fff; }
    .hd-hero .btn-light:hover { background: #eef0fb; border-color: #eef0fb; color: #4859b9; }
    .hd-hero .btn-outline-light:hover { color: #4859b9; }

    .hd-stat {
        display: flex;
        flex-direction: row;
        align-items: center;
        padding: 20px;
        height: calc(100% - 1.8rem);
        margin-bottom: 1.8rem;
        border-radius: 6px;
        transition: transform .15s ease, box-shadow .15s ease;
        color: inherit;
    }
    a.hd-stat:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0, 0, 0, .08); color: inherit; }
    .hd-stat-icon {
        width: 56px; height: 56px; min-width: 56px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; color: #fff; margin-right: 16px;
    }
    .hd-stat-num { font-size: 1.8rem; font-weight: 700; line-height: 1.1; color: #464855; }
    .hd-stat > div { min-width: 0; }
    .hd-stat-label { color: #6b6f82; font-size: 14px; margin: 2px 0 0; white-space: nowrap; }
    .hd-stat-sub { color: #98a4b8; font-size: 12px; white-space: nowrap; }
    .hd-bg-indigo { background: #4859b9; }
    .hd-bg-teal { background: #009688; }
    .hd-bg-cyan { background: #00b5b8; }
    .hd-bg-orange { background: #ff9149; }
    .hd-bg-pink { background: #ff4961; }

    .hd-card-tools { position: absolute; right: 15px; top: 50%; transform: translateY(-50%); }
    .hd-card-tools .btn { padding: 4px 12px; font-size: 13px; background: rgba(255,255,255,.15); color: #fff; border: 1px solid rgba(255,255,255,.4); }
    .hd-card-tools .btn:hover { background: #fff; color: #4859b9; }
    .card-header.hd-relative { position: relative; }

    .hd-room {
        border: 1px solid #e8eaf2;
        border-radius: 6px;
        overflow: hidden;
        margin-bottom: 20px;
        background: #fff;
        height: calc(100% - 20px);
        display: flex; flex-direction: column;
    }
    .hd-room-img { position: relative; padding-top: 62%; background: #f4f5fa; }
    .hd-room-img img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .hd-room-img .badge { position: absolute; top: 10px; left: 10px; }
    .hd-room-body { padding: 12px 14px; flex: 1; display: flex; flex-direction: column; }
    .hd-room-name { font-weight: 600; color: #464855; margin: 0 0 4px; font-size: 15px; }
    .hd-room-meta { color: #98a4b8; font-size: 13px; margin-bottom: 10px; flex: 1; }
    .hd-room-body .btn { align-self: flex-start; }
    .hd-empty { text-align: center; color: #98a4b8; padding: 30px 10px; }
    .hd-empty i { font-size: 40px; display: block; margin-bottom: 10px; color: #c5cbe0; }

    .hd-actions a {
        display: flex; align-items: center;
        padding: 12px 6px;
        border-bottom: 1px solid #f0f1f6;
        color: #464855;
        transition: background .15s ease, padding .15s ease;
    }
    .hd-actions a:last-child { border-bottom: 0; }
    .hd-actions a:hover { background: #f7f8fc; padding-left: 12px; color: #4859b9; }
    .hd-actions .hd-a-icon {
        width: 36px; height: 36px; min-width: 36px; border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        color: #fff; font-size: 15px; margin-right: 12px;
    }
    .hd-actions .hd-a-text { flex: 1; font-size: 15px; }
    .hd-actions .hd-a-text small { display: block; color: #98a4b8; font-size: 12px; }
    .hd-actions .fa-chevron-right { color: #c5cbe0; font-size: 12px; }

    .hd-info li { display: flex; padding: 9px 0; border-bottom: 1px dashed #eceef5; font-size: 14px; color: #464855; }
    .hd-info li:last-child { border-bottom: 0; }
    .hd-info li i { width: 26px; color: #009688; margin-top: 3px; }
    .hd-info li span { flex: 1; word-break: break-word; }
    .hd-info .hd-missing { color: #ff4961; font-style: italic; }

    .hd-pages td { vertical-align: middle; }
    .hd-pages .hd-url { color: #98a4b8; font-size: 13px; }
    .hd-pages .btn { margin: 2px; }
    .hd-pages .hd-nowrap { white-space: nowrap; }

    @media (min-width: 1200px) and (max-width: 1500px) {
        .hd-stat { padding: 16px 14px; }
        .hd-stat-icon { width: 46px; height: 46px; min-width: 46px; font-size: 18px; margin-right: 12px; }
    }
    @media (max-width: 575px) {
        .hd-hero { padding: 22px 20px; }
        .hd-hero h2 { font-size: 1.35rem; }
        .hd-stat { flex-direction: column; text-align: center; padding: 16px 10px; }
        .hd-stat-icon { margin: 0 0 8px; width: 46px; height: 46px; min-width: 46px; font-size: 18px; }
        .hd-stat-num { font-size: 1.5rem; }
        .hd-card-tools .hd-hide-xs { display: none; }
    }
</style>
@endpush @section('contents')
@php
    $g = general();
    $user = Auth::user();
    $perm = json_decode($user->permission->permission ?? '[]', true);
    $hour = (int) now()->format('G');
    $greeting = $hour < 12 ? 'Good Morning' : ($hour < 17 ? 'Good Afternoon' : 'Good Evening');
@endphp
<div class="content-header row"></div>
<div class="content-body">

    @include(adminTheme().'alerts')

    <!-- Welcome -->
    <div class="hd-hero">
        <div class="hd-date"><i class="fa-solid fa-calendar-days"></i> {{ now()->format('l, d F Y') }}</div>
        <h2>{{ $greeting }}, {{ $user->name }}!</h2>
        <p>Manage everything on <b>{{ $g->title }}</b> website from here &mdash; pages, rooms, menu, slider and gallery.</p>
        <div class="hd-hero-actions">
            <a href="{{ route('index') }}" target="_blank" rel="noopener" class="btn btn-light"><i class="fa-solid fa-globe"></i> View Website</a>
            @isset($perm['appsSetting']['general'])
            <a href="{{ route('admin.setting','general') }}" class="btn btn-outline-light"><i class="fa-solid fa-gear"></i> Site Settings</a>
            @endisset
        </div>
    </div>

    <!-- Statistics -->
    <div class="row">
        <div class="col-xl col-lg-4 col-md-6 col-6">
            <a href="{{ route('admin.pages') }}" class="card hd-stat">
                <span class="hd-stat-icon hd-bg-indigo"><i class="fa-solid fa-copy"></i></span>
                <div><div class="hd-stat-num">{{ $stats['pages'] }}</div><p class="hd-stat-label">Pages</p><span class="hd-stat-sub">Published</span></div>
            </a>
        </div>
        <div class="col-xl col-lg-4 col-md-6 col-6">
            <a href="{{ route('admin.rooms') }}" class="card hd-stat">
                <span class="hd-stat-icon hd-bg-teal"><i class="fa-solid fa-bed"></i></span>
                <div><div class="hd-stat-num">{{ $stats['rooms'] }}</div><p class="hd-stat-label">Rooms</p><span class="hd-stat-sub">{{ $stats['roomsInactive'] ? $stats['roomsInactive'].' hidden' : 'All visible' }}</span></div>
            </a>
        </div>
        <div class="col-xl col-lg-4 col-md-6 col-6">
            <a href="{{ $headerMenu ? route('admin.menusAction',['edit',$headerMenu->id]) : route('admin.menus') }}" class="card hd-stat">
                <span class="hd-stat-icon hd-bg-cyan"><i class="fa-solid fa-bars"></i></span>
                <div><div class="hd-stat-num">{{ $stats['menuItems'] }}</div><p class="hd-stat-label">Menu Items</p><span class="hd-stat-sub">Header menu</span></div>
            </a>
        </div>
        <div class="col-xl col-lg-6 col-md-6 col-6">
            <a href="{{ $homeSlider ? route('admin.slidersAction',['edit',$homeSlider->id]) : route('admin.sliders') }}" class="card hd-stat">
                <span class="hd-stat-icon hd-bg-orange"><i class="fa-solid fa-panorama"></i></span>
                <div><div class="hd-stat-num">{{ $stats['slides'] }}</div><p class="hd-stat-label">Home Slides</p><span class="hd-stat-sub">Home page</span></div>
            </a>
        </div>
        <div class="col-xl col-lg-6 col-md-12 col-12">
            <a href="{{ $hotelGallery ? route('admin.galleriesAction',['edit',$hotelGallery->id]) : route('admin.galleries') }}" class="card hd-stat">
                <span class="hd-stat-icon hd-bg-pink"><i class="fa-solid fa-images"></i></span>
                <div><div class="hd-stat-num">{{ $stats['galleryImages'] }}</div><p class="hd-stat-label">Photos</p><span class="hd-stat-sub">Gallery page</span></div>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Left: rooms + website pages -->
        <div class="col-xl-8 col-lg-7 col-12">
            <div class="card">
                <div class="card-header hd-relative" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title"><i class="fa-solid fa-bed"></i> Our Rooms</h4>
                    <div class="hd-card-tools">
                        @isset($perm['pages']['add'])
                        <a href="{{ route('admin.roomsAction',['create']) }}" class="btn btn-sm"><i class="fa-solid fa-plus"></i> Add Room</a>
                        @endisset
                        <a href="{{ route('admin.rooms') }}" class="btn btn-sm hd-hide-xs">All Rooms</a>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($rooms->count())
                        <div class="row">
                            @foreach($rooms as $room)
                            @php $features = collect(preg_split('/\r\n|\r|\n/', (string) $room->description))->filter(fn ($f) => trim($f) !== '')->count(); @endphp
                            <div class="col-xl-4 col-md-6 col-12">
                                <div class="hd-room">
                                    <div class="hd-room-img">
                                        <img src="{{ asset($room->image()) }}" alt="{{ $room->name }}" loading="lazy" />
                                        @if($room->status=='active')
                                        <span class="badge badge-success">Active</span>
                                        @else
                                        <span class="badge badge-danger">Hidden</span>
                                        @endif
                                    </div>
                                    <div class="hd-room-body">
                                        <h5 class="hd-room-name">{{ $room->name }}</h5>
                                        <div class="hd-room-meta"><i class="fa-solid fa-list-check"></i> {{ $features }} facilities &nbsp;&middot;&nbsp; Serial {{ (int) $room->view }}</div>
                                        <a href="{{ route('admin.roomsAction',['edit',$room->id]) }}" class="btn btn-sm btn-info"><i class="fa-solid fa-pen-to-square"></i> Edit</a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @else
                        <div class="hd-empty"><i class="fa-solid fa-bed"></i>No rooms yet. Add your first room.</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header hd-relative" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title"><i class="fa-solid fa-copy"></i> Website Pages</h4>
                    <div class="hd-card-tools"><a href="{{ route('admin.pages') }}" class="btn btn-sm">All Pages</a></div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover hd-pages mb-0">
                                <thead>
                                    <tr>
                                        <th style="min-width: 220px;">Page</th>
                                        <th style="min-width: 140px;">Type</th>
                                        <th style="min-width: 90px;">Status</th>
                                        <th style="min-width: 130px;">Last Updated</th>
                                        <th style="min-width: 160px;width: 160px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sitePages as $page)
                                    @php $url = $page->template == 'Front Page' ? route('index') : route('pageView', $page->slug); @endphp
                                    <tr>
                                        <td><b>{{ $page->name }}</b><br /><span class="hd-url">{{ $page->template == 'Front Page' ? '/' : '/'.$page->slug }}</span></td>
                                        <td>{{ ['Front Page' => 'Home Page', 'gallery' => 'Gallery', 'Book Now' => 'Booking Form', 'Rooms' => 'Rooms List', 'Services' => 'Services & Packages', 'About Us' => 'Content'][$page->template] ?? 'Content' }}</td>
                                        <td>
                                            @if($page->status=='active')
                                            <span class="badge badge-success">Active</span>
                                            @else
                                            <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                        <td class="hd-nowrap"><span class="hd-url"><i class="fa-solid fa-clock"></i> {{ $page->updated_at ? $page->updated_at->diffForHumans() : '' }}</span></td>
                                        <td>
                                            <a href="{{ route('admin.pagesAction',['edit',$page->id]) }}" class="btn btn-sm btn-info">Edit</a>
                                            <a href="{{ $url }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-primary"><i class="fa-solid fa-eye"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: quick actions + website info -->
        <div class="col-xl-4 col-lg-5 col-12">
            <div class="card">
                <div class="card-header" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title"><i class="fa-solid fa-bolt"></i> Quick Actions</h4>
                </div>
                <div class="card-content">
                    <div class="card-body hd-actions" style="padding-top: 8px; padding-bottom: 8px;">
                        @if($homePage)
                        <a href="{{ route('admin.pagesAction',['edit',$homePage->id]) }}">
                            <span class="hd-a-icon hd-bg-indigo"><i class="fa-solid fa-house"></i></span>
                            <span class="hd-a-text">Edit Home Page<small>Welcome text, prices, services</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        @endif
                        <a href="{{ route('admin.rooms') }}">
                            <span class="hd-a-icon hd-bg-teal"><i class="fa-solid fa-bed"></i></span>
                            <span class="hd-a-text">Manage Rooms<small>Name, photo, facilities</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <a href="{{ route('admin.hotelServices') }}">
                            <span class="hd-a-icon hd-bg-orange"><i class="fa-solid fa-concierge-bell"></i></span>
                            <span class="hd-a-text">Services &amp; Packages<small>Services photos, package prices</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <a href="{{ $headerMenu ? route('admin.menusAction',['edit',$headerMenu->id]) : route('admin.menus') }}">
                            <span class="hd-a-icon hd-bg-cyan"><i class="fa-solid fa-bars"></i></span>
                            <span class="hd-a-text">Website Menu<small>Add, remove or reorder links</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <a href="{{ $homeSlider ? route('admin.slidersAction',['edit',$homeSlider->id]) : route('admin.sliders') }}">
                            <span class="hd-a-icon hd-bg-orange"><i class="fa-solid fa-panorama"></i></span>
                            <span class="hd-a-text">Home Slider<small>Big photo on the home page</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        <a href="{{ $hotelGallery ? route('admin.galleriesAction',['edit',$hotelGallery->id]) : route('admin.galleries') }}">
                            <span class="hd-a-icon hd-bg-pink"><i class="fa-solid fa-images"></i></span>
                            <span class="hd-a-text">Photo Gallery<small>Add or remove photos</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        @isset($perm['appsSetting']['social'])
                        <a href="{{ route('admin.setting','social') }}">
                            <span class="hd-a-icon hd-bg-indigo"><i class="fa-solid fa-globe"></i></span>
                            <span class="hd-a-text">Social &amp; Footer<small>Facebook, YouTube video</small></span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </a>
                        @endisset
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header hd-relative" style="border-bottom: 1px solid #e3ebf3;">
                    <h4 class="card-title"><i class="fa-solid fa-hotel"></i> Website Info</h4>
                    @isset($perm['appsSetting']['general'])
                    <div class="hd-card-tools"><a href="{{ route('admin.setting','general') }}" class="btn btn-sm"><i class="fa-solid fa-pen-to-square"></i> Edit</a></div>
                    @endisset
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <ul class="list-unstyled hd-info mb-0">
                            <li><i class="fa-solid fa-hotel"></i><span>{{ $g->title }}@if($g->subtitle) ({{ $g->subtitle }})@endif</span></li>
                            <li><i class="fa-solid fa-phone"></i><span>@if($g->mobile){{ $g->mobile }}@else<span class="hd-missing">Phone not set</span>@endif</span></li>
                            <li><i class="fa-solid fa-envelope"></i><span>@if($g->email){{ $g->email }}@else<span class="hd-missing">Email not set</span>@endif</span></li>
                            <li><i class="fa-solid fa-location-dot"></i><span>@if($g->address_one || $g->address_two){{ trim($g->address_one.', '.$g->address_two, ', ') }}@else<span class="hd-missing">Address not set</span>@endif</span></li>
                            <li><i class="fa-solid fa-globe"></i><span>{{ $g->website ?: request()->getHost() }}</span></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection @push('js')
@endpush
