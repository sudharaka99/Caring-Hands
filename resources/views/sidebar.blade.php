@php
    $currentRole = auth()->user()->role ?? 'admin';

    // Prevent error if $menus is not passed
    $menus = $menus ?? collect();
@endphp

<aside class="admin-sidebar" id="adminSidebar">

    <!-- ==========================================
         LOGO
    =========================================== -->
    <div class="sidebar-logo">
        <a href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo.png') }}"
                 alt="Caring Hands">
        </a>
    </div>


    <!-- ==========================================
         NAVIGATION
    =========================================== -->
    <nav class="sidebar-nav">

        <span class="sidebar-menu-title">
            MAIN MENU
        </span>


        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">

            <i class="fa-solid fa-table-columns"></i>
            <span>Dashboard</span>

        </a>


        <!-- ==========================================
             DYNAMIC MENUS
        =========================================== -->
        @foreach($menus as $menu)

            @php

                // Get children that current role can access
                $children = $menu->children->filter(function ($child) use ($currentRole) {

                    $access = $child->accesses
                        ->where('role', $currentRole)
                        ->first();

                    return $child->status === 'active'
                        && $access
                        && $access->can_view;

                });

                $hasChildren = $children->isNotEmpty();


                // Check if parent route is active
                $isParentActive = $menu->route
                    && request()->routeIs($menu->route);


                // Check if any child route is active
                $hasActiveChild = $children->contains(function ($child) {

                    return $child->route
                        && request()->routeIs($child->route);

                });


                $isOpen = $isParentActive || $hasActiveChild;

            @endphp


            <!-- ==========================================
                 MENU WITH SUBMENU
            =========================================== -->
            @if($hasChildren)

                <div class="sidebar-dropdown {{ $isOpen ? 'open' : '' }}">

                    <button type="button"
                            class="sidebar-link sidebar-dropdown-toggle {{ $isOpen ? 'active' : '' }}"
                            onclick="toggleSidebarDropdown(this)">

                        <div class="sidebar-link-left">

                            <i class="{{ $menu->icon ?: 'fa-solid fa-folder' }}"></i>

                            <span>
                                {{ $menu->name }}
                            </span>

                        </div>

                        <i class="fa-solid fa-chevron-down sidebar-arrow"></i>

                    </button>


                    <!-- Submenu -->
                    <div class="sidebar-submenu">

                        @foreach($children as $child)

                            @php
                                $childUrl = '#';

                                if ($child->route && Route::has($child->route)) {
                                    $childUrl = route($child->route);
                                }
                            @endphp

                            <a href="{{ $childUrl }}"
                               class="sidebar-sublink {{ $child->route && request()->routeIs($child->route) ? 'active' : '' }}">

                                <i class="{{ $child->icon ?: 'fa-solid fa-circle' }}"></i>

                                <span>
                                    {{ $child->name }}
                                </span>

                            </a>

                        @endforeach

                    </div>

                </div>


            <!-- ==========================================
                 NORMAL MENU
            =========================================== -->
            @else

                @php
                    $menuUrl = '#';

                    if ($menu->route && Route::has($menu->route)) {
                        $menuUrl = route($menu->route);
                    }
                @endphp

                <a href="{{ $menuUrl }}"
                   class="sidebar-link {{ $isParentActive ? 'active' : '' }}">

                    <i class="{{ $menu->icon ?: 'fa-solid fa-circle' }}"></i>

                    <span>
                        {{ $menu->name }}
                    </span>

                </a>

            @endif

        @endforeach


        <!-- ==========================================
             SYSTEM - ADMIN ONLY
        =========================================== -->
        @if($currentRole === 'admin')

            <span class="sidebar-menu-title">
                SYSTEM
            </span>


            <a href="{{ route('admin.menus.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.menus.*') ? 'active' : '' }}">

                <i class="fa-solid fa-bars"></i>

                <span>Menu Management</span>

            </a>


            <a href="{{ route('admin.menu-access.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.menu-access.*') ? 'active' : '' }}">

                <i class="fa-solid fa-user-shield"></i>

                <span>Menu Access</span>

            </a>

        @endif

    </nav>


    <!-- ==========================================
         BOTTOM USER
    =========================================== -->
    <div class="sidebar-user">

        <div class="sidebar-avatar">
            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
        </div>


        <div class="sidebar-user-info">

            <strong>
                {{ auth()->user()->name ?? 'Administrator' }}
            </strong>

            <span>
                {{ ucfirst($currentRole) }}
            </span>

        </div>

    </div>

</aside>


<!-- Mobile Overlay -->
<div class="sidebar-overlay"
     id="sidebarOverlay"
     onclick="toggleAdminSidebar()">
</div>


<script>
    function toggleSidebarDropdown(button) {
        const dropdown = button.closest('.sidebar-dropdown');

        if (dropdown) {
            dropdown.classList.toggle('open');
        }
    }
</script>