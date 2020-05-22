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
@include('alertas')
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
                    @if(Auth::user()->tipo == 1)
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
                    </a>
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
					@endif

                     {{--  <a href="{{ route('proyectos.pdf',['id' => $proyecto->id]) }}" target="_blank" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
                    </a>
                    <a href="{{ route('proyectos.pdf',['id' => $proyecto->id]) }}" target="_blank" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a> --}}
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
			        	<span class="collapse-title mb-1">
			        		{{ $sector->nombre }}
			        	</span>
		        		<br> 
		        		<div class="activity-progress flex-grow-1 mt-2" >
		                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
		                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ $p = round(($sector->porcentajeSector->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}" style="width:{{ $p = round(($sector->porcentajeSector->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}%"></div>
		                  	</div>
		                </div>

			      	</div>
			      	<div id="accordion-sector-{{$sector->id}}" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading-sector-{{$sector->id}}" class="collapse" style="">
				        <div class="card-content">
				          	<div class="card-body">
				          		<div class="row">
				          			<div class="col-12">
				          				<p>{{ $sector->descripcion }}</p>
				          			</div>
				          			@if(Auth::user()->tipo == 1)
				          			<div class="col-12">
				          				<a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
					                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
					                    </a>
					                    <a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
					                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
				          			</div>
				          			@endif
				          		</div>
								<hr>
				          		<div class="card widget-todo">
					              	<div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap">
						                <h4 class="card-title d-flex mb-25 mb-sm-0">
						                  <i class="bx bx-check font-medium-5 pl-25 pr-75"></i> {{ __('messages.actividades') }}
						                </h4>
					              	</div>
					              	<div class="card-body px-0 py-3">
						                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
											@forelse($sector->Actividades as $actividad)
							                  	<li class="widget-todo-item  cursor-pointer {{ ($actividad->estatus == 0 || $actividad->avance() == 100)? 'completed' : '' }}" >
							                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
							                      		<div class="widget-todo-title-area d-flex align-items-center">
									                        <div class="checkbox checkbox-shadow">
									                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad-{{$actividad->id}}" {{ ($actividad->estatus == 0 || $actividad->avance() == 100)? 'checked="true"' : '' }}  disabled="true">
									                          <label for="checkbox-actividad-{{$actividad->id}}"></label>
									                        </div>

							                      		</div>
									                        	<div class="activity-progress flex-grow-1  modal-actividades"   data-uri="{{ route('actividades.show',['id' => $actividad->id]) }}">
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
									                        @if(Auth::user()->tipo != 3)
								                        	<div class="dropdown">
								                          		<span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-offset="5,20"></span>
								                          		<div class="dropdown-menu dropdown-menu-right">
								                          			@if(Auth::user()->tipo == 1)
								                            		<a class="dropdown-item" href="{{ route('sectores.actividades.edit',['id' => $actividad->id]) }}"><i class="bx bx-edit-alt mr-1"></i> {{ __('messages.edit') }}</a>
								                            		@endif
								                            		{{-- <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> {{ __('messages.delete') }}</a> --}}
																	
																	@if(Auth::user()->tipo == 2)
								                            		<a class="dropdown-item modal-reporte" href="#"  data-uri="{{ route('reportes.store',['id' => $actividad->id]) }}" data-actividad="{{ $actividad->nombre }}" data-max="{{ $actividad->metrado - $actividad->Reportes->sum('metrado') }}"><i class="bx bx-file mr-1"></i> {{ __('messages.reportar') }}</a>
								                            		@endif
								                          		</div>
								                        	</div>
								                        	@endif
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
          <h4 class="modal-title" id="myModalLabel20"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
         	<table class="table table-striped">
         		<thead>
         			<tr>
         				<th>{{ __('messages.descripcion') }}</th>
         				<th>{{ __('messages.metrado') }}</th>
         				<th>{{ __('messages.metradoRealizado') }}</th>
         				<th>{{ __('messages.precio') }}</th>
         			</tr>
         		</thead>
         		<tbody>
         			<tr>
         				<td id="descripcion"></td>
         				<td id="metradoT"></td>
         				<td id="metradoR"></td>
         				<td id="precio"></td>
         			</tr>
         		</tbody>
         		<tfoot>
         			<tr>
         				<td align="right" colspan="3">{{ __('messages.precioTotal')}}</td>
         				<td id="precioTotal"></td>
         			</tr>
         		</tfoot>
         	</table>

          <!-- App File - Recent Accessed Files Section Starts -->
          	<div class="divider">
              <div class="divider-text">{{ __('messages.reportes') }}</div>
            </div>
            <div class="row">
            	<div class="col-12" id="reportes">
            		
            	</div>
            	
            </div>

			          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-cmetal" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">{{ __('messages.cerrar') }}</span>
          </button>
          {{-- <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
          </button> --}}
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade text-left w-100" id="modal-reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel21">Reportar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
         		
			<form class="form" method="POST" autocomplete="off" id="form-reporte" enctype="multipart/form-data">
				{{ csrf_field() }}
              	<div class="form-body">
	                <div class="row">
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="number" min="0.01" step="0.01" class="form-control {{ ($errors->has('metrado')) ? 'is-invalid' : '' }}" name="metrado" id="metrado" placeholder="{{ __('messages.metradoRealizado') }}">
	                      <label for="last-name-column">{{ __('messages.metradoRealizado') }}</label>
	                      	@if ($errors->has('metrado'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('metrado') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="date"   class="form-control {{ ($errors->has('fecha')) ? 'is-invalid' : '' }}" name="fecha" id="fecha" >
	                      <label for="last-name-column">{{ __('messages.fecha') }}</label>
	                      	@if ($errors->has('fecha'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('fecha') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>
						<div class="col-md-12 col-12">
	                    	<div class="form-label-group">
	                      		<input type="file"   class="form-control {{ ($errors->has('archivo')) ? 'is-invalid' : '' }}" multiple="" name="archivo[]" id="archivo" accept="image/*,application/pdf,.xls,.xl,doc,docx">
	                      		<label for="last-name-column">{{ __('messages.archivo') }}</label>
		                      	@if ($errors->has('archivo'))
									<div class="invalid-feedback">
				                    	<i class="bx bx-radio-circle"></i>
			                    		{{ $errors->first('archivo') }}
				                  	</div>
								@endif
	                    	</div>
	                  	</div>

	                  
	                {{--   <div class="col-12 d-flex justify-content-end mt-1">

	                  </div> --}}
	                </div>
              	</div>
		
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-cmetal">{{ __('messages.guardar') }}</button>
          <button type="button" class="btn btn-light-cmetal" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">{{ __('messages.cerrar') }}</span>
          </button>
            </form>       
          {{-- <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
          </button> --}}
        </div>
      </div>
    </div>
  </div>
{{-- </div> --}}

@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-file-manager.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/file-uploaders/dropzone.css') }}">
    <!-- END: Page CSS-->
@endpush


@push('scripts')
<script src="{{ asset('vendors/js/extensions/dropzone.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/ext-component-block-ui.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-file-manager.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/dropzone.js') }}"></script>
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
   						$('#myModalLabel20').html(data.actividad.nombre);
   						$('#descripcion').html(data.actividad.descripcion);
   						$('#metradoT').html(data.actividad.metrado);
   						$('#metradoR').html(data.reportes);
   						$('#precio').html(data.actividad.precio);
   						var precoT = data.actividad.metrado*data.actividad.precio;
   						$('#precioTotal').html(precoT.toFixed(2));

   						$('#reportes').html(data.r);
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

   			$(document).on('click', '.modal-reporte', function(event) {
   				event.preventDefault();
   				$('#form-reporte').trigger("reset");
   				block()
   				var uri = $(this).data('uri');
   				$('#form-reporte').attr('action', uri);
   				$('#myModalLabel21').html('Reporte - '+$(this).data('actividad'));
   				if($(this).data('max') == 0){
   					$('#metrado').attr('disabled','disabled');
   				}
   				$('#metrado').attr('max',$(this).data('max'));
   				unBlock()
   				$('#modal-reporte').modal('show');
   				
   			});
   		});
   </script>
@endpush