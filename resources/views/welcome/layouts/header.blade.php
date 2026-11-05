

    <header class="top-bar">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Contact info (Left) -->
                <div>
                    <a href="mailto:{{general()->email}}" class="top-bar-link" id="header-email">
                        <i class="fa-regular fa-envelope me-2"></i>{{general()->email}}
                    </a>
                    <a href="tel:{{general()->mobile}}" class="top-bar-link" id="header-phone">
                        <i class="fa-solid fa-phone me-2"></i>{{general()->mobile}}
                    </a>
                </div>
                <!-- Social Media Icons (Right) -->
                <div class="social-icons">
                    @if(general()->facebook_link)
                    <a href="{{general()->facebook_link}}" id="social-fb"><i class="fa-brands fa-facebook-f"></i></a>
                    @endif
                    @if(general()->twitter_link)
                    <a href="{{general()->twitter_link}}" id="social-twitter"><i class="fa-brands fa-twitter"></i></a>
                    @endif
                    @if(general()->linkedin_link)
                    <a href="{{general()->linkedin_link}}" id="social-linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                    @endif
                     @if(general()->pinterest_link)
                    <a href="{{general()->pinterest_link}}" id="social-whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                    @endif
                    @if(general()->youtube_link)
                    <a href="{{general()->youtube_link}}" id="social-youtube"><i class="fa-brands fa-youtube"></i></a>
                    @endif
                    @if(general()->instagram_link)
                    <a href="{{general()->instagram_link}}" id="social-instagram"><i class="fa-brands fa-instagram"></i></a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- ==========================================================================
         NAVBAR
         ========================================================================== -->
    <nav class="navbar navbar-expand-lg nuv-navbar sticky-top">
        <div class="container">
            <!-- Brand Logo -->
            <a class="navbar-brand" href="{{route('index')}}" id="navbar-brand-logo">
                <img src="{{asset(general()->logo())}}" alt="Nuvesta Global LLC Logo">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#mainNavbar"
                aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation" id="navbar-toggle-btn">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Nav Links -->
            <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="mainNavbar" aria-labelledby="mainNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold" id="mainNavbarLabel">Main Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        data-bs-target="#mainNavbar" aria-label="Close"></button>
                </div>
      <div class="offcanvas-body">
    <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">

        @if(menu('Header Menus'))
            @foreach(menu('Header Menus')->subMenus as $menu)

                @if($menu->subMenus->count() > 0)

                    <li class="nav-item dropdown {{ asset($menu->menuLink()) == url()->current() ? 'active' : '' }}">

                        <a class="nav-link dropdown-toggle"
                           href="{{ asset($menu->menuLink()) }}"
                           id="navbarDropdown{{ $menu->id }}"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false">
                            {{ $menu->menuName() }}
                        </a>

                        <ul class="dropdown-menu">

                            @foreach($menu->subMenus as $submenu)
                                <li>
                                    <a class="dropdown-item"
                                       href="{{ asset($submenu->menuLink()) }}">
                                        {{ $submenu->menuName() }}
                                    </a>
                                </li>
                            @endforeach

                        </ul>

                    </li>

                @else

                    <li class="nav-item">
                        <a class="nav-link {{ asset($menu->menuLink()) == url()->current() ? 'active' : '' }}"
                           href="{{ asset($menu->menuLink()) }}">
                            {{ $menu->menuName() }}
                        </a>
                    </li>

                @endif

            @endforeach
        @endif

        {{-- CTA Button --}}
        <li class="nav-item nav-item-cta ms-lg-3 mt-3 mt-lg-0">
            <a href="{{ url('/get-a-quote') }}" class="btn-quote">
                <i class="fa-regular fa-envelope-open"></i>
                GET A QUOTE
            </a>
        </li>

    </ul>
</div>
            </div>
        </div>
    </nav>