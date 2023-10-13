 var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrar_impuesto();
	mostrarform(false);
	listar();

	$("#formulario").on("submit",function(e)
	{
		guardaryeditar(e);	
	});
	//Cargamos los items al select proveedor
	$.post("../controladores/compra.php?op=selectProveedor", function(r){
	            $("#idproveedor").html(r);
	            $('#idproveedor').selectpicker('refresh');
	});
	$('#navCompras').addClass("treeview active");
    $('#navCompra').addClass("active");
}

//Función limpiar
function limpiar()
{
	$("#idproveedor").val("");
	$("#idproveedor").selectpicker('refresh');
	$("#proveedor").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");
	articuloAdd="";
	no_aplica=18;

	$("#total_compra").val("");
	$(".filas").remove();
	$("#total").html("0");

	$("#most_total").html("0");
	$("#most_imp").html("0");

	//Obtenemos la fecha actual
	var now = new Date();
	var day = ("0" + now.getDate()).slice(-2);
	var month = ("0" + (now.getMonth() + 1)).slice(-2);
	var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    $('#fecha').val(today);

    //Marcamos el primer tipo_documento
    $("#tipo_comprobante").val("Boleta");
	$("#tipo_comprobante").selectpicker('refresh');
}

//Función mostrar formulario
function mostrarform(flag)
{
	limpiar();
	if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();

	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
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
					url: '../controladores/compra.php?op=listar',
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
		url: "../controladores/compra.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'compra',
				  type: 'success',
					text:datos
				});	          
	          mostrarform(false);
	          listar();
	    }

	});
	limpiar();
}

//muestra datos de la tabla y del detalle de la tabla
function mostrar(idcompra)
{
	$("#getCodeModal").modal('show');
	$.post("../controladores/compra.php?op=mostrar",{idcompra : idcompra}, function(data, status)
	{
		data = JSON.parse(data);		
		//mostrarform(true);

		$("#idproveedorm").val(data.proveedor);
		$("#tipo_comprobantem").val(data.tipo_comprobante);
		$("#serie_comprobantem").val(data.serie_comprobante);
		$("#num_comprobantem").val(data.num_comprobante);
		$("#fecha_horam").val(data.fecha);
		$("#impuestom").val(data.impuesto);
		$("#idingresom").val(data.idingreso);


 	});
	//enviar mediante get listar detalle a la varible op de ajax
 	$.post("../controladores/compra.php?op=listarDetalle&id="+idcompra,function(r){
	        $("#detallesm").html(r);
	});
}

//Función para anular registros
function anular(idcompra)
{
	swal({
						    title: "¿Anular?",
						    text: "¿Está seguro Que Desea anular la Compra?",
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
									$.post("../controladores/compra.php?op=anular", {idcompra : idcompra}, function(e){
										swal(
											'!!! Anulado !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la anulación de la Compra", "error");
							 }
							});
}

function listarArticulos(){
	tabla=$('#tblarticulos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax":
		{
			url:'../controladores/compra.php?op=listarArticulos',
			type: "get",
			dataType : "json",
			error:function(e){
				console.log(e.responseText);
			}
		},
		"bDestroy":true,
		"iDisplayLength":5,//paginacion
		"order":[[0,"desc"]]//ordenar (columna, orden)
	}).DataTable();
}

var articuloAdd="";
//para contar cuantos detalles le agregamos a la compra
var cont=0;
//cantidad de detalles que tiene la compra
var detalles=0;

function mostrar_impuesto(){

	$.ajax({
		url: '../controladores/negocio.php?op=mostrar_impuesto',
		type:'get',
		dataType:'json',
		success: function(i){

			 impuesto=i;

			 $("#impuesto").val(impuesto);

		}

	});

}

var no_aplica=0;

$("#btnguardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);

function marcarImpuesto()
  {
  	//lo que seleccionemos en el select estara guardado en esta variable
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
  	if (tipo_comprobante=='Factura') {
  		mostrar_impuesto();
        no_aplica=impuesto;
	}else if(tipo_comprobante=='Boleta'){
		mostrar_impuesto();
        no_aplica=impuesto;
	}
	else{
		$("#impuesto").val("0");
        no_aplica=0;	}
  }

  function agregarDetalle(idproducto,producto,precioVenta,precioCompra,unidadmedida)
  {
  	//aquí preguntamos si el idarticulo ya fue agregado
    if(articuloAdd.indexOf(idproducto)!= -1)
    { //reporta -1 cuando no existe
     	swal( producto +" ya se agrego");
    }
    else
    {
  	var cantidad=1;
    var precio_compra=1;
    var precio_venta=1;

    if (idproducto!="")
    {
    	var subtotal=cantidad*precio_compra;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><input style="text-align:center" type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td>'+
        '<td><input style="text-align:center" type="hidden">'+unidadmedida+'</td>'+
        '<td><input style="text-align:center" type="number" onchange="modificarSubtotales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input style="text-align:center" type="number" step="0.01" onchange="modificarSubtotales()" name="precio_compra[]" id="precio_compra[]" value="'+precioCompra+'"></td>'+
        '<td><input style="text-align:center" type="number" step="0.01" name="precio_venta[]" value="'+precioVenta+'"></td>'+
        '<td><spans id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
        '<td><center><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash"></i></button></center></td>'+
		'</tr>';
    	cont++;
    	detalles=detalles+1;
    	articuloAdd= articuloAdd + idproducto + "-"; //aca concatemanos los idarticulos xvg: 1-2-5-12-20
    	//agregar fila a la tabla
    	$('#detalles').append(fila);
    	modificarSubtotales();
    }
    else
    {
    	swal("Error al ingresar el detalle, revisar los datos del producto");
    }
	}
  }

  function modificarSubtotales()
  {
  	//tres array para almacenar las cantidades, precios de compra y subtotales
  	//leer del documento
  	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_compra[]");
    var sub = document.getElementsByName("subtotal");
    //recorrer los detalles y calcular los subtotales
    //recorrer hasta la cantidad de indices que tiene cant
    for (var i = 0; i <cant.length; i++) {
    	var inpC=cant[i];
    	var inpP=prec[i];
    	var inpS=sub[i];

    	inpS.value=inpC.value * inpP.value;
    	document.getElementsByName("subtotal")[i].innerHTML = inpS.value;
    }
    //Permitir calcular los totales en base a los subtotales
    calcularTotales();

  }
  function calcularTotales(){
  	var sub = document.getElementsByName("subtotal");
  	var total=0.0;
  	var total_monto=0.0;
  	var igv_dec =0.0;

  	//ejecutar el for tanto subtotales tenga
  	for (var i = 0; i <sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
		var igv=total*(no_aplica)/(no_aplica+100);
		var total_monto=(total-(igv)).toFixed(2);
		var igv_dec=igv.toFixed(2);
			
	}
	//mostrar total
	$("#total").html("S/. " + total.toFixed(2));
    $("#total_compra").val(total.toFixed(2));
	$("#most_total").html(total_monto);
	$("#most_imp").html(igv_dec);
    //permite mostrar los botones de guardar si tenemos almenos un detalle 
    evaluar();
  }

  function evaluar(){
  	//si los detalles son mayores que 0 mostrar boton guardar
  	if (detalles>0)
    {
      $("#btnGuardar").show();
    }
    else
    {
      $("#btnGuardar").hide(); 
      cont=0;
    }
  }
  //funcion que espera el id de la fila a eliminar
  function eliminarDetalle(indice){
  	//id fila mas el indice
  	$("#fila" + indice).remove();
  	calcularTotales();
  	detalles=detalles-1;
  	evaluar();
  	articuloAdd="";
  }



init();