
 <div class="left-dashboard-show">
      <button class="btn btn_black sm rounded bg-primary">Show Menu</button>
    </div>
    <div class="dashboard-left-sidebar sticky">
      <div class="profile-box"> 
        <div class="profile-bg-img"></div>
        <div class="dashboard-left-sidebar-close"><i class="fa-solid fa-xmark"></i></div>
        <div class="profile-contain">
          <div class="profile-image"> <img class="img-fluid" src="{{asset(Auth::user()->image())}}" alt="{{Auth::user()->name}}"></div>
          <div class="profile-name"> 
            <h4>{{Auth::user()->name}}</h4>
          </div>
        </div>
      </div>
      <ul class="nav flex-column nav-pills dashboard-tab" id="v-pills-tab" role="tablist" aria-orientation="vertical">
        <li>
            <a class="nav-link {{Request::is('customer/dashboard*')? 'active' : ''}}" href="{{route('customer.dashboard')}}" >
              <i class="iconsax" data-icon="home-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 18V15" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                <path d="M10.07 2.81997L3.14002 8.36997C2.36002 8.98997 1.86002 10.3 2.03002 11.28L3.36002 19.24C3.60002 20.66 4.96002 21.81 6.40002 21.81H17.6C19.03 21.81 20.4 20.65 20.64 19.24L21.97 11.28C22.13 10.3 21.63 8.98997 20.86 8.36997L13.93 2.82997C12.86 1.96997 11.13 1.96997 10.07 2.81997Z" stroke="#292D32" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
                </i> 
                Dashboard
            </a>
        </li>
      </ul>
      <div class="logout-button"> 
        <a class="btn btn_black sm" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
          <i class="iconsax me-1" data-icon="logout-1"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.4389 15.3714C17.2489 15.3714 17.0589 15.3014 16.9089 15.1514C16.6189 14.8614 16.6189 14.3814 16.9089 14.0914L18.9389 12.0614L16.9089 10.0314C16.6189 9.74141 16.6189 9.26141 16.9089 8.97141C17.1989 8.68141 17.6789 8.68141 17.9689 8.97141L20.5289 11.5314C20.8189 11.8214 20.8189 12.3014 20.5289 12.5914L17.9689 15.1514C17.8189 15.3014 17.6289 15.3714 17.4389 15.3714Z" fill="#292D32"></path>
            <path d="M19.9317 12.8086H9.76172C9.35172 12.8086 9.01172 12.4686 9.01172 12.0586C9.01172 11.6486 9.35172 11.3086 9.76172 11.3086H19.9317C20.3417 11.3086 20.6817 11.6486 20.6817 12.0586C20.6817 12.4686 20.3417 12.8086 19.9317 12.8086Z" fill="#292D32"></path>
            <path d="M11.7617 20.75C6.61172 20.75 3.01172 17.15 3.01172 12C3.01172 6.85 6.61172 3.25 11.7617 3.25C12.1717 3.25 12.5117 3.59 12.5117 4C12.5117 4.41 12.1717 4.75 11.7617 4.75C7.49172 4.75 4.51172 7.73 4.51172 12C4.51172 16.27 7.49172 19.25 11.7617 19.25C12.1717 19.25 12.5117 19.59 12.5117 20C12.5117 20.41 12.1717 20.75 11.7617 20.75Z" fill="#292D32"></path>
            </svg>
            </i> 
        Logout 
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</div>