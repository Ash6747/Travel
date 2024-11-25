    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() != 'admin.dashboard' ? 'collapsed' : '' }}" href="{{ route(Auth::user()->role . '.dashboard') }}">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li><!-- End Dashboard Nav -->

            <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'route.table' ? 'collapsed' : '' }}" href="{{ route('route.table') }}">
                <i class="ri ri-guide-line"></i>
                <span>Routes</span>
            </a>
            </li><!-- End Routes Nav -->

            <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'bus.table' ? 'collapsed' : '' }}" href="{{ route('bus.table') }}">
                <i class="bx bxs-bus"></i>
                {{-- <i class="ri ri-bus-fill"></i> --}}
                <span>Buses</span>
            </a>
            </li><!-- End Buses Nav -->

            <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'stop.table' ? 'collapsed' : '' }}" href="{{ route('stop.table') }}">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Stops</span>
            </a>
            </li><!-- End Stops Nav -->

            <li class="nav-item">
            <a class="nav-link {{ Route::currentRouteName() != 'course.table' ? 'collapsed' : '' }}" href="{{ route('course.table') }}">
                <i class="ri ri-book-open-fill"></i>
                <span>Courses</span>
            </a>
            </li><!-- End Courses Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() != 'transaction.table' ? 'collapsed' : '' }}" href="{{ route('transaction.table') }}">
                    <i class="ri ri-secure-payment-line"></i>
                    <span>Transactions</span>
                </a>
            </li><!-- End transactions Nav -->

            <li class="nav-item">
                <a class="nav-link {{ (Route::currentRouteName() == 'trip.table'
                || Route::currentRouteName() == 'triphistory.table'
                // || Route::currentRouteName() == 'leave.table'
                ) ? '' : 'collapsed' }}" data-bs-target="#Trips-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri ri-compass-3-line"></i><span>Trips</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Trips-nav" class="nav-content collapse {{ (Route::currentRouteName() == 'trip.table'
                || Route::currentRouteName() == 'triphistory.table'
                // || Route::currentRouteName() == 'leave.table'
                ) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="{{ Route::currentRouteName() != 'trip.table' ? '' : 'active' }}" href="{{ route('trip.table') }}">
                            <i class="bi bi-circle"></i><span>Assigned</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ Route::currentRouteName() != 'triphistory.table' ? '' : 'active' }}" href="{{ route('triphistory.table') }}">
                            <i class="bi bi-circle"></i><span>History</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Drivers Nav -->

            {{-- <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() != 'triphistory.table' ? 'collapsed' : '' }}" href="{{ route('triphistory.table') }}">
                    <i class="ri ri-history-line"></i>
                    <span>Trip History</span>
                </a>
            </li><!-- End trip history Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() != 'trip.table' ? 'collapsed' : '' }}" href="{{ route('trip.table') }}">
                    <i class="ri ri-compass-3-line"></i>
                    <span>Trips</span>
                </a>
            </li><!-- End trips Nav --> --}}

            <li class="nav-item">
                <a class="nav-link {{ (Route::currentRouteName() == 'booking.table'
                || Route::currentRouteName() == 'student.table'
                || Route::currentRouteName() == 'booking.pending'
                || Route::currentRouteName() == 'booking.active'
                || Route::currentRouteName() == 'booking.rejected'
                || Route::currentRouteName() == 'booking.expired') ? '' : 'collapsed' }}" data-bs-target="#Bookings-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri ri-ticket-2-line"></i><span>Bookings</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Bookings-nav" class="nav-content collapse {{ (
                Route::currentRouteName() == 'booking.table'
                || Route::currentRouteName() == 'student.table'
                || Route::currentRouteName() == 'booking.pending'
                || Route::currentRouteName() == 'booking.active'
                || Route::currentRouteName() == 'booking.rejected'
                || Route::currentRouteName() == 'booking.expired') ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="{{ (Route::currentRouteName() == 'booking.table'
                            || Route::currentRouteName() == 'booking.pending'
                            || Route::currentRouteName() == 'booking.active'
                            || Route::currentRouteName() == 'booking.rejected'
                            || Route::currentRouteName() == 'booking.expired') ? 'active' : '' }}"
                            href="{{ route('booking.table') }}">
                            <i class="bi bi-circle"></i><span>Bookings</span>
                        </a>
                    </li><!-- End Bookings Nav -->
                    <li>
                        <a class="{{ (Route::currentRouteName() == 'student.table') ? 'active' : '' }}"
                            href="{{ route('student.table') }}">
                            <i class="bi bi-circle"></i><span>Students</span>
                        </a>
                    </li><!-- End Bookings Nav -->
                </ul>
            </li><!-- End Bookings Nav -->

            <li class="nav-item">
                <a class="nav-link {{ (Route::currentRouteName() == 'driver.table'
                || Route::currentRouteName() == 'driver.unregistered'
                || Route::currentRouteName() == 'leave.table'
                ) ? '' : 'collapsed' }}" data-bs-target="#Drivers-nav" data-bs-toggle="collapse" href="#">
                    <i class="ri ri-contacts-line"></i><span>Drivers</span><i
                        class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Drivers-nav" class="nav-content collapse {{ (Route::currentRouteName() == 'driver.table'
                || Route::currentRouteName() == 'driver.unregistered'
                || Route::currentRouteName() == 'leave.table'
                ) ? 'show' : '' }}" data-bs-parent="#sidebar-nav">
                    <li>
                        <a class="{{ Route::currentRouteName() != 'driver.table' ? '' : 'active' }}" href="{{ route('driver.table') }}">
                            <i class="bi bi-circle"></i><span>Registered</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ Route::currentRouteName() != 'driver.unregistered' ? '' : 'active' }}" href="{{ route('driver.unregistered') }}">
                            <i class="bi bi-circle"></i><span>Unregistered</span>
                        </a>
                    </li>
                    <li>
                        <a class="{{ Route::currentRouteName() != 'leave.table' ? '' : 'active' }}" href="{{ route('leave.table') }}">
                            <i class="bi bi-circle"></i><span>Leaves</span>
                        </a>
                    </li>
                </ul>
            </li><!-- End Drivers Nav -->

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() == 'complaint.table'
                || Route::currentRouteName() == 'complaint.pending'
                || Route::currentRouteName() == 'complaint.progress'
                || Route::currentRouteName() == 'complaint.resolved'
                || Route::currentRouteName() == 'complaint.edit'
                 ? '' : 'collapsed' }}" href="{{ route('complaint.table') }}">
                    <i class="ri ri-feedback-line"></i>
                    <span>Complaints</span>
                </a>
            </li><!-- End complaints Nav -->

            <li class="nav-heading">Admin Account</li>

            <li class="nav-item">
                <a class="nav-link {{ Route::currentRouteName() != 'admin.profile.edit' ? 'collapsed' : '' }}" href="{{ route('admin.profile.edit') }}">
                    <i class="bi bi-person"></i>
                    <span>Profile</span>
                </a>
            </li><!-- End Profile Page Nav -->


            {{-- <li class="nav-item">
                <a class="nav-link collapsed" href="pages-register.html">
                    <i class="bi bi-card-list"></i>
                    <span>Register</span>
                </a>
            </li><!-- End Register Page Nav -->

            <li class="nav-item">
                <a class="nav-link collapsed" href="pages-login.html">
                    <i class="bi bi-box-arrow-in-right"></i>
                    <span>Login</span>
                </a>
            </li><!-- End Login Page Nav --> --}}

        </ul>

    </aside><!-- End Sidebar-->
