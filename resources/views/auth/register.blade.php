<x-guest-layout>
    <!-- Begin Form -->
    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Begin Heading -->
        <div class="text-center mb-11">
            <!-- Begin Title -->
            <h1 class="text-dark fw-bolder mb-3">Sign Up</h1>
            <!-- End Title -->

            <!-- Begin Subtitle -->
            <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
            <!-- End Subtitle -->
        </div>
        <!-- End Heading -->

        <!-- Begin Input Group -->
        <div class="fv-row mb-8">
            <!-- Begin Label -->
            <label class="form-label fs-6 fw-bolder text-dark">Full Name</label>
            <!-- End Label -->

            <!-- Begin Input -->
            <input class="form-control bg-transparent @error('name') is-invalid @enderror" type="text" placeholder="" name="name" autocomplete="off" value="{{ old('name') }}" required autofocus />
            <!-- End Input -->

            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- End Input Group -->

        <!-- Begin Input Group -->
        <div class="fv-row mb-8">
            <!-- Begin Label -->
            <label class="form-label fs-6 fw-bolder text-dark">Email</label>
            <!-- End Label -->

            <!-- Begin Input -->
            <input class="form-control bg-transparent @error('email') is-invalid @enderror" type="email" placeholder="" name="email" autocomplete="off" value="{{ old('email') }}" required />
            <!-- End Input -->

            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- End Input Group -->

        <!-- Begin Input Group -->
        <div class="fv-row mb-8" data-kt-password-meter="true">
            <!-- Begin Wrapper -->
            <div class="mb-1">
                <!-- Begin Label -->
                <label class="form-label fw-bolder text-dark fs-6">Password</label>
                <!-- End Label -->

                <!-- Begin Input Wrapper -->
                <div class="position-relative mb-3">
                    <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="" name="password" autocomplete="off" required />

                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- End Input Wrapper -->
            </div>
            <!-- End Wrapper -->
        </div>
        <!-- End Input Group -->

        <!-- Begin Input Group -->
        <div class="fv-row mb-8">
            <!-- Begin Label -->
            <label class="form-label fw-bolder text-dark fs-6">Confirm Password</label>
            <!-- End Label -->

            <!-- Begin Input -->
            <input class="form-control bg-transparent @error('password_confirmation') is-invalid @enderror" type="password" placeholder="" name="password_confirmation" autocomplete="off" required />
            <!-- End Input -->

            @error('password_confirmation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <!-- End Input Group -->

        <!-- Begin Accept -->
        <div class="fv-row mb-8">
            <label class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="toc" value="1" required />
                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">I Accept the
                    <a href="#" class="ms-1 link-primary">Terms</a>
                </span>
            </label>
        </div>
        <!-- End Accept -->

        <!-- Begin Submit -->
        <div class="d-grid mb-10">
            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                <!-- Begin Indicator Label -->
                <span class="indicator-label">Sign up</span>
                <!-- End Indicator Label -->

                <!-- Begin Indicator Progress -->
                <span class="indicator-progress">Please wait...
                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                </span>
                <!-- End Indicator Progress -->
            </button>
        </div>
        <!-- End Submit -->

        <!-- Begin Sign In -->
        <div class="text-gray-500 text-center fw-semibold fs-6">
            Already have an Account?
            <a href="{{ route('login') }}" class="link-primary fw-semibold">Sign in</a>
        </div>
        <!-- End Sign In -->
    </form>
    <!-- End Form -->
</x-guest-layout>
