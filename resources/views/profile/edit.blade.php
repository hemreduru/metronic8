@extends('layouts.app')

@section('title', __('users.edit_profile'))

@section('content')
<!--begin::Content wrapper-->
<div class="d-flex flex-column flex-column-fluid">
    <!--begin::Toolbar-->
    <div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
        <div id="kt_app_toolbar_container" class="app-container container-xxl d-flex flex-stack">
            <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
                <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">
                    {{ __('users.edit_profile') }}
                </h1>
                <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('dashboard') }}" class="text-muted text-hover-primary">{{ __('users.home') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">
                        <a href="{{ route('profile.show') }}" class="text-muted text-hover-primary">{{ __('users.profile') }}</a>
                    </li>
                    <li class="breadcrumb-item">
                        <span class="bullet bg-gray-400 w-5px h-2px"></span>
                    </li>
                    <li class="breadcrumb-item text-muted">{{ __('users.edit_profile') }}</li>
                </ul>
            </div>
            <!--RC31: Back button-->
            <div class="d-flex align-items-center gap-2 gap-lg-3">
                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-light">
                    <i class="ki-duotone ki-black-left fs-2"></i>
                    {{ __('Geri') }}
                </a>
            </div>
        </div>
    </div>
    <!--end::Toolbar-->

    <!--begin::Content-->
    <div id="kt_app_content" class="app-content flex-column-fluid">
        <div id="kt_app_content_container" class="app-container container-xxl">
            <!--begin::Layout-->
            <div class="d-flex flex-column flex-lg-row">
                <!--begin::Sidebar-->
                <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
                    <!--begin::Card-->
                    <div class="card mb-5 mb-xl-8">
                        <!--begin::Card body-->
                        <div class="card-body">
                            <!--begin::Summary-->
                            <!--begin::User Info-->
                            <div class="d-flex flex-center flex-column py-5">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-100px symbol-circle mb-7">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" />
                                    @else
                                        <div class="symbol-label fs-3 bg-light-primary text-primary">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <!--end::Avatar-->

                                <!--begin::Name-->
                                <span class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->name }}</span>
                                <!--end::Name-->

                                <!--begin::Position-->
                                <div class="mb-9">
                                    @if($roles)
                                        @foreach($roles as $role)
                                            <div class="badge badge-lg badge-light-primary d-inline">{{ $role }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <!--end::Position-->
                            </div>
                            <!--end::User Info-->
                            <!--end::Summary-->

                            <!--begin::Details toggle-->
                            <div class="d-flex flex-stack fs-4 py-3">
                                <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">
                                    {{ __('Detaylar') }}
                                    <span class="ms-2 rotate-180">
                                        <i class="ki-duotone ki-down fs-3"></i>
                                    </span>
                                </div>
                            </div>
                            <!--end::Details toggle-->

                            <div class="separator"></div>

                            <!--begin::Details content-->
                            <div id="kt_user_view_details" class="collapse show">
                                <div class="pb-5 fs-6">
                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">{{ __('users.email') }}</div>
                                    <div class="text-gray-600">{{ $user->email }}</div>
                                    <!--begin::Details item-->

                                    <!--begin::Details item-->
                                    <div class="fw-bold mt-5">{{ __('Kayıt Tarihi') }}</div>
                                    <div class="text-gray-600">{{ $user->created_at->format('d M Y, H:i') }}</div>
                                    <!--begin::Details item-->

                                    <!--begin::Details item-->
                                    @if($settings)
                                    <div class="fw-bold mt-5">{{ __('users.language') }}</div>
                                    <div class="text-gray-600">
                                        @if($settings->preferredLanguage)
                                            {{ $settings->preferredLanguage->name }}
                                        @else
                                            {{ __('Varsayılan') }}
                                        @endif
                                    </div>
                                    @endif
                                    <!--begin::Details item-->
                                </div>
                            </div>
                            <!--end::Details content-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Sidebar-->

                <!--begin::Content-->
                <div class="flex-lg-row-fluid ms-lg-15">
                    <!--begin:::Tabs-->
                    <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">
                                {{ __('Genel Bilgiler') }}
                            </a>
                        </li>
                        <!--end:::Tab item-->

                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_security_tab">
                                {{ __('Güvenlik') }}
                            </a>
                        </li>
                        <!--end:::Tab item-->

                        <!--begin:::Tab item-->
                        <li class="nav-item">
                            <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_settings_tab">
                                {{ __('Ayarlar') }}
                            </a>
                        </li>
                        <!--end:::Tab item-->
                    </ul>
                    <!--end:::Tabs-->

                    <!--begin:::Tab content-->
                    <div class="tab-content" id="myTabContent">
                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2>{{ __('Profil Bilgileri') }}</h2>
                                        <div class="fs-6 fw-semibold text-muted">{{ __('Temel bilgilerinizi güncelleyin') }}</div>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('profile.update') }}" class="form">
                                        @csrf
                                        @method('PUT')

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">{{ __('users.name') }}</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="text" class="form-control form-control-solid @error('name') is-invalid @enderror"
                                                   name="name" value="{{ old('name', $user->name) }}"
                                                   placeholder="{{ __('users.name') }}" required />
                                            <!--end::Input-->

                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">{{ __('users.email') }}</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="email" class="form-control form-control-solid @error('email') is-invalid @enderror"
                                                   name="email" value="{{ old('email', $user->email) }}"
                                                   placeholder="{{ __('users.email') }}" required />
                                            <!--end::Input-->

                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            @if(old('email', $user->email) !== $user->getOriginal('email'))
                                                <div class="form-text text-warning">
                                                    <i class="ki-duotone ki-information fs-1 text-warning me-2">
                                                        <span class="path1"></span>
                                                        <span class="path2"></span>
                                                        <span class="path3"></span>
                                                    </i>
                                                    {{ __('E-posta değişirse doğrulama gerekebilir') }}
                                                </div>
                                            @endif
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Action buttons-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                                                {{ __('users.cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                                <span class="indicator-label">{{ __('Güncelle') }}</span>
                                                <span class="indicator-progress">{{ __('Lütfen bekleyin...') }}
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->

                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2>{{ __('Profil Fotoğrafı') }}</h2>
                                        <div class="fs-6 fw-semibold text-muted">{{ __('Profil fotoğrafınızı güncelleyin') }}</div>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('profile.avatar.update') }}" enctype="multipart/form-data" class="form">
                                        @csrf

                                        <!--begin::Image input-->
                                        <div class="image-input image-input-outline mb-3" data-kt-image-input="true">
                                            <!--begin::Preview existing avatar-->
                                            <div class="image-input-wrapper w-150px h-150px"
                                                 style="background-image: url({{ $user->avatar_or_default }})"></div>
                                            <!--end::Preview existing avatar-->

                                            <!--begin::Label-->
                                            <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                   data-kt-image-input-action="change" data-bs-toggle="tooltip" title="{{ __('Fotoğraf değiştir') }}">
                                                <i class="ki-duotone ki-pencil fs-7">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                                <!--begin::Inputs-->
                                                <input type="file" name="avatar" accept=".png, .jpg, .jpeg" />
                                                <input type="hidden" name="avatar_remove" />
                                                <!--end::Inputs-->
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Cancel-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                  data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="{{ __('İptal et') }}">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <!--end::Cancel-->

                                            <!--begin::Remove-->
                                            <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-body shadow"
                                                  data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="{{ __('Fotoğrafı kaldır') }}">
                                                <i class="ki-duotone ki-cross fs-2">
                                                    <span class="path1"></span>
                                                    <span class="path2"></span>
                                                </i>
                                            </span>
                                            <!--end::Remove-->
                                        </div>
                                        <!--end::Image input-->

                                        <!--begin::Hint-->
                                        <div class="form-text mb-3">{{ __('İzin verilen dosya türleri: png, jpg, jpeg. Maksimum dosya boyutu: 2MB.') }}</div>
                                        <!--end::Hint-->

                                        @error('avatar')
                                            <div class="text-danger fs-7 mb-3">{{ $message }}</div>
                                        @enderror

                                        <!--begin::Action buttons-->
                                        <div class="d-flex justify-content-between">
                                            @if($user->avatar)
                                                <button type="button" class="btn btn-light-danger" onclick="deleteAvatar()">
                                                    {{ __('Fotoğrafı Sil') }}
                                                </button>
                                            @else
                                                <div></div>
                                            @endif

                                            <button type="submit" class="btn btn-primary">
                                                <span class="indicator-label">{{ __('Fotoğrafı Güncelle') }}</span>
                                                <span class="indicator-progress">{{ __('Lütfen bekleyin...') }}
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->

                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade" id="kt_user_view_security_tab" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2>{{ __('Şifre Değiştir') }}</h2>
                                        <div class="fs-6 fw-semibold text-muted">{{ __('Hesap güvenliğiniz için güçlü bir şifre kullanın') }}</div>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('profile.password.update') }}" class="form">
                                        @csrf
                                        @method('PUT')

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">{{ __('users.current_password') }}</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="password" class="form-control form-control-solid @error('current_password') is-invalid @enderror"
                                                   name="current_password" placeholder="{{ __('users.current_password') }}" required />
                                            <!--end::Input-->

                                            @error('current_password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">{{ __('users.new_password') }}</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="password" class="form-control form-control-solid @error('password') is-invalid @enderror"
                                                   name="password" placeholder="{{ __('users.new_password') }}" required />
                                            <!--end::Input-->

                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror

                                            <div class="form-text">{{ __('Şifre en az 8 karakter olmalı ve büyük harf, küçük harf ve rakam içermelidir.') }}</div>
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">
                                                <span class="required">{{ __('users.password_confirmation') }}</span>
                                            </label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <input type="password" class="form-control form-control-solid"
                                                   name="password_confirmation" placeholder="{{ __('users.password_confirmation') }}" required />
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Action buttons-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light me-3">
                                                {{ __('users.cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="indicator-label">{{ __('Şifreyi Güncelle') }}</span>
                                                <span class="indicator-progress">{{ __('Lütfen bekleyin...') }}
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->

                        <!--begin:::Tab pane-->
                        <div class="tab-pane fade" id="kt_user_view_settings_tab" role="tabpanel">
                            <!--begin::Card-->
                            <div class="card pt-4 mb-6 mb-xl-9">
                                <!--begin::Card header-->
                                <div class="card-header border-0">
                                    <!--begin::Card title-->
                                    <div class="card-title flex-column">
                                        <h2>{{ __('Uygulama Ayarları') }}</h2>
                                        <div class="fs-6 fw-semibold text-muted">{{ __('Tercihlerinizi ayarlayın') }}</div>
                                    </div>
                                    <!--end::Card title-->
                                </div>
                                <!--end::Card header-->

                                <!--begin::Card body-->
                                <div class="card-body pt-0 pb-5">
                                    <!--begin::Form-->
                                    <form method="POST" action="{{ route('profile.settings.update') }}" class="form">
                                        @csrf
                                        @method('PUT')

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">{{ __('users.language') }}</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <!--RC13: Select2 for select elements-->
                                            <select name="preferred_language_id" class="form-select form-select-solid" data-control="select2">
                                                <option value="">{{ __('Varsayılan Dil') }}</option>
                                                @foreach($languages as $language)
                                                    <option value="{{ $language->id }}"
                                                            {{ ($settings && $settings->preferred_language_id == $language->id) ? 'selected' : '' }}>
                                                        {{ $language->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Input group-->
                                        <div class="mb-7">
                                            <!--begin::Label-->
                                            <label class="fs-6 fw-semibold form-label mt-3">{{ __('users.theme') }}</label>
                                            <!--end::Label-->

                                            <!--begin::Input-->
                                            <select name="theme" class="form-select form-select-solid" data-control="select2">
                                                <option value="system" {{ ($settings && $settings->theme == 'system') ? 'selected' : '' }}>
                                                    {{ __('users.system') }}
                                                </option>
                                                <option value="light" {{ ($settings && $settings->theme == 'light') ? 'selected' : '' }}>
                                                    {{ __('users.light') }}
                                                </option>
                                                <option value="dark" {{ ($settings && $settings->theme == 'dark') ? 'selected' : '' }}>
                                                    {{ __('users.dark') }}
                                                </option>
                                            </select>
                                            <!--end::Input-->
                                        </div>
                                        <!--end::Input group-->

                                        <!--begin::Action buttons-->
                                        <div class="d-flex justify-content-end">
                                            <button type="reset" class="btn btn-light me-3">
                                                {{ __('users.cancel') }}
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <span class="indicator-label">{{ __('Ayarları Güncelle') }}</span>
                                                <span class="indicator-progress">{{ __('Lütfen bekleyin...') }}
                                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                </span>
                                            </button>
                                        </div>
                                        <!--end::Action buttons-->
                                    </form>
                                    <!--end::Form-->
                                </div>
                                <!--end::Card body-->
                            </div>
                            <!--end::Card-->
                        </div>
                        <!--end:::Tab pane-->
                    </div>
                    <!--end:::Tab content-->
                </div>
                <!--end::Content-->
            </div>
            <!--end::Layout-->
        </div>
    </div>
    <!--end::Content-->
</div>
<!--end::Content wrapper-->

<!--begin::Modal - Delete Avatar-->
<div class="modal fade" id="kt_modal_delete_avatar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered mw-450px">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="fw-bold">{{ __('Profil Fotoğrafını Sil') }}</h2>
                <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                    <i class="ki-duotone ki-cross fs-1">
                        <span class="path1"></span>
                        <span class="path2"></span>
                    </i>
                </div>
            </div>

            <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                <form method="POST" action="{{ route('profile.avatar.delete') }}" class="form">
                    @csrf
                    @method('DELETE')

                    <div class="fv-row mb-7">
                        <div class="fw-semibold text-gray-600 fs-6 mb-5">{{ __('Profil fotoğrafınızı silmek istediğinizden emin misiniz?') }}</div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">
                            {{ __('users.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-danger" data-kt-users-modal-action="submit">
                            <span class="indicator-label">{{ __('Sil') }}</span>
                            <span class="indicator-progress">{{ __('Lütfen bekleyin...') }}
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end::Modal - Delete Avatar-->
@endsection

@push('scripts')
<!--RC29: Clear JS console errors-->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Select2
    $('[data-control="select2"]').select2({
        allowClear: false
    });

    // Initialize image input
    KTImageInput.createInstances();

    // Form submission handlers
    document.querySelectorAll('form').forEach(function(form) {
        const submitButton = form.querySelector('[type="submit"]');
        if (submitButton) {
            form.addEventListener('submit', function() {
                submitButton.setAttribute('data-kt-indicator', 'on');
                submitButton.disabled = true;
            });
        }
    });
});

// Delete avatar function
function deleteAvatar() {
    $('#kt_modal_delete_avatar').modal('show');
}

// Modal close handlers
$('#kt_modal_delete_avatar').on('hidden.bs.modal', function() {
    const form = this.querySelector('form');
    const submitButton = form.querySelector('[type="submit"]');
    submitButton.removeAttribute('data-kt-indicator');
    submitButton.disabled = false;
});
</script>
@endpush
