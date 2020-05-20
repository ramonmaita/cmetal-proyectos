@extends('panel.app')

@section('titulo_page')
{{ __('messages.newProject') }}  
@endsection
@section('proyectos','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item ">
			<a href="{{ url('panel') }}"><i class="bx bx-home-alt"></i></a>
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('proyectos.index') }}">{{ __('messages.projects') }}</a>
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.newProject') }}            
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.newProject') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('proyectos.store') }}" autocomplete="off">
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row">
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="date" class="form-control {{ ($errors->has('fecha_inicio')) ? 'is-invalid' : '' }}" name="fecha_inicio">
					                      <label for="first-name-column">{{ __('messages.fechaInicio') }}</label>	
											@if ($errors->has('fecha_inicio'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('fecha_inicio') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="date"  class="form-control {{ ($errors->has('fecha_fin')) ? 'is-invalid' : '' }}" name="fecha_fin">
					                      <label for="last-name-column">{{ __('messages.fechaFin') }}</label>
					                      	@if ($errors->has('fecha_fin'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('fecha_fin') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control  {{ ($errors->has('nombre_proyecto')) ? 'is-invalid' : '' }}" id="nombre_proyecto" placeholder="{{ __('messages.nombreProyecto') }}" name="nombre_proyecto">
					                      <label for="nombre_proyecto">{{ __('messages.nombreProyecto') }}</label>
					                      	@if ($errors->has('nombre_proyecto'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('nombre_proyecto') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" id="direccion"  class="form-control {{ ($errors->has('direccion')) ? 'is-invalid' : '' }}" name="direccion" placeholder="{{ __('messages.direccionProyecto') }}">
					                      <label for="direccion">{{ __('messages.direccionProyecto') }}</label>
											@if ($errors->has('direccion'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('direccion') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group mt-2">
					                      <input type="text" id="descripcion" class="form-control  {{ ($errors->has('descripcion')) ? 'is-invalid' : '' }}" name="descripcion" placeholder="{{ __('messages.descripcionProyecto') }}">
					                      <label for="descripcion">{{ __('messages.descripcionProyecto') }}</label>
					                      	@if ($errors->has('descripcion'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('descripcion') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="">
					                      <label for="estatus">{{ __('messages.estatus') }}</label>
					                      <select name="estatus" id="estatus" class="form-control  {{ ($errors->has('estatus')) ? 'is-invalid' : '' }}">
					                      	<option value="1">{{ __('messages.activo') }}</option>
					                      </select>
					                      	@if ($errors->has('estatus'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('estatus') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-12 d-flex justify-content-end mt-1">
					                    <button type="submit" class="btn btn-cmetal mr-1 mb-1">{{ __('messages.guardar') }}</button>
					                    <button type="reset" class="btn btn-light-cmetal mr-1 mb-1"> {{ __('messages.reset') }}</button>
					                  </div>
					                </div>
				              	</div>
				            </form>
          				</div>
        			</div>
      			</div>
    		</div>
  		</div>
	</div>
</div>

@endsection

@push('css')
	
@endpush


@push('scripts')
   	
@endpush