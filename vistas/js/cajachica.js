var tabla;

// window.onload = function()
// {
// 	mostrarCaja();
// 	calcularTotalEnCaja();
// 	calcularTotales();

// }

//Función que se ejecuta al inicio
function init(){

	listar();
	mostrarCaja();
	calcularTotalEnCaja();
	calcularTotales();

	$("#myModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	});

	$("#fecha_inicio").change(mostrarCaja);
	$("#fecha_fin").change(mostrarCaja);

    $('#navCajaChica').addClass("treeview active");

}

function limpiar(){

	$('#egresos').prop("checked", true);

	$('#montoPagar').val('0');
	$('#descripcion').val('');

}

function mostrar(idmovimiento)
{

	$("#myModal").modal('show');

	$.post("../controladores/cajachica.php?op=mostrar",{idmovimiento : idmovimiento}, function(data, status)
	{
		data = JSON.parse(data);

		if (data.tipo == 'Egresos') {

			$('#egresos').prop("checked", true);

		} else {

			$('#ingresos').prop("checked", true);

		}

		$('#montoPagar').val(data.monto);
		$('#descripcion').val(data.descripcion);
 		$("#idmovimiento").val(data.idmovimiento);

 	})
}

function listar()
{

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();

	tabla=$('#tbllistado').dataTable(
	{
		//"lengthMenu": [ 5, 10, 25, 75, 100],//mostramos el menú de registros a revisar
		"aProcessing": true,//Activamos el procesamiento del datatables
	    "aServerSide": true,//Paginación y filtrado realizados por el servidor
	    dom: 'Bfrtip',//Definimos los elementos del control de tabla
	    "processing": true,
	    "language": 
		{          
		"processing": "<img style='width:80px; height:80px;' src='../files/plantilla/loading-page.gif' />",
		},
		lengthMenu: [
            [5,10, 25, 50, 100, -1],
            ['5 filas','10 filas', '25 filas', '50 filas','100 filas', 'Mostrar todo']
        ],
        buttons: ['pageLength','copy','excel', 'pdf'],
		"ajax":
				{
					url: '../controladores/cajachica.php?op=listar',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin},
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
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

	$.ajax({
		url: "../controladores/cajachica.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'Movimiento',
				  type: 'success',
					text:datos
				});
              $('#myModal').modal('hide');

	          listar();

	          mostrarCaja();


	    }

	});
	limpiar();
}

function eliminar(idmovimiento)
{
	swal({
	    title: "Eliminar?",
	    text: "¿Está seguro Que Desea Eliminar el Movimiento?",
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
				$.post("../controladores/cajachica.php?op=eliminar", {idmovimiento : idmovimiento}, function(e){
					swal(
						'!!! Eliminado !!!',e,'success')
            tabla.ajax.reload();
    	});
	    }else {
	    swal("! Cancelado ¡", "Se Cancelo la eliminación del Movimiento", "error");
		 }
		});
}

function mostrarCaja(){
	limpiar();
	$("#getCodeModal").modal('show');

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();

	$.post("../controladores/consultas.php?op=mostrarTotalBoletasCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#boletas');
		label.textContent=data.total_venta;
			

	});

	$.post("../controladores/consultas.php?op=mostrarTotalBoletasTCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#boletasT');
		label.textContent=data.total_venta;	

	});

	$.post("../controladores/consultas.php?op=mostrarTotalFacturasCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#facturas');
		label.textContent=data.total_venta;
			

	});

	$.post("../controladores/consultas.php?op=mostrarTotalFacturasTCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#facturasT');
		label.textContent=data.total_venta;	

	});

	$.post("../controladores/consultas.php?op=mostrarTotalNotasVentaCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#notasVenta');
		label.textContent=data.total_venta;
			

	});

	$.post("../controladores/consultas.php?op=mostrarTotalNotasVentaTCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#notasVentaT');
		label.textContent=data.total_venta;	

	});

	$.post("../controladores/consultas.php?op=mostrarTotalCuentasCobrarVentaCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		var label=document.querySelector('#cuentasCobrar');
		label.textContent=data.total_venta;
			

	});

	$.post("../controladores/consultas.php?op=mostrarTotalCuentasCobrarVentaTCaja",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#cuentasCobrarT');
		label.textContent=data.total_venta;	

	});

	$.post("../controladores/consultas.php?op=mostrarTotalEfectivo",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#totalEfectivo');
		label.textContent=data.total_venta;	

	});

	$.post("../controladores/consultas.php?op=mostrarTotalTransferencia",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#totalTransferencia');
		label.textContent=data.total_venta;	

		calcularTotales();

	});

	$.post("../controladores/consultas.php?op=mostrarTotalIngresos",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#totalI');
		label.textContent=data.totalIngresos;

	});

	$.post("../controladores/consultas.php?op=mostrarTotalEgresos",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);
		
		var label=document.querySelector('#totalE');
		label.textContent=data.totalEgresos;

		calcularTotalEnCaja();



	});


	$.post("../controladores/consultas.php?op=totalFacturas",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		if(data.totalcuentaventa != 0){

			var label=document.querySelector('#boleta_total_documentos_fac');
			label.textContent=data.totalcuentaventa;

		}else{
			var label=document.querySelector('#boleta_total_documentos_fac');
			label.textContent=null;
		}

	});

	$.post("../controladores/consultas.php?op=totalBoletas",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		if(data.totalcuentaventa != 0){

			var label=document.querySelector('#boleta_total_documentos_bol');
			label.textContent=data.totalcuentaventa;

		}else{
			var label=document.querySelector('#boleta_total_documentos_bol');
			label.textContent=null;
		}

	});

	$.post("../controladores/consultas.php?op=totalNotas",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		if(data.totalcuentaventa != 0){

			var label=document.querySelector('#boleta_total_documentos_not');
			label.textContent=data.totalcuentaventa;

		}else{
			var label=document.querySelector('#boleta_total_documentos_not');
			label.textContent=null;
		}

	});

	$.post("../controladores/consultas.php?op=totalCuentas",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin}, function(data,status)
	{

		data=JSON.parse(data);

		if(data.totalcuentacobrar != 0){

			var label=document.querySelector('#boleta_total_documentos_cuentas');
			label.textContent=data.totalcuentacobrar;

		}else{
			var label=document.querySelector('#boleta_total_documentos_cuentas');
			label.textContent=null;
		}

	});

	listar();

}

function calcularTotalEnCaja(){

	let SubTotal = document.getElementById("totalT").innerHTML;

	let TotalI = document.getElementById("totalI").innerHTML;

	let TotalE = document.getElementById("totalE").innerHTML;

	let TotalF;

	TotalF = Number(SubTotal) + Number(TotalI) - Number(TotalE);

	var labelTotalEnCaja=document.querySelector('#totalEC');
	labelTotalEnCaja.textContent=TotalF.toFixed(2);

	if (SubTotal == 0.00 && TotalI == 0.00 && totalE == 0.00) {

		let c = 0;

		labelTotalEnCaja.textContent=c.toFixed(2);

	}

}

function calcularTotales(){

	let TotalFacturas = document.getElementById("facturas").innerHTML;

	let TotalFacturasT = document.getElementById("facturasT").innerHTML;

	let TotalF;

	TotalF = Number(TotalFacturas) + Number(TotalFacturasT);

	var labelTotalFacturas=document.querySelector('#totalF');
	labelTotalFacturas.textContent=TotalF.toFixed(2);

	if (TotalFacturas == 0.00 && TotalFacturasT == 0.00) {

		let c = 0;

		labelTotalFacturas.textContent=c.toFixed(2);

	}


	let TotalBoletas = document.getElementById("boletas").innerHTML;

	let TotalBoletasT = document.getElementById("boletasT").innerHTML;

	let TotalB;

	TotalB = Number(TotalBoletas) + Number(TotalBoletasT);

	var labelTotalBoletas=document.querySelector('#totalB');
	labelTotalBoletas.textContent=TotalB.toFixed(2);

	if (TotalBoletas == 0.00 && TotalBoletasT == 0.00) {

		let c = 0;

		labelTotalBoletas.textContent=c.toFixed(2);

	}


	let TotalNotas = document.getElementById("notasVenta").innerHTML;

	let TotalNotasT = document.getElementById("notasVentaT").innerHTML;

	let TotalN;

	TotalN = Number(TotalNotas) + Number(TotalNotasT);

	var labelTotalNotas=document.querySelector('#totalNotas');
	labelTotalNotas.textContent=TotalN.toFixed(2);

	if (TotalNotas == 0.00 && TotalNotasT == 0.00) {

		let c = 0;

		labelTotalNotas.textContent=c.toFixed(2);

	}


	let TotalCuentasCobrar = document.getElementById("cuentasCobrar").innerHTML;

	let TotalCuentasCobrarT = document.getElementById("cuentasCobrarT").innerHTML;

	let TotalCuentasC = 0;

	TotalCuentasC = Number(TotalCuentasCobrar) + Number(TotalCuentasCobrarT);

	var labelCuentasCobrar=document.querySelector('#totalCuentasCobrar');
	labelCuentasCobrar.textContent=TotalCuentasC.toFixed(2);

	if (TotalCuentasCobrar == 0.00 && TotalCuentasCobrarT == 0.00) {

		let c = 0;

		labelCuentasCobrar.textContent=c.toFixed(2);

	}


	let TotalEfectivo = document.getElementById("totalEfectivo").innerHTML;

	let TotalEfectivoT = document.getElementById("totalTransferencia").innerHTML;

	let Total = 0;

	Total = Number(TotalEfectivo) + Number(TotalEfectivoT);

	var label=document.querySelector('#totalT');
	label.textContent=Total.toFixed(2);

	if (TotalEfectivo == 0.00 && TotalEfectivoT == 0.00) {

		let c = 0;

		label.textContent=c.toFixed(2);

	}




}

init();