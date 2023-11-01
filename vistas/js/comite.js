var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	mostrarformB(false);
	listar();

	$("#myModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#myModalB").on("submit",function(e)
	{
		guardarB(e);	
	});
	
    $('#navSupervision').addClass("treeview active");
    $('#navComiteLi').addClass("active");

}
$.post("../controladores/comite.php?op=selectZona", function(r){

	    $("#idzona").html(r);
	    $('#idzona').selectpicker('refresh');

	});

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#idcomite").val("");
	$("#direccion").val("");
	$("#responsable").val("");
	$("#DNI").val("");
	$("#dirresponsable").val("");
	$("#cocinero").val("");
	$("#idzona").val("");
	$("#idzona").selectpicker('refresh');


}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").show();
		$('#myModal').modal('show');
	}
	else
	{
		$("#listadoregistros").show();
		$("#btnagregar").show();
	}
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
	mostrarform(false);
	mostrarformB(false);
}

//Función Listar
function listar()
{
	tabla=$('#tbllistado').dataTable(
	{
		//"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
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
					url: '../controladores/comite.php?op=listar',
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

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controladores/comite.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Comite',
				  type: 'success',
					text:datos
				});
              $('#myModal').modal('hide');
              	          
	          mostrarform(false);
	          tabla.ajax.reload();


	    }

	});
	limpiar();
	//location.reload();
}

function guardarB(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formularioB")[0]);

	$.ajax({
		url: "../controladores/comite.php?op=guardarB",
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

function mostrar(idcomite)
{
	$.post("../controladores/comite.php?op=mostrar",{idcomite : idcomite}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
 		$("#idcomite").val(data.idcomite);
		$("#direccion").val(data.direccion);
		$("#responsable").val(data.responsable);
		$("#DNI").val(data.DNI);
		$("#dirresponsable").val(data.dirresponsable);
		$("#cocinero").val(data.cocinero);
		$("#idzona").val(data.idzona);
		$('#idzona').selectpicker('refresh');

 	})
}

function beneficiario(idcomite)
{
	$.post("../controladores/comite.php?op=beneficiario",{idcomite : idcomite}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarformB(true);

		$("#nombres").val(data.nombre);
 		$("#idcomites").val(data.idcomite);

 	})
}

//Función para desactivar registros
function desactivar(idcomite)
{
	swal({
						    title: "¿Desactivar?",
						    text: "¿Está seguro Que Desea Desactivar el Comite?",
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
									$.post("../controladores/comite.php?op=desactivar", {idcomite : idcomite}, function(e){
										swal(
											'!!! Desactivada !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la desactivacion de la Categoria", "error");
							 }
							});
}

//Función para activar registros
function activar(idcomite)
{
	swal({
		    title: "¿Activar?",
		    text: "¿Está seguro Que desea Activar el Comite?",
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
						$.post("../controladores/comite.php?op=activar", {idcomite : idcomite}, function(e){
						swal("!!! Activada !!!", e ,"success");
								tabla.ajax.reload();
						});
		    }else {
		    swal("! Cancelado ¡", "Se Cancelo la activacion de la Categoria", "error");
			 }
			});
}


init();