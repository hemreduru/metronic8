<x-guest-layout>
    <!-- Begin Form -->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_in_form" data-kt-redirect-url="{{ route('dashboard') }}" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Begin Heading -->
        <div class="text-center mb-11">
            <!-- Begin Title -->
            <h1 class="text-dark fw-bolder mb-3">{{ __('common.login') }}</h1>
            <!-- End Title -->

            <!-- Begin Link -->
            <div class="text-gray-500 fw-semibold fs-6">{{ __('common.welcome') }}</div>
            @if(app()->environment('local'))
                <div class="text-info fw-semibold fs-7 mt-2">
                    <i class="fas fa-info-circle"></i> Local: {{ __('common.password_optional') }}
                </div>
            @endif
            <!-- End Link -->
        </div>
        <!-- End Heading -->

        <!-- Session Status -->
        @if (session('status'))
            <div class="alert alert-success mb-5">{{ session('status') }}</div>
        @endif

        <!-- Begin Input Group -->
        <div class="fv-row mb-8">
            <!-- Begin Label -->
            <label class="form-label fs-6 fw-bolder text-dark">{{ __('common.username_or_email') }}</label>
            <!-- End Label -->

            <!-- Begin Input -->
            <input class="form-control bg-transparent @error('login') is-invalid @enderror" type="text" name="login" autocomplete="off" value="{{ old('login') }}" required autofocus placeholder="{{ __('common.enter_username_or_email') }}" />
            <!-- End Input -->

            @error('login')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- End Input Group -->

        <!-- Begin Input Group -->
        <div class="fv-row mb-3">
            <!-- Begin Label -->
            <label class="form-label fw-bolder text-dark fs-6 mb-0">
                {{ __('common.password') }}
                @if(app()->environment('local'))
                    <span class="text-muted fs-7">({{ __('common.optional_in_local') }})</span>
                @endif
            </label>
            <!-- End Label -->

            <!-- Begin Input -->
            <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" name="password" autocomplete="off" {{ app()->environment('local') ? '' : 'required' }} />
            <!-- End Input -->

            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- End Input Group -->

        <!-- Begin Wrapper -->
        <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
            <!-- Begin Remember Me -->
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
                <label class="form-check-label" for="remember_me">{{ __('common.remember_me') }}</label>
            </div>
            <!-- End Remember Me -->

            <!-- Begin Link -->
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="link-primary">{{ __('common.forgot_password') }}</a>
            @endif
            <!-- End Link -->
        </div>
        <!-- End Wrapper -->

        <!-- Begin Submit -->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
                <!-- Begin Indicator Label -->
                <span class="indicator-label">{{ __('common.login') }}</span>
                <!-- End Indicator Label -->

                <!-- Begin Indicator Progress -->
                <span class="indicator-progress">{{ __('common.loading') }}
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                <!-- End Indicator Progress -->
            </button>
        </div>
        <!-- End Submit -->

        <!-- Begin Sign Up -->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            {{ __('common.not_member_yet') }}
            <a href="{{ route('register') }}" class="link-primary">{{ __('common.register') }}</a>
        </div>
        <!-- End Sign Up -->
    </form>
    <!-- End Form -->
</x-guest-layout>
