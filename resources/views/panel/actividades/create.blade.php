@extends('panel.app')

@section('titulo_page')
{{ __('messages.newActividad') }}  
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
		<li class="breadcrumb-item ">
			<a href="{{ route('proyectos.show',['id' => $sector->Proyecto->id]) }}">{{ $sector->Proyecto->nombre }}</a>        
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('sectores',['id' => $sector->Proyecto->id]) }}">{{ __('messages.sectores') }}   </a>        
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('sectores.actividades.index',['id' => $sector->id]) }}">{{ $sector->nombre }}   </a>        
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.newActividad') }}         
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.newActividad') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('sectores.actividades.store',['id'=>$sector->id]) }}" autocomplete="off">
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row">
					                  <div class="col-md-6 col-12">
					                    <div class="">
					                      <label for="unidad_id">{{ __('messages.nombreMetrado') }}</label>
					                      <select name="unidad_id" id="unidad_id" class="form-control  {{ ($errors->has('unidad_id')) ? 'is-invalid' : '' }}">
					                      	<option value="" data-precio="0.00"></option>
					                      	@forelse($unidades as $unidad)
					                      		<option value="{{ $unidad->id }}" data-precio="{{ $unidad->precio }}">{{ $unidad->nombre }}</option>
					                      	@empty
												<option value="">{{ __('messages.sinUnidades') }}</option>
					                      	@endforelse
					                      </select>
					                      	@if ($errors->has('unidad_id'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('unidad_id') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group mt-2">
					                      <input type="number" min="0.01" step="0.01"  class="form-control {{ ($errors->has('precio')) ? 'is-invalid' : '' }}" name="precio" id="precio" >
					                      <label for="last-name-column">{{ __('messages.precio') }}</label>
					                      	@if ($errors->has('precio'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('precio') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control  {{ ($errors->has('nombre_actividad')) ? 'is-invalid' : '' }}" id="nombre_actividad" placeholder="{{ __('messages.nombre') }}" name="nombre_actividad">
					                      <label for="nombre_actividad">{{ __('messages.nombre') }}</label>
					                      	@if ($errors->has('nombre_actividad'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('nombre_actividad') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" id="descripcion" class="form-control  {{ ($errors->has('descripcion')) ? 'is-invalid' : '' }}" name="descripcion" placeholder="{{ __('messages.descripcion') }}">
					                      <label for="descripcion">{{ __('messages.descripcion') }}</label>
					                      	@if ($errors->has('descripcion'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('descripcion') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
					                    <div class="form-label-group mt-2">
					                      <input type="number" min="0.01" step="0.01" id="metrado"  class="form-control {{ ($errors->has('metrado')) ? 'is-invalid' : '' }}" name="metrado" placeholder="{{ __('messages.metrado') }}">
					                      <label for="metrado">{{ __('messages.metrado') }}</label>
											@if ($errors->has('metrado'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('metrado') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
					                    <div class="form-label-group mt-2">
					                      <input type="number" min="0.01" step="0.01" id="precioTotal"  class="form-control {{ ($errors->has('precioTotal')) ? 'is-invalid' : '' }}" name="precioTotal" placeholder="{{ __('messages.precioTotal') }}" readonly="true">
					                      <label for="precioTotal">{{ __('messages.precioTotal') }}</label>
											@if ($errors->has('precioTotal'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('precioTotal') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
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
   	<script>
		$('#unidad_id').change(function(event) {
			var precio = $(this).find(':selected').attr('data-precio');
			// $('#precio').val(precio);
			// console.log(precio);
		});
   		$(function() {

   			$('#metrado,#precio').keyup(function(event) {
   				// var precio_unit = parseFloat($('#unidad_id').find(':selected').attr('data-precio'));
   				var precio_unit = parseFloat($('#precio').val());
   				var metrado = parseFloat($('#metrado').val());
   				var precioT = metrado*precio_unit
   				// console.log( parseFloat(precioT) );
   				// console.log(metrado);
   				// console.log(precio_unit);
   				if(metrado == 0){
   					$('#precioTotal').val( parseFloat(0).toFixed(2));
   					return false;
   				}
   				$('#precioTotal').val( parseFloat(precioT).toFixed(2));
   			});
   			$('#metrado,#precio').change(function(event) {
   				// var precio_unit = parseFloat($('#unidad_id').find(':selected').attr('data-precio'));
   				var precio_unit = parseFloat($('#precio').val());
   				var metrado = parseFloat($('#metrado').val());
   				var precioT = metrado*precio_unit
   				// console.log( parseFloat(precioT) );
   				// console.log(metrado);
   				// console.log(precio_unit);
   				if(metrado == 0){
   					$('#precioTotal').val( parseFloat(0).toFixed(2));
   					return false;
   				}
   				$('#precioTotal').val( parseFloat(precioT).toFixed(2));
   			});
   		});
   	</script>
@endpush