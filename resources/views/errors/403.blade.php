<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="68xGBAAdkPoonCxwmQvfGedd22UBNGcJ2ZCa2mFI">

    <title>{{ config('app.name') }}</title>
    <link rel="apple-touch-icon" href="images/ico/apple-icon-120.html">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.ico') }}">

    
    <link href="../../../../external.html?link=https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
            <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themes/semi-dark-layout.css') }}">
        <!-- END: Theme CSS-->

    <!-- BEGIN: Page CSS-->
        <link rel="stylesheet" type="text/css" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}">
            <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
        <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css') }}">
        <!-- END: Custom CSS-->

        <style>
        html .pace .pace-progress {
            background: #fff;
        }
        .main-menu .navbar-header .navbar-brand .brand-text {
          color: #5b1818 !important;
        }

        .nav-item .active{
          background: rgba(151, 31, 31, 0.83) !important;
        }
        .main-menu.menu-light .navigation > li.active:not(.sidebar-group-active) > a {
           background: rgba(151, 31, 31, 0.83) !important;
          color: #fff;
          border-radius: .267rem;
        }
        .breadcrumb-item.active , .breadcrumb-item:hover{
            color: #5b1818 !important;
        }
        html body .content .content-wrapper .breadcrumb-wrapper .breadcrumb .breadcrumb-item a:hover, html body .content .content-wrapper .breadcrumb-wrapper .breadcrumb .breadcrumb-item a i:hover {
            color: #5b1818 !important;
        }
        .btn-cmetal.active, .btn-cmetal:active, .btn-cmetal:focus {
          background-color: #5b1818 !important;
          color: #fff !important;
        }

        html body .form-label-group > input:focus:not(:placeholder-shown) ~ label,  html body .form-label-group textarea:focus:not(:placeholder-shown) ~ label, html body .form-label-group textarea:not(:active):not(:placeholder-shown) ~ label {
            color: #5b1818 !important;
            transition: all .25s ease-in-out;
            opacity: 1;
          }
          .form-control:focus {
            color: #5b1818;
            background-color: #fff;
            border-color: #5b1818;
            outline: 0;
            box-shadow: 0 3px 8px 0 rgba(0,0,0,.1);
          }

          .btn-light-cmetal.hover, .btn-light-cmetal:hover {
              background-color: #5b1818 !important;
              color: #fff !important;
          }
          .btn-light-cmetal {
            background-color: #e6eaee;
            color: #5b1818;
          }

          .data-table{
            width: 100% !important;
          }

          .progress-bar-cmetal .progress-bar {
              background-color: #5b1818;
              box-shadow: 0 2px 6px 0 rgb(91, 24, 24);
          }

          .dropdown-item.active, .dropdown-item:active {
              background-color: #5b1818 !important;
          }
      </style>
  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout 1-column navbar-sticky bg-full-screen-image footer-static blank-page
   light-layout " data-open="click" data-menu="vertical-menu-modern" data-col="1-column">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
         <!-- not authorized start -->
          <section class="row flexbox-container">
            <div class="col-xl-7 col-md-8 col-12">
              <div class="card bg-transparent shadow-none">
                <div class="card-content">
                  <div class="card-body text-center bg-transparent miscellaneous">
                    <img src="{{asset('images/pages/not-authorized.png')}}" class="img-fluid" alt="not authorized" width="400">
                    <h1 class="my-2 error-title">You are not authorized!</h1>
                    <p>
                        You do not have permission to view this directory or page using 
                        the credentials that you supplied.
                    </p>
                    <a href="{{ route('panel.index') }}" class="btn btn-cmetal round glow mt-2">BACK TO HOME</a>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- not authorized end -->
        </div>
      </div>
    </div>
    <!-- END: Content-->

    
    <!-- BEGIN: Vendor JS-->
    <script>
        var assetBaseUrl = "";
    </script>
    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.tools.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.defaults.js') }}"></script>
    <script src="{{ asset('fonts/LivIconsEvo/js/LivIconsEvo.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
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
        <!-- END: Page JS-->

  </body>
  <!-- END: Body-->

<!-- Mirrored from www.pixinvent.com/demo/frest-bootstrap-laravel-admin-dashboard-template/demo-1/page-not-authorized by HTTrack Website Copier/3.x [XR&CO'2017], Tue, 12 May 2020 22:45:00 GMT -->
</html>