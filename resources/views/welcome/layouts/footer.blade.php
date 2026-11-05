<!-- footer part start  -->
<!--<footer>-->
<!--    <div class="footerPartMain">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-3">-->
<!--                    <div class="footerGrid">-->
<!--                        <div class="footerLogo">-->
<!--                            <a href="{{route('index')}}"><img src="{{asset('public/welcome/images/Logo White-16.png')}}" alt="{{general()->title}}"></a>-->
<!--                        </div>-->
<!--                        <div class="footerContactInfo">-->
<!--                            <div class="infoDiv">-->
<!--                                <span><i class="fa fa-phone" aria-hidden="true"></i></span>-->
<!--                                <p>{{general()->mobile}}</p>-->
<!--                            </div>-->
<!--                            <div class="infoDiv">-->
<!--                                <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>-->
<!--                                <p>{{general()->email}}</p>-->
<!--                            </div>-->
<!--                            <div class="infoDiv">-->
<!--                                <span><i class="fa fa-map-marker" aria-hidden="true"></i></span>-->
<!--                                <p>{{general()->address_one}}</p>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-2 col-6">-->
<!--                    <div class="footerGrid">-->
<!--                        @if($menu = menu('Footer Two'))-->
<!--                        <h5>{{$menu->name}}</h5>-->
<!--                        <ul>-->
<!--                            @foreach($menu->subMenus as $menu)-->
<!--                            <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>-->
<!--                            @endforeach-->
<!--                        </ul>-->
<!--                        @endif-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-2 col-6">-->
<!--                    <div class="footerGrid">-->
<!--                        @if($menu = menu('Footer Three'))-->
<!--                        <h5>{{$menu->name}}</h5>-->
<!--                        <ul>-->
<!--                            @foreach($menu->subMenus as $menu)-->
<!--                            <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>-->
<!--                            @endforeach-->
<!--                        </ul>-->
<!--                        @endif-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-2">-->
<!--                    <div class="footerGrid">-->
<!--                        <div class="qrCode">-->
<!--                            <img src="{{asset('public/welcome/images/qr_code_barcode.jpg')}}" alt="Kansai" />-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="col-md-3">-->
<!--                    <div class="footerGrid">-->
<!--                        <h5>Subscribe Now</h5>-->
<!--                        <div class="subscribeNow">-->
<!--                            <p>Type your e-mail here to know us...</p>-->
<!--                            <div class="input-group mb-3">-->
<!--                                <input type="text" class="form-control" placeholder="Your Email Address" aria-label="Username" aria-describedby="basic-addon1" />-->
<!--                                <span class="input-group-text" id="basic-addon1"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>-->
<!--                            </div>-->
<!--                        </div>-->
<!--                        <div class="footerSicalLink">-->
<!--                            <ul>-->
<!--                                @if(general()->facebook_link)-->
<!--                                <li><a href="{{general()->facebook_link}}"><i class="fa fa-facebook"></i></a></li>-->
<!--                                @endif-->
<!--                                @if(general()->twitter_link)-->
<!--                                <li><a href="{{general()->twitter_link}}"><i class="fa fa-twitter"></i></a></li>-->
<!--                                @endif-->
<!--                                @if(general()->instagram_link)-->
<!--                                <li><a href="{{general()->instagram_link}}"><i class="fa fa-instagram"></i></a></li>-->
<!--                                @endif-->
<!--                                @if(general()->linkedin_link)-->
<!--                                <li><a href="{{general()->linkedin_link}}"><i class="fa fa-linkedin"></i></a></li>-->
<!--                                @endif-->
<!--                                @if(general()->youtube_link)-->
<!--                                <li><a href="{{general()->youtube_link}}"><i class="fa fa-youtube-play"></i></a></li>-->
<!--                                @endif-->
<!--                                @if(general()->pinterest_link)-->
<!--                                <li><a href="{{general()->pinterest_link}}"><i class="fa fa-pinterest-p"></i></a></li>-->
<!--                                @endif-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--    <div class="footerBottomPart">-->
<!--        <div class="container">-->
<!--            <div class="row">-->
<!--                <div class="col-md-5">-->
<!--                    <p>漏 2024 Kansai Apparel Co. Ltd.路 All Rights Reserved</p>-->
<!--                </div>-->
<!--                <div class="col-md-4"></div>-->
<!--                <div class="col-md-3">-->
<!--                    <p>Developed By - <a href="https://arbdesignbd.com" target="_blank">ARB Design</a></p>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</footer>-->
<!-- footer part end  -->


<footer class="footer-section">
        <div class="footer-top-wrap">
            <div class="container">
                <div class="row g-4 align-items-start">
                    <!-- Col 1: Logo & Contact Info -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-col">
                            <div class="footer-logo">
                                <img src="{{asset('public/welcome/images/z1/footer-logo2.webp')}}" alt=" Logo White">
                            </div>
                            <ul class="footer-contact-info">
                                <li>
                                    <i class="fa-solid fa-phone"></i>
                                    <span>{{general()->mobile}}</span>
                                </li>
                                <li>
                                    <i class="fa-regular fa-envelope"></i>
                                    <span>{{general()->email}}</span>
                                </li>
                                <li>
                                    <i class="fa-solid fa-location-dot"></i>
                                    <span>{{general()->address_one}}</span>
                                </li>
                                <!--<li>-->
                                <!--    <i class="fa-solid fa-location-dot"></i>-->
                                <!--    <span>{{general()->address_two}}</span>-->
                                <!--</li>-->
                            </ul>
                        </div>
                    </div>

        

                    <!-- Col 3: Useful Links -->
                    <div class="col-lg-2 col-md-6 col-6 text-start">
                        <div class="footer-col">
                             @if($menu = menu('Footer Three'))
                            <h4>{{$menu->name}}</h4>
                            <ul class="footer-links-list">
                                 @foreach($menu->subMenus as $menu)
                                <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>
                    
                                <!-- Col 2: Products Links -->
                    <div class="col-lg-2 col-md-6 col-6 text-start">
                        <div class="footer-col">
                              @if($menu = menu('Footer Two'))
                            <h4>{{$menu->name}}</h4>
                            <ul class="footer-links-list">
                                 @foreach($menu->subMenus as $menu)
                                <li><a href="{{asset($menu->menuLink())}}">{{$menu->menuName()}}</a></li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                    </div>

                    <!-- Col 4: Subscribe Form, Socials & QR Code -->
                    <div class="col-lg-4 col-md-6">
                        <div class="footer-col">
                            <h4>Subscribe Now</h4>
                            <p class="subscribe-text">Type your e-mail here to know us...</p>
                            <form action="#" class="subscribe-form" id="newsletter-form">
                                <div class="subscribe-input-group">
                                    <input type="email" placeholder="Your Email Address" required id="newsletter-email">
                                    <button type="submit" class="subscribe-submit-btn" id="newsletter-submit">
                                        <i class="fa-regular fa-paper-plane"></i>
                                    </button>
                                </div>
                            </form>
                            <div class="footer-social-icons">
                                
                                @if(general()->facebook_link)
                                <a href="{{general()->facebook_link}}"><i class="fa-brands fa-facebook-f"></i></a>
                                @endif
                                
                                @if(general()->twitter_link)
                                <a href="{{general()->twitter_link}}"><i class="fa-brands fa-twitter"></i></a>
                                @endif
                                
                                 @if(general()->linkedin_link)
                                <a href="{{general()->linkedin_link}}"><i class="fa-brands fa-linkedin-in"></i></a>
                                @endif
                                
                                @if(general()->youtube_link)
                                <a href="{{general()->youtube_link}}"><i class="fa-brands fa-youtube"></i></a>
                                @endif
                                
                                @if(general()->instagram_link)
                                <a href="{{general()->instagram_link}}"><i class="fa-brands fa-instagram"></i></a>
                                @endif
                                
                                @if(general()->pinterest_link)
                                <a href="{{general()->pinterest_link}}"><i class="fa-brands fa-whatsapp"></i></a>
                                @endif
                            </div>
                            <div class="footer-qr-code mt-4">
                                <img src="{{asset('public/welcome/images/Nuvesta/qrcode.png')}}" alt="QR Code" class="footer-qr-code-img">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container text-center">
                <p class="mb-0">&copy; 2026 Zero One BD Sourcing Ltd - All Rights Reserved</p>
            </div>
        </div>
    </footer>