<!--begin::Theme Scripts-->
<script>
// Theme switching functionality
function switchTheme(theme) {
    // Update UI immediately without page reload
    updateThemeUI(theme);

    // Add loading state to button
    const activeButton = document.querySelector(`[data-theme="${theme}"]`);
    if (activeButton) {
        const themeTextSpan = activeButton.querySelector('.theme-text');
        if (themeTextSpan) {
            const originalText = themeTextSpan.innerHTML;
            themeTextSpan.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>{{ __('auth.theme_changing') }}...';
            activeButton.style.pointerEvents = 'none';

            // Restore button after delay
            setTimeout(() => {
                themeTextSpan.innerHTML = originalText;
                activeButton.style.pointerEvents = 'auto';
            }, 600);
        }
    }

    // Save to server - toastr artık AJAX interceptor ile otomatik çalışır!
    fetch('{{ route("theme.switch") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ theme: theme })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Server-side toastr AJAX interceptor ile otomatik çalışır
            updateThemeIcon(theme);
        }
    })
    .catch(error => {
        console.error('Theme switch error:', error);
        // Hata durumunda otomatik toastr gösterecek (AJAX error interceptor)
    });
}

function updateThemeUI(theme) {
    let actualTheme = theme;

    // System temasında browser'ın tercihini kontrol et
    if (theme === 'system') {
        actualTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // HTML'e tema attribute'unu ekle - sayfa yenileme yok!
    document.documentElement.setAttribute('data-bs-theme', actualTheme);
    document.body.setAttribute('data-bs-theme', actualTheme);

    // localStorage'a kaydet
    localStorage.setItem('data-bs-theme', theme);
    localStorage.setItem('data-bs-theme-actual', actualTheme);

    // Menu item'ları güncelle
    document.querySelectorAll('[data-theme]').forEach(item => {
        item.classList.remove('active');
        if (item.getAttribute('data-theme') === theme) {
            item.classList.add('active');
        }
    });

    // CSS variables'ı güncelle (eğer varsa)
    updateCSSVariables(actualTheme);

    // Smooth transition effect
    document.documentElement.style.transition = 'all 0.3s ease';
    setTimeout(() => {
        document.documentElement.style.transition = '';
    }, 300);
}

function updateThemeIcon(theme) {
    const themeIcon = document.getElementById('theme-icon');
    if (themeIcon) {
        // Icon'u temaya göre değiştir
        switch(theme) {
            case 'light':
                themeIcon.className = 'ki-duotone ki-sun fs-2';
                break;
            case 'dark':
                themeIcon.className = 'ki-duotone ki-moon fs-2';
                break;
            case 'system':
            default:
                themeIcon.className = 'ki-duotone ki-night-day fs-2';
                break;
        }
    }
}

function updateCSSVariables(theme) {
    const root = document.documentElement;

    if (theme === 'dark') {
        // Dark theme CSS variables
        root.style.setProperty('--bs-body-bg', '#1e1e2e');
        root.style.setProperty('--bs-body-color', '#ffffff');
        root.style.setProperty('--bs-border-color', '#2a2a3e');
    } else {
        // Light theme CSS variables
        root.style.setProperty('--bs-body-bg', '#ffffff');
        root.style.setProperty('--bs-body-color', '#181c32');
        root.style.setProperty('--bs-border-color', '#e1e3ea');
    }
}

// Initialize theme on page load
function initializeTheme() {
    // Önce localStorage'dan kontrol et
    const savedTheme = localStorage.getItem('data-bs-theme') || 'system';

    // Sunucudan mevcut temayı al
    fetch('{{ route("theme.current") }}')
        .then(response => response.json())
        .then(data => {
            const serverTheme = data.theme || savedTheme;
            updateThemeUI(serverTheme);
            updateThemeIcon(serverTheme);
        })
        .catch(error => {
            // Hata durumunda localStorage'daki temayı kullan
            updateThemeUI(savedTheme);
            updateThemeIcon(savedTheme);
        });
}

// System theme değişikliklerini dinle
function listenSystemThemeChanges() {
    const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');

    mediaQuery.addEventListener('change', function(e) {
        const currentTheme = localStorage.getItem('data-bs-theme') || 'system';
        if (currentTheme === 'system') {
            updateThemeUI('system');
        }
    });
}

// DOM yüklendiğinde başlat
document.addEventListener('DOMContentLoaded', function() {
    initializeTheme();
    listenSystemThemeChanges();
});

// Sayfa visibility değiştiğinde tema senkronizasyonu
document.addEventListener('visibilitychange', function() {
    if (!document.hidden) {
        // Sayfa tekrar görünür olduğunda tema durumunu kontrol et
        const savedTheme = localStorage.getItem('data-bs-theme') || 'system';
        updateThemeUI(savedTheme);
    }
});
</script>
<!--end::Theme Scripts-->
