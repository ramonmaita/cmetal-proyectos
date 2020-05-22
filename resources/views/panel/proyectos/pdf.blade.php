<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Proyecto</title>
	<style>
		@page { 
			margin-top: 100px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;

		}
   		header { position: fixed; top: -80px; left: 0px; right: 0px;  height: auto; background-size: 80%; font-size: 10pt; font-family: 'Times New Roman'; }
    	footer { position: fixed; bottom: -80px; left: 0px; right: 0px;/* background-color: lightblue;*/ height: 50px;  }
    	@page :first{
    		margin-top: 100px;
			margin-bottom: 60px;
			margin-right: 50px;
			margin-left: 50px;
		}

		.table th {
			background: #5b1818d6 ;
			color: #fff;
		}
		.table td {
			background: lightgray ;
			text-align: center;
		}
		.table th, .table td {
			border: 1px solid #632323;
		}
	</style>
</head>
<body>
	<header >
		
	</header>
	<footer>
		
	</footer>
	<main style="margin-bottom: 90px;/*140px*/ margin-top: -50px;">
	
		<table width="100%" cellpadding="0" cellspacing="0" class="table" bor>
			<tr>
				<th>{{ __('messages.nombreProyecto') }}</th>
				<th>{{ __('messages.estatus') }}</th>
			</tr>
			<tr>
				<td>proyecto</td>
				<td>activo</td>
			</tr>
			<tr>
				<th>{{ __('messages.fechaInicio') }}</th>
				<th>{{ __('messages.fechaFin') }}</th>
			</tr>
			<tr>
				<td>fecha I</td>
				<td>direccion </td>
			</tr>
			<tr>
				<th>{{ __('messages.descripcion') }}</th>
				<th>{{ __('messages.direccionProyecto') }}</th>
			</tr>
			<tr>
				<td>descripcion proyecto</td>
				<td>direccion </td>
			</tr>
		</table>
		
		<hr>
		<table width="100%" cellpadding="0" cellspacing="0" class="table" bor>
			@foreach ($proyecto->Sectores as $sector)
				<tr>
					<th>{{ $sector->nombre }}</th>
				</tr>
				<tr>
					<td>
					
					<table width="100%">
							
						@forelse ($sector->Actividades as $actividad)
							<tr>
								<td>{{ $actividad->nombre }}</td>
							</tr>
						@empty
						<tr><td></td></tr>
						@endforelse
						</table>
					</td>
				</tr>
			@endforeach
		</table>
	</main>
</body>
</html>