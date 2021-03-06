@extends('panel.app')

@section('titulo_page')
{{ $proyecto->nombre }}
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
		<li class="breadcrumb-item active">
			<a href="{{ route('proyectos.show',['id' => $proyecto->id]) }}">{{ $proyecto->nombre }}</a>        
		</li>
  	</ol>
</div>
@endsection

@section('content')

@php
	$estatus = '';
	switch ($proyecto->estatus) {
        case 0:
            $estatus = '<span class="badge badge-pill badge-success">'.__('messages.finalizado').'</span>';
            break;
        case 1:
            $estatus = '<span class="badge badge-pill badge-info">'.__('messages.activo').'</span>';
            break;
        case 2:
            $estatus = '<span class="badge badge-pill badge-warning">'.__('messages.suspendido').'</span>';
            break;
        case 1:
            $estatus = '<span class="badge badge-pill badge-danger">'.__('messages.cancelado').'</span>';
            break;
        default:
            $estatus = '<span class="badge badge-pill badge-primary">'.__('messages.espera').'</span>';
            break;
    }

    function tipo_usuario($estatus)
    {
    	switch ($estatus) {
            case 1:
	            return '<span class="badge badge-pill badge-dark">'.__('messages.admin').'</span>';
	            break;
	        case 2:
	            return '<span class="badge badge-pill badge-primary">'.__('messages.supervisor').'</span>';
	            break;
	        default:
	            return '<span class="badge badge-pill badge-warning">'.__('messages.cliente').'</span>';
	            break;
        }
    }
@endphp
@include('alertas')
<div class="row">
	<div class="col-12">
  		<div class="card">
    		<div class="card-header">
      			<h4 class="card-title"> {{ $proyecto->nombre }}</h4>
      			<a class="heading-elements-toggle">
        			<i class='bx bx-dots-vertical font-medium-3'></i>
      			</a>
      			<div class="heading-elements">
	            <ul class="list-inline mb-0">
	              	<li>
	                	<a data-action="collapse">
	                  		<i class="bx bx-chevron-down"></i>
	                	</a>
	              	</li>
           		</ul>
	          </div>
    		</div>
    		@php
    			use Carbon\Carbon;
    			$fechaEmision = Carbon::parse($proyecto->fecha_inicio);
				$fechaExpiracion = Carbon::parse($proyecto->fecha_fin);
				$fechaActual = Carbon::now();
				$diasDiferencia = $fechaExpiracion->diffInDays($fechaEmision);
				$diasTDiferencia = $fechaActual->diffInDays($fechaEmision);

				if ($diasTDiferencia > $diasDiferencia) {
					$diasTDiferencia = $diasDiferencia;
				}
    		@endphp
			<div class="card-content collapse show">
				<div class="card-body">
                    <div class="row">
                    	<div class="col-md-4 col-sm-12 col-xs-12">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-calendar-alt mb-1 mr-50"></i> {{ __('messages.fechaInicio') }}</small></h6>
	                        <p>{{ $proyecto->fecha_inicio }}</p>
	                    </div>
	                    <div class="col-md-4 col-sm-12 col-xs-12">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-calendar-check mb-1 mr-50"></i> {{ __('messages.fechaFin') }}</small></h6>
	                        <p>{{ $proyecto->fecha_fin }}</p>
                      	</div>
                      	<div class="col-md-4 col-sm-12 col-xs-12">
	                        <h6><small class="text-muted"><i class="cursor-pointer bx bx-purchase-tag-alt mb-1 mr-50"></i> {{ __('messages.estatus') }}</small></h6>
	                        <p>{!! $estatus !!}</p>
                      	</div>
                      	<hr>
                      	<div class="col-12">
                        	<h6><small class="text-muted"><i class="cursor-pointer bx bx-map mb-1 mr-50"></i> {{ __('messages.direccionProyecto') }}</small></h6>
                        	<p>{{ $proyecto->direccion }}</p>
                        	<h6><small class="text-muted"><i class="cursor-pointer bx bx-error-circle mb-1 mr-50"></i> {{ __('messages.descripcion') }}</small></h6>
                        	<p>{{ $proyecto->descripcion }}</p>
                      	</div>
                    </div>
                    @if(Auth::user()->isAdmin() == true)
                    <div class="divider">
		              <div class="divider-text">{{ __('messages.indicadores') }}</div>
		            </div>
                    <div class="row">
                    	<div class="col-12">
							<div class="row">
								<div class="col-8">
									<label for="">{{__('messages.avanceProyectado')}} </label>
									
								</div>
								<div class="col-12">
		                    		<div class="activity-progress flex-grow-1 mt-2 cursor-pointer  pb-2"   data-toggle="popover" data-content=" {{ number_format(round($diasTDiferencia,2)) }} Dias Transcurridos de {{ number_format(round($diasDiferencia,2)) }}" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
					                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
					                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ round(($diasTDiferencia/ $g = ($diasDiferencia == 0) ? 1 : $diasDiferencia)*100,2)}}" style="width:{{ round(($diasTDiferencia/ $g = ($diasDiferencia == 0) ? 1 : $diasDiferencia)*100,2)}}%">
					                    	</div>
					                  	</div>
					                </div>
								</div>
							</div>
                    	</div>
                    	<div class="col-12">
							<label for="">{{__('messages.avanceReal')}}  </label>
							@php
								// totales
								$subtotal = round($proyecto->MetradoProyecto()['pt'],2);
								$gastosG = round($proyecto->MetradoProyecto()['pt'] * ($proyecto->gastos_generales / 100),2);
								$utilidad = round($proyecto->MetradoProyecto()['pt'] * ($proyecto->utilidad / 100),2);
								$total = round(($subtotal+$gastosG+$utilidad),2);
								$pd = $total*($proyecto->descuento/100);
								$descuento = round($total*($proyecto->descuento/100));
								// realizado
								$subtotal_r = round($proyecto->MetradoProyecto()['pr'],2);
								$gastosG_r = round($proyecto->MetradoProyecto()['pr'] * ($proyecto->gastos_generales / 100),2);
								$utilidad_r = round($proyecto->MetradoProyecto()['pr'] * ($proyecto->utilidad / 100),2);
								$total_r = round(($subtotal_r+$gastosG_r+$utilidad_r),2);
								$descuento_r =  round($total_r*($proyecto->descuento/100),2);

								// total 
            					$tot = $total - $descuento;
							@endphp
                    		<div class="activity-progress flex-grow-1 mt-2 cursor-pointer pb-2"   data-toggle="popover" data-content="
                    		SUBTOTAL: {{ number_format($subtotal_r,2) }} de <b>{{ number_format($subtotal,2) }}</b> <br> 
                    		GASTOS GEN.: {{ number_format($gastosG_r,2) }} de <b>{{ number_format($gastosG,2) }}</b> <br> 
                    		UTILIDAD: {{ number_format($utilidad_r,2) }} de  <b>{{ number_format($utilidad,2) }}</b><br> 
                    		DESC COM.: {{ number_format($descuento_r,2) }} de  <b>{{ number_format($descuento,2) }}</b><br> 
                    		TOTAL: {{ number_format($total_r,2) }} de <b>{{ number_format($total,2) }}</b>" 
                    		data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
			                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
			                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ $p = round(($proyecto->MetradoProyecto()['mr'] / $res = ($proyecto->MetradoProyecto()['mt']  == 0)? 1 : $proyecto->MetradoProyecto()['mt'] /100),2)}}" style="width:{{ $p = round(($proyecto->MetradoProyecto()['mr'] / $res = ($proyecto->MetradoProyecto()['mt']  == 0)? 1 : $proyecto->MetradoProyecto()['mt'] /100),2)}}%">
			                    		
			                    	</div>
			                  	</div>
			                </div>
                    	</div>

                    	<div class="col-12">
							<div class="row">
								<div class="col-8">
									<label for="">{{__('messages.gastosReal')}} </label>
									
								</div>
								<div class="col-4">
									<a href="#" data-uri="{{ route('gastos.store',['id' => $proyecto->id]) }}" data-max="{{ round($proyecto->gasto_estimado,2) - round($proyecto->Gastos->sum('monto'),2) }}" class="float-right cmetal modal-registro" data-titulo="{{__('messages.gastosEstimado')}}">
				                      <i class="cursor-pointer bx bx-plus-circle font-small-3 mr-50"></i><span>{{ __('messages.nuevoGasto') }}</span>
				                    </a>
				                </div>
								<div class="col-12">
		                    		<div class="activity-progress flex-grow-1 mt-2 cursor-pointer  pb-2"   data-toggle="popover" data-content=" {{ number_format(round($proyecto->Gastos->sum('monto'),2),2) }} de {{ number_format(round($proyecto->gasto_estimado,2),2) }}" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
					                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
					                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ round(($proyecto->Gastos->sum('monto')/ $g = ($proyecto->gasto_estimado == 0) ? 1 : $proyecto->gasto_estimado)*100,2)}}" style="width:{{ round(($proyecto->Gastos->sum('monto')/ $g = ($proyecto->gasto_estimado == 0) ? 1 : $proyecto->gasto_estimado)*100,2)}}%">
					                    	</div>
					                  	</div>
					                </div>
								</div>
							</div>
                    	</div>

                    	<div class="col-12">
                    		<div class="row">
                    			<div class="col-8">
									<label for="">{{__('messages.facturaEstimada')}}  </label>
                    			</div>
                    			<div class="col-4">
                    				
                    				<a href="#" data-uri="{{ route('facturas.store',['id' => $proyecto->id]) }}" data-max="{{ round($tot,2) - round($proyecto->Facturas->sum('monto'),2) }}" class="float-right cmetal modal-registro" data-titulo="{{__('messages.facturaEstimada')}}">
				                      <i class="cursor-pointer bx bx-plus-circle font-small-3 mr-50"></i><span>{{ __('messages.nuevaFactura') }}</span>
				                    </a>
                    			</div>
                    			<div class="col-12">
		                    		<div class="activity-progress flex-grow-1 mt-2 cursor-pointer  pb-2"   data-toggle="popover" data-content="{{ number_format(round($proyecto->Facturas->sum('monto'),2),2) }} de {{ number_format(round($total - $descuento,2),2) }}" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
					                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
					                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ round(($proyecto->Facturas->sum('monto') / $r = ($tot == 0) ? 1 : $tot)*100,2)}}" style="width:{{ round(($proyecto->Facturas->sum('monto') / $r = ($tot == 0) ? 1 : $tot)*100,2) }}%">
					                    		
					                    	</div>
					                  	</div>
					                </div>
                    			</div>
                    		</div>
                    	</div>

                    	<div class="col-12">
							<div class="row">
                    			<div class="col-8">
									<label for="">{{__('messages.depositoEstimado')}}  </label>
                    			</div>
                    			<div class="col-4">
                    				
                    				<a href="#" data-uri="{{ route('depositos.store',['id' => $proyecto->id]) }}" data-max="{{ round($tot,2) - round($proyecto->Depositos->sum('monto'),2) }}" class="float-right cmetal modal-registro" data-titulo="{{__('messages.depositoEstimado')}}">
				                      <i class="cursor-pointer bx bx-plus-circle font-small-3 mr-50"></i><span>{{ __('messages.nuevoDeposito') }}</span>
				                    </a>
                    			</div>
                    			<div class="col-12">
		                    		<div class="activity-progress flex-grow-1 mt-2 cursor-pointer  pb-2"   data-toggle="popover" data-content="{{ number_format(round($proyecto->Depositos->sum('monto'),2),2) }} de {{ number_format(round($total - $descuento,2),2) }}" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
					                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
					                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ round(($proyecto->Depositos->sum('monto') / $r = ($tot == 0) ? 1 : $tot)*100,2)}}" style="width:{{ round(($proyecto->Depositos->sum('monto') / $r = ($tot == 0) ? 1 : $tot)*100,2) }}%">
					                    		
					                    	</div>
					                  	</div>
					                </div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <hr>
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
                    </a>
                    <a href="{{ route('proyectos.edit',['id' => $proyecto->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
					@endif
              	</div>
    		</div>
  		</div>

  		{{-- <canvas id="myChart" width="400" height="400"></canvas> --}}

  	{{-- 	<div class="col-md-6">
	      <div class="card">
	        <div class="card-header">
	          <h4 class="card-title">Line Chart</h4>
	        </div>
	        <div class="card-content">
	          <div class="card-body pl-0">
	            <div class="height-300">
	              <canvas id="myChart"></canvas>
	            </div>
	          </div>
	        </div>
	      </div>
	    </div> --}}
	    <!-- Line Area Chart -->
	    <div class="row">
	    	<div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Ratio de Producción</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="ratioProduccion"></div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Ratio de Compras</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="line-area-chart"></div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Ratio de Facturación</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="ratioFacturacion"></div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Ratio de Cobro</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="ratioCobro"></div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Flujo de Caja Facturada</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="ratioFlujoCaja"></div>
		          </div>
		        </div>
		      </div>
		    </div>

		    <div class="col-lg-6 col-md-6 col-md-12">
		      <div class="card">
		        <div class="card-header">
		          <h4 class="card-title">Flujo de Liquidez</h4>
		        </div>
		        <div class="card-content">
		          <div class="card-body">
		            <div id="ratioFlujoLiquidez"></div>
		          </div>
		        </div>
		      </div>
		    </div>
	    </div>

  

  		

        
  		@if($proyecto->Sectores)
		<section id="accordionWrapa">
			<div class="row">
				<div class="col-md-6">
		  			<h4 class="">{{ __('messages.sectores') }}</h4>
				</div>	
				<div class="col-md-6">
					<ul class="nav nav-tabs justify-content-end" role="tablist">
		              	<li class="nav-item {{ (Auth::user()->tipo == 4) ? 'current' : '' }}">
		                	<a class="nav-link {{ (Auth::user()->tipo == 4) ? 'active' : '' }} {{ (Auth::user()->isAdmin() == true || Auth::user()->tipo == 4)? '' : 'disabled' }}" id="service-tab-end" data-toggle="tab" href="#service-align-end" aria-controls="service-align-end" role="tab" aria-selected="false">
		                  {{ __('messages.proveedor')}}
		                	</a>
		              	</li>
		              	<li class="nav-item {{ (Auth::user()->tipo == 3) ? 'current' : '' }} ">
		                	<a class="nav-link {{ (Auth::user()->tipo == 3) ? 'active' : 'active' }}  {{ (Auth::user()->isAdmin() == true || Auth::user()->tipo == 3)? '' : 'disabled' }}" id="account-tab-end" data-toggle="tab" href="#account-align-end" aria-controls="account-align-end" role="tab" aria-selected="true">
		                  {{ __('messages.supervisor')}}
		                	</a>
		              	</li>
		            </ul>
				</div>	
			</div>
			<div class="tab-content">
				<div class="tab-pane  {{ (Auth::user()->tipo == 3) ? 'active' : 'active' }}" id="account-align-end" aria-labelledby="account-tab-end" role="tabpanel">
			  		<div class="accordion" id="accordionWrapa21" data-toggle-hover="true">
		@endif
		@forelse($proyecto->Sectores as $sector)
			@php
				// totales sector
				$subtotalS = round($sector->Actividades->sum('metrado')*$sector->Actividades->sum('precio'),2);
				$gastosGS = round($subtotalS*($proyecto->gastos_generales/100),2);
				$utilidadS = round($subtotalS*($proyecto->utilidad/100),2);
				$descuentoS = round($subtotalS*($proyecto->descuento/100),2);
				$totalS = ($gastosGS + $subtotalS + $utilidadS);
				// total realizado sector
				$subtotalS_r = round($sector->total(3),2);
				$gastosGS_r = round($subtotalS_r*($proyecto->gastos_generales/100),2);
				$utilidadS_r = round($subtotalS_r*($proyecto->utilidad/100),2);
				$descuentoS_r = round($subtotalS_r*($proyecto->descuento/100),2);
				$totalS_r = ($subtotalS_r + $gastosGS_r +$utilidadS_r);
			@endphp
		    <div class="card collapse-header" >
		      	<div id="heading-sector-{{$sector->id}}" class="card-header collapsed" role="tablist" data-toggle="collapse" data-target="#accordion-sector-s-{{$sector->id}}" aria-expanded="false" aria-controls="accordion-sector-s-{{$sector->id}}">
		        	<span class="collapse-title mb-1 ">
		        		{{ $sector->nombre }}
		        	</span>
	        		<br> 
	        		<div class="activity-progress flex-grow-1 mt-2"  @if(Auth::user()->isAdmin() == true) data-toggle="popover" data-content=" SUBTOTAL: {{ number_format($subtotalS_r,2) }} de <b>{{ number_format($subtotalS,2) }}</b> <br> 
	        			GASTOS GEN.: {{ number_format($gastosGS_r,2) }} de <b>{{ number_format($gastosGS,2) }} </b><br> 
	        			UTILIDAD: {{ number_format($utilidadS_r,2) }} de <b>{{ number_format($utilidadS,2) }} </b><br> 
	        			DESC COM.: {{ number_format($descuentoS_r,2) }} de <b>{{ number_format($descuentoS,2) }}</b><br> 
	        			TOTAL: {{ number_format($totalS_r,2) }} de <b>{{ number_format($totalS,2) }}</b>" 
	        			data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true" @endif>
	                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
	                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ $p = round(($sector->porcentajeSector->where('tipo',2)->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}" style="width:{{ $p = round(($sector->porcentajeSector->where('tipo',2)->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}%"></div>
	                  	</div>
	                </div>

		      	</div>
		      	<div id="accordion-sector-s-{{$sector->id}}" role="tabpanel" data-parent="#accordionWrapa21" aria-labelledby="heading-sector-{{$sector->id}}" class="collapse" style="">
			        <div class="card-content">
			          	<div class="card-body">
			          		<div class="row">
			          			<div class="col-12">
			          				<p>{{ $sector->descripcion }}</p>
			          			</div>
			          			@if(Auth::user()->isAdmin() == true)
			          			<div class="col-12">
			          				<a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
				                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
				                    </a>
				                    <a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
				                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
			          			</div>
			          			@endif
			          		</div>
							<hr>
			          		<div class="card widget-todo">
				              	<div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap">
					                <h4 class="card-title d-flex mb-25 mb-sm-0">
					                  <i class="bx bx-check font-medium-5 pl-25 pr-75"></i> {{ __('messages.actividades') }}
					                </h4>
				              	</div>
				              	<div class="card-body px-0 py-3">
					                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
										@forelse($sector->Actividades as $actividad)
						                  	<li class="widget-todo-item  cursor-pointer {{ ($actividad->estatus == 0 || $actividad->avance(2) == 100)? 'completed' : '' }}" >
						                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
						                      		<div class="widget-todo-title-area d-flex align-items-center">
								                        <div class="checkbox checkbox-shadow">
								                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad-{{$actividad->id}}" {{ ($actividad->estatus == 0 || $actividad->avance(2) == 100)? 'checked="true"' : '' }}  disabled="true">
								                          <label for="checkbox-actividad-{{$actividad->id}}"></label>
								                        </div>

						                      		</div>
								                        	<div class="activity-progress flex-grow-1  modal-actividades"   data-uri="{{ route('actividades.show',['id' => $actividad->id]) }}"   data-toggle="popover" data-content=" 
								                        		MONTO ACUM: {{ $actividad->Reportes->where('tipo',2)->sum('metrado')*$actividad->precio }} de {{ $actividad->metrado*$actividad->precio }}
								                        		<br>
								                        		MET ACUM: {{ $actividad->Reportes->where('tipo',2)->sum('metrado')}} de {{ $actividad->metrado}}
								                        		" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
											                  	<span class="text-muted d-inline-block mb-50">
											                  		<span class="widget-todo-title ml-50">
								                        				{{ $actividad->nombre }}
											                        </span>
											                    </span>
											                  <div class="progress progress-bar-success progress-sm mt-1" style="width: 92% !important; margin: auto;">
											                    <div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{$actividad->avance(2)}}" style="width:{{$actividad->avance(2)}}%"></div>
											                  </div>
											                </div>
						                      		<div class="widget-todo-item-action d-flex align-items-center">
						                        		<div class="badge badge-pill badge-light-info mr-1">{{ $actividad->Unidad->nombre }}</div>
								                        <div class="avatar bg-rgba-primary m-0 mr-50">
								                          	<div class="avatar-content">
								                            	<span class="font-size-base text-primary">RA</span>
								                          	</div>
								                        </div>
								                        @if(Auth::user()->tipo != 3)
							                        	<div class="dropdown">
							                          		<span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-offset="5,20"></span>
							                          		<div class="dropdown-menu dropdown-menu-right">
							                          			@if(Auth::user()->isAdmin() == true)
							                            		<a class="dropdown-item" href="{{ route('sectores.actividades.edit',['id' => $actividad->id]) }}"><i class="bx bx-edit-alt mr-1"></i> {{ __('messages.edit') }}</a>
							                            		@endif
							                            		{{-- <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> {{ __('messages.delete') }}</a> --}}
																
																{{-- @if(Auth::user()->tipo == 2) --}}
							                            		<a class="dropdown-item modal-reporte" href="#"  data-uri="{{ route('reportes.store',['id' => $actividad->id]) }}" data-actividad="{{ $actividad->nombre }}" data-max="{{ $actividad->metrado - $actividad->Reportes->sum('metrado') }}"><i class="bx bx-file mr-1"></i> {{ __('messages.reportar') }}</a>
							                            		{{-- @endif --}}
							                          		</div>
							                        	</div>
							                        	@endif
							                      	</div>
						                    	</div>
						                  	</li>
										@empty
											<li class="widget-todo-item">
						                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
						                      		<div class="widget-todo-title-area d-flex align-items-center">
								                        <i class="bx bx-grid-vertical mr-25 font-medium-4 cursor-move"></i>
								                        <div class="checkbox checkbox-shadow">
								                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad">
								                          <label for="checkbox-actividad"></label>
								                        </div>
								                        <span class="widget-todo-title ml-50">{{ __('messages.sinResultados' )}}</span>
						                      		</div>
						                      		
						                    	</div>
						                  	</li>
										@endforelse
					                </ul>
				              	</div>
				            </div>
			          	</div>
			        </div>
		      	</div>
		    </div>
		@empty
			<div class="alert alert-danger alert-block">
				<button type="button" class="close" data-dismiss="alert">×</button>	
			        <strong>{{ __('messages.sinResultados') }}</strong>
			</div>
		@endforelse
		@if($proyecto->Sectores)
					</div>
				</div>
				<div class="tab-pane  {{ (Auth::user()->tipo == 4) ? 'active' : '' }}" id="service-align-end" aria-labelledby="service-tab-end" role="tabpanel">
					<div class="accordion" id="accordionWrapa1" data-toggle-hover="true">
					@forelse($proyecto->Sectores as $sector)
						@php
							// totales sector
							$subtotalS = round($sector->Actividades->sum('metrado')*$sector->Actividades->sum('precio'),2);
							$gastosGS = round($subtotalS*($proyecto->gastos_generales/100),2);
							$utilidadS = round($subtotalS*($proyecto->utilidad/100),2);
							$descuentoS = round($subtotalS*($proyecto->descuento/100),2);
							$totalS = ($gastosGS + $subtotalS + $utilidadS);
							// total realizado sector
							$subtotalS_r = round($sector->total(4),2);
							$gastosGS_r = round($subtotalS_r*($proyecto->gastos_generales/100),2);
							$utilidadS_r = round($subtotalS_r*($proyecto->utilidad/100),2);
							$descuentoS_r = round($subtotalS_r*($proyecto->descuento/100),2);
							$totalS_r = ($subtotalS_r + $gastosGS_r +$utilidadS_r);
						@endphp
					    <div class="card collapse-header" >
					      	<div id="heading-sector-{{$sector->id}}" class="card-header collapsed" role="tablist" data-toggle="collapse" data-target="#accordion-sector-{{$sector->id}}" aria-expanded="false" aria-controls="accordion-sector-{{$sector->id}}">
					        	<span class="collapse-title mb-1 ">
					        		{{ $sector->nombre }}
					        	</span>
				        		<br> 
				        		<div class="activity-progress flex-grow-1 mt-2"  @if(Auth::user()->isAdmin() == true) data-toggle="popover" data-content=" SUBTOTAL: {{ number_format($subtotalS_r,2) }} de <b>{{ number_format($subtotalS,2) }}</b> <br> 
				        			GASTOS GEN.: {{ number_format($gastosGS_r,2) }} de <b>{{ number_format($gastosGS,2) }} </b><br> 
				        			UTILIDAD: {{ number_format($utilidadS_r,2) }} de <b>{{ number_format($utilidadS,2) }} </b><br> 
				        			DESC COM.: {{ number_format($descuentoS_r,2) }} de <b>{{ number_format($descuentoS,2) }}</b><br> 
				        			TOTAL: {{ number_format($totalS_r,2) }} de <b>{{ number_format($totalS,2) }}</b>" 
				        			data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true" @endif>
				                  	<div class="progress progress-bar-cmetal progress-sm mt-1" style="width: 92% !important; margin: auto;">
				                    	<div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{ $p = round(($sector->porcentajeSector->where('tipo',4)->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}" style="width:{{ $p = round(($sector->porcentajeSector->where('tipo',4)->sum('metrado') / $res = ($sector->Actividades->sum('metrado') == 0)? 1 : $sector->Actividades->sum('metrado')/100),2)}}%"></div>
				                  	</div>
				                </div>

					      	</div>
					      	<div id="accordion-sector-{{$sector->id}}" role="tabpanel" data-parent="#accordionWrapa1" aria-labelledby="heading-sector-{{$sector->id}}" class="collapse" style="">
						        <div class="card-content">
						          	<div class="card-body">
						          		<div class="row">
						          			<div class="col-12">
						          				<p>{{ $sector->descripcion }}</p>
						          			</div>
						          			@if(Auth::user()->isAdmin() == true)
						          			<div class="col-12">
						          				<a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-none d-sm-block float-right btn-light-cmetal mb-2">
							                      <i class="cursor-pointer bx bx-edit font-small-3 mr-50"></i><span>{{ __('messages.editar') }}</span>
							                    </a>
							                    <a href="{{ route('sectores.edit',['id' => $sector->id]) }}" class="btn d-block d-sm-none btn-block text-center btn-light-cmetal">
							                      <i class="cursor-pointer bx bx-edit font-small-3 mr-25"></i><span>{{ __('messages.editar') }}</span></a>
						          			</div>
						          			@endif
						          		</div>
										<hr>
						          		<div class="card widget-todo">
							              	<div class="card-header border-bottom d-flex justify-content-between align-items-center flex-wrap">
								                <h4 class="card-title d-flex mb-25 mb-sm-0">
								                  <i class="bx bx-check font-medium-5 pl-25 pr-75"></i> {{ __('messages.actividades') }}
								                </h4>
							              	</div>
							              	<div class="card-body px-0 py-3">
								                <ul class="widget-todo-list-wrapper" id="widget-todo-list">
													@forelse($sector->Actividades as $actividad)
									                  	<li class="widget-todo-item  cursor-pointer {{ ($actividad->estatus == 0 || $actividad->avance(4) == 100)? 'completed' : '' }}" >
									                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
									                      		<div class="widget-todo-title-area d-flex align-items-center">
											                        <div class="checkbox checkbox-shadow">
											                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad-{{$actividad->id}}" {{ ($actividad->estatus == 0 || $actividad->avance(4) == 100)? 'checked="true"' : '' }}  disabled="true">
											                          <label for="checkbox-actividad-{{$actividad->id}}"></label>
											                        </div>

									                      		</div>
											                        	<div class="activity-progress flex-grow-1  modal-actividades"   data-uri="{{ route('actividades.show',['id' => $actividad->id]) }}"   data-toggle="popover" data-content=" 
											                        		MONTO ACUM: {{ $actividad->Reportes->where('tipo',4)->sum('metrado')*$actividad->precio }} de {{ $actividad->metrado*$actividad->precio }}
											                        		<br>
											                        		MET ACUM: {{ $actividad->Reportes->where('tipo',4)->sum('metrado')}} de {{ $actividad->metrado}}
											                        		" data-trigger="hover" data-original-title="" title="" data-placement="top" data-html="true">
														                  	<span class="text-muted d-inline-block mb-50">
														                  		<span class="widget-todo-title ml-50">
											                        				{{ $actividad->nombre }}
														                        </span>
														                    </span>
														                  <div class="progress progress-bar-success progress-sm mt-1" style="width: 92% !important; margin: auto;">
														                    <div class="progress-bar progress-bar-striped  progress-label" role="progressbar" aria-valuenow="{{$actividad->avance(4)}}" style="width:{{$actividad->avance(4)}}%"></div>
														                  </div>
														                </div>
									                      		<div class="widget-todo-item-action d-flex align-items-center">
									                        		<div class="badge badge-pill badge-light-info mr-1">{{ $actividad->Unidad->nombre }}</div>
											                        <div class="avatar bg-rgba-primary m-0 mr-50">
											                          	<div class="avatar-content">
											                            	<span class="font-size-base text-primary">RA</span>
											                          	</div>
											                        </div>
											                        @if(Auth::user()->tipo != 3)
										                        	<div class="dropdown">
										                          		<span class="bx bx-dots-vertical-rounded font-medium-3 dropdown-toggle nav-hide-arrow cursor-pointer icon-light" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" role="menu" data-offset="5,20"></span>
										                          		<div class="dropdown-menu dropdown-menu-right">
										                          			@if(Auth::user()->isAdmin() == true)
										                            		<a class="dropdown-item" href="{{ route('sectores.actividades.edit',['id' => $actividad->id]) }}"><i class="bx bx-edit-alt mr-1"></i> {{ __('messages.edit') }}</a>
										                            		@endif
										                            		{{-- <a class="dropdown-item" href="#"><i class="bx bx-trash mr-1"></i> {{ __('messages.delete') }}</a> --}}
																			
																			{{-- @if(Auth::user()->tipo == 2) --}}
										                            		<a class="dropdown-item modal-reporte" href="#"  data-uri="{{ route('reportes.store',['id' => $actividad->id]) }}" data-actividad="{{ $actividad->nombre }}" data-max="{{ $actividad->metrado - $actividad->Reportes->sum('metrado') }}"><i class="bx bx-file mr-1"></i> {{ __('messages.reportar') }}</a>
										                            		{{-- @endif --}}
										                          		</div>
										                        	</div>
										                        	@endif
										                      	</div>
									                    	</div>
									                  	</li>
													@empty
														<li class="widget-todo-item">
									                    	<div class="widget-todo-title-wrapper d-flex justify-content-between align-items-center mb-50">
									                      		<div class="widget-todo-title-area d-flex align-items-center">
											                        <i class="bx bx-grid-vertical mr-25 font-medium-4 cursor-move"></i>
											                        <div class="checkbox checkbox-shadow">
											                          <input type="checkbox" class="checkbox__input" id="checkbox-actividad">
											                          <label for="checkbox-actividad"></label>
											                        </div>
											                        <span class="widget-todo-title ml-50">{{ __('messages.sinResultados' )}}</span>
									                      		</div>
									                      		
									                    	</div>
									                  	</li>
													@endforelse
								                </ul>
							              	</div>
							            </div>
						          	</div>
						        </div>
					      	</div>
					    </div>
					@empty
						<div class="alert alert-danger alert-block">
							<button type="button" class="close" data-dismiss="alert">×</button>	
						        <strong>{{ __('messages.sinResultados') }}</strong>
						</div>
					@endforelse
					</div>
				</div>
		  	</div>
		</section>
		@endif

		<div class="card">
			@forelse ($proyecto->Comentarios as $comentario)
				<div class="card-content">
	              	<div class="card-header user-profile-header">
	              		<div class="avatar  mr-50 align-top mr-1 bg-warning bg-lighten-2">
	                    	<span class="avatar-content"  width="32" height="32"><b>{{ substr($comentario->Usuario->nombre,0,1) }}{{ substr($comentario->Usuario->apellido,0,1) }}</b></span>
	                  		{{-- <span class="avatar-status-online"></span> --}}
	                  	</div>
	                	
	            		<div class="d-inline-block mt-25">
	                  		<h6 class="mb-0 text-bold-500">{{$comentario->Usuario->nombre}} {{$comentario->Usuario->apellido}}</h6>
	                  		<p class="text-muted">
	                  			<small>{!! tipo_usuario($comentario->Usuario->tipo) !!}</small> - 
	                  			<small>{{$comentario->updated_at}}</small>
	                  		</p>
	                	</div>
	                	<i class="cursor-pointer bx bx-dots-vertical-rounded float-right"></i>
	              	</div>
	              	<div class="card-body py-0">
	                	<p>{{$comentario->comentario}}</p>
	              	</div>
	            </div>
	            <hr>
	        @empty

	        	{{-- <hr> --}}
	            
			@endforelse
            
            {{-- <hr> --}}
        	<form action="{{ route('comentarios.store') }}" method="POST">
        		@csrf
        		<input type="hidden" name="proyecto_id" value="{{$proyecto->id}}">
            	<div class="form-group row align-items-center px-1">
	              	<div class="col-2 col-sm-1">
	              		<div class="avatar mr-1 bg-warning bg-lighten-2">
	                    	<span class="avatar-content"  width="32" height="32"><b>{{ substr(Auth::user()->nombre,0,1) }}{{ substr(Auth::user()->apellido,0,1) }}</b></span>
	                  		<span class="avatar-status-online"></span>
	                  	</div>
	                	{{-- <div class="avatar">
	                  		<img src="images/portrait/small/avatar-s-2.jpg" alt="avtar images" width="32" height="32">
	                	</div> --}}
	              	</div>
            		
	              	<div class="col-sm-10 col-8">
	                	<textarea class="form-control" id="user-comment-textarea" name="comentario" rows="1" placeholder="comment.." style="height: 47px;"></textarea>
	              	</div>
	              	<div class="col-sm-1 col-2">
	                	<button type="submit" class="btn btn-icon rounded-circle btn-cmetal mr-1 mt-2 mb-1"><i class="bx bxs-send"></i></button>
	              	</div>
        	    </div>
        	</form>
            <!-- user profile comments ends -->
        </div>
	</div>
</div>



  <!-- full size modal-->
  <div class="modal fade text-left w-100" id="modal-actividades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel20"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
        	<div class="col-12">
        		<div class="row">
        			<div class="col-md-3 col-sm-12 col-xs-12">
        				<b>{{ __('messages.descripcion') }}</b>
        				<p  id="descripcion"></p>
        			</div>
    				<div class="col-md-3 col-sm-12 col-xs-12">
    					<b>{{ __('messages.metrado') }}</b>
    					<p  id="metradoT"></p>
    				</div>
    				<div class="col-md-3 col-sm-12 col-xs-12">
    					<b>{{ __('messages.metradoRealizado') }}</b>
						<p  id="metradoR"></p>
    				</div>
    				<div class="col-md-3 col-sm-12 col-xs-12">
    					<b>{{ __('messages.precio') }}</b>
    					<p  id="precio"></p>
    				</div>	
        		</div>
        		<div class="row">
        			<div class="col-12 text-rigth right">
	        			<b>{{ __('messages.precioTotal')}}</b>
						<p  id="precioTotal"></p>
        			</div>
        		</div>
        		
	         	{{-- <table class="table table-striped">
	         		<thead>
	         			<tr>
	         				<th>{{ __('messages.descripcion') }}</th>
	         				<th>{{ __('messages.metrado') }}</th>
	         				<th>{{ __('messages.metradoRealizado') }}</th>
	         				<th>{{ __('messages.precio') }}</th>
	         			</tr>
	         		</thead>
	         		<tbody>
	         			<tr>
	         				<td id="descripcion"></td>
	         				<td id="metradoT"></td>
	         				<td id="metradoR"></td>
	         				<td id="precio"></td>
	         			</tr>
	         		</tbody>
	         		<tfoot>
	         			<tr>
	         				<td align="right" colspan="3">{{ __('messages.precioTotal')}}</td>
	         				<td id="precioTotal"></td>
	         			</tr>
	         		</tfoot>
	         	</table> --}}
        	</div>

          <!-- App File - Recent Accessed Files Section Starts -->
          	<div class="divider">
              <div class="divider-text">{{ __('messages.reportes') }}</div>
            </div>
            <div class="row">
            	<div class="col-12" id="reportes">
            		
            	</div>
            	
            </div>

			          

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-light-cmetal" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">{{ __('messages.cerrar') }}</span>
          </button>
          {{-- <button type="button" class="btn btn-primary ml-1" data-dismiss="modal">
            <i class="bx bx-check d-block d-sm-none"></i>
            <span class="d-none d-sm-block">Accept</span>
          </button> --}}
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade text-left w-100" id="modal-reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel21">Reportar</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
         		
			<form class="form" method="POST" autocomplete="off" id="form-reporte" enctype="multipart/form-data">
				{{ csrf_field() }}
              	<div class="form-body">
	                <div class="row">
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="number" min="0.01" step="0.01" class="form-control {{ ($errors->has('metrado')) ? 'is-invalid' : '' }}" name="metrado" id="metrado" placeholder="{{ __('messages.metradoRealizado') }}" required="required">
	                      <label for="metrado">{{ __('messages.metradoRealizado') }}</label>
	                      	@if ($errors->has('metrado'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('metrado') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="date"   class="form-control {{ ($errors->has('fecha')) ? 'is-invalid' : '' }}" name="fecha" id="fecha"  required="required">
	                      <label for="fecha">{{ __('messages.fecha') }}</label>
	                      	@if ($errors->has('fecha'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('fecha') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>
						<div class="col-md-12 col-12">
	                    	<div class="form-label-group">
	                      		<input type="file"   class="form-control {{ ($errors->has('archivo')) ? 'is-invalid' : '' }}" multiple="" name="archivo[]" id="archivo" accept="image/*,application/pdf,.xls,.xl,doc,docx">
	                      		<label for="last-name-column">{{ __('messages.archivo') }}</label>
		                      	@if ($errors->has('archivo'))
									<div class="invalid-feedback">
				                    	<i class="bx bx-radio-circle"></i>
			                    		{{ $errors->first('archivo') }}
				                  	</div>
								@endif
	                    	</div>
	                  	</div>

	                  
	                {{--   <div class="col-12 d-flex justify-content-end mt-1">

	                  </div> --}}
	                </div>
              	</div>
		
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-cmetal">{{ __('messages.guardar') }}</button>
          <button type="button" class="btn btn-light-cmetal" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">{{ __('messages.cerrar') }}</span>
          </button>
            </form>       
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade text-left w-100" id="modal-registro" tabindex="-1" role="dialog" aria-labelledby="myModalLabel20" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel22"></h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <i class="bx bx-x"></i>
          </button>
        </div>
        <div class="modal-body">
         		
			<form class="form" method="POST" autocomplete="off" id="form-registro-a">
				{{ csrf_field() }}
              	<div class="form-body">
	                <div class="row">
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="date"   class="form-control {{ ($errors->has('fecha')) ? 'is-invalid' : '' }}" name="fecha" id="fecha" required="required" >
	                      <label for="last-name-column">{{ __('messages.fecha') }}</label>
	                      	@if ($errors->has('fecha'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('fecha') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>
	                  <div class="col-md-6 col-12">
	                    <div class="form-label-group">
	                      <input type="number" min="0.01" step="0.01" class="form-control {{ ($errors->has('monto')) ? 'is-invalid' : '' }}" name="monto" id="monto" placeholder="{{ __('messages.monto') }}" required="required">
	                      <label for="last-name-column">{{ __('messages.monto') }}</label>
	                      	@if ($errors->has('monto'))
								<div class="invalid-feedback">
			                    	<i class="bx bx-radio-circle"></i>
		                    		{{ $errors->first('monto') }}
			                  	</div>
							@endif
	                    </div>
	                  </div>

	                </div>
              	</div>
		
        </div>
        <div class="modal-footer">
        <button type="submit" class="btn btn-cmetal">{{ __('messages.guardar') }}</button>
          <button type="button" class="btn btn-light-cmetal" data-dismiss="modal">
            <i class="bx bx-x d-block d-sm-none"></i>
            <span class="d-none d-sm-block">{{ __('messages.cerrar') }}</span>
          </button>
            </form> 
        </div>
      </div>
    </div>
  </div>
{{-- </div> --}}

@endsection

@push('css')
	<link rel="stylesheet" type="text/css" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/app-file-manager.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('css/plugins/file-uploaders/dropzone.css') }}">
    <!-- END: Page CSS-->

    <style>
    	.popover-body{
    		width: 200% !important;
    		/*padding: 5px !important;*/
    	}
    	a.cmetal, a.cmetal:hover{
		    color: #5b1818 !important;
		}
    </style>
@endpush

@php
	$dav ='';
	foreach($dataavance as $av){
		$dav .= $av.',';
	}

	$dgs ='';
	foreach($datagasto as $g){
		$dgs .= $g.',';
	}
	$dra ='';
	foreach($dataratio as $ratio){
		$dra .= $ratio.',';
	}
	$label ='';
	foreach($labels as $l){
		$label .= '"'.$l.'",';
	}

@endphp
@push('scripts')
<script src="{{ asset('vendors/js/extensions/dropzone.min.js') }}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/ext-component-block-ui.js') }}"></script>
<script src="{{ asset('js/scripts/pages/app-file-manager.js') }}"></script>
<script src="{{ asset('js/scripts/extensions/dropzone.js') }}"></script>
<script src="{{ asset('js/scripts/popover/popover.js') }}"></script>
<!-- BEGIN: Page Vendor JS-->
<script src="{{asset('vendors/js/charts/chart.min.js')}}"></script>
<script src="{{asset('js/scripts/components.js')}}"></script>
  <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
   {{-- <script src="{{asset('js/scripts/charts/chart-apex.js')}}"></script> --}}
<!-- END: Page Vendor JS-->
  <script>
  	var e=["#5A8DEE","#FDAC41","#FF5B5C","#39DA8A","#00CFDD"],t={chart:{height:350,type:"line",zoom:{enabled:!1}},colors:e,dataLabels:{enabled:!1},stroke:{curve:"straight"},series:[{name:"Desktops",data:[10,41,35,51,49,62,69,91,148]}],title:{text:"Product Trends by Month",align:"left"},grid:{row:{colors:["#f3f3f3","transparent"],opacity:.5}},xaxis:{categories:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep"]},yaxis:{tickAmount:5}};new ApexCharts(document.querySelector("#line-chart"),t).render();

    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Avance Real",data:[@php echo $dav; @endphp]},
    		{name:"Gasto Real",data:[@php echo $dgs; @endphp]},
    		{name:"Ratio",data:[@php echo $dra; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$label"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#line-area-chart"),a).render();

    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Avance Real",data:[@php echo $dataavanceR; @endphp]},
    		{name:"Facturado",data:[@php echo $datafacturado; @endphp]},
    		{name:"Ratio",data:[@php echo $dataratiof; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$labelsf"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#ratioFacturacion"),a).render();


    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Avance Real",data:[@php echo $dataavanceRC; @endphp]},
    		{name:"Cobrado",data:[@php echo $datacobrado; @endphp]},
    		{name:"Ratio",data:[@php echo $dataratioc; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$labelsc"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#ratioCobro"),a).render();

    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Gastos",data:[@php echo $dataGasF; @endphp]},
    		{name:"Facturado",data:[@php echo $datafacF; @endphp]},
    		{name:"Ratio",data:[@php echo $dataratiofc; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$labelsf"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#ratioFlujoCaja"),a).render();


    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Gastos",data:[@php echo $dataGasDF; @endphp]},
    		{name:"Cobrado",data:[@php echo $datafacDF; @endphp]},
    		{name:"Ratio",data:[@php echo $dataratiofl; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$labelsDf"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#ratioFlujoLiquidez"),a).render();


    	var a={chart:{height:350,type:"area"},colors:e,dataLabels:{enabled:!1},stroke:{curve:"smooth"},
    	series:[
    		{name:"Avance Real",data:[@php echo $dataavFP; @endphp]},
    		{name:"Ratio",data:[@php echo $dataratiofp; @endphp]}
    	],
    	legend:{offsetY:-10},xaxis:{type:"date",
    	categories:[
    	@php echo "$labelsFP"; @endphp
    	]},tooltip:{x:{format:"dd/MM/yy HH:mm"}}};new ApexCharts(document.querySelector("#ratioProduccion"),a).render();

    </script>
    	{{-- @php echo "$label"; @endphp --}}

<script src="{{ asset('js/scripts/charts/chart-chartjs.js') }}"></script>
   <script>
   	$('[data-toggle="popover"]').popover()
   		function block() {
		  $.blockUI({
		    message: '<div class="bx bx-revision icon-spin font-medium-2"></div>',
		    overlayCSS: {
		      backgroundColor: "#fff",
		      opacity: .8,
		      cursor: "wait"
		    },
		    css: {
		      border: 0,
		      padding: 0,
		      backgroundColor: "transparent"
		    }
		  })
		}

		function unBlock() {
			$.unblockUI();
		}
   		$(function() {
   			$(document).on('click', '.modal-actividades', function(event) {
   				event.preventDefault();
   				var uri = $(this).data('uri');
   				block()
   				$.ajax({
   					url: uri,
   					type: 'GET',
   					dataType: 'json',
   				})
   				.done(function(data) {
   					console.log("success");
   					if(data.success == true){
   						$('#myModalLabel20').html(data.actividad.nombre);
   						$('#descripcion').html(data.actividad.descripcion);
   						$('#metradoT').html(data.actividad.metrado);
   						$('#metradoR').html(data.reportes);
   						$('#precio').html(data.actividad.precio);
   						var precoT = data.actividad.metrado*data.actividad.precio;
   						$('#precioTotal').html(precoT.toFixed(2));

   						$('#reportes').html(data.r);
   						unBlock()
   						$('#modal-actividades').modal('show');
   					}
   				})
   				.fail(function(e) {
   					console.log("error");
   					console.log(e);

   				})
   				.always(function() {
   					console.log("complete");
   				});
   				
   			});

   			$(document).on('click', '.modal-reporte', function(event) {
   				event.preventDefault();
   				$('#form-reporte').trigger("reset");
   				block()
   				var uri = $(this).data('uri');
   				$('#form-reporte').attr('action', uri);
   				$('#myModalLabel21').html('Reporte - '+$(this).data('actividad'));
   				if($(this).data('max') == 0){
   					$('#metrado').attr('disabled','disabled');
   				}else{
   					$('#monto').removeAttr('disabled');
   				}
   				$('#metrado').attr('max',$(this).data('max'));
   				unBlock()
   				$('#modal-reporte').modal('show');
   				
   			});


   			$(document).on('click', '.modal-registro', function(event) {
   				event.preventDefault();
   				$('#form-registro-a').trigger("reset");
   				block()
   				var uri = $(this).data('uri');
   				$('#form-registro-a').attr('action', uri);
   				$('#myModalLabel22').html($(this).data('titulo'));
   				if($(this).data('max') == 0){
   					$('#monto').attr('disabled','disabled');
   				}else{
   					$('#monto').removeAttr('disabled');
   				}
   				$('#monto').attr('max',$(this).data('max'));
   				unBlock()
   				$('#modal-registro').modal('show');
   				
   			});
   		});
   </script>
@endpush