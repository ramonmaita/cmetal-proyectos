@extends('panel.app')

@section('titulo_page')
{{ $proyecto->nombre }}
@endsection
@section('proyectos','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item ">
			<a href="{{ url('panel') }}"><i class="bx bx-home-alt"></i></a>
		</li>
		{{-- <li class="breadcrumb-item ">
			<a href="#">Card</a>
		</li> --}}
		<li class="breadcrumb-item ">
			<a href="{{ route('proyectos.index') }}">{{ __('messages.projects') }}</a>            
		</li>
		<li class="breadcrumb-item active">
			<a href="{{ route('proyectos.show',['id' => $proyecto->id]) }}">{{ $proyecto->nombre }}</a>        
		</li>
  	</ol>
</div>
@endsection

@section('content')

@php
	$estatus = '';
	switch ($proyecto->estatus) {
        case 0:
            $estatus = '<span class="badge badge-pill badge-success">'.__('messages.finalizado').'</span>';
            break;
        case 1:
            $estatus = '<span class="badge badge-pill badge-info">'.__('messages.activo').'</span>';
            break;
        case 2:
            $estatus = '<span class="badge badge-pill badge-warning">'.__('messages.suspendido').'</span>';
            break;
        case 1:
            $estatus = '<span class="badge badge-pill badge-danger">'.__('messages.cancelado').'</span>';
            break;
        default:
            $estatus = '<span class="badge badge-pill badge-primary">'.__('messages.espera').'</span>';
            break;
    }
@endphp

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title"> {{ $proyecto->nombre }}</h4>
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
           		</ul>
	          </div>
    		</div>
			<div class="card-content collapse show">
				<div class="card-body">
                    <div class="row">
                    	<div class="col-4">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-calendar-alt mb-1 mr-50"></i> {{ __('messages.fechaInicio') }}</small></h6>
	                        <p>{{ $proyecto->fecha_inicio }}</p>
	                    </div>
	                    <div class="col-4">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-calendar-check mb-1 mr-50"></i> {{ __('messages.fechaFin') }}</small></h6>
	                        <p>{{ $proyecto->fecha_fin }}</p>
                      	</div>
                      	<div class="col-4">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-purchase-tag-alt mb-1 mr-50"></i> {{ __('messages.estatus') }}</small></h6>
	                        <p>{!! $estatus !!}</p>
                      	</div>
                      	<hr>
                      	<div class="col-12">
                        	<h6><small class="text-muted"><i class="cursor-pointer bx bx-map mb-1 mr-50"></i> {{ __('messages.direccionProyecto') }}</small></h6>
                        	<p>{{ $proyecto->direccion }}</p>
                        	<h6><small class="text-muted"><i class="cursor-pointer bx bx-error-circle mb-1 mr-50"></i> {{ __('messages.descripcion') }}</small></h6>
                        	<p>{{ $proyecto->descripcion }}</p>
                      	</div>
                    </div>
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
                    </a>
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
              	</div>
      			{{-- <div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				
          				</div>
        			</div>
      			</div> --}}
    		</div>
  		</div>
  		
  		@if($proyecto->Sectores)
		<section id="accordionWrapa">
		  	<h4 class="mt-3">{{ __('messages.sectores') }}</h4>
		  	<div class="accordion" id="accordionWrapa1" data-toggle-hover="true">
		@endif
		@forelse($proyecto->Sectores as $sector)
			    <div class="card collapse-header">
			      	<div id="heading-sector-{{$sector->id}}" class="card-header collapsed" role="tablist" data-toggle="collapse" data-target="#accordion-sector-{{$sector->id}}" aria-expanded="false" aria-controls="accordion-sector-{{$sector->id}}">
			        	<span class="collapse-title">{{ $sector->nombre }}</span>
			      	</div>
			      	<div id="accordion-sector-{{$sector->id}}" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading-sector-{{$sector->id}}" class="collapse" style="">
				        <div class="card-content">
				          	<div class="card-body">
				          		<p>{{ $sector->descripcion }}</p>

				          		<div class="card widget-todo">
					              	<div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap">
						                <h4 class="card-title d-flex mb-25 mb-sm-0">
						                  <i class="bx bx-check font-medium-5 pl-25 pr-75"></i> {{ __('messages.actividades') }}
						                </h4>
						                {{-- <ul class="list-inline d-flex mb-25 mb-sm-0">
						                  <li class="d-flex align-items-center">
						                    <i class="bx bx-check-circle font-medium-3 mr-50"></i>
						                    <div class="dropdown">
						                      <div class="dropdown-toggle mr-1 cursor-pointer" role="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task
						                      </div>
						                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						                        <a class="dropdown-item" href="#">Option 1</a>
						                        <a class="dropdown-item" href="#">Option 2</a>
						                        <a class="dropdown-item" href="#">Option 3</a>
						                      </div>
						                    </div>
						                  </li>
						                  <li class="d-flex align-items-center">
						                    <i class="bx bx-sort mr-50 font-medium-3"></i>
						                    <div class="dropdown">
						                      <div class="dropdown-toggle cursor-pointer" role="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">All Task</div>
						                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
						                        <a class="dropdown-item" href="#">Option 1</a>
						                        <a class="dropdown-item" href="#">Option 2</a>
						                        <a class="dropdown-item" href="#">Option 3</a>
						                      </div>
						                    </div>
						                  </li>
						                </ul> --}}
					              	</div>
					              	<div class="card-body px-0 py-1">
						                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
											@forelse($sector->Actividades as $actividad)
							                  	<li class="widget-todo-item  cursor-pointer modal-actividades {{ ($actividad->estatus == 0 || $actividad->avance() == 100)? 'completed' : '' }}"   data-uri="{{ route('actividades.show',['id' => $actividad->id]) }}">
							                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
							                      		<div class="widget-todo-title-area d-flex align-items-center">
									                        <i class="bx bx-grid-vertical mr-25 font-medium-4 cursor-move"></i>
									                        <div class="checkbox checkbox-shadow">
									                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad-{{$actividad->id}}" {{ ($actividad->estatus == 0 || $actividad->avance() == 100)? 'checked="true"' : '' }} >
									                          <label for="checkbox-actividad-{{$actividad->id}}"></label>
									                        </div>

							                      		</div>
									                        	<div class="activity-progress flex-grow-1" >
												                  	<span class="text-muted d-inline-block mb-50">
												                  		<span class="widget-todo-title ml-50">
									                        				{{ $actividad->nombre }}
												                        </span>
												                    </span>
												                  <div class="progress progress-bar-success progress-sm mt-1" style="width: 92% !important; margin: auto;">
												                    <div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{$actividad->avance()}}" style="width:{{$actividad->avance()}}%"></div>
												                  </div>
												                </div>
							                      		<div class="widget-todo-item-action d-flex align-items-center">
							                        		<div class="badge badge-pill badge-light-info mr-1">{{ $actividad->Unidad->nombre }}</div>
									                        <div class="avatar bg-rgba-primary m-0 mr-50">
									                          	<div class="avatar-content">
									                            	<span class="font-size-base text-primary">RA</span>
									                          	</div>
									                        </div>
								                        	<div class="dropdown">
								                          		<span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu"></span>
								                          		<div class="dropdown-menu dropdown-menu-right">
								                            		<a class="dropdown-item" href="#"><i class="bx bx-edit-alt mr-1"></i> edit</a>
								                            		<a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> delete</a>
								                          		</div>
								                        	</div>
								                      	</div>
							                    	</div>
							                  	</li>
											@empty
												<li class="widget-todo-item">
							                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
							                      		<div class="widget-todo-title-area d-flex align-items-center">
									                        <i class="bx bx-grid-vertical mr-25 font-medium-4 cursor-move"></i>
									                        <div class="checkbox checkbox-shadow">
									                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad">
									                          <label for="checkbox-actividad"></label>
									                        </div>
									                        <span class="widget-todo-title ml-50">{{ __('messages.sinResultados' )}}</span>
							                      		</div>
							                      		
							                    	</div>
							                  	</li>
											@endforelse
						                </ul>
					              	</div>
					            </div>
				          	</div>
				        </div>
			      	</div>
			    </div>
		@empty
			<div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>	
			        <strong>{{ __('messages.sinResultados') }}</strong>
			</div>
		@endforelse
		@if($proyecto->Sectores)
		  	</div>
		</section>
		@endif
	</div>
</div>

{{-- <div class="mr-1 mb-1 d-inline-block"> --}}
  <!-- Button trigger for full size modal -->
  {{-- <button type="button" class="btn btn-outline-warning" data-toggle="modal" data-target="#full-scrn">
    Full Screen Modal
  </button> --}}

  <!-- full size modal-->
  <div class="modal fade text-left w-100" id="modal-actividades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel20">Full Screen Modal</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
          Cake cupcake sugar plum. Sesame snaps pudding cupcake candy canes icing cheesecake. Sweet roll
          pudding lollipop apple pie gummies dragée. Chocolate bar cookie caramels I love lollipop ice
          cream tiramisu lollipop sweet.


          <!-- App File - Recent Accessed Files Section Starts -->
          	<div class="divider">
              <div class="divider-text">{{ __('messages.archivos') }}</div>
            </div>
          	<div class="col-12">	
			    <div class="row app-file-recent-access">
			      	<div class="col-md-3 col-6">
				        <div class="card border shadow-none mb-1 app-file-info ">
				          <div class="card-content">
				            <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4;">
				              <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
				              <img class="d-block mx-auto" src="{{asset('images/icon/pdf.png')}}" alt="Card image cap" width="30" height="38" style="margin: 25px 0;">
				            </div>
				            <div class="card-body p-50">
				              <div class="app-file-recent-details">
				                <div class="app-file-name font-size-small font-weight-bold"><a href="">Felecia Resume.pdf</a></div>
				                <div class="app-file-size font-size-small text-muted mb-25">12.85kb</div>
				                <div class="app-file-last-access font-size-small text-muted">Last accessed : 3 hours ago</div>
				              </div>
				            </div>
				          </div>
				        </div>
			      	</div>

			      	<div class="col-md-3 col-6">
				        <div class="card border shadow-none mb-1 app-file-info ">
				          <div class="card-content">
				            <div class="app-file-content-logo card-img-top cursor-pointer" style="padding: 10px 6px;    border-bottom: 1px solid #dfe3e7; background-color: #f2f4f4; width: 100%">
				              <i class="bx bx-dots-vertical-rounded app-file-edit-icon d-block float-right"></i>
				              <img class="d-block mx-auto" src="{{asset('images/elements/ipad-pro.png')}}" alt="Card image cap" width="50" height="100%" style="min-height: 89px !important;max-height: 89px !important;">
				            </div>
				            <div class="card-body p-50">
				              <div class="app-file-recent-details">
				                <div class="app-file-name font-size-small font-weight-bold"><a href="">Felecia Resume.pdf</a></div>
				                <div class="app-file-size font-size-small text-muted mb-25">12.85kb</div>
				                <div class="app-file-last-access font-size-small text-muted">Last accessed : 3 hours ago</div>
				              </div>
				            </div>
				          </div>
				        </div>
			      	</div>
			    </div>
			</div>
		    <!-- App File - Recent Accessed Files Section Ends -->

			          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-secondary" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Close</span>
          </button>
          <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
          </button>
        </div>
      </div>
    </div>
  </div>
{{-- </div> --}}

@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-file-manager.css') }}">
    <!-- END: Page CSS-->
@endpush


@push('scripts')
<script src="{{ asset('js/scripts/extensions/ext-component-block-ui.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-file-manager.js') }}"></script>
   <script>
   		function block() {
		  $.blockUI({
		    message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
		    overlayCSS: {
		      backgroundColor: "#fff",
		      opacity: .8,
		      cursor: "wait"
		    },
		    css: {
		      border: 0,
		      padding: 0,
		      backgroundColor: "transparent"
		    }
		  })
		}

		function unBlock() {
			$.unblockUI();
		}
   		$(function() {
   			$(document).on('click', '.modal-actividades', function(event) {
   				event.preventDefault();
   				var uri = $(this).data('uri');
   				block()
   				$.ajax({
   					url: uri,
   					type: 'GET',
   					dataType: 'json',
   				})
   				.done(function(data) {
   					console.log("success");
   					if(data.success == true){
   						unBlock()
   						$('#modal-actividades').modal('show');
   					}
   				})
   				.fail(function(e) {
   					console.log("error");
   					console.log(e);

   				})
   				.always(function() {
   					console.log("complete");
   				});
   				
   			});
   		});
   </script>
@endpush