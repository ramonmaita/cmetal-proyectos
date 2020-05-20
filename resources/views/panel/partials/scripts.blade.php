<script>
        var assetBaseUrl = "{{ asset('') }}";
    </script>
    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
	    <script src="{{ asset('vendors/js/charts/apexcharts.min.js') }}"></script>
		<script src="{{ asset('vendors/js/extensions/swiper.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
        <script src="{{ asset('js/scripts/configs/vertical-menu-light.js') }}"></script>
        <script src="{{ asset('js/core/app-menu.js') }}"></script>
	    <script src="{{ asset('js/core/app.js') }}"></script>
	    <script src="{{ asset('js/scripts/components.js') }}"></script>
	    <script src="{{ asset('js/scripts/footer.js') }}"></script>
	    <script src="{{ asset('js/scripts/customizer.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
        <script src="{{ asset('js/scripts/pages/dashboard-analytics.js') }}"></script>
    	<script src="{{ asset('js/scripts/pages/dashboard-ecommerce.js') }}"></script>
    <!-- END: Page JS-->

    @stack('scripts')