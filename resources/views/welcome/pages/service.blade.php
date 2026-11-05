@extends(welcomeTheme().'layouts.app') @section('title')
<title>{{$page->seo_title?:websiteTitle($page->name)}}</title>
@endsection @section('SEO')
<meta name="title" property="og:title" content="{{$page->seo_title?:websiteTitle($page->name)}}" />
<meta name="description" property="og:description" content="{!!$page->seo_description?:general()->meta_description!!}" />
<meta name="keywords" content="{{$page->seo_keyword?:general()->meta_keyword}}" />
<meta name="image" property="og:image" content="{{asset($page->image())}}" />
<meta name="url" property="og:url" content="{{route('pageView',$page->slug?:'no-title')}}" />
<link rel="canonical" href="{{route('pageView',$page->slug?:'no-title')}}" />
@endsection @push('css')
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
</style>
@endpush @section('contents')

    <!-- ==========================================================================
         1. SERVICES MINIMAL HEADER COVER
         ========================================================================== -->
<section class="contact-cover-section">
    <img src="{{ asset('welcome/images/z1/banner5.webp') }}" alt="Contact Us Banner" class="contact-cover-bg">
    <div class="container">
        <h1 class="contact-cover-title">Service</h1>
        <div class="contact-cover-breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <span class="separator"><i class="fa-solid fa-chevron-right"></i></span>
            <span class="current">Service</span>
        </div>
    </div>
</section>

    <!-- ==========================================================================
         2. INTRO BANNER (EDITORIAL STATEMENT)
         ========================================================================== -->
    <section class="services-intro-section" data-aos="fade-up" style="padding: 80px 0;">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <span class="services-section-badge">Global Sourcing</span>
                    <h2 class="services-intro-title" style="margin-bottom: 20px;">Connecting Brands with Reliable Apparel Solutions</h2>
                    <p class="services-intro-text" style="margin-bottom: 30px;">
                        Zero One BD Sourcing Ltd provides complete apparel sourcing and supply chain services for international brands. From factory sourcing and product development to quality control and logistics, we ensure efficient, reliable, and on-time delivery.
                    </p>
                    <div class="services-intro-highlight" style="padding: 20px; background-color: #f8f9fa; border-left: 4px solid #2a9282; border-radius: 4px;">
                        <strong class="d-block text-dark mb-1">Dhaka & Vilnius Offices</strong>
                        <span class="text-muted small">Seamless European coordination with direct Bangladesh manufacturing power.</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="services-intro-image-wrap position-relative">
                        <img src="https://images.unsplash.com/photo-1520006403909-838d6b92c22e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1000&q=80" alt="Garment Buying House Showroom" class="img-fluid rounded" style="box-shadow: 0 20px 40px rgba(0,0,0,0.08); width: 100%; object-fit: cover; height: 450px;">
                        <div class="position-absolute bg-white p-3 rounded shadow-sm d-flex align-items-center gap-3" style="bottom: -20px; left: -20px;">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background-color: #0f2957 !important;">
                                <i class="fa-solid fa-check-double"></i>
                            </div>
                            <div>
                                <h6 class="mb-0 fw-bold" style="color: #0f2957;">100% Quality</h6>
                                <small class="text-muted">Assurance</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         3. WHAT WE OFFER (HIGH-CONTRAST BENTO GRID)
         ========================================================================== -->
    <section class="services-offer-section">
        <div class="container">
            <div class="text-center max-w-700 mx-auto" data-aos="fade-up">
                <span class="services-section-badge">Capabilities</span>
                <h2>What We Offer</h2>
            </div>

            <div class="services-bento-grid">
                <!-- Bento Card 1 (Dark Theme) -->
                <div class="services-bento-card bento-dark" data-aos="fade-up" data-aos-delay="100">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-industry"></i>
                            </div>
                            <span class="services-bento-num">01</span>
                        </div>
                        <h3 class="services-bento-title">Factory Sourcing</h3>
                    </div>
                    <p class="services-bento-desc">Connecting you with trusted and compliant garment manufacturers in Bangladesh holding international accreditations.</p>
                </div>

                <!-- Bento Card 2 (Standard Theme) -->
                <div class="services-bento-card" data-aos="fade-up" data-aos-delay="150">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-scissors"></i>
                            </div>
                            <span class="services-bento-num">02</span>
                        </div>
                        <h3 class="services-bento-title">Sample Development</h3>
                    </div>
                    <p class="services-bento-desc">Managing samples from initial concept to final approval with technical precision, exact measurements, and material quality.</p>
                </div>

                <!-- Bento Card 3 (Coral Accent Theme) -->
                <div class="services-bento-card bento-accent" data-aos="fade-up" data-aos-delay="200">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-circle-check"></i>
                            </div>
                            <span class="services-bento-num">03</span>
                        </div>
                        <h3 class="services-bento-title">Total QA Management</h3>
                    </div>
                    <p class="services-bento-desc">Conducting comprehensive inline inspections and quality checks throughout every stage of the manufacturing process.</p>
                </div>

                <!-- Bento Card 4 (Dark Theme) -->
                <div class="services-bento-card bento-dark" data-aos="fade-up" data-aos-delay="250">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-calendar-days"></i>
                            </div>
                            <span class="services-bento-num">04</span>
                        </div>
                        <h3 class="services-bento-title">PPC & FRI</h3>
                    </div>
                    <p class="services-bento-desc">Ensuring production planning control (PPC) and final random inspections (FRI) to maintain zero-defect export standards.</p>
                </div>

                <!-- Bento Card 5 (Standard Theme) -->
                <div class="services-bento-card" data-aos="fade-up" data-aos-delay="300">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-ship"></i>
                            </div>
                            <span class="services-bento-num">05</span>
                        </div>
                        <h3 class="services-bento-title">Logistics Coordination</h3>
                    </div>
                    <p class="services-bento-desc">Managing freight booking, shipping, compliance documentation, and customs delivery for a seamless global export process.</p>
                </div>

                <!-- Bento Card 6 (Standard Theme) -->
                <div class="services-bento-card" data-aos="fade-up" data-aos-delay="350">
                    <div>
                        <div class="services-bento-header">
                            <div class="services-bento-icon">
                                <i class="fa-solid fa-file-invoice-dollar"></i>
                            </div>
                            <span class="services-bento-num">06</span>
                        </div>
                        <h3 class="services-bento-title">Pricing & Admin Support</h3>
                    </div>
                    <p class="services-bento-desc">Providing transparent costing structures, active order management, and complete administrative assistance.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         4. WHY CHOOSE US (SOURCING EXCELLENCE SHOWCASE)
         ========================================================================== -->
    <section class="services-why-section">
        <div class="container">
            <div class="row g-5">
                <!-- Left: Sticky Editorial Sourcing Panel -->
                <div class="col-lg-5" data-aos="fade-right">
                    <div class="services-why-sticky-box">
                        <span class="services-section-badge">The Nuvesta Edge</span>
                        <h2 class="services-why-sticky-title">Why Partner With Us?</h2>
                        <p class="services-why-sticky-text">
                            We bridge global fashion buyers with top Bangladesh manufacturers through operational transparency, strict technical precision, and reliable execution.
                        </p>

                        <div class="services-why-metrics-box">
                            <div class="services-why-metric-item">
                                <div class="services-why-metric-icon"><i class="fa-solid fa-check"></i></div>
                                <div class="services-why-metric-text">
                                    <strong>Vetted Manufacturing Network</strong>
                                    <span>Accredited with WRAP, SEDEX & BSCI</span>
                                </div>
                            </div>
                            <div class="services-why-metric-item">
                                <div class="services-why-metric-icon"><i class="fa-solid fa-check"></i></div>
                                <div class="services-why-metric-text">
                                    <strong>Direct Factory Pricing</strong>
                                    <span>Zero middleman markup inflation</span>
                                </div>
                            </div>
                            <div class="services-why-metric-item">
                                <div class="services-why-metric-icon"><i class="fa-solid fa-check"></i></div>
                                <div class="services-why-metric-text">
                                    <strong>Dual-Office Support</strong>
                                    <span>Coordinated from Dhaka & Vilnius</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mt-4 overflow-hidden rounded shadow-sm">
                            <img src="https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Garment Sourcing Fabric Swatches" class="img-fluid w-100" style="object-fit: cover; height: 220px; transition: transform 0.3s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                        </div>
                    </div>
                </div>

                <!-- Right: Alternating Edge Cards Grid -->
                <div class="col-lg-7" data-aos="fade-left">
                    <div class="row g-4">
                        <!-- Advantage 1 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-1">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">01</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-network-wired"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">Trusted Manufacturing Network</h4>
                                </div>
                                <p class="services-edge-text">Direct access to compliant garment factories in Bangladesh holding verified social and safety accreditations.</p>
                            </div>
                        </div>

                        <!-- Advantage 2 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-2">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">02</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-clipboard-check"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">Quality-Focused Production</h4>
                                </div>
                                <p class="services-edge-text">Rigorous inline and final quality auditing overseen by our dedicated local quality assurance inspectors.</p>
                            </div>
                        </div>

                        <!-- Advantage 3 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-1">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">03</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-tags"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">Competitive Pricing & Transparency</h4>
                                </div>
                                <p class="services-edge-text">Open costing layouts and direct factory negotiations designed to protect buyer margins and competitiveness.</p>
                            </div>
                        </div>

                        <!-- Advantage 4 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-2">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">04</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-user-tie"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">Experienced Sourcing Professionals</h4>
                                </div>
                                <p class="services-edge-text">A skilled team of textile engineers and merchandisers handling complex technical specifications and timelines.</p>
                            </div>
                        </div>

                        <!-- Advantage 5 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-1">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">05</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-comments"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">On-Time Delivery & Reliable Communication</h4>
                                </div>
                                <p class="services-edge-text">Proactive status reporting and daily production tracking to ensure zero surprises and punctual shipments.</p>
                            </div>
                        </div>

                        <!-- Advantage 6 -->
                        <div class="col-md-6">
                            <div class="services-edge-card edge-style-2">
                                <div>
                                    <div class="services-edge-top">
                                        <span class="services-edge-num">06</span>
                                        <div class="services-edge-icon-box">
                                            <i class="fa-solid fa-headset"></i>
                                        </div>
                                    </div>
                                    <h4 class="services-edge-title">Dedicated Customer Support</h4>
                                </div>
                                <p class="services-edge-text">Dual-office coordination between Dhaka, Bangladesh and Vilnius, Lithuania providing seamless communication.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         5. OUR WORK PROCESS (HIGH-CONTRAST ARCHITECTURAL FLOW)
         ========================================================================== -->
    <section class="services-process-section">
        <div class="container">
            <div class="text-center" data-aos="fade-up">
                <span class="services-section-badge">Step-By-Step</span>
                <h2 class="services-process-title">Our Work Process</h2>
            </div>

            <div class="services-process-grid">
                <!-- Process Step 1 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="100">
                    <span class="services-process-step-num">1</span>
                    <h4 class="services-process-step-name">Requirement Analysis</h4>
                    <p class="services-process-step-desc">Gathering style tech packs, fabric specifications, target pricing, and order quantities.</p>
                </div>

                <!-- Process Step 2 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="150">
                    <span class="services-process-step-num">2</span>
                    <h4 class="services-process-step-name">Design Development</h4>
                    <p class="services-process-step-desc">Refining sketches, selecting yarns, and creating prototype samples for fit approval.</p>
                </div>

                <!-- Process Step 3 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="200">
                    <span class="services-process-step-num">3</span>
                    <h4 class="services-process-step-name">Factory Sourcing</h4>
                    <p class="services-process-step-desc">Matching your production requirements with accredited manufacturers for optimal execution.</p>
                </div>

                <!-- Process Step 4 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="250">
                    <span class="services-process-step-num">4</span>
                    <h4 class="services-process-step-name">Order Execution</h4>
                    <p class="services-process-step-desc">Daily capacity monitoring, production planning control (PPC), and timeline tracking.</p>
                </div>

                <!-- Process Step 5 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="300">
                    <span class="services-process-step-num">5</span>
                    <h4 class="services-process-step-name">Final Inspection</h4>
                    <p class="services-process-step-desc">Conducting rigorous AQL auditing of finished apparel batches before carton packaging.</p>
                </div>

                <!-- Process Step 6 -->
                <div class="services-process-card" data-aos="zoom-in" data-aos-delay="350">
                    <span class="services-process-step-num">6</span>
                    <h4 class="services-process-step-name">Delivery</h4>
                    <p class="services-process-step-desc">Managing export customs documentation, vessel booking, and secure shipment loading.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ==========================================================================
         6. CTA CONSULTATION BANNER (MODERN MINIMAL BOX)
         ========================================================================== -->
    <section class="services-cta-banner">
        <div class="container" data-aos="fade-up">
            <div class="services-cta-box">
                <span class="services-section-badge">Start Sourcing</span>
                <h2 class="services-cta-heading">Your Trusted Sourcing Partner</h2>
                <p class="services-cta-text">
                    Partner with Zero One BD Sourcing Ltd for dependable apparel sourcing, quality assurance, and efficient supply chain solutions that help your business grow with confidence.
                </p>
                <a href="contact.html" class="services-cta-button">Book Your Consultation</a>
            </div>
        </div>
    </section>



@endsection @push('js') @endpush