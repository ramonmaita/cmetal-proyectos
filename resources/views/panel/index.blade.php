@extends('panel.app')

@section('titulo_page','Inicio')
@section('inicio','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item active">
			<a href="index.html"><i class="bx bx-home-alt"></i></a>
		</li>
		{{-- <li class="breadcrumb-item ">
			<a href="#">Card</a>
		</li>
		<li class="breadcrumb-item active">
			Card Actions            
		</li> --}}
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-3 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
              <i class="bx bx-file font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">{{ __('messages.projects') }}</p>
            <h2 class="mb-0">{{ $proyectos }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
              <i class="bx bx-extension font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">{{ __('messages.sectores') }}</p>
            <h2 class="mb-0">{{ $sectores }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
              <i class="bx bx-list-ul font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">{{ __('messages.actividades') }}</p>
            <h2 class="mb-0">{{ $actividades }}</h2>
          </div>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-md-4 col-sm-6">
      <div class="card text-center">
        <div class="card-content">
          <div class="card-body">
            <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1">
              <i class="bx bxs-map-alt font-medium-5"></i>
            </div>
            <p class="text-muted mb-0 line-ellipsis">{{ __('messages.metrados') }}</p>
            <h2 class="mb-0">{{ $metrados }}</h2>
          </div>
        </div>
      </div>
    </div>
</div>
<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.home') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
            				{{ __('messages.welcome' )}}
          				</div>
        			</div>
      			</div>
    		</div>
  		</div>
	</div>
</div>



@endsection