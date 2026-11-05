@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:websiteTitle($page->name)}}" />
<meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($page->image())}}" />
<meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}">
@endsection
@push('css')
<style>

</style>
@endpush @section('contents')

{{--<div class="pageTitleHeader">
    <div class="container">
        <h1>{{$page->name}}</h1>
    </div>
</div>--}}









    <!-- ==========================================================================
         CONTACT COVER HEADER
         ========================================================================== -->
    <section class="contact-cover-section">
        <div class="container">
            <h1 class="contact-cover-title">{{$page->name}}</h1>
            <div class="contact-cover-breadcrumb">
                <a href="index.html">Home</a>
                <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
                <span class="current">{{$page->name}}</span>
            </div>
        </div>
    </section>




<section class="appointment-section">
  <div class="container">
    <div class="appointment-card">
      <div class="row g-0">

        <!-- Left Content -->
        <div class="col-lg-5">
          <div class="appointment-left">
            <span>Get an Appointment</span>
            <h2>Let’s Discuss Your Sourcing Requirements</h2>
            <p>
              Schedule a consultation with our sourcing team to discuss your apparel requirements,
              production goals, and quality expectations.
            </p>
            <p>
              Whether you need factory sourcing, product development, quality management,
              or complete order execution, we are here to support you.
            </p>

            <ul class="info-list">
              <li><i class="fa-solid fa-shirt"></i> Apparel Sourcing Support</li>
              <li><i class="fa-solid fa-industry"></i> Factory & Production Management</li>
              <li><i class="fa-solid fa-clipboard-check"></i> Quality Control Solutions</li>
              <li><i class="fa-solid fa-handshake"></i> Transparent Communication</li>
            </ul>
          </div>
        </div>

        <!-- Form -->
        <div class="col-lg-7">
          <div class="appointment-form">
            <h3 class="form-title">Request a Quotation</h3>

           @if(Session::has('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success! </strong> {{ Session::get('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<form action="{{ route('contactMail') }}" method="POST">
    @csrf

    <div class="row">

        <div class="col-md-6 mb-3">
            <label class="form-label">Full Name <span class="required">*</span></label>
            <input type="text" name="name" class="form-control"
                placeholder="Your Name Here" value="{{ old('name') }}" required>

            @error('name')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Company Name <span class="required">*</span></label>
            <input type="text" name="company_name" class="form-control"
                placeholder="Your Company Name Here" value="{{ old('company_name') }}" required>

            @error('company_name')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Business Email <span class="required">*</span></label>
            <input type="email" name="email" class="form-control"
                placeholder="Your E-mail Here" value="{{ old('email') }}" required>

            @error('email')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Phone / WhatsApp <span class="required">*</span></label>
            <input type="text" name="phone" class="form-control"
                placeholder="Your Number Here" value="{{ old('phone') }}" required>

            @error('phone')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Country / Region <span class="required">*</span></label>

            <select name="country" class="form-select" required>
                <option value="">--- Select Choice ---</option>
                <option value="Bangladesh" {{ old('country')=='Bangladesh'?'selected':'' }}>Bangladesh</option>
                <option value="United States" {{ old('country')=='United States'?'selected':'' }}>United States</option>
                <option value="United Kingdom" {{ old('country')=='United Kingdom'?'selected':'' }}>United Kingdom</option>
                <option value="Canada" {{ old('country')=='Canada'?'selected':'' }}>Canada</option>
                <option value="Germany" {{ old('country')=='Germany'?'selected':'' }}>Germany</option>
                <option value="Australia" {{ old('country')=='Australia'?'selected':'' }}>Australia</option>
            </select>

            @error('country')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Product Category <span class="required">*</span></label>

            <select name="product_category" class="form-select" required>
                <option value="">Select Category</option>
                <option value="Knitwear" {{ old('product_category')=='Knitwear'?'selected':'' }}>Knitwear</option>
                <option value="Woven" {{ old('product_category')=='Woven'?'selected':'' }}>Woven</option>
                <option value="Denim" {{ old('product_category')=='Denim'?'selected':'' }}>Denim</option>
                <option value="Sportswear" {{ old('product_category')=='Sportswear'?'selected':'' }}>Sportswear</option>
                <option value="Kidswear" {{ old('product_category')=='Kidswear'?'selected':'' }}>Kidswear</option>
                <option value="Outerwear" {{ old('product_category')=='Outerwear'?'selected':'' }}>Outerwear</option>
            </select>

            @error('product_category')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Estimated Order Volume <span class="required">*</span></label>

            <select name="order_volume" class="form-select" required>
                <option value="">--- Select Choice ---</option>
                <option value="500 - 1,000 pcs" {{ old('order_volume')=='500 - 1,000 pcs'?'selected':'' }}>500 - 1,000 pcs</option>
                <option value="1,000 - 5,000 pcs" {{ old('order_volume')=='1,000 - 5,000 pcs'?'selected':'' }}>1,000 - 5,000 pcs</option>
                <option value="5,000 - 10,000 pcs" {{ old('order_volume')=='5,000 - 10,000 pcs'?'selected':'' }}>5,000 - 10,000 pcs</option>
                <option value="10,000+ pcs" {{ old('order_volume')=='10,000+ pcs'?'selected':'' }}>10,000+ pcs</option>
            </select>

            @error('order_volume')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Brief & Order</label>

            <input type="text" name="brief_order" class="form-control"
                placeholder="Brief & Order" value="{{ old('brief_order') }}">

            @error('brief_order')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Preferred Date <span class="required">*</span></label>

            <input type="date" name="preferred_date"
                class="form-control" value="{{ old('preferred_date') }}" required>

            @error('preferred_date')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Preferred Time <span class="required">*</span></label>

            <input type="time" name="preferred_time"
                class="form-control" value="{{ old('preferred_time') }}" required>

            @error('preferred_time')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-12 mb-4">
            <label class="form-label">Message / Project Brief</label>

            <textarea name="message" class="form-control"
                placeholder="Your Message Here">{{ old('message') }}</textarea>

            @error('message')
                <p class="text-danger small mb-0">{{ $message }}</p>
            @enderror
        </div>

        <div class="col-12">
            <button type="submit" class="submit-btn">
                Submit Request
                <i class="fa-solid fa-arrow-right ms-2"></i>
            </button>
        </div>

    </div>
</form>

          </div>
        </div>

      </div>
    </div>
  </div>
</section>





@endsection
@push('js')
@endpush


