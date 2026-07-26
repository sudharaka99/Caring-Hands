<header class="admin-topbar">

    <!-- LEFT -->
    <div class="topbar-left">

        <!-- Mobile Sidebar Toggle -->
        <button type="button"
                class="sidebar-toggle"
                onclick="toggleAdminSidebar()"
                aria-label="Toggle sidebar">

            <i class="fa-solid fa-bars"></i>

        </button>


        <!-- Search -->
        <div class="topbar-search">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input type="text"
                   placeholder="Search residents, staff...">

        </div>

    </div>


    <!-- RIGHT -->
    <div class="topbar-right">

        <!-- Website -->
        <a href="{{ route('home') }}"
           class="topbar-icon-btn"
           title="View Website">

            <i class="fa-solid fa-house"></i>

        </a>


        <!-- Messages -->
        <button type="button"
                class="topbar-icon-btn"
                title="Messages">

            <i class="fa-regular fa-envelope"></i>

            <span class="topbar-notification">
                2
            </span>

        </button>


        <!-- Notifications -->
        <button type="button"
                class="topbar-icon-btn"
                title="Notifications">

            <i class="fa-regular fa-bell"></i>

            <span class="topbar-notification">
                3
            </span>

        </button>


        <!-- ======================================
             USER DROPDOWN
        ======================================= -->

        <div class="topbar-user-dropdown" id="userDropdownWrapper">

            <!-- User Button -->
            <button type="button"
                    class="topbar-user"
                    id="userDropdownButton"
                    aria-expanded="false">

                <!-- Avatar -->
                <div class="topbar-avatar">

                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                </div>


                <!-- User Details -->
                <div class="topbar-user-info">

                    <strong>
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </strong>

                    <span>
                        {{ ucfirst(auth()->user()->role ?? 'Admin') }}
                    </span>

                </div>


                <!-- Arrow -->
                <i class="fa-solid fa-chevron-down dropdown-arrow"
                   id="dropdownArrow"></i>

            </button>


            <!-- Dropdown -->
            <div class="user-dropdown-menu"
                 id="userDropdown">

                <!-- User Info -->
                <div class="dropdown-user-header">

                    <div class="dropdown-avatar">

                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}

                    </div>


                    <div class="dropdown-user-details">

                        <strong>
                            {{ auth()->user()->name ?? 'Administrator' }}
                        </strong>

                        <span>
                            {{ auth()->user()->email ?? '' }}
                        </span>

                    </div>

                </div>


                <div class="dropdown-divider"></div>


                <!-- Profile -->
                <a href="#"
                   class="dropdown-item">

                    <i class="fa-regular fa-user"></i>

                    <div>
                        <strong>My Profile</strong>
                        <span>View personal information</span>
                    </div>

                </a>


                <!-- Settings -->
                <a href="#"
                   class="dropdown-item">

                    <i class="fa-solid fa-gear"></i>

                    <div>
                        <strong>Account Settings</strong>
                        <span>Manage your account</span>
                    </div>

                </a>


                <!-- Website -->
                <a href="{{ route('home') }}"
                   class="dropdown-item">

                    <i class="fa-solid fa-globe"></i>

                    <div>
                        <strong>View Website</strong>
                        <span>Go to Caring Hands website</span>
                    </div>

                </a>


                <div class="dropdown-divider"></div>


                <!-- Logout -->
                <form method="POST"
                      action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                            class="dropdown-item dropdown-logout">

                        <i class="fa-solid fa-arrow-right-from-bracket"></i>

                        <div>
                            <strong>Logout</strong>
                            <span>Sign out of your account</span>
                        </div>

                    </button>

                </form>

            </div>

        </div>

    </div>

</header>