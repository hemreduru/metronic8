{{--
    Metronic Toastr Integration
    Otomatik olarak yakalayacak:
    1. Session flash mesajları (success, error, warning, info)
    2. AJAX JSON response'ları (status: success/error, message: "...")
--}}
<script>
// Toastr global ayarları
if (typeof toastr !== 'undefined') {
    toastr.clear();
    toastr.options = {
        closeButton: true,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toastr-top-right", // Metronic uses 'toastr-' prefix
        preventDuplicates: true,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut"
    };

    // 1. Session Flash Messages - Sayfa yüklendiğinde otomatik göster
    @if(session()->has('success'))
        toastr.success('{{ session('success') }}');
    @endif

    @if(session()->has('error'))
        toastr.error('{{ session('error') }}');
    @endif

    @if(session()->has('warning'))
        toastr.warning('{{ session('warning') }}');
    @endif

    @if(session()->has('info'))
        toastr.info('{{ session('info') }}');
    @endif

    // 2. AJAX Response Interceptor - Tüm AJAX isteklerini yakala
    $(document).ready(function() {
        // jQuery AJAX Global Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Global AJAX Success Handler
        $(document).ajaxSuccess(function(event, xhr, settings) {
            try {
                const response = xhr.responseJSON;
                if (response && response.message) {
                    if (response.status === 'success') {
                        toastr.success(response.message);
                    } else if (response.status === 'error') {
                        toastr.error(response.message);
                    } else if (response.status === 'warning') {
                        toastr.warning(response.message);
                    } else if (response.status === 'info') {
                        toastr.info(response.message);
                    }
                }
            } catch (e) {
                // JSON parse hatası varsa sessizce geç
            }
        });

        // Global AJAX Error Handler
        $(document).ajaxError(function(event, xhr, settings) {
            try {
                const response = xhr.responseJSON;
                if (response && response.message) {
                    toastr.error(response.message);
                } else {
                    // Default error message
                    toastr.error('{{ __('common.error') }}');
                }
            } catch (e) {
                toastr.error('{{ __('common.error') }}');
            }
        });

        // Fetch API Interceptor (modern JS için)
        const originalFetch = window.fetch;
        window.fetch = function(...args) {
            return originalFetch.apply(this, args)
                .then(response => {
                    // Response'u klonla (bir kez okursan tükenir)
                    const clonedResponse = response.clone();

                    if (response.headers.get('content-type')?.includes('application/json')) {
                        clonedResponse.json().then(data => {
                            if (data && data.message) {
                                if (data.status === 'success') {
                                    toastr.success(data.message);
                                } else if (data.status === 'error') {
                                    toastr.error(data.message);
                                } else if (data.status === 'warning') {
                                    toastr.warning(data.message);
                                } else if (data.status === 'info') {
                                    toastr.info(data.message);
                                }
                            }
                        }).catch(() => {
                            // JSON parse hatası varsa sessizce geç
                        });
                    }

                    return response;
                })
                .catch(error => {
                    toastr.error('{{ __('common.error') }}');
                    throw error;
                });
        };
    });

    // Helper functions - Manuel kullanım için
    window.showToast = {
        success: function(message, title) {
            toastr.success(message, title || 'Success');
        },
        error: function(message, title) {
            toastr.error(message, title || 'Error');
        },
        warning: function(message, title) {
            toastr.warning(message, title || 'Warning');
        },
        info: function(message, title) {
            toastr.info(message, title || 'Info');
        }
    };
} else {
    console.warn('Toastr library not found!');
}
</script>
