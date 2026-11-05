@extends(welcomeTheme().'layouts.app')
@section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection
@section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:websiteTitle($page->name)}}" />
<meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($page->image())}}" />
<meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}">
@endsection
@push('css')
<style>

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

.gallery-section {
        padding-top: 30px !important;
        padding-bottom: 80px !important;
    }

    .gallery-title {
        margin: 0 0 15px;
        font-size: 42px;
        font-weight: 700;
        line-height: 1.2;
    }

    .gallery-description {
        max-width: 650px;
        margin: 0 auto 45px;
        font-size: 16px;
        line-height: 1.8;
        color: #777;
    }

    .gallery-item {
        display: block;
        overflow: hidden;
        margin: 0;
        padding: 0;
        border-radius: 12px;
        cursor: pointer;
        background: #f5f5f5;
    }

    .gallery-item img {
        width: 100%;
        height: 280px;
        padding: 0;
        margin: 0;
        display: block;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .gallery-item:hover img {
        transform: scale(1.06);
    }

    #galleryModal .modal-dialog {
        max-width: 95%;
    }

    #galleryModalImage {
        max-width: 100%;
        max-height: 90vh;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    @media (max-width: 991.98px) {
        .gallery-section {
            padding-top: 60px !important;
            padding-bottom: 60px !important;
        }

        .gallery-title {
            font-size: 34px;
        }

        .gallery-item img {
            height: 240px;
        }
    }

    @media (max-width: 575.98px) {
        .gallery-title {
            font-size: 28px;
        }

        .gallery-description {
            margin-bottom: 30px;
        }

        .gallery-item img {
            height: 200px;
        }
    }



</style>
@endpush
@section('contents')

<section class="contact-cover-section">
    <img src="{{ asset('welcome/images/z1/banner2.webp') }}" alt="Contact Us Banner" class="contact-cover-bg">
    <div class="container">
        <h1 class="contact-cover-title">Gallery</h1>
        <div class="contact-cover-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="current">Gallery</span>
        </div>
    </div>
</section>


<section class="gallery-section py-5">
    <div class="container">

        <div class="text-center mb-5">
            <h2 class="gallery-title">Our Images Gallery</h2>
            <p class="gallery-description">
                Explore our garment factory, production process, team and workplace.
            </p>
        </div>

        <div class="row g-4">

            <!-- 1 -->
            <div class="col-6 col-lg-3">
                <a href="https://www.tbsnews.net/sites/default/files/styles/amp_metadata_content_image_min_696px_wide/public/images/2025/03/07/rmg_tram_group_nidle_3_0.jpeg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://www.tbsnews.net/sites/default/files/styles/amp_metadata_content_image_min_696px_wide/public/images/2025/03/07/rmg_tram_group_nidle_3_0.jpeg"
                         class="img-fluid w-100"
                         alt="Bangladesh garment factory workers">
                </a>
            </div>

            <!-- 2 -->
            <div class="col-6 col-lg-3">
                <a href="https://textiletoday.com.bd/storage/uploads/2023/04/rmg-4_11zon.jpeg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://textiletoday.com.bd/storage/uploads/2023/04/rmg-4_11zon.jpeg"
                         class="img-fluid w-100"
                         alt="Garment production line Bangladesh">
                </a>
            </div>

            <!-- 3 -->
            <div class="col-6 col-lg-3">
                <a href="https://cdn.prod.website-files.com/63d0c93e6ceec6358feec098/63d0c93e6ceec67fb2eec1f0_IMG_7518.webp"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://cdn.prod.website-files.com/63d0c93e6ceec6358feec098/63d0c93e6ceec67fb2eec1f0_IMG_7518.webp"
                         class="img-fluid w-100"
                         alt="Bangladesh apparel factory">
                </a>
            </div>

            <!-- 4 -->
            <div class="col-6 col-lg-3">
                <a href="https://specials-images.forbesimg.com/imageserve/1197101197/960x0.jpg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://specials-images.forbesimg.com/imageserve/1197101197/960x0.jpg"
                         class="img-fluid w-100"
                         alt="Bangladesh garment workers">
                </a>
            </div>

            <!-- 5 -->
            <div class="col-6 col-lg-3">
                <a href="https://rising-group.com/wp-content/uploads/elementor/thumbs/who-we-are-qwc1kmkw559go0c0q6wbk24zjuxa7hwytp0h30kijk.jpg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://rising-group.com/wp-content/uploads/elementor/thumbs/who-we-are-qwc1kmkw559go0c0q6wbk24zjuxa7hwytp0h30kijk.jpg"
                         class="img-fluid w-100"
                         alt="Garment quality inspection Bangladesh">
                </a>
            </div>

            <!-- 6 -->
            <div class="col-6 col-lg-3">
                <a href="https://garmentsmerchandising.com/wp-content/uploads/2016/02/Ironing-Or-Pressing-Section-In-Garments-Industry.jpg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://garmentsmerchandising.com/wp-content/uploads/2016/02/Ironing-Or-Pressing-Section-In-Garments-Industry.jpg"
                         class="img-fluid w-100"
                         alt="Garment factory ironing section">
                </a>
            </div>

            <!-- 7 -->
            <div class="col-6 col-lg-3">
                <a href="https://upload.wikimedia.org/wikipedia/commons/e/e6/Knit_Fabric_Cutting_in_a_RMG_factory_of_Bangladesh.JPG"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e6/Knit_Fabric_Cutting_in_a_RMG_factory_of_Bangladesh.JPG"
                         class="img-fluid w-100"
                         alt="Bangladesh garment fabric cutting">
                </a>
            </div>

            <!-- 8 -->
            <div class="col-6 col-lg-3">
                <a href="https://texterrain.com/sites/default/files/tt-all-img/Material%20Sourcing-min.jpg"
                   class="gallery-item"
                   data-bs-toggle="modal"
                   data-bs-target="#galleryModal">
                    <img src="https://texterrain.com/sites/default/files/tt-all-img/Material%20Sourcing-min.jpg"
                         class="img-fluid w-100"
                         alt="Bangladesh textile warehouse">
                </a>
            </div>

        </div>
    </div>

    <!-- Full Image Modal -->
    <div class="modal fade" id="galleryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-transparent border-0">

                <div class="modal-body p-0 text-center position-relative">

                    <button type="button"
                            class="btn-close btn-close-white position-absolute top-0 end-0 m-3"
                            data-bs-dismiss="modal"
                            aria-label="Close">
                    </button>

                    <img id="galleryModalImage"
                         src=""
                         class="img-fluid rounded"
                         alt="Full gallery image">

                </div>

            </div>
        </div>
    </div>
</section>





@endsection
@push('js')
<script>
    document.querySelectorAll('.gallery-item').forEach(function (item) {
        item.addEventListener('click', function () {
            document.getElementById('galleryModalImage').src = this.href;
        });
    });
</script>

@endpush