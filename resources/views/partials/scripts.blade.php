<!--begin::Theme mode setup on page load-->
<script>
    var defaultThemeMode = "dark";
    var themeMode;
    if (document.documentElement) {
        if (document.documentElement.hasAttribute("data-bs-theme-mode")) {
            themeMode = document.documentElement.getAttribute("data-bs-theme-mode");
        } else {
            if (localStorage.getItem("data-bs-theme") !== null) {
                themeMode = localStorage.getItem("data-bs-theme");
            } else {
                themeMode = defaultThemeMode;
            }
        }
        if (themeMode === "dark") {
            themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
        }
        document.documentElement.setAttribute("data-bs-theme", themeMode);
    }
</script>
<!--end::Theme mode setup on page load-->

<!--begin::Javascript-->
<!--begin::Global Javascript Bundle(mandatory for all pages)-->
<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
<script src="{{ asset('js/scripts.bundle.js') }}"></script>
<!--end::Global Javascript Bundle-->

<!--begin::Vendors Javascript(used for this page only)-->
<script src="{{ asset('plugins/custom/fullcalendar/fullcalendar.bundle.js') }}"></script>
<script src="{{ asset('plugins/custom/datatables/datatables.bundle.js') }}"></script>
<!--end::Vendors Javascript-->

<!--begin::Custom Javascript(used for this page only)-->
<script src="{{ asset('js/widgets.bundle.js') }}"></script>
<script src="{{ asset('js/custom/widgets.js') }}"></script>
<script src="{{ asset('js/custom/apps/chat/chat.js') }}"></script>
<script src="{{ asset('js/custom/utilities/modals/upgrade-plan.js') }}"></script>
<script src="{{ asset('js/custom/utilities/modals/create-app.js') }}"></script>
<!--end::Custom Javascript-->

<!--begin::Notification System-->
@include('partials.notifications')
<!--end::Notification System-->
@include('partials.theme-scripts')

@yield('scripts')
<!--end::Javascript-->
