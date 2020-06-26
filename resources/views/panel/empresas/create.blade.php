@extends('panel.app')

@section('titulo_page')
{{ __('messages.newEmpresa') }}  
@endsection
@section('empresas','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item ">
			<a href="{{ url('panel') }}"><i class="bx bx-home-alt"></i></a>
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('empresas.index') }}">{{ __('messages.empresas') }}</a>            
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.newEmpresa') }}         
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.newEmpresa') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('empresas.store') }}" autocomplete="off">
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row"> 
					                  
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group  mt-2">
					                      <input type="text" class="form-control  {{ ($errors->has('nombre')) ? 'is-invalid' : '' }}" id="nombre" placeholder="{{ __('messages.nombre') }}" name="nombre">
					                      <label for="nombre">{{ __('messages.nombre') }}</label>
					                      	@if ($errors->has('nombre'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('nombre') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group  mt-2">
					                      <input type="text" class="form-control  {{ ($errors->has('descripcion')) ? 'is-invalid' : '' }}" id="descripcion" placeholder="{{ __('messages.descripcion') }}" name="descripcion">
					                      <label for="descripcion">{{ __('messages.descripcion') }}</label>
					                      	@if ($errors->has('descripcion'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('descripcion') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group  mt-2">
					                      <input type="text" class="form-control  {{ ($errors->has('sector')) ? 'is-invalid' : '' }}" id="sector" placeholder="{{ __('messages.sector') }}" name="sector">
					                      <label for="sector">{{ __('messages.sector') }}</label>
					                      	@if ($errors->has('sector'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('sector') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  {{-- <div class="col-md-4 col-12">
					                    <div class="form-label-group  mt-2">
					                      <input type="number" min="0.01" step="0.01" id="precio"  class="form-control {{ ($errors->has('precio')) ? 'is-invalid' : '' }}" name="precio" placeholder="{{ __('messages.precio') }}">
					                      <label for="precio">{{ __('messages.precio') }}</label>
											@if ($errors->has('precio'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('precio') }}
							                  	</div>
											@endif
					                    </div>
					                  </div> --}}
					                  <div class="col-md-6 col-12">
					                    <div class="">
					                      <label for="estatus">{{ __('messages.estatus') }}</label>
					                      <select name="estatus" id="estatus" class="form-control  {{ ($errors->has('estatus')) ? 'is-invalid' : '' }}">
					                      	<option value="1">{{ __('messages.activo') }}</option>
					                      	<option value="2">{{ __('messages.inactivo') }}</option>
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