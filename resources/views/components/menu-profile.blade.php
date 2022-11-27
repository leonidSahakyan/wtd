<div class="col-lg-4 col-md-12 col-sm-12">
    <!-- Service Detail Category -->
    <div class="sidebar-widget service-details__category">
        <div class="sidebar-widget__content">
            <h3 class="service-details__title">Profile</h3>
            <ul class="service-details__cagegory-list">
                <li
                    class="{{ request()->is('personal-info') ? 'active' : '' }}{{ request()->is('auth') ? 'active' : '' }}">
                    <a href="{{ route('personalinfo') }}">Personal Information<span
                            class="arrow icon-right-arrow"></span></a>
                </li>
                <li class="{{ request()->is('profile-password') ? 'active' : '' }}"><a
                        href="{{ route('profilepassword') }}">Change Password<span
                            class="arrow icon-right-arrow"></span></a></li>
                <li class="{{ request()->is('orders-profile') ? 'active' : '' }}"><a
                        href="{{ route('ordersprofile') }}">Orders<span class="arrow icon-right-arrow"></span></a></li>
                <li><a href="{{ route('logout') }}">Logout<span class="arrow icon-right-arrow"></span></a></li>

            </ul>
        </div>
    </div>
</div>