@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:websiteTitle($page->name)}}" />
        <meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
        <meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
        <meta name="image" property="og:image" content="{{asset($page->image())}}" />
        <meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
        <link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}">
@endsection @push('css')
<style>
	.image a img {
    transition: 0.5s all;
    width: 100%;
}
.blogCompany {
    padding: 100px 0;
}
.blog-content .btn {
    border: 1px solid #0e580b;
    color: #1b5f17;
    background: unset;
}
.blog-sidebar .widget-title {
    color: #10570b;
}
.widget_categories .card-body a {
    color: #10570b;
}
.blog-sidebar {
    background-color: unset;
}




/* ============================================================
   Contact Cover Section - Complete CSS Rules
   ============================================================ */

.contact-cover-section {
    position: relative !important;
    width: 100% !important;
    min-height: 300px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    overflow: hidden !important;
    padding: 60px 0 !important;
    margin: 0 !important;
    background-color: #1a1a1a !important;
}

.contact-cover-section img.contact-cover-bg,
.contact-cover-bg {
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    object-fit: cover !important;
    object-position: center !important;
    z-index: 1 !important;
    margin: 0 !important;
    padding: 0 !important;
    border: none !important;
    display: block !important;
}

.contact-cover-section::after {
    content: '' !important;
    position: absolute !important;
    top: 0 !important;
    left: 0 !important;
    width: 100% !important;
    height: 100% !important;
    background: rgb(0 0 0 / 19%) !important;
    z-index: 2 !important;
}

.contact-cover-section .container {
    position: relative !important;
    z-index: 3 !important;
    text-align: center !important;
    max-width: 1200px !important;
    margin: 0 auto !important;
    padding-left: 15px !important;
    padding-right: 15px !important;
}

.contact-cover-section .contact-cover-title {
    color: #ffffff !important;
    font-size: 2.5rem !important;
    font-weight: 700 !important;
    text-transform: capitalize !important;
    margin-top: 0 !important;
    margin-bottom: 15px !important;
    line-height: 1.2 !important;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.4) !important;
}

.contact-cover-section .contact-cover-breadcrumb {
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    gap: 10px !important;
    color: #ffffff !important;
    font-size: 1rem !important;
    font-weight: 400 !important;
}

.contact-cover-section .contact-cover-breadcrumb a {
    color: #ffffff !important;
    text-decoration: none !important;
    transition: opacity 0.3s ease !important;
}

.contact-cover-section .contact-cover-breadcrumb a:hover {
    color: #f0f0f0 !important;
    text-decoration: underline !important;
    opacity: 0.85 !important;
}

.contact-cover-section .contact-cover-breadcrumb .separator {
    color: #ffffff !important;
    font-size: 0.8rem !important;
    display: inline-flex !important;
    align-items: center !important;
}

.contact-cover-section .contact-cover-breadcrumb .current {
    color: #dddddd !important;
    font-weight: 500 !important;
}

@media (max-width: 768px) {
    .contact-cover-section {
        min-height: 200px !important;
        padding: 40px 0 !important;
    }
    .contact-cover-section .contact-cover-title {
        font-size: 1.8rem !important;
    }
    .contact-cover-section .contact-cover-breadcrumb {
        font-size: 0.9rem !important;
    }
}
</style>
@endpush 

@section('contents')

{{--<div class="breadcrumb-area"
@if($page->bannerFile)
style="background-image:url({{asset($page->banner())}});background-repeat: no-repeat;
    background-size: cover;padding: 50px 0;"
@endif
>
    <div class="container">
        <div class="title">
            <h1>{{$page->name}}</h1>
            <ul>
                <li><a href="{{route('index')}}">Home</a></li>
                <li>{{$page->name}}</li>
            </ul>
        </div>
    </div>
</div>--}}

  <section class="contact-cover-section">
    <img src="{{ asset('welcome/images/z1/banner4.webp') }}" alt="Contact Us Banner" class="contact-cover-bg">
    <div class="container">
        <h1 class="contact-cover-title">Blogs</h1>
        <div class="contact-cover-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="current">Blogs</span>
        </div>
    </div>
</section>
    
    
    
        <section class="blog-grid-section section-padding">
        <div class="container">
            <div class="row mb-5 text-center">
                <div class="col-12">
                    <span class="blog-section-badge">Our Journal</span>
                    <h2 class="blog-section-title">Latest Articles & News</h2>
                </div>
            </div>
            
            <div class="row g-4">
                <!-- Blog Post 1 -->
                @foreach($posts as $post)
                <div class="col-lg-4 col-md-6">
                     @include(welcomeTheme().'blogs.includes.blogGrid')
                   
                </div>
                 @endforeach

            </div>

            	<!-- pagination -->
			{{$posts->links(welcomeTheme().'blogs.pagination')}}

            <!-- Pagination -->
           {{-- <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Blog pagination">
                        <ul class="pagination justify-content-center blog-pagination">
                            <li class="page-item disabled"><a class="page-link" href="#"><i class="fa-solid fa-chevron-left"></i></a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#"><i class="fa-solid fa-chevron-right"></i></a></li>
                        </ul>
                    </nav>
                </div>
            </div>--}}
        </div>
    </section>



{{--<div class="blogCompany">
    <div class="container">
		<div class="row">
		<div class="col-md-12">
            <div class="row">
                @foreach($posts as $post)
                <div class="col-md-4">
                  
                </div>
                @endforeach
            </div>
			<!-- pagination -->
			{{$posts->links(welcomeTheme().'blogs.pagination')}}
		</div>
	<div class="col-md-4">
			@include(welcomeTheme().'blogs.includes.sideBar')
		</div>
		</div>
	</div>
</div>--}}




@endsection @push('js') @endpush