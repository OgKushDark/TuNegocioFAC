var tabla;

//Función que se ejecuta al inicio
function init(){
	listar();

	$("#getCodeModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#fecha_inicio").change(listar);
	$("#fecha_fin").change(listar);
	$("#estado").change(listar);

    $('#navCuentasPorCobrar').addClass("treeview active");
}

//Función limpiar
function limpiar()
{
	$("#montoPagar").val("");
	$("#observacion").val("");
}

//Función Listar
function listar()
{

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var estado = $("#estado").val();

	tabla=$('#tbllistadocuentasxcobrar').dataTable(
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
					url: '../controladores/cuentascobrar.php?op=listar',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin,estado: estado},
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

function guardaryeditar(e)
{
	
	e.preventDefault();

	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controladores/cuentascobrar.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Abono Registrado Correctamente',
				  type: 'success',
					text:datos
				});
              $('#getCodeModal').modal('hide');

              listar();


	    }

	});
	limpiar();
}

function mostrar(idcpc){
	$("#getCodeModal").modal('show');
	$.post("../controladores/cuentascobrar.php?op=mostrar",{idcpc : idcpc}, function(data,status)
		{

			data=JSON.parse(data);

			var label=document.querySelector('#documento');
			label.textContent=data.tipo_comprobante + " : " + data.serie_comprobante + " - " + data.num_comprobante;

			var label=document.querySelector('#deutaTotal');
			label.textContent=data.deudatotal;

			var label=document.querySelector('#fechavencimiento');
			label.textContent=data.fechavencimiento;

			$("#montoAdeudado").val(data.deudatotal);

			$("#idcpc").val(data.idcpc);

			$("#idventa").val(data.idventa);

			$("#fechaPago").val(data.fechavencimiento);
			

		});

}

function mostrarAbonos(idcpc){

	$("#getCodeModal2").modal('show');

	$.post("../controladores/cuentascobrar.php?op=mostrar",{idcpc : idcpc}, function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#abonoTotal2');
		label.textContent=data.deuda;

		var label=document.querySelector('#abonoTotal');
		label.textContent=data.abonototal;

	});

	tabla=$('#tbllistado').dataTable(
	{
		//"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
		buttons: [		        
		            'excelHtml5',
		            'pdf'
		        ],
		"ajax":
				{
					url: '../controladores/cuentascobrar.php?op=listarDetalle',
					data:{idcpc: idcpc},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	}).DataTable();

}

init();
