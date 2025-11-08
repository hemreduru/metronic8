@extends('layouts.app')

@section('title', __('users.my_profile'))

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('users.my_profile') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">{{ __('users.home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('users.profile') }}</li>
                </ul>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Navbar-->
            <div class="card mb-5 mb-xxl-8">
                <div class="card-body pt-9 pb-0">
                    <!--begin::Details-->
                    <div class="d-flex flex-wrap flex-sm-nowrap">
                        <!--begin::Image-->
                        <div class="me-7 mb-4">
                            <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" />
                                @else
                                    <div class="symbol-label fs-3 bg-light-primary text-primary">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!--end::Image-->

                        <!--begin::Info-->
                        <div class="flex-grow-1">
                            <!--begin::Title-->
                            <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                                <!--begin::User-->
                                <div class="d-flex flex-column">
                                    <!--begin::Name-->
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ $user->name }}</span>
                                        @if($user->is_verified)
                                            <span class="badge badge-light-success fs-8 fw-bold">{{ __('users.verified') }}</span>
                                        @else
                                            <span class="badge badge-light-warning fs-8 fw-bold">{{ __('users.unverified') }}</span>
                                        @endif
                                    </div>
                                    <!--end::Name-->

                                    <!--begin::Info-->
                                    <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                            <i class="ki-duotone ki-sms fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ $user->email }}
                                        </span>

                                        @if($roles)
                                            <span class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                                <i class="ki-duotone ki-security-user fs-4 me-1">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                {{ implode(', ', $roles) }}
                                            </span>
                                        @endif

                                        <span class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                            <i class="ki-duotone ki-calendar fs-4 me-1">
                                                <span class="path1"></span>
                                                <span class="path2"></span>
                                            </i>
                                            {{ __('Katıldı') }}: {{ $user->created_at->format('M d, Y') }}
                                        </span>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->

                                <!--begin::Actions-->
                                <div class="d-flex my-4">
                                    <a href="{{ route('profile.edit') }}" class="btn btn-sm btn-primary me-3">
                                        {{ __('users.edit_profile') }}
                                    </a>

                                    <!--begin::Menu-->
                                    <div class="me-0">
                                        <button class="btn btn-sm btn-icon btn-bg-light btn-active-color-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                            <i class="ki-solid ki-dots-horizontal fs-5"></i>
                                        </button>

                                        <!--begin::Menu 3-->
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-3" data-kt-menu="true">
                                            <!--begin::Menu item-->
                                            <div class="menu-item px-3">
                                                <a href="{{ route('profile.export') }}" class="menu-link px-3">
                                                    {{ __('Veriyi İndir') }}
                                                </a>
                                            </div>
                                            <!--end::Menu item-->
                                        </div>
                                        <!--end::Menu 3-->
                                    </div>
                                    <!--end::Menu-->
                                </div>
                                <!--end::Actions-->
                            </div>
                            <!--end::Title-->
                        </div>
                        <!--end::Info-->
                    </div>
                    <!--end::Details-->

                    <!--begin::Navs-->
                    <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                        <!--begin::Nav item-->
                        <li class="nav-item mt-2">
                            <a class="nav-link text-active-primary ms-0 me-10 py-5 active" href="#kt_profile_overview">
                                {{ __('Genel Bakış') }}
                            </a>
                        </li>
                        <!--end::Nav item-->
                    </ul>
                    <!--end::Navs-->
                </div>
            </div>
            <!--end::Navbar-->

            <!--begin::details View-->
            <div class="row g-5 g-xxl-8">
                <!--begin::Col-->
                <div class="col-xl-4">
                    <!--begin::Mixed Widget 5-->
                    <div class="card card-xl-stretch mb-5 mb-xxl-8">
                        <!--begin::Beader-->
                        <div class="card-header border-0 py-5">
                            <h3 class="card-title align-items-start flex-column">
                                <span class="card-label fw-bold fs-3 mb-1">{{ __('Hesap Bilgileri') }}</span>
                            </h3>
                        </div>
                        <!--end::Header-->

                        <!--begin::Body-->
                        <div class="card-body d-flex flex-column">
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <span class="text-muted fw-semibold me-1">{{ __('users.name') }}:</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $user->name }}</span>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <span class="text-muted fw-semibold me-1">{{ __('users.email') }}:</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $user->email }}</span>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-5">
                                <span class="text-muted fw-semibold me-1">{{ __('users.status') }}:</span>
                                <span class="badge {{ $user->status_badge }} fs-7 fw-bold">{{ __('users.' . strtolower($user->status)) }}</span>
                            </div>
                            <!--end::Item-->

                            <!--begin::Item-->
                            @if($settings && $settings->preferredLanguage)
                            <div class="d-flex align-items-center mb-5">
                                <span class="text-muted fw-semibold me-1">{{ __('users.language') }}:</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ $settings->preferredLanguage->name }}</span>
                            </div>
                            @endif
                            <!--end::Item-->

                            <!--begin::Item-->
                            @if($settings)
                            <div class="d-flex align-items-center mb-5">
                                <span class="text-muted fw-semibold me-1">{{ __('users.theme') }}:</span>
                                <span class="fw-bold text-gray-800 fs-6">{{ __('users.' . $settings->theme) }}</span>
                            </div>
                            @endif
                            <!--end::Item-->
                        </div>
                        <!--end::Body-->
                    </div>
                    <!--end::Mixed Widget 5-->
                </div>
                <!--end::Col-->

                <!--begin::Col-->
                <div class="col-xl-8">
                    <!--begin::Row-->
                    <div class="row g-5 g-xxl-8">
                        <!--begin::Col-->
                        <div class="col-xxl-6">
                            <!--begin::Engage widget 10-->
                            <div class="card card-xl-stretch-50 mb-5 mb-xxl-8">
                                <!--begin::Body-->
                                <div class="card-body d-flex flex-column">
                                    <!--begin::Wrapper-->
                                    <div class="d-flex flex-column mb-7">
                                        <!--begin::Title-->
                                        <span class="text-dark fw-bold fs-3">{{ __('Roller ve İzinler') }}</span>
                                        <!--end::Title-->
                                    </div>
                                    <!--end::Wrapper-->

                                    <!--begin::Row-->
                                    <div class="row g-0">
                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-9 me-2">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40px me-3">
                                                    <div class="symbol-label bg-light">
                                                        <i class="ki-duotone ki-security-user fs-1 text-dark">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div>
                                                    <div class="fs-5 text-dark fw-bold lh-1">{{ count($roles) }}</div>
                                                    <div class="fs-7 text-gray-600 fw-bold">{{ __('Aktif Rol') }}</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                        <!--end::Col-->

                                        <!--begin::Col-->
                                        <div class="col-6">
                                            <div class="d-flex align-items-center mb-9 ms-2">
                                                <!--begin::Symbol-->
                                                <div class="symbol symbol-40px me-3">
                                                    <div class="symbol-label bg-light">
                                                        <i class="ki-duotone ki-key fs-1 text-dark">
                                                            <span class="path1"></span>
                                                            <span class="path2"></span>
                                                        </i>
                                                    </div>
                                                </div>
                                                <!--end::Symbol-->

                                                <!--begin::Title-->
                                                <div>
                                                    <div class="fs-5 text-dark fw-bold lh-1">{{ count($permissions) }}</div>
                                                    <div class="fs-7 text-gray-600 fw-bold">{{ __('İzin') }}</div>
                                                </div>
                                                <!--end::Title-->
                                            </div>
                                        </div>
                                        <!--end::Col-->
                                    </div>
                                    <!--end::Row-->

                                    <!--begin::Info-->
                                    @if($roles)
                                    <div class="m-0">
                                        <span class="fw-semibold text-gray-400 d-block fs-8 mb-2">{{ __('Mevcut Roller') }}</span>
                                        @foreach($roles as $role)
                                            <span class="badge badge-light-primary fs-7 fw-bold me-1 mb-2">{{ $role }}</span>
                                        @endforeach
                                    </div>
                                    @endif
                                    <!--end::Info-->
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::Engage widget 10-->
                        </div>
                        <!--end::Col-->

                        <!--begin::Col-->
                        <div class="col-xxl-6">
                            <!--begin::List Widget 9-->
                            <div class="card card-xl-stretch-50 mb-5 mb-xxl-8">
                                <!--begin::Header-->
                                <div class="card-header border-0">
                                    <h3 class="card-title fw-bold text-dark">{{ __('Son Aktiviteler') }}</h3>
                                </div>
                                <!--end::Header-->

                                <!--begin::Body-->
                                <div class="card-body pt-2">
                                    <!--begin::Item-->
                                    <div class="d-flex align-items-center mb-8">
                                        <!--begin::Bullet-->
                                        <div class="bullet bullet-vertical h-40px bg-success"></div>
                                        <!--end::Bullet-->

                                        <!--begin::Checkbox-->
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <input class="form-check-input" type="checkbox" value="" checked disabled />
                                        </div>
                                        <!--end::Checkbox-->

                                        <!--begin::Description-->
                                        <div class="flex-grow-1">
                                            <span class="text-gray-800 text-hover-primary fw-bold fs-6">{{ __('Hesap oluşturuldu') }}</span>
                                            <span class="text-muted fw-semibold d-block">{{ $user->created_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Item-->

                                    <!--begin::Item-->
                                    @if($user->email_verified_at)
                                    <div class="d-flex align-items-center mb-8">
                                        <!--begin::Bullet-->
                                        <div class="bullet bullet-vertical h-40px bg-primary"></div>
                                        <!--end::Bullet-->

                                        <!--begin::Checkbox-->
                                        <div class="form-check form-check-custom form-check-solid mx-5">
                                            <input class="form-check-input" type="checkbox" value="" checked disabled />
                                        </div>
                                        <!--end::Checkbox-->

                                        <!--begin::Description-->
                                        <div class="flex-grow-1">
                                            <span class="text-gray-800 text-hover-primary fw-bold fs-6">{{ __('E-posta doğrulandı') }}</span>
                                            <span class="text-muted fw-semibold d-block">{{ $user->email_verified_at->format('M d, Y H:i') }}</span>
                                        </div>
                                        <!--end::Description-->
                                    </div>
                                    <!--end::Item-->
                                    @endif
                                </div>
                                <!--end::Body-->
                            </div>
                            <!--end::List Widget 9-->
                        </div>
                        <!--end::Col-->
                    </div>
                    <!--end::Row-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::details View-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->
@endsection
