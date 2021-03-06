@extends('panel.app')

@section('titulo_page')
{{ __('messages.newUsuario') }}  
@endsection
@section('usuarios','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item ">
			<a href="{{ url('panel') }}"><i class="bx bx-home-alt"></i></a>
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('usuarios.index') }}">{{ __('messages.usuarios') }}</a>
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.newUsuario') }}            
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.newUsuario') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('usuarios.store') }}" autocomplete="off">
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row">
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control {{ ($errors->has('nombres')) ? 'is-invalid' : '' }}" name="nombres" placeholder="{{ __('messages.nombres') }}" value="{{ old('nombres') }}">
					                      <label for="first-name-column">{{ __('messages.nombres') }}</label>	
											@if ($errors->has('nombres'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('nombres') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text"  class="form-control {{ ($errors->has('apellidos')) ? 'is-invalid' : '' }}" name="apellidos"  placeholder="{{ __('messages.apellidos') }}" value="{{ old('apellidos') }}">
					                      <label for="last-name-column">{{ __('messages.apellidos') }}</label>
					                      	@if ($errors->has('apellidos'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('apellidos') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control  {{ ($errors->has('email')) ? 'is-invalid' : '' }}" id="email" placeholder="{{ __('messages.email') }}" name="email" value="{{ old('email') }}">
					                      <label for="email">{{ __('messages.email') }}</label>
					                      	@if ($errors->has('email'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('email') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
					                    <div class="form-label-group">
					                      <input type="password" id="password" class="form-control  {{ ($errors->has('password')) ? 'is-invalid' : '' }}" name="password" placeholder="{{ __('messages.password') }}">
					                      <label for="password">{{ __('messages.password') }}</label>
					                      	@if ($errors->has('password'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('password') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-4 col-12">
					                    <div class="form-label-group">
					                      <input type="password" id="password_confirmation" class="form-control  {{ ($errors->has('password_confirmation')) ? 'is-invalid' : '' }}" name="password_confirmation" placeholder="{{ __('messages.password_confirmation') }}">
					                      <label for="password_confirmation">{{ __('messages.password_confirmation') }}</label>
					                      	@if ($errors->has('password_confirmation'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('password_confirmation') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  
					                  <div class="col-md-{{(Auth::user()->tipo == 0) ? '4':'6'}} col-12">
					                    <div class="">
					                      <label for="tipo_usuario">{{ __('messages.tipoUsuario') }}</label>
					                      <select name="tipo_usuario" id="tipo_usuario" class="form-control  {{ ($errors->has('tipo_usuario')) ? 'is-invalid' : '' }}">
					                      	@if (Auth::user()->tipo == 0)
					                      	<option value="0">{{ __('messages.superadmin') }}</option>
					                      	@endif
					                      	<option value="1">{{ __('messages.admin') }}</option>
					                      	<option value="2">{{ __('messages.supervisor') }}</option>
					                      	<option value="3">{{ __('messages.cliente') }}</option>
					                      	<option value="4">{{ __('messages.proveedor') }}</option>
					                      </select>
					                      	@if ($errors->has('tipo_usuario'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('tipo_usuario') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  @if (Auth::user()->tipo == 0)
					                  <div class="col-md-4 col-12">
					                    <div class="">
					                      <label for="empresa">{{ __('messages.empresa') }}</label>
					                      <select name="empresa" id="empresa" class="form-control  {{ ($errors->has('empresa')) ? 'is-invalid' : '' }}" disabled="disabled">
					                      	@forelse($empresas as $empresa)
												<option value="{{ $empresa->id }}">{{ $empresa->nombre }}</option>
					                      	@empty
												<option value="">{{ __('messages.sinResultados') }}</option>
					                      	@endforelse
					                      </select>
					                      	@if ($errors->has('empresa'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('empresa') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  @endif
					                  <div class="col-md-{{(Auth::user()->tipo == 0) ? '4':'6'}} col-12">
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
   		$(function() {
   			$('#tipo_usuario').change(function(event) {
   				if($(this).val() == 0){
   					$('#empresa').attr('disabled', 'disabled');
   				}else{
   					$('#empresa').removeAttr('disabled');
   				}
   			});
   		});
   	</script>
@endpush