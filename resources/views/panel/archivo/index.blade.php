@extends('panel.app')

@section('titulo_page')
{{ __('messages.usuarios') }}  
@endsection
@section('usuarios','active')

@section('breadcrumb')
<div class="breadcrumb-wrapper col-12">
	<ol class="breadcrumb p-0 mb-0">
      	<li class="breadcrumb-item ">
			<a href="{{ url('panel') }}"><i class="bx bx-home-alt"></i></a>
		</li>
		{{-- <li class="breadcrumb-item ">
			<a href="#">Card</a>
		</li> --}}
		<li class="breadcrumb-item active">
			{{ __('messages.usuarios') }}            
		</li>
  	</ol>
</div>
@endsection

@section('content')

<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title">{{ __('messages.usuarios') }} </h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
      			<div class="heading-elements">
        			<ul class="list-inline mb-0">
          				<li>
            				<a href="{{ route('usuarios.create') }}" role="button" class="cmetal">
              					<i class="bx bx-plus-circle"></i>
              					{{ __('messages.newUsuario') }}
            				</a>
          				</li>
          				
        			</ul>
      			</div>
    		</div>
    		<div class="card-content collapse show">
      			<div class="card-body">
        			<div class="row">
          				<div class="col-sm-12">
          					@include('alertas')
            				<form action="{{ route('excel.store') }}" method="post" class="col-md-6 col-md-offset-3" autocomplete="off" enctype="multipart/form-data">
								{{csrf_field()}}
								<div class="form-group">
									<label for=""> Archivo</label>
									<input type="file" name="excel" class="form-control" required="required">
								</div>
								<div class="form-group">
									<input type="submit" value="Cargar Archivo" class="btn btn-primary btn-flat btn-block">
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
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
@endpush


@push('scripts')
   	
@endpush