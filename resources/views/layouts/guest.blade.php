<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - @yield('title', 'Auth')</title>

    @include('partials.head')
</head>

<body id="kt_body" class="app-blank bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <div class="d-flex flex-column flex-column-fluid flex-lg-row">
            <!-- Aside -->
            <div class="d-flex flex-center w-lg-50 pt-15 pt-lg-0 px-10" style="background-image: url('{{ asset('media/auth/bg10.jpeg') }}')">
                <div class="d-flex flex-center flex-lg-start flex-column">
                    <!-- Logo -->
                    <a href="{{ url('/') }}" class="mb-7">
                        <img alt="Logo" src="{{ asset('media/logos/default.svg') }}" />
                    </a>
                    <!-- Title -->
                    <h2 class="text-white fw-normal m-0">
                        Branding tools designed for your business
                    </h2>
                </div>
            </div>

            <!-- Body -->
            <div class="d-flex flex-column-fluid flex-lg-row-auto justify-content-center justify-content-lg-end p-12 p-lg-20">
                <!-- Form -->
                <div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 w-md-600px p-20">
                    <!-- Wrapper -->
                    <div class="d-flex flex-center flex-column flex-column-fluid px-lg-10 pb-15 pb-lg-20">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.scripts')
</body>
</html>
