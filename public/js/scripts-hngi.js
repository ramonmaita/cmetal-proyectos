$(function() {
    $('.montos').priceFormat({
        prefix: '',
        centsSeparator: ',',
        thousandsSeparator: '.'
    });
    $(".select2").select2();
	// CAMBIO DE COLOR DE CONTROLES FORM WIZARD
	$('a[href="#next"]').attr('class', 'btn-warning').html('Siguiente');
    $('a[href="#previous"]').attr('class', 'btn-warning').html('Anterior');
    $('a[href="#finish"]').attr('class', 'btn-warning').html('Guardar');

    $('#nombres').blur(function(event) {
    	$('#txt_nombres').html($(this).val());
    });
    $('#apellidos').blur(function(event) {
    	$('#txt_apellidos').html($(this).val());
    });
    $('#cedula').blur(function(event) {
    	$('#txt_ci').html($('#nacionalidad').val()+'-'+$(this).val());
    });
    $('#rif').blur(function(event) {
    	$('#txt_rif').html($('#lrif').val()+'-'+$(this).val());
    });
    $('#fn').blur(function(event) {
    	$('#txt_fn').html($(this).val());
    });
     $('#sexo').blur(function(event) {
    	$('#txt_sexo').html($(this).val());
    });



     $('#tipo_pago').change(function(event) {
     	var tipo_pago = $(this).val();
     	console.log(tipo_pago)
     	switch(tipo_pago) {
		  case 'PRECARGADO':
		    $('.transferencia').hide('slow/400/fast');
            $('#codigo_precargado').removeClass('hide');
     		$('#codigo_precargado').show('slow/400/fast');
            $('.transferencia').find('input').attr('disabled', 'disabled');
            $('#codigo_precargado').find('input').removeAttr('disabled');

		    break;
		  case 'TRANSFERENCIA':
		    $('.transferencia').show('slow/400/fast');
     		$('#codigo_precargado').hide('slow/400/fast');
     		$('#codigo_precargado').find('input').attr('disabled', 'disabled');
            $('.transferencia').find('input').removeAttr('disabled');
		    break;
		  default:
		    $('.transferencia').show('slow/400/fast');
            $('#codigo_precargado').find('input').attr('disabled', 'disabled');
            $('.transferencia').find('input').removeAttr('disabled');
     		$('#codigo_precargado').hide('slow/400/fast');
		    break;
		}
     });

     $(document).on('click', '.redirect', function(event) {
         event.preventDefault();
         /* Act on the event */
         window.location.href=$(this).data('uri');
     });

     $(document).on('keypress', '.SoloLetras', function(e) {
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
     });

     $(document).on('keypress', '.SoloNumeros', function(e) {
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key).toLowerCase();
       letras = "0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }

        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
     });

     // Mensajes de alerta al borrar registro

     $(document).on('click', '.eliminar', function(event) {
         // event.preventDefault();
         var form = $(this).data('uri');
        swal({   
            title: "¿Estás seguro que desea eliminar este registro?",   
            text: "¡No podrá recuperar este registro luego de eliminarlo!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#f2b701",   
            confirmButtonText: "Sí, bórralo!",   
            closeOnConfirm: false 
        }, function(isConfirm){
            if (isConfirm) {     
                swal("Eliminado", "El registro ha sido eliminado.", "success"); 
                $(form).submit();
            }
        });
        return false;

     });

     $(document).on('click', '.confirmar', function(event) {
         // event.preventDefault();
         var form = $(this).data('uri');
        swal({   
            title: "¿Estás seguro que desea continuar?",   
            text: "",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#f2b701",   
            confirmButtonText: "Sí",   
            closeOnConfirm: false 
        }, function(isConfirm){
            if (isConfirm) {     
                swal("Exito", "Operaccion realizada.", "success"); 
                $(form).submit();
            }
        });
        return false;

     });

});