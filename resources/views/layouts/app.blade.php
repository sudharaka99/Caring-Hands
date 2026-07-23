<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Caring Hands | Elder Home Management System')
    </title>

    <meta name="description"
          content="@yield('description', 'Caring Hands is a modern elder home management system connecting residents, caregivers, healthcare professionals and families.')">

    <!-- Google Font -->
    <link rel="preconnect"
          href="https://fonts.googleapis.com">

    <link rel="preconnect"
          href="https://fonts.gstatic.com"
          crossorigin>

    <link
        href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <!-- Main CSS -->
    <link rel="stylesheet"
          href="{{ asset('css/style.css') }}">

    <!-- Page Specific Styles -->
    @stack('styles')

</head>

<body>

    <!-- ==========================================
         HEADER
    =========================================== -->
    @include('components.header')


    <!-- ==========================================
         MAIN CONTENT
    =========================================== -->
    <main>
        @yield('content')
    </main>


    <!-- ==========================================
         FOOTER
    =========================================== -->
    @include('components.footer')


    <!-- ==========================================
         MAIN JAVASCRIPT
    =========================================== -->

    <script>

        document.addEventListener('DOMContentLoaded', function () {

            /*
            ==========================================
            MOBILE MENU
            ==========================================
            */

            const navMenu = document.getElementById('navMenu');

            const navLinks =
                document.querySelectorAll('.nav-menu a');


            navLinks.forEach(function (link) {

                link.addEventListener('click', function () {

                    if (navMenu) {
                        navMenu.classList.remove('active');
                    }

                });

            });


            /*
            ==========================================
            CLOSE LOGIN MODAL WHEN CLICKING OUTSIDE
            ==========================================
            */

            const loginModal =
                document.getElementById('loginModal');


            if (loginModal) {

                loginModal.addEventListener(
                    'click',
                    function (event) {

                        if (event.target === loginModal) {

                            closeLogin();

                        }

                    }
                );

            }


            /*
            ==========================================
            AUTO OPEN LOGIN MODAL ON VALIDATION ERROR
            ==========================================
            */

            @if ($errors->any() && !request()->is('register'))

                openLogin();

            @endif

        });



        /*
        ==========================================
        MOBILE MENU
        ==========================================
        */

        function toggleMenu() {

            const menu =
                document.getElementById('navMenu');

            if (menu) {

                menu.classList.toggle('active');

            }

        }



        /*
        ==========================================
        LOGIN MODAL
        ==========================================
        */

        function openLogin() {

            const modal =
                document.getElementById('loginModal');

            if (modal) {

                modal.classList.add('active');

                document.body.style.overflow = 'hidden';

            }

        }


        function closeLogin() {

            const modal =
                document.getElementById('loginModal');

            if (modal) {

                modal.classList.remove('active');

                document.body.style.overflow = '';

            }

        }



        /*
        ==========================================
        CONTACT FORM
        ==========================================
        */

        function submitContact(event) {

            const form = event.target;

            const submitBtn =
                form.querySelector(
                    'button[type="submit"]'
                );


            if (submitBtn) {

                submitBtn.disabled = true;

                submitBtn.innerHTML =
                    'Sending... <i class="fa-solid fa-spinner fa-spin"></i>';

            }

            // Return true to allow Laravel
            // to submit the form normally.

            return true;

        }



        /*
        ==========================================
        LOGIN FORM
        ==========================================
        */

        function validateLogin(event) {

            const form = event.target;

            const submitBtn =
                form.querySelector(
                    'button[type="submit"]'
                );


            if (submitBtn) {

                submitBtn.disabled = true;

                submitBtn.innerHTML =
                    'Logging in... <i class="fa-solid fa-spinner fa-spin"></i>';

            }

            // Return true to allow Laravel
            // to process authentication.

            return true;

        }

    </script>


    <!-- Page Specific Scripts -->
    @stack('scripts')

</body>

</html>