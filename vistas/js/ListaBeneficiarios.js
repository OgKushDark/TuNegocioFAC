var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarformB(false);
	listar();

	$("#myModalB").on("submit",function(e)
	{
		editarB(e);	
	});
	
	$('#navConfiguracion').addClass("treeview active");
    $('#navBeneLi').addClass("active");
}

$.post("../controladores/comite.php?op=selectZona", function(r){

	    $("#idzona").html(r);
	    $('#idzona').selectpicker('refresh');

	});


$(document).ready(function() {
  // Función para cargar los comités basados en la zona seleccionada
  function cargarComitesPorZona(zonaSeleccionada) {
    $.post("../controladores/fichasupervision.php?op=selectComites1", { zona: zonaSeleccionada }, function(response) {
      // Actualizar el selector de comités con la respuesta del servidor
      $("#cbxComite").html(response);
      $("#cbxComite").selectpicker('refresh');
    });
  }

  // Cargar los comités iniciales basados en la zona seleccionada al cargar la página
  var zonaSeleccionada = $("#idzona").val();
  cargarComitesPorZona(zonaSeleccionada);

  // Manejar el evento de cambio en el selector de zona
  $('#idzona').on('change', function() {
    var zonaSeleccionada = $(this).val(); // Obtener el valor seleccionado
    cargarComitesPorZona(zonaSeleccionada);
  });
});

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#idcomite").val("");
	$("#beneficiario").val("");
	$("#DNI").val("");
	$("#edad").val("");
	$("#responsable").val("");
	$("#DNIr").val("");
	$("#tipo_opcion").val("");
	$("#tipo_opcion").selectpicker('refresh');


}

//Función mostrar formularioBeneficiario
function mostrarformB(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").show();
		$('#myModalB').modal('show');
	}
	else
	{
		$("#listadoregistros").show();
		$("#btnagregarB").show();
	}
}


//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarformB(false);
}




//Función Listar
function listar()
{
	var idcomite = $("#cbxComite").val();

	tabla=$('#tbllistado').dataTable(
	{
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    "processing": true,
	    "language": 
		{          
		"processing": "<img style='width:80px; height:80px;' src='../files/plantilla/loading-page.gif' />",
		},
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    lengthMenu: [
            [5,10, 25, 50, 100, -1],
            ['5 filas','10 filas', '25 filas', '50 filas','100 filas', 'Mostrar todo']
        ],
        buttons: ['pageLength','copy','excel', 'pdf'],
		"ajax":
				{
					url: '../controladores/consultas.php?op=ListaBeneficiario',
					data:{idcomite: idcomite},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar

function editarB(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formularioB")[0]);

	$.ajax({
		url: "../controladores/consultas.php?op=editarB",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Beneficiario',
				  type: 'success',
					text:datos
				});
              $('#myModalB').modal('hide');
              	          
	          mostrarformB(false);
	          tabla.ajax.reload();


	    }

	});
	limpiar();
	//location.reload();
}

function mostrar(idbeneficiario)
{
	$.post("../controladores/consultas.php?op=mostrar",{idbeneficiario : idbeneficiario}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarformB(true);

		$("#beneficiario").val(data.nombre);
 		$("#idbeneficiario").val(data.idbeneficiario);
 		$("#DNI").val(data.DNI);
 		$("#edad").val(data.edad);
 		$("#tipo_opcion").val(data.tipo_opcion);
		$('#tipo_opcion').selectpicker('refresh');
		$("#responsable").val(data.responsable);
		$("#DNIr").val(data.DNIr);
 	})
}

//Función para desactivar registros
function desactivarB(idbeneficiario)
{
	swal({
						    title: "¿Desactivar?",
						    text: "¿Está seguro Que Desea Desactivar el Beneficiario?",
						    type: "warning",
						    showCancelButton: true,
								cancelButtonText: "No",
								cancelButtonColor: '#FF0000',
						    confirmButtonText: "Si",
						    confirmButtonColor: "#0004FA",
						    closeOnConfirm: false,
						    closeOnCancel: false,
						    showLoaderOnConfirm: true
						    },function(isConfirm){
						    if (isConfirm){
									$.post("../controladores/consultas.php?op=desactivarB", {idbeneficiario : idbeneficiario}, function(e){
										swal(
											'!!! Desactivada !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la desactivacion del Beneficiario", "error");
							 }
							});
}

//Función para activar registros
function activarB(idbeneficiario)
{
	swal({
		    title: "¿Activar?",
		    text: "¿Está seguro Que desea Activar el Beneficiario?",
		    type: "warning",
		    showCancelButton: true,
				confirmButtonColor: '#0004FA',
				confirmButtonText: "Si",
		    cancelButtonText: "No",
				cancelButtonColor: '#FF0000',
		    closeOnConfirm: false,
		    closeOnCancel: false,
		    showLoaderOnConfirm: true
		    },function(isConfirm){
		    if (isConfirm){
						$.post("../controladores/consultas.php?op=activarB", {idbeneficiario : idbeneficiario}, function(e){
						swal("!!! Activada !!!", e ,"success");
								tabla.ajax.reload();
						});
		    }else {
		    swal("! Cancelado ¡", "Se Cancelo la activacion del Beneficiario", "error");
			 }
			});
}


init();