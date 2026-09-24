@php
    $currentRole = auth()->user()->role ?? 'admin';

    // Prevent error if $menus is not passed
    $menus = $menus ?? collect();

    // ==========================================
    // ROLE-AWARE DASHBOARD ROUTE
    // ==========================================
    $dashboardRouteName = Route::has($currentRole . '.dashboard')
        ? $currentRole . '.dashboard'
        : 'admin.dashboard';

    $dashboardUrl = route($dashboardRouteName);

    // ==========================================
    // ROLE LABELS
    // ==========================================
    $roleLabels = [
        'admin'      => ['Admin Panel',      'fa-shield-halved'],
        'manager'    => ['Manager Panel',    'fa-user-tie'],
        'caregiver'  => ['Caregiver Panel',  'fa-user-nurse'],
        'healthcare' => ['Healthcare Panel', 'fa-user-doctor'],
    ];

    [$roleLabel, $roleIcon] = $roleLabels[$currentRole]
        ?? [ucfirst($currentRole) . ' Panel', 'fa-user'];

    // ==========================================
    // HELPER — resolve role-specific route
    // Swaps 'admin.' prefix to current role if
    // the role-specific route exists.
    // ==========================================
    $resolveRoute = function ($routeName) use ($currentRole) {
        if (!$routeName) return null;

        // Admin uses routes as-is
        if ($currentRole === 'admin') {
            return Route::has($routeName) ? $routeName : null;
        }

        // Other roles: swap 'admin.' → '{role}.'
        $swapped = preg_replace('/^admin\./', $currentRole . '.', $routeName);

        if ($swapped && Route::has($swapped)) {
            return $swapped;
        }

        return null;
    };
@endphp

<aside class="admin-sidebar" id="adminSidebar">

    <!-- ==========================================
         LOGO
    =========================================== -->
    <div class="sidebar-logo">
        <a href="{{ $dashboardUrl }}">
            <img src="{{ asset('images/logo.png') }}" alt="Caring Hands">
        </a>
    </div>


    <!-- ==========================================
         ROLE BADGE
    =========================================== -->
    <div class="sidebar-role-badge">
        <i class="fa-solid {{ $roleIcon }}"></i>
        {{ $roleLabel }}
    </div>


    <!-- ==========================================
         NAVIGATION
    =========================================== -->
    <nav class="sidebar-nav">

        <span class="sidebar-menu-title">MAIN MENU</span>


        <!-- Dashboard (role-aware) -->
        <a href="{{ $dashboardUrl }}"
           class="sidebar-link {{ request()->routeIs($currentRole . '.dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-table-columns"></i>
            <span>Dashboard</span>
        </a>


        <!-- ==========================================
             DYNAMIC MENUS
        =========================================== -->
        @foreach($menus as $menu)

            @php

                // Filter children by current role
                $children = $menu->children->filter(function ($child) use ($currentRole) {
                    $access = $child->accesses
                        ->where('role', $currentRole)
                        ->first();

                    return $child->status === 'active'
                        && $access
                        && $access->can_view;
                });

                $hasChildren = $children->isNotEmpty();

                // Resolve parent route for current role
                $parentRouteName = $resolveRoute($menu->route);
                $parentUrl       = $parentRouteName ? route($parentRouteName) : '#';

                $isParentActive = $parentRouteName
                    && request()->routeIs($parentRouteName);

                // Check active child
                $hasActiveChild = $children->contains(function ($child) use ($resolveRoute) {
                    $r = $resolveRoute($child->route);
                    return $r && request()->routeIs($r);
                });

                $isOpen = $isParentActive || $hasActiveChild;

                // Skip menus the current role cannot access at all
                $parentAccess = $menu->accesses
                    ->where('role', $currentRole)
                    ->first();

                $canSeeParent = $parentAccess && $parentAccess->can_view;

            @endphp

            @if(!$canSeeParent)
                @continue
            @endif


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
                            <span>{{ $menu->name }}</span>
                        </div>

                        <i class="fa-solid fa-chevron-down sidebar-arrow"></i>

                    </button>


                    <!-- Submenu -->
                    <div class="sidebar-submenu">

                        @foreach($children as $child)

                            @php
                                $childRouteName = $resolveRoute($child->route);
                                $childUrl       = $childRouteName ? route($childRouteName) : '#';
                                $childActive    = $childRouteName
                                    && request()->routeIs($childRouteName);
                            @endphp

                            <a href="{{ $childUrl }}"
                               class="sidebar-sublink {{ $childActive ? 'active' : '' }}">

                                <i class="{{ $child->icon ?: 'fa-solid fa-circle' }}"></i>
                                <span>{{ $child->name }}</span>

                            </a>

                        @endforeach

                    </div>

                </div>


            <!-- ==========================================
                 NORMAL MENU (no children)
            =========================================== -->
            @else

                <a href="{{ $parentUrl }}"
                   class="sidebar-link {{ $isParentActive ? 'active' : '' }}">

                    <i class="{{ $menu->icon ?: 'fa-solid fa-circle' }}"></i>
                    <span>{{ $menu->name }}</span>

                </a>

            @endif

        @endforeach


        <!-- ==========================================
             SYSTEM — ADMIN ONLY
        =========================================== -->
        @if($currentRole === 'admin')

            <span class="sidebar-menu-title">SYSTEM</span>

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
            <strong>{{ auth()->user()->name ?? 'User' }}</strong>
            <span>{{ ucfirst($currentRole) }}</span>
        </div>

    </div>

</aside>


<!-- ==========================================
     MOBILE OVERLAY — only include if layout
     does NOT already provide one
========================================== -->
@once
    <div class="sidebar-overlay"
         id="sidebarOverlay"
         onclick="toggleAdminSidebar()">
    </div>
@endonce


<script>
    // Dropdown toggle — safe to redeclare (checks existence)
    if (typeof toggleSidebarDropdown !== 'function') {
        window.toggleSidebarDropdown = function (button) {
            const dropdown = button.closest('.sidebar-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('open');
            }
        };
    }
</script>