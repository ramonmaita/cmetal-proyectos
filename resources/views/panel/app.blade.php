<!DOCTYPE html>

<html class="loading" lang="{{ config('app.locale') }}"
 data-textdirection="ltr">
 @php
 	// \App::setLocale('en');
 @endphp
  <!-- BEGIN: Head-->
    @include('panel.partials.head')
		
  
  <!-- END: Head-->

          <!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern 2-columns  light-layout  navbar-sticky  footer-static" data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">

  <!-- BEGIN: Header-->
    @include('panel.partials.header')
  
  <!-- END: Header-->

  <!-- BEGIN: Main Menu-->

    @include('panel.partials.sidebar')

  <!-- END: Main Menu-->

  <!-- BEGIN: Content-->
  	<div class="app-content content">
  
	    
    <div class="content-overlay"></div>
		<div class="content-wrapper">
			<div class="content-header row">
              	<div class="content-header-left col-12 mb-2 mt-1">
  					<div class="row breadcrumbs-top">
    					<div class="col-12">
      						<h5 class="content-header-title float-left pr-1 mb-0">@yield('titulo_page')</h5>
      						@yield('breadcrumb')
      						{{-- <div class="breadcrumb-wrapper col-12">
        						<ol class="breadcrumb p-0 mb-0">
                                  	<li class="breadcrumb-item ">
                          				<a href="index.html"><i class="bx bx-home-alt"></i></a>
                          			</li>
                        			<li class="breadcrumb-item ">
                          				<a href="#">Card</a>
                          			</li>
                    				<li class="breadcrumb-item active">
              							Card Actions            
              						</li>
                              	</ol>
      						</div> --}}
    					</div>
  					</div>
				</div>        			
			</div>
			<div class="content-body">
				<!-- card actions section start -->
				<section id="card-actions">
				  	<!-- Info table about action starts -->
				  	@yield('content')
				  	{{-- <div class="row">
				    	<div class="col-12">
				      		<div class="card">
				        		<div class="card-header">
				          			<h4 class="card-title">Card Actions </h4>
				          			<a class="heading-elements-toggle">
				            			<i class='bx bx-dots-vertical font-medium-3'></i>
				          			</a>
				          			<div class="heading-elements">
				            			<ul class="list-inline mb-0">
				              				<li>
				                				<a data-action="collapse">
				                  					<i class="bx bx-chevron-down"></i>
				                				</a>
				              				</li>
				              				<li>
				                				<a data-action="expand">
				                  					<i class="bx bx-fullscreen"></i>
				               	 				</a>
				              				</li>
				              				<li>
				                				<a data-action="reload">
				                  					<i class="bx bx-revision"></i>
				                				</a>
				              				</li>
				              				<li>
				                				<a data-action="close">
				                  					<i class="bx bx-x"></i>
				                				</a>
				              				</li>
				            			</ul>
				          			</div>
				        		</div>
				        		<div class="card-content collapse show">
				          			<div class="card-body">
				            			<div class="row">
				              				<div class="col-sm-12">
				                				<div class="table-responsive">
				                  					<table class="table table-bordered">
									                    <thead>
									                      <tr>
									                        <th>Action</th>
									                        <th class="text-center">Icon</th>
									                        <th>Details</th>
									                      </tr>
									                    </thead>
									                    <tbody>
									                      <tr>
									                        <td>Collapse</td>
									                        <td class="text-center">
									                          <i class="bx bx-chevron-down"></i>
									                        </td>
									                        <td> Collapse card content using collapse action.</td>
									                      </tr>
									                      <tr>
									                        <td>Expand Card</td>
									                        <td class="text-center">
									                          <i class="bx bx-fullscreen"></i>
									                        </td>
									                        <td>Maximize your card using expand action</td>
									                      </tr>
									                      <tr>
									                        <td>Refresh Content</td>
									                        <td class="text-center">
									                          <i class="bx bx-revision"></i>
									                        </td>
									                        <td>Refresh your card content using refresh action.</td>
									                      </tr>
									                      <tr>
									                        <td>Remove Card</td>
									                        <td class="text-center">
									                          <i class="bx bx-x"></i>
									                        </td>
									                        <td> Remove card from page using remove card action</td>
									                      </tr>
									                    </tbody>
									                </table>
				                				</div>
				              				</div>
				            			</div>
				          			</div>
				        		</div>
				      		</div>
				    	</div>
				  	</div> --}}
				  <!-- Info table about action Ends -->
				</section>
				<!-- // card-actions section end -->
			</div>
		</div>
	</div>
  <!-- END: Content-->

	

<!-- BEGIN: Customizer-->
	{{-- @include('panel.partials.customizer') --}}
<!-- End: Customizer-->

  
   

  <div class="sidenav-overlay"></div>
  <div class="drag-target"></div>

  <!-- BEGIN: Footer-->
    @include('panel.partials.footer')
  	
  <!-- END: Footer-->

  <!-- BEGIN: Vendor JS-->
    @include('panel.partials.scripts')
   {{-- END VENDOR JS --}}
</body>
<!-- END: Body-->
     

<!-- Mirrored from www.pixinvent.com/demo/frest-bootstrap-laravel-admin-dashboard-template/demo-1/ by HTTrack Website Copier/3.x [XR&CO'2017], Tue, 12 May 2020 22:39:52 GMT -->
</html>
