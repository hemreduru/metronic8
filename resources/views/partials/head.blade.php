<!--begin::Head-->
<head>
    <base href="{{ url('/') }}"/>
    <title>@yield('title', 'Metronic Dashboard')</title>
    <meta charset="utf-8" />
    <meta name="description" content="Laravel Metronic Dashboard" />
    <meta name="keywords" content="laravel, metronic, bootstrap, dashboard" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="tr_TR" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="Laravel Metronic Dashboard" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:site_name" content="Laravel Metronic" />
    <link rel="canonical" href="{{ url('/') }}" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />

    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/regular/style.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/@phosphor-icons/web@2.1.1/src/fill/style.css" />
    <!--begin::Vendor Stylesheets(used for this page only)-->
    <link href="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Vendor Stylesheets-->

    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->

    <!--begin::Theme Transition Styles-->
    <style>
        /* Smooth theme transitions */
        :root {
            transition: background-color 0.3s ease, color 0.3s ease, border-color 0.3s ease;
        }

        body, .app-root, .app-page {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .menu-link[data-theme] {
            transition: all 0.2s ease;
        }

        .menu-link[data-theme].active {
            background-color: var(--bs-primary-bg-subtle) !important;
            color: var(--bs-primary-text-emphasis) !important;
        }

        /* Theme icon transitions */
        #theme-icon {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        /* Loading state for theme buttons */
        .menu-link[data-theme]:disabled,
        .menu-link[data-theme][style*="pointer-events: none"] {
            opacity: 0.7;
        }

        /* Smooth sidebar and header transitions */
        .app-header, .app-sidebar, .app-main {
            transition: background-color 0.3s ease, border-color 0.3s ease;
        }

        .toastr-top-right {
            top: 80px; /* Header yüksekliği kadar boşluk bırak */
        }
    </style>
    <!--end::Theme Transition Styles-->

    <script>
        // Frame-busting to prevent site from being loaded within a frame without permission (click-jacking)
        if (window.top != window.self) {
            window.top.location.replace(window.self.location.href);
        }
    </script>

    @yield('styles')
</head>
<!--end::Head-->
