
      <div class="sidebar" data-color="purple" data-background-color="white" data-image=" {{url('/vendors/assets/img/sidebar-1.jpg')}}">

<div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
Quick Service
  </a></div>
<div class="sidebar-wrapper">
  <ul class="nav">
    <li class="nav-item {{ request()->is('quick_admin/dashboard.php') ? 'active' : '' }} ">
      <a class="nav-link" href="{{route('adminHome')}}">
        <i class="material-icons">grid_view</i>
        <p>Dashboard</p>
      </a>
    </li>

    <li class="nav-item {{ request()->is('quick_admin/user.php') ? 'active' : '' }} ">
          <a class="nav-link" href="{{route('adminUser')}}">
          <i class="material-icons">group_add</i>
              <span class="menu-title">All User's</span>
            </a>
          </li>

          <li class="nav-item {{ request()->is('quick_admin/partner.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('partner')}}">
            <i class="material-icons">manage_accounts</i>
              <span class="menu-title">All Provider's</span>
            </a>
          </li>

          
    <li class="nav-item {{ request()->is('quick_admin/category.php') ? 'active' : '' }}">
      <a class="nav-link " href="{{route('category')}}">
      <i class="material-icons">category</i>
        <p>Categories</p>
      </a>
    </li>


        
          <li class="nav-item {{ request()->is('quick_admin/city_list.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('citylist')}}">
            <i class="material-icons">place</i>
              <span class="menu-title"> Address List</span>
            </a>
          </li>

    <li class="nav-item {{ request()->is('quick_admin/service.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('service')}}">
            <i class="material-icons">home_repair_service</i>
              <span class="menu-title"> Services List </span>
            </a>
          </li>

          <li class="nav-item  {{ request()->is('quick_admin/promo.php') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('coupon')}}">
            <i class="material-icons">local_offer</i>
              <span class="menu-title">Promo Code</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link" href="{{route('add_onslist')}}">
            <i class="material-icons">settings_applications</i>
              <span class="menu-title">Addon Service</span>
            </a>
          </li>

    <li class="nav-item  {{ request()->is('quick_admin/bookings.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('bookinglist')}}">
            <i class="material-icons">local_library</i>
              <span class="menu-title">All Booking lists</span>
            </a>
          </li>
          </li>

          <li class="nav-item {{ request()->is('quick_admin/banners.php') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('adminBanner')}}">
            <i class="material-icons">ad_units</i>
              <span class="menu-title">Slider Banner</span>
            </a>
          </li>
       

    <li class="nav-item {{ request()->is('quick_admin/money_request.php') ? 'active' : '' }}">
      <a class="nav-link " href="{{route('pay_req')}}">
      <i class="material-icons">account_balance</i>
        <p>Payment Request</p>
      </a>
    </li>

   

          
     
          
          
            <li class="nav-item {{ request()->is('quick_admin/cancelations.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('cancelationlist')}}">
            <i class="material-icons">cancel</i>
              <span class="menu-title">Canceled List</span>
            </a>
          </li>
          
          <li class="nav-item {{ request()->is('quick_admin/booking_setting.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('booking_setting')}}">
            <i class="material-icons">bookmarks</i>
              <span class="menu-title">Booking Settings</span>
            </a>
          </li>
          
        

          </li>
             <li class="nav-item {{ request()->is('quick_admin/membership_list.php') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('membershiplist')}}">
            <i class="material-icons">loyalty</i>
              <span class="menu-title">Point Settings</span>
            </a>
          </li>
          
            
          <li class="nav-item {{ request()->is('web/settings.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('admin.settings')}}">
            <i class="material-icons">psychology</i>
              <span class="menu-title">Multi Settings</span>
            </a>
          </li>
          
       
         
   
          
          
            <!-- <li class="nav-item  {{ request()->is('admin/enquirylist') ? 'active' : '' }}">
            <a class="nav-link" href="{{route('enquirylist')}}">
              <i class="menu-icon fa fa-question-circle"></i>
              <span class="menu-title">Enquiry</span>
            </a>
          </li> -->
          
          
           <li class="nav-item {{ request()->is('quick_admin/notification.php') ? 'active' : '' }} ">
            <a class="nav-link" href="{{route('adminNotification')}}">
            <i class="material-icons">notifications</i>
              <span class="menu-title">Push Notification</span>
            </a>
          </li>
          
          

  </ul>
</div>
</div>
