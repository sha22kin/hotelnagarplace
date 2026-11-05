<!-- home page slider part start -->
<!--<div class="homeSliderPart">-->
<!--    @if($slider =slider('Front Page Slider'))-->
<!--    <div id="carouselSlider" class="carousel slide" data-bs-ride="carousel" data-bs-pause="false">-->
<!--      <div class="carousel-inner">-->
<!--        @foreach($slider->subSliders as $i=>$slider)-->
<!--        <div class="carousel-item {{$i==0?'active':''}}" data-bs-interval="3000">-->
<!--          <img style="width:100%;" src="{{asset($slider->image())}}" alt="{{$slider->name}}" title="{{$slider->name}}" />-->
<!--            <div class="carousel-caption d-md-block">-->
<!--                <h1 data-aos="fade-up">-->
<!--                    {!!$slider->name!!}-->
<!--                </h1>-->
<!--                <p data-aos="fade-down">-->
<!--                    {!!$slider->description!!}-->
<!--                </p>-->
<!--                @if($slider->seo_title)-->
<!--                <a class="shopNowBtn" @if($slider->seo_keyword) style="background:{{$slider->seo_keyword}}" @endif href="{{$slider->seo_description?:javascript::void(0)}}">{{$slider->seo_title}}</a>-->
<!--                @endif-->
<!--            </div>-->
<!--        </div>-->
<!--        @endforeach-->
<!--      </div>-->
<!--      <button class="carousel-control-prev" type="button" data-bs-target="#carouselSlider" data-bs-slide="prev">-->
<!--        <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
<!--        <span class="visually-hidden">Previous</span>-->
<!--      </button>-->
<!--      <button class="carousel-control-next" type="button" data-bs-target="#carouselSlider" data-bs-slide="next">-->
<!--        <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
<!--        <span class="visually-hidden">Next</span>-->
<!--      </button>-->
<!--    </div>-->
<!--    @endif-->
    
<!--</div>-->
<!-- home page slider part end -->
<section class="hero-slider-section">
        <!-- Bootstrap Carousel Slider -->
         @if($slider =slider('Front Page Slider'))
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
            
            <div class="carousel-inner">
                
                 @foreach($slider->subSliders as $i=>$slider)
                <div class="carousel-item {{$i==0?'active':''}}">
                    <img src="{{asset($slider->image())}}" class="d-block w-100 hero-slide-img"
                        alt="Nuvesta Apparel Sourcing Slide 1">
                </div>
                 @endforeach
               
            </div>
        </div>
        @endif

        <!-- Static Text Overlay -->
        <div class="hero-overlay-content d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-7 hero-text-col" data-aos="fade-up" data-aos-duration="1000">
                        <span class="hero-tag">100%<br>EXPORT<br>ORIENTED</span>
                        <h1 class="hero-title">YOUR TRUSTED APPAREL<br>SOURCING PARTNER<br>IN BANGLADESH</h1>
                        <a href="#" class="hero-cta-btn" id="hero-cta-btn">INQUIRY</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Split Bottom Bar (navy blue left, coral red right) -->
        <div class="hero-bottom-bar">
            <div class="hero-bar-navy"></div>
            <div class="hero-bar-coral"></div>
        </div>
    </section>