@extends('panel.app')

@section('titulo_page')
{{ __('messages.sectores') }}
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
			<a href="{{ route('proyectos.show',['id' => $proyecto->id]) }}">{{ $proyecto->nombre }}</a>        
		</li>
		<li class="breadcrumb-item active">
			{{ __('messages.sectores') }}         
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.sectores') }}   -  {{ $proyecto->nombre }}</h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
      			<div class="heading-elements">
        			<ul class="list-inline mb-0">
          				<li>
            				<a href="{{ route('sectores.create',['id' => $proyecto->id]) }}" role="button" class="cmetal">
              					<i class="bx bx-plus-circle"></i>
              					{{ __('messages.newSector') }}
            				</a>
          				</li>
        			</ul>
      			</div>
    		</div>

  		</div>
  		@include('alertas')
  		@if (count($sectores) > 0)
			{{-- <div class="card-columns"> --}}
				<div class="row match-height">
				    <div class="col-12">
				      {{-- <div class="card-deck-wrapper">
				        <div class="card-deck"> --}}
				          <div class="row">
  		@endif
							@forelse($sectores as $sector)
								<div class="col-md-3 col-sm-6 mb-sm-1">
								  	<div class="card">
								    	<img src="..." class="card-img-top" alt="">
								    	<div class="card-body">
								      		<h5 class="card-title">{{ $sector->nombre }}</h5>
								      		<p class="card-text">{{ $sector->descripcion}}</p>
								    	</div>
								    	<div class="card-footer d-flex justify-content-between" style="font-size: 10pt !important;">
								      		<a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="card-link">{{ __('messages.editSector') }}</a>
								      		<a href="{{ route('sectores.actividades.index',['id' => $sector->id]) }}" class="card-link">{{ __('messages.showActividades') }}</a>
								    	</div>
								  	</div>
								</div>
							@empty
								<div class="alert alert-danger alert-block">
									<button type="button" class="close" data-dismiss="alert">×</button>	
								        <strong>{{ __('messages.sinResultados') }}</strong>
								</div>
							@endforelse
		@if (count($sectores) > 0)
							</div>
						{{-- </div>
					</div> --}}
				</div>

			</div>
  		@endif
	</div>
</div>

@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endpush


@push('scripts')
   
@endpush