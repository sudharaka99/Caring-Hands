<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Caring Hands Admin')</title>

    <!-- Google Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main Website CSS -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <!-- Admin CSS -->
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    @stack('styles')
</head>

<body class="admin-body">

    <!-- Sidebar -->
    @include('admin.components.sidebar')

    <div class="admin-main" id="adminMain">

        <!-- Topbar -->
        @include('admin.components.topbar')

        <!-- Page Content -->
        <main class="admin-content">
            @yield('content')
        </main>

    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- SweetAlert Functions -->
    @include('admin.components.sweetalert-functions')
    
    <!-- SweetAlert Messages -->
    @include('admin.components.sweetalert')

    <script>
        function toggleAdminSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            if (sidebar) sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const button = document.getElementById('userDropdownButton');
            const dropdown = document.getElementById('userDropdown');
            const wrapper = document.getElementById('userDropdownWrapper');
            const arrow = document.getElementById('dropdownArrow');

            if (!button || !dropdown || !wrapper) return;

            button.addEventListener('click', function(event) {
                event.stopPropagation();
                const isOpen = dropdown.classList.toggle('active');
                button.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
                if (arrow) arrow.classList.toggle('active', isOpen);
            });

            dropdown.addEventListener('click', function(event) {
                event.stopPropagation();
            });

            document.addEventListener('click', function(event) {
                if (!wrapper.contains(event.target)) {
                    dropdown.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                    if (arrow) arrow.classList.remove('active');
                }
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    dropdown.classList.remove('active');
                    button.setAttribute('aria-expanded', 'false');
                    if (arrow) arrow.classList.remove('active');
                }
            });
        });
    </script>

    @stack('scripts')

</body>

</html>