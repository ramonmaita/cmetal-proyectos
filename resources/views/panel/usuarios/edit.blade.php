@extends('panel.app')

@section('titulo_page')
{{ __('messages.editUsuario') }}  
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
			{{ __('messages.editUsuario') }}            
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.editUsuario') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('usuarios.update',['id' => $usuario->id]) }}" autocomplete="off">
            					@method('PUT')
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row">
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control {{ ($errors->has('nombres')) ? 'is-invalid' : '' }}" name="nombres" placeholder="{{ __('messages.nombres') }}" value="{{ (old('nombres')!='') ?  old('nombres') : $usuario->nombre }}">
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
					                      <input type="text"  class="form-control {{ ($errors->has('apellidos')) ? 'is-invalid' : '' }}" name="apellidos"  placeholder="{{ __('messages.apellidos') }}"  value="{{ (old('apellidos')!='') ?  old('apellidos') : $usuario->apellido }}">
					                      <label for="last-name-column">{{ __('messages.apellidos') }}</label>
					                      	@if ($errors->has('apellidos'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('apellidos') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control  {{ ($errors->has('email')) ? 'is-invalid' : '' }}" id="email" placeholder="{{ __('messages.email') }}" name="email"  value="{{ (old('email')!='') ?  old('email') : $usuario->email }}">
					                      <label for="email">{{ __('messages.email') }}</label>
					                      	@if ($errors->has('email'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('email') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
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
					                  
					                  <div class="col-md-6 col-12">
					                    <div class="">
					                      <label for="tipo_usuario">{{ __('messages.tipoUsuario') }}</label>
					                      <select name="tipo_usuario" id="tipo_usuario" class="form-control  {{ ($errors->has('tipo_usuario')) ? 'is-invalid' : '' }}">
					                      	<option value="1"  value="{{ (old('tipo_usuario') == 1 || $usuario->tipo == 1) ? 'selected' : '' }}">{{ __('messages.admin') }}</option>
					                      	<option value="2"  value="{{ (old('tipo_usuario') == 2 || $usuario->tipo == 2) ? 'selected' : '' }}">{{ __('messages.supervisor') }}</option>
					                      	<option value="3"  value="{{ (old('tipo_usuario') == 3 || $usuario->tipo == 3) ? 'selected' : '' }}">{{ __('messages.cliente') }}</option>
					                      </select>
					                      	@if ($errors->has('tipo_usuario'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('tipo_usuario') }}
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