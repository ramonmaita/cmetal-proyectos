<head>
      <meta  charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <meta name="csrf-token" content="68xGBAAdkPoonCxwmQvfGedd22UBNGcJ2ZCa2mFI">

      <title>{{ config('app.name') }}</title>
      <link rel="apple-touch-icon" href="images/ico/apple-icon-120.html">
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('images/ico/favicon.ico') }}">

      
      {{-- <link href="https://fonts.googleapis.com/css?family=Rubik:300,400,500,600%7CIBM+Plex+Sans:300,400,500,600,700" rel="stylesheet"> --}}

      <!-- BEGIN: Vendor CSS-->
      <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/vendors.min.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/charts/apexcharts.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/extensions/swiper.min.css') }}">
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
      <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/dashboard-analytics.css') }}">
      <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/dashboard-ecommerce.css') }}">
      <!-- END: Page CSS-->

      <!-- BEGIN: Custom CSS-->
       <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
      <!-- END: Custom CSS-->

      @stack('css')

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
      </style>
  </head>