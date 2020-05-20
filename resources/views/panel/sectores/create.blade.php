@extends('panel.app')

@section('titulo_page')
{{ __('messages.newSector') }}  
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
		<li class="breadcrumb-item ">
			<a href="{{ route('proyectos.show',['id' => $proyecto->id]) }}">{{ $proyecto->nombre }}</a>        
		</li>
		<li class="breadcrumb-item ">
			<a href="{{ route('sectores',['id' => $proyecto->id]) }}">{{ __('messages.sectores') }}</a>         
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.newSector') }}         
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.newSector') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form class="form" method="POST" action="{{ route('sectores.store',['id_proyecto' => $proyecto->id]) }}" autocomplete="off">
            					{{ csrf_field() }}
				              	<div class="form-body">
					                <div class="row"> 
					                  
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" class="form-control  {{ ($errors->has('nombre_sector')) ? 'is-invalid' : '' }}" id="nombre_sector" placeholder="{{ __('messages.nombreSector') }}" name="nombre_sector">
					                      <label for="nombre_sector">{{ __('messages.nombreSector') }}</label>
					                      	@if ($errors->has('nombre_sector'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('nombre_sector') }}
							                  	</div>
											@endif
					                    </div>
					                  </div>
					                  <div class="col-md-6 col-12">
					                    <div class="form-label-group">
					                      <input type="text" id="descripcion"  class="form-control {{ ($errors->has('descripcion')) ? 'is-invalid' : '' }}" name="descripcion" placeholder="{{ __('messages.descripcion') }}">
					                      <label for="descripcion">{{ __('messages.descripcion') }}</label>
											@if ($errors->has('descripcion'))
												<div class="invalid-feedback">
							                    	<i class="bx bx-radio-circle"></i>
						                    		{{ $errors->first('descripcion') }}
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