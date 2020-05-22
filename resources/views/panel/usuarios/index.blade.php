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
            				<div class="table-responsive">
              					<table class="table data-table">
	                                <thead>
	                                    <tr>
	                                        <th>{{ __('messages.nombres') }}</th>
	                                        <th>{{ __('messages.apellidos') }}</th>
	                                        <th>{{ __('messages.email') }}</th>
	                                        <th>{{ __('messages.tipoUsuario') }}</th>
	                                        <th>{{ __('messages.estatus') }}</th>
	                                        <th>{{ __('messages.acciones') }}</th>
	                                    </tr>
	                                </thead>
	                                <tbody>
	                                   
	                                </tbody>
	                            </table>
            				</div>
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
   	<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/dataTables.buttons.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
	<script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
	<script src="{{ asset('js/scripts/datatables/datatable.js') }}"></script>

	<script>
		$(function() {
			var locale = '';
			@if (config('app.locale')  == 'es' )
				locale = '{{ asset('idiomas/Spanish.json') }}';
			@else
				locale = '{{ asset('idiomas/English.json') }}'
			@endif
			$('.data-table').DataTable( {
			    language: {
			        url: locale
			    },
	            processing: true,
	            serverSide: true,
	            ajax: '{{ route('usuarios.index') }}',
	            columns: [
	                { data: 'nombre', name: 'nombre' },
	                { data: 'apellido', name: 'apellido' },
	                { data: 'email', name: 'email' },
	                { data: 'tipo', name: 'tipo' },
	                { data: 'estatus', name: 'estatus' },
	                { data: 'acciones', name: 'acciones' },
	            ]
			} );
		});	
	</script>
@endpush