<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}"
    data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}"
    data-kt-sticky-animation="false">
    <div class="app-container container-fluid d-flex align-items-stretch justify-content-between"
        id="kt_app_header_container">
        <div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
            <div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
                <i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
                    <span class="path1"></span>
                    <span class="path2"></span>
                </i>
            </div>
        </div>
        <div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
            <a href="{{ route('dashboard') }}" class="d-lg-none">
                <img alt="Logo" src="{{ asset('media/logos/default-small.svg') }}" class="h-30px" />
            </a>
        </div>
        <div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
            <div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true"
                data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}"
                data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end"
                data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true"
                data-kt-swapper-mode="{default: 'append', lg: 'prepend'}"
                data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
                <div class="menu menu-lg-rounded menu-column menu-lg-row my-5 my-lg-0 align-items-stretch fw-semibold px-2 px-lg-0"
                    id="kt_app_header_menu" data-kt-menu="true">
                    <div class="menu-item d-flex align-items-center me-0 me-lg-2">
                        <span class="fs-2 fw-bold text-dark">
                            @yield('page-title')
                        </span>
                    </div>
                </div>
            </div>
            <div class="app-navbar flex-shrink-0">
                @auth
                    <div class="app-navbar-item d-flex align-items-center ms-1 ms-md-3">
                        @if (Auth::user() && Auth::user()->currentRole)
                            <span
                                class="fs-7 fw-semibold text-muted me-2">{{ Auth::user()->currentRole->display_name ?? Auth::user()->currentRole->name }}</span>
                        @endif
                    </div>
                @endauth
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_theme_menu_toggle">
                    <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
                        <i class="ki-duotone ki-night-day fs-2" id="theme-icon">
                            <span class="path1"></span>
                            <span class="path2"></span>
                            <span class="path3"></span>
                            <span class="path4"></span>
                            <span class="path5"></span>
                            <span class="path6"></span>
                            <span class="path7"></span>
                            <span class="path8"></span>
                            <span class="path9"></span>
                            <span class="path10"></span>
                        </i>
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                {{ __('auth.theme_selection') }}
                            </div>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-theme="light"
                                onclick="event.preventDefault(); switchTheme('light')">
                                <span class="symbol symbol-20px me-4">
                                    <i class="ki-duotone ki-sun fs-2 text-warning">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="theme-text">{{ __('auth.theme_light') }}</span>
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-theme="dark"
                                onclick="event.preventDefault(); switchTheme('dark')">
                                <span class="symbol symbol-20px me-4">
                                    <i class="ki-duotone ki-moon fs-2 text-info">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>
                                </span>
                                <span class="theme-text">{{ __('auth.theme_dark') }}</span>
                            </a>
                        </div>
                        <div class="menu-item px-3">
                            <a href="#" class="menu-link px-3" data-theme="system"
                                onclick="event.preventDefault(); switchTheme('system')">
                                <span class="symbol symbol-20px me-4">
                                    <i class="ki-duotone ki-screen fs-2 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                        <span class="path4"></span>
                                    </i>
                                </span>
                                <span class="theme-text">{{ __('auth.theme_system') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_lang_menu_toggle">
                    <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-color-primary w-35px h-35px"
                        data-kt-menu-trigger="click" data-kt-menu-attach="parent"
                        data-kt-menu-placement="bottom-end">
                        @if (app()->getLocale() == 'tr')
                            🇹🇷
                        @else
                            🇺🇸
                        @endif
                    </div>
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px py-4"
                        data-kt-menu="true">
                        <div class="menu-item px-3">
                            <div class="menu-content text-muted pb-2 px-3 fs-7 text-uppercase">
                                {{ __('common.language') }}
                            </div>
                        </div>
                        <div class="menu-item px-3">
                            <form method="POST" action="{{ route('lang.switch') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="lang" value="tr">
                                <a href="#"
                                    class="menu-link px-3 {{ app()->getLocale() == 'tr' ? 'active' : '' }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span class="symbol symbol-20px me-4">
                                        <span class="symbol-label">🇹🇷</span>
                                    </span>
                                    {{ __('common.turkish') }}
                                </a>
                            </form>
                        </div>
                        <div class="menu-item px-3">
                            <form method="POST" action="{{ route('lang.switch') }}" class="d-inline">
                                @csrf
                                <input type="hidden" name="lang" value="en">
                                <a href="#"
                                    class="menu-link px-3 {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    <span class="symbol symbol-20px me-4">
                                        <span class="symbol-label">🇺🇸</span>
                                    </span>
                                    {{ __('common.english') }}
                                </a>
                            </form>
                        </div>
                    </div>
                </div>

                @auth
                    <div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
                        <div class="cursor-pointer symbol symbol-35px"
                            data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent"
                            data-kt-menu-placement="bottom-end">
                            <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-info">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </div>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <div class="menu-content d-flex align-items-center px-3">
                                    <div class="symbol symbol-50px me-5">
                                        <div class="symbol-label fs-2 fw-semibold bg-info text-inverse-info">
                                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                        </div>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <div class="fw-bold d-flex align-items-center fs-5">{{ Auth::user()->name }}</div>
                                        <a href="#"
                                            class="fw-semibold text-muted text-hover-primary fs-7">{{ Auth::user()->email }}</a>
                                    </div>
                                </div>
                            </div>
                            @if (Auth::user()->hasMultipleRoles())
                                <div class="menu-item px-5">
                                    <a href="{{ route('role.select') }}" class="menu-link px-5">
                                        {{ __('common.switch_role') }}
                                    </a>
                                </div>
                            @endif
                            <div class="separator my-2"></div>
                            <div class="menu-item px-5">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <a href="{{ route('logout') }}" class="menu-link px-5 text-danger"
                                        onclick="event.preventDefault(); this.closest('form').submit();">
                                        {{ __('common.logout') }}
                                    </a>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="app-navbar-item">
                        <a href="{{ route('login') }}" class="btn btn-sm btn-light me-3">{{ __('common.login') }}</a>
                        <a href="{{ route('register') }}" class="btn btn-sm btn-primary">{{ __('common.register') }}</a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</div>
