 <style>
     body.vertical-layout.vertical-menu-modern.menu-expanded .navbar .navbar-brand .brand-text{
         font-size: 14px !important;
         letter-spacing: 0;
         display: inline-block;
         white-space: nowrap;
         overflow: hidden;
         text-overflow: ellipsis;
         max-width: 160px;
         vertical-align: middle;
     }
     /* Section "•••" markers belong to the collapsed (icon-only) sidebar. */
     body:not(.menu-collapsed) .main-menu .navigation-header > i,
     body.menu-collapsed .main-menu.expanded .navigation-header > i { display: none; }

     /* "Show menu" button: only on desktop while the sidebar is collapsed. */
     .admin-menu-expand-item { display: none; }
     @media (min-width: 992px) {
         body.menu-collapsed .admin-menu-expand-item { display: block; }
     }
     .admin-menu-expand-item .nav-link { font-size: 1.3rem; color: #4859b9 !important; }
     .navbar-header .nav-toggle .fa-2x {
         font-size: 1.45em;
     }
     .navbar-brand .admin-brand-icon {
         display: inline-flex;
         align-items: center;
         justify-content: center;
         width: 30px;
         height: 30px;
         background: #fff;
         color: #4859b9;
         border-radius: 50%;
         font-size: 14px;
         vertical-align: middle;
     }
 </style>
 
 <!-- BEGIN: Header-->
 <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
   <div class="navbar-wrapper">
     <div class="navbar-header">
       <ul class="nav navbar-nav flex-row">
         <li class="nav-item mobile-menu d-lg-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#">
          <!-- <i class="fa-2x fas fa-bars"></i> -->
          <i class="fa-2x fas fa-arrow-alt-circle-right"></i>
          </a>
          </li>
         <li class="nav-item mr-auto">
          <a class="navbar-brand" href="{{route('index')}}" title="{{ general()->title }}">
             @if(general()->favicon)
             <img class="brand-logo" src="{{asset(general()->favicon)}}" alt="{{ general()->title }}" style="max-height:30px;background: white;border-radius: 50%;" />
             @else
             <span class="brand-logo admin-brand-icon"><i class="fa-solid fa-hotel"></i></span>
             @endif
             <h2 class="brand-text">{{ general()->title }}</h2>
           </a>
           </li>
         <li class="nav-item d-none d-lg-block nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse" style="    color: white;"><i class="fa-2x fas fa-bars"></i></a></li>
       </ul>
     </div>
     <div class="navbar-container content">
       <div class="collapse navbar-collapse" id="navbar-mobile">
         <ul class="nav navbar-nav mr-auto float-left">

           <li class="nav-item admin-menu-expand-item">
            <a class="nav-link admin-menu-expand" href="#" title="Show menu">
              <i class="fas fa-bars"></i>
            </a>
          </li>
           <li class="nav-item d-none d-md-block">
            <a class="nav-link nav-link-expand" href="#">
              <i class="fas fa-compress"></i>
            </a>
          </li>
          <li class="nav-item d-none d-md-block">
            <a class="nav-link">Quick Link</a>
          </li>
         </ul>
         <ul class="nav navbar-nav float-right">

           <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="javascript:void(0)" data-toggle="dropdown">
               <div class="avatar avatar-online">
                <img src="{{asset(Auth::user()->image())}}" alt="avatar" /><i></i>
              </div>
               <span class="user-name">{{Str::limit(Auth::user()->name,15)}}</span></a>
               <div class="dropdown-menu dropdown-menu-right">
                <a class="dropdown-item" href="{{route('customer.dashboard')}}" style="min-width: 220px"><i class="fas fa-th-large"></i> My Dashboard </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{route('admin.myProfile')}}" style="min-width: 220px"><i class="fas fa-user-check"></i> My Profile </a>

                 <div class="dropdown-divider"></div>
                 
                 <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                  <i class="fas fa-power-off"></i> Logout 
                  </a>
                  
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                
               </div>
           </li>
         </ul>
       </div>
     </div>
   </div>
 </nav>
 <!-- END: Header-->