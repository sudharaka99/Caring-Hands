<aside class="admin-sidebar" id="adminSidebar">

    <!-- Logo -->
    <div class="sidebar-logo">

        <a href="{{ route('admin.dashboard') }}">

            <img src="{{ asset('images/logo.png') }}"
                 alt="Caring Hands">

        </a>

    </div>


    <!-- Menu -->
    <nav class="sidebar-nav">

        <span class="sidebar-menu-title">
            MAIN MENU
        </span>


        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <i class="fa-solid fa-table-columns"></i>

            <span>Dashboard</span>

        </a>


        <a href="{{ route('admin.elders.index') }}"
           class="sidebar-link">

            <i class="fa-solid fa-person-cane"></i>

            <span>Elders</span>

        </a>


        <a href="{{ route('admin.owners.index') }}"
           class="sidebar-link">

            <i class="fa-solid fa-users"></i>

            <span>Elder Owners</span>

        </a>


        <span class="sidebar-menu-title">
            STAFF MANAGEMENT
        </span>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-user-nurse"></i>

            <span>Caregivers</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-user-doctor"></i>

            <span>Healthcare</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-user-tie"></i>

            <span>Managers</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-calendar-days"></i>

            <span>Shifts</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-fingerprint"></i>

            <span>Attendance</span>

        </a>


        <span class="sidebar-menu-title">
            CARE MANAGEMENT
        </span>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-notes-medical"></i>

            <span>Care Plans</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-pills"></i>

            <span>Medication</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-calendar-check"></i>

            <span>Appointments</span>

        </a>


        <span class="sidebar-menu-title">
            SYSTEM
        </span>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-chart-column"></i>

            <span>Reports</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-comments"></i>

            <span>Messages</span>

        </a>


        <a href="#"
           class="sidebar-link">

            <i class="fa-solid fa-gear"></i>

            <span>Settings</span>

        </a>

    </nav>


    <!-- Bottom User -->
    <div class="sidebar-user">

        <div class="sidebar-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>

        <div class="sidebar-user-info">

            <strong>
                {{ auth()->user()->name ?? 'Administrator' }}
            </strong>

            <span>Administrator</span>

        </div>

    </div>

</aside>


<!-- Mobile Overlay -->
<div class="sidebar-overlay"
     id="sidebarOverlay"
     onclick="toggleAdminSidebar()">
</div>