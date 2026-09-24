<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Optional dynamic meta description --}}
    <meta name="description" content="@yield('meta_description', 'Caring Hands - Elderly Care Management System')">

    <title>@yield('title', 'Caring Hands Admin')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Google Font (preconnect for speed) --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    {{--  Bootstrap 5 CSS — load BEFORE custom CSS so custom styles override --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Main Website CSS --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    {{-- Admin CSS (custom overrides Bootstrap) --}}
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body class="admin-body role-{{ auth()->user()->role ?? 'guest' }}">

    {{-- ==========================================
         SIDEBAR (dynamic, role-aware)
    =========================================== --}}
    @include('sidebar')


    {{-- ==========================================
         MAIN CONTENT AREA
    =========================================== --}}
    <div class="admin-main" id="adminMain">

        {{-- Topbar --}}
        @include('admin.components.topbar')

        {{-- Page Content --}}
        <main class="admin-content">
            @yield('content')
        </main>

    </div>


    {{-- ==========================================
         MOBILE OVERLAY (for sidebar toggle)
    =========================================== --}}
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleAdminSidebar()"></div>


    {{-- ==========================================
         SCRIPTS
    =========================================== --}}

    {{-- Bootstrap 5 JS (for dropdowns, modals, etc.) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- SweetAlert Functions --}}
    @include('admin.components.sweetalert-functions')

    {{-- SweetAlert Messages (flash auto-triggers) --}}
    @include('admin.components.sweetalert')


    {{-- ==========================================
         SIDEBAR TOGGLE
    =========================================== --}}
    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar) sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        }
    </script>


    {{-- ==========================================
         USER DROPDOWN
    =========================================== --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const button  = document.getElementById('userDropdownButton');
            const dropdown = document.getElementById('userDropdown');
            const wrapper  = document.getElementById('userDropdownWrapper');
            const arrow    = document.getElementById('dropdownArrow');

            if (!button || !dropdown || !wrapper) return;

            button.addEventListener('click', function (event) {
                event.stopPropagation();
                const isOpen = dropdown.classList.toggle('active');
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                if (arrow) arrow.classList.toggle('active', isOpen);
            });

            dropdown.addEventListener('click', function (event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function (event) {
                if (!wrapper.contains(event.target)) {
                    dropdown.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                    if (arrow) arrow.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    dropdown.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                    if (arrow) arrow.classList.remove('active');
                }
            });
        });
    </script>


    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>

</html>