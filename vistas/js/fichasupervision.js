var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#myModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	})
	
	$('#navSupervision').addClass("treeview active");
    $('#navSupervisorLi').addClass("active");
}

$.post("../controladores/fichasupervision.php?op=selectOpciones", function(r){

	    $("#cbxCondicionProducto").html(r);
	    $('#cbxCondicionProducto').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones", function(r){

	    $("#cbxCondicionPreparacion").html(r);
	    $('#cbxCondicionPreparacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones", function(r){

	    $("#cbxHigieneUtensilios").html(r);
	    $('#cbxHigieneUtensilios').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxApilado").html(r);
	    $('#cbxApilado').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxHumedad").html(r);
	    $('#cbxHumedad').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxSeguridad").html(r);
	    $('#cbxSeguridad').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxVentilacion").html(r);
	    $('#cbxVentilacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxIluminacion").html(r);
	    $('#cbxIluminacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones1", function(r){

	    $("#cbxLimpieza").html(r);
	    $('#cbxLimpieza').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxControlDocumentacion").html(r);
	    $('#cbxControlDocumentacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxControlBeneficiarios").html(r);
	    $('#cbxControlBeneficiarios').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxParticipacion").html(r);
	    $('#cbxParticipacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxApoyoGastos").html(r);
	    $('#cbxApoyoGastos').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxAsistenciaAsamblea").html(r);
	    $('#cbxAsistenciaAsamblea').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxAsistenciaActividad").html(r);
	    $('#cbxAsistenciaActividad').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectOpciones2", function(r){

	    $("#cbxDesarrolloParticipacion").html(r);
	    $('#cbxDesarrolloParticipacion').selectpicker('refresh');

	});
$.post("../controladores/fichasupervision.php?op=selectComites", function(r){
	$("#cbxComite").html(r);
	$("#cbxComite").selectpicker('refresh');
});

//Función limpiar
function limpiar()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#fecha_hora").val("");
	$("#idpersona").val("");
	$("#idzona").val("");
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

//Función cancelarform
function cancelarform()
{
	limpiar();
	mostrarform(false);
}

//Función Listar
function listar()
{
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
					url: '../controladores/persona.php?op=listarc',
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
		url: "../controladores/persona.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Cliente',
				  type: 'success',
					text:datos
				});
              $('#myModal').modal('hide');	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idpersona)
{
	$.post("../controladores/persona.php?op=mostrar",{idpersona : idpersona}, function(data, status)
	{
		data = JSON.parse(data);		
		mostrarform(true);

		$("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
		$("#fecha_hora").val(data.fecha);
 		$("#idpersona").val(data.idpersona);
		

 	})
}

//Función para eliminar registros
function eliminar(idpersona)
{
	swal({
	    title: "Eliminar?",
	    text: "¿Está seguro Que Desea Eliminar el Cliente?",
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
				$.post("../controladores/persona.php?op=eliminar", {idpersona : idpersona}, function(e){
					swal(
						'!!! Desactivada !!!',e,'success')
            tabla.ajax.reload();
    	});
	    }else {
	    swal("! Cancelado ¡", "Se Cancelo la eliminación del Cliente", "error");
		 }
		});
}

function obtenerDataPorComite(){
	let idComite = $("#cbxComite").val();
	
	$.post("../controladores/fichasupervision.php?op=obtenerDataPorComite",{idComite : idComite}, function(data, status)
	{
		data1 = JSON.parse(data);
		console.log(data1.aaData);
		dataResp = data1.aaData[0];
		console.log(data1.aaData[0]);
		console.log(dataResp[1]);


	
	$("#txtAAHH").val(dataResp[0]);
	$("#txtNombrePresidenta").val(dataResp[1]);
	$("#txtDni").val(dataResp[2]);
	$("#txtDireccion").val(dataResp[3]);
	$("#txtResponsableCocina").val(dataResp[4]);
	
	
	});
}


init();