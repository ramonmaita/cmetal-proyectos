<!DOCTYPE html>
<html class="loading" lang="es" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="csrf-token" content="68xGBAAdkPoonCxwmQvfGedd22UBNGcJ2ZCa2mFI">

    <title>{{ config('app.name') }}</title>
    {{-- <link rel="apple-touch-icon" href="images/ico/apple-icon-120.html"> --}}
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
    <link rel="stylesheet" type="text/css" href="{{ asset('css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <!-- END: Custom CSS-->
    <style>
        html .pace .pace-progress {
            background: #fff;
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
      </style>
  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout 1-column navbar-sticky  footer-static blank-page light-layout " data-open="click" data-menu="vertical-menu-modern" data-col="1-column" style="background-color: #5b1818 !important;">
    <!-- BEGIN: Content-->
    <div class="app-content content">
      <div class="content-overlay"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <!-- login page start -->
          <section id="auth-login" class="row flexbox-container">
            <div class="col-xl-8 col-11">
              <div class="card bg-authentication mb-0">
                <div class="row m-0">
                  <!-- left section-login -->
                  <div class="col-md-6 col-12 px-0">
                    <div class="card disable-rounded-right mb-0 p-2 h-100 d-flex justify-content-center">
                      <div class="card-header pb-1">
                        <div class="card-title">
                          <h4 class="text-center">{{ __('messages.produccionProyectos') }}</h4>
                          <hr>
                        </div>
                      </div>
                      <div class="card-content">
                        <div class="card-body">
                          <div class="d-flex flex-md-row flex-column text-center">
                            <center>
                              
                            <img class="img-fluid" src="{{ asset('images/logo/logo-cmetal.png') }}" alt="branding logo" width="80%">
                            </center>
                          </div>
                          <hr>
                          @include('alertas')
                          @if (session('status'))
                              <div class="alert alert-success">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                  {{ session('status') }}
                              </div>
                          @endif
                          @if ($errors->any())
                              <div class="alert alert-danger">
                                <button type="button" class="close" data-dismiss="alert">×</button>
                                  {{ $errors->first() }}
                              </div>
                          @endif
                          	<div class="text-muted text-center mb-2">
                          		<small>{{ __('messages.restablecerPass') }}</small>
                          	</div>
                          <form method="POST" action="{{ route('password.update') }}" autocomplete="off">
                            {{ csrf_field() }}
                            <input type="hidden" name="token" value="{{ $token }}">
			                      <div class="form-group">
                                <label class="text-bold-600" for="exampleInputPassword1">{{ __('messages.newPass') }}</label>
                                <input type="password" name="password" class="form-control {{ ($errors->has('password')) ? 'is-invalid' : '' }}" id="exampleInputPassword1"
                                      placeholder="{{ __('messages.newPass') }}">
                              @if ($errors->has('password'))
                                <div class="invalid-feedback">
                                    <i class="bx bx-radio-circle"></i>
                                    {{ $errors->last('password') }}
                                  </div>
                              @endif
                            </div>
                            <div class="form-group mb-2">
                                  <label class="text-bold-600" for="exampleInputPassword2"> {{ __('messages.confirmPass') }}</label>
                                  <input type="password" class="form-control {{ ($errors->has('password_confirmation')) ? 'is-invalid' : '' }}" id="exampleInputPassword2" name="password_confirmation" 
                                      placeholder="{{ __('messages.confirmPass') }}">
                                  @if ($errors->has('password_confirmation'))
                                    <div class="invalid-feedback">
                                        <i class="bx bx-radio-circle"></i>
                                        {{ $errors->first('password_confirmation') }}
                                      </div>
                                  @endif
                            </div>
                            <button type="submit" class="btn btn-cmetal glow position-relative w-100">{{ __('messages.resetPass') }}<i id="icon-arrow" class="bx bx-right-arrow-alt"></i>
                            </button>
                          </form>
                          <hr>
                          {{-- <div class="text-center">
                            <small class="mr-25">Don't have an account?</small>
                            <a href="auth-register.html"><small>Sign up</small></a>
                          </div> --}}
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- right section image -->
                  <div class="col-md-6 d-md-block d-none text-center align-self-center">
                    <div class="card-content">
                      <img class="img-fluid" src="{{ asset('images/pages/login.png') }}" alt="branding logo" width="100%">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
          <!-- login page ends -->
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

</html>
