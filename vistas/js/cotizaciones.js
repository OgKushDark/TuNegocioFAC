var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();
   numTicket();

   origin = window.location.origin

   pathName = window.location.pathname
   arrPath = pathName.split("/")
   lastPath = arrPath[arrPath.length - 3]

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

   $("#formularioClientes").on("submit",function(e){
   	guardarCliente(e);
   });

   $("#formularioProductos").on("submit",function(e){
   	guardarProducto(e);
   });

   //cargamos los items al select cliente
   $.post("../controladores/venta.php?op=selectCliente", function(r){
   	$("#idcliente").html(r);
   	$('#idcliente').selectpicker('refresh');
   });

   //cargamos los items al celect comprobantes
   $.post("../controladores/cotizaciones.php?op=selectComprobante", function(c){ 
   	$("#tipo_comprobante").html(c);
   	$("#tipo_comprobante").selectpicker('refresh');
   });

	$('#navVentasV').addClass("treeview active");
    $('#navCotizacionesLi').addClass("active");

    //Cargamos los items al select categoria
	$.post("../controladores/producto.php?op=selectCategoria", function(r){
		
	    $("#idcategoria").html(r);
	    $('#idcategoria').selectpicker('refresh');

	});

	$("#imagenmuestra").show();
	$("#imagenmuestra").attr("src","../files/productos/anonymous.png");
	$("#imagenactual").val("anonymous.png");

    $('form').keypress(function(e){   
	    if(e == 13){
	      return false;
	    }
	  });

	  $('input').keypress(function(e){
	    if(e.which == 13){
	      return false;
	    }
	  });

}

//funcion limpiar
function limpiar(){

	$("#idventa").val("");
	$("#idcliente").val("");
	$("#cliente").val("");
	$("#serie_comprobante").val("");
	$("#num_comprobante").val("");

	articuloAdd="";
	no_aplica=18;

	$("#total_venta").val("");
	$(".filas").remove();
	$("#total").html("0");

	$("#most_total").html("0");
	$("#most_imp").html("0");

	//obtenemos la fecha actual
	var now = new Date();
	var day =("0"+now.getDate()).slice(-2);
	var month=("0"+(now.getMonth()+1)).slice(-2);
	var today=now.getFullYear()+"-"+(month)+"-"+(day);
	$("#fecha").val(today);

	$("#tipo_comprobante").val('Cotización');

	$("#tipo_comprobante").selectpicker('refresh');


}

//Función limpiar
function limpiarCliente()
{
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#fecha_hora").val("");
	$("#idpersona").val("");
}

//Función limpiar
function limpiarProducto()
{
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#precio").val("");
	$("#fecha").val("");
	$("#fecha_hora").val("");
	$("#imagenmuestra").attr("src","../files/productos/anonymous.png");
	$("#imagenactual").val("anonymous.png");
	$("#print").hide();
	$("#idproducto").val("");
	$("#modelo").val("");
	$("#nserie").val("");
}

function BuscarCliente(){

  if ($('#tipo_documento').val()=='DNI'){
    var cod = $.trim($('#tipo_documento').val());
    $numero=$("#num_documento").val();
    if($numero.length<8)
    {
      	swal({
		  title: 'Falta Números en el DNI',
		  type: 'error',
			text:'El DNI debe tener 8 Carácteres'
		});	
    }else{
    	$('#Buscar_Cliente').addClass('hide');
    	var numdni=$('#num_documento').val();
        var url = 'https://www.buqkly.com/api/consultadni/'+numdni+'?';
    	$('#cargando').removeClass('hide');
    	$.ajax({
            type:'GET',
            url:url,
            success: function(dat){
              	if(dat.success[1] == false){

      	            swal({
					  title: 'DNI Inválido',
					  type: 'error',
						text:'¡No Existe DNI!'
					});
                  
                    }else{
                        $('#nombre').val(dat.success[0]);
                        $('#Buscar_Cliente').removeClass('show');
                        $('#cargando').addClass('hide');
                  }
                }, complete: function(){

                	$('#Buscar_Cliente').removeClass('hide');
                	$('#cargando').addClass('hide');
                	
                }, error: function(){
                	
                }
        });
      }

  	}else{
    	var cod = $.trim($('#tipo_documento').val());
        $numero=$("#num_documento").val();
        if($numero.length<11){
            swal({
			  title: 'Falta Números en el RUC',
			  type: 'error',
				text:'El DNI debe tener 11 Carácteres'
			});
        }else{
    		$('#Buscar_Cliente').addClass('hide');          
            var numdni=$('#num_documento').val();
            var url = 'https://www.buqkly.com/api/consultaruc/'+numdni+'?';
    		$('#cargando').removeClass('hide');
            $.ajax({
	            type:'GET',
	            url:url,
	            success: function(dat){
	                if(dat.success[1] == null){
	                    swal({
						  title: 'Ruc Inválido',
						  type: 'error',
							text:'¡No Existe RUC!'
						});
	                }else{
	                    $('#nombre').val(dat.success[1]);
	                    $('#direccion').val(dat.success[2]);
	                    $('#Buscar_Cliente').removeClass('show');
                        $('#cargando').addClass('hide');         
	        		}
	            }, complete: function(){

                	$('#Buscar_Cliente').removeClass('hide');
                	$('#cargando').addClass('hide');
	            	
	            }, error: function(){
	            	
	            }            
            });
        }
  	}

}

//__________________________________________________________________________

	//mostramos el num_comprobante del ticket
	function numTicket(){
	$.ajax({
	url: '../controladores/cotizaciones.php?op=mostrar_num_ticket',
	type:'get',
	dataType:'json',
	success: function(d){
			 iva=d;
			 console.log("iva", iva);
	$("#num_comprobante").val( ('0000000' + iva).slice(-7) ); // "0001"
	$("#nFacturas").html( ('0000000' + iva).slice(-7) ); // "0001"
	}
		});}
	//mostramos la serie_comprobante de la ticket
	function numSerieTicket(){
	$.ajax({
	url: '../controladores/cotizaciones.php?op=mostrar_s_ticket',
	type:'get',
	dataType:'json',
	success: function(s){
		 series=s;
	$("#numeros").html( ('000' + series).slice(-3) ); // "0001"
	$("#serie_comprobante").val( ('000' + series).slice(-3) ); // "0001"
	}

	});}
//_______________________________________________________________________________________________

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	numTicket();
	numSerieTicket();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		//$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnGuardar").hide();
		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt1").show();


	}else{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").show();
	}
}

//cancelar form
function cancelarform(){
	limpiar();
	mostrarform(false);
}

//funcion listar
function listar(){
	tabla=$('#tbllistado').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		"processing": true,
		"language": 
		{          
		"processing": "<img style='width:80px; height:80px;' src='../files/plantilla/loading-page.gif' />",
		},
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		lengthMenu: [
            [5,10, 25, 50, 100, -1],
            ['5 filas','10 filas', '25 filas', '50 filas','100 filas', 'Mostrar todo']
        ],
        buttons: ['pageLength','copy','excel', 'pdf'],
		"ajax":
		{
			url:'../controladores/cotizaciones.php?op=listar',
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

function listarArticulos(){
	tabla=$('#tblarticulos').dataTable({
		"aProcessing": true,//activamos el procedimiento del datatable
		"aServerSide": true,//paginacion y filrado realizados por el server
		dom: 'Bfrtip',//definimos los elementos del control de la tabla
		buttons: [

		],
		"ajax":
		{
			url:'../controladores/cotizaciones.php?op=listarArticulos',
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
//funcion para guardaryeditar
function guardaryeditar(e){
     e.preventDefault();//no se activara la accion predeterminada 
     //$("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../controladores/cotizaciones.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		swal({
				  title: 'Cotización',
				  type: 'success',
					text:datos
				});
     		mostrarform(false);
     		listar();
     	}
     });

     limpiar();
}

//funcion para Guardar Clientes
function guardarCliente(e){
     e.preventDefault();//no se activara la accion predeterminada 
     //$("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formularioClientes")[0]);

     $.ajax({
     	url: "../controladores/cotizaciones.php?op=guardarCliente",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		swal({
				  title: 'Cliente',
				  type: 'success',
					text:datos
				});
     		//cargamos los items al select cliente
		   $.post("../controladores/venta.php?op=selectCliente", function(r){
		   	$("#idcliente").html(r);
		   	$('#idcliente').selectpicker('refresh');
		   });
     	}
     });

     $("#ModalClientes").modal('hide');

     limpiarCliente();
}

//Función para guardar o editar

function guardarProducto(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formularioProductos")[0]);

	$.ajax({
		url: "../controladores/producto.php?op=guardaryeditar",
	    type: "POST",
	    data: formData,
	    contentType: false,
	    processData: false,

	    success: function(datos)
	    {                    
	          swal({
				  title: 'producto',
				  type: 'success',
					text:datos
				});
              $('#agregarProducto').modal('hide');
			  listarArticulos();
	    }

	});
	limpiarProducto();
}

function mostrar(idcotizacion){
	$("#getCodeModal").modal('show');
	$.post("../controladores/cotizaciones.php?op=mostrar",{idcotizacion : idcotizacion}, function(data,status)
		{
			data=JSON.parse(data);
			//mostrarform(true);

			$("#cliente").val(data.cliente);
			$("#tipo_comprobantem").val(data.tipo_comprobante);
			$("#serie_comprobantem").val(data.serie_comprobante);
			$("#num_comprobantem").val(data.num_comprobante);
			$("#fecha_horam").val(data.fecha);
			$("#impuestom").val(data.impuesto);
			$("#formapagom").val(data.formapago);
			$("#nrooperacionm").val(data.numoperacion);
			$("#fechadeposito").val(data.fechadeposito);
			$("#idventam").val(data.idventa);
		});
		
		$.post("../controladores/cotizaciones.php?op=listarDetalle&id="+idcotizacion,function(r){
		$("#detallesm").html(r);


	});

}

function mostrarE(idcotizacion){
	$.post("../controladores/cotizaciones.php?op=mostrar",{idcotizacion : idcotizacion}, function(data,status)
		{
			data=JSON.parse(data);
			
			$("#listadoregistros").hide();
			$("#formularioregistros").show();
			listarArticulos();

			$('#nuevoVendedor').val(data.personal);
			$('#idcliente').val(data.idcliente);
			$('#idcliente').selectpicker('refresh');
			$('#fecha_hora').val(data.fecha);
			// $('#serie_comprobante').val(data.serie_comprobante);
			// $('#num_comprobante').val(data.num_comprobante);
			$('#tipo_comprobante').val(data.tipo_comprobante);
			$('#tipo_comprobante').selectpicker('refresh');


		});
		
		$.post("../controladores/cotizaciones.php?op=listarDetalleCotizacion",{idcotizacion : idcotizacion}, function(data,status)
		{
			data=JSON.parse(data);
			console.log("data", data);

			for(var i=0; i < data.length; i++){

				agregarDetalle(data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],0.00,0.00,0.00,data[i][5],data[i][6],data[i][7])

			}

		});

}



function Enviar(idventa){
		
		$.post("../controladores/venta.php?op=mostrardetalle&id="+idventa,function(r){
			window.open("https://api.whatsapp.com/send?phone=51952761400&text="+r+"");
		});

}

function EnviarComprobante(idcotizacion){
		
		$.post("../controladores/cotizaciones.php?op=mostrar",{idcotizacion : idcotizacion}, function(data,status){
			data=JSON.parse(data);

			window.open("https://api.whatsapp.com/send?phone=51"+data.telefono+"&text="+origin+'/'+lastPath+"/reportes/documentos/Cotizacion-"+data.num_comprobante+".pdf");

		});

}


//funcion para desactivar
function anular(idventa){
	swal({
						    title: "¿Anular?",
						    text: "¿Está seguro Que Desea anular la Venta?",
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
									$.post("../controladores/venta.php?op=anular", {idventa : idventa}, function(e){
										swal(
											'!!! Anulado !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la anulación de la Venta", "error");
							 }
							});
}

var articuloAdd="";
//declaramos variables necesarias para trabajar con las compras y sus detalles
var cont=0;
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

$("#btnGuardar").hide();
$("#tipo_comprobante").change(marcarImpuesto);


function marcarImpuesto()
  {
  	var tipo_comprobante=$("#tipo_comprobante option:selected").text();
    if (tipo_comprobante=='Factura') {
		// $("#impuesto").val(impuesto);
		mostrar_impuesto(); 
        no_aplica=impuesto;
        numFactura();
		numSerie();
	}else if(tipo_comprobante=='Boleta'){
		// $("#impuesto").val(impuesto);
		mostrar_impuesto();
        no_aplica=impuesto;
        numBoleta();
		numSerieBoleta();
	}
	else{
		$("#impuesto").val("0");
        no_aplica=0;
        numTicket();
		numSerieTicket();
	}
  }

  // Buscar producto por código
function buscarProductoCod(e, codigo)
{

	if (e.keyCode === 13) {

		if (codigo.length > 0) {

			$.post("../controladores/venta.php?op=buscarProducto",{codigo : codigo}, function(data,status)
			{

				data=JSON.parse(data);

				if(data == null){
					alert("Producto no encontrado");
				}else{

					agregarDetalle(data.idproducto, data.nombre, 1, 0, data.precio, data.precioB, data.precioC, data.precioD, data.stock, data.unidadmedida);

				}

				$("#idCodigoBarra").val("");		

			});

		}

	}

}

function agregarDetalle(idproducto,producto,cant,desc,precio_venta,precioB,precioC,precioD,stock,unidadmedida){

	//aquí preguntamos si el idarticulo ya fue agregado
    if(articuloAdd.indexOf(idproducto)!= -1)
    { //reporta -1 cuando no existe
     // swal( producto +" ya se agrego");

     let cant = document.getElementsByName("cantidad[]");

     let id = document.getElementsByName("idproducto[]");

     for (var i = 0; i < cant.length; i++) {

     	if(id[i].value == idproducto){
     		console.log("id[i].value: ", id[i].value);

     		let total = Number(cant[i].value) + 1;

     		document.getElementsByName("cantidad[]")[i].value=total;

     		modificarSubtotales();

     	}

     }

    }
    else
    {

	var cantidad=cant;
	var descuento=desc;

	var cad = '';
	var select = '';

	if(precioB != '0.00' || precioC != '0.00' || precioD != '0.00'){

		cad = '<option value="'+precio_venta+'">'+precio_venta+'</option>';

		if(precioB!='0.00'){
			cad = cad + '<option value="'+precioB+'">B - '+precioB+'</option>';
		}

		if(precioC!='0.00'){
			cad = cad + '<option value="'+precioC+'">C - '+precioC+'</option>';
		}

		if(precioD!='0.00'){
			cad = cad + '<option value="'+precioD+'">D - '+precioD+'</option>';
		}

		select = '<td><select style="width:140px;height:28px;" oninput="modificarSubtotales()" name="precio_venta[]" id="precio_venta[]" class="form-control" required>'+cad+'</select></td>';

	}else{

		select = '<td><input style="text-align:center; width: 80px;" type="number" step="0.01" oninput="modificarSubtotales()" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>';

	}

	if (idproducto!="") {
		var subtotal=cantidad*precio_venta;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><input style="text-align:center" type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td>'+
        '<td><input style="text-align:center" type="hidden">'+unidadmedida+'</td>'+
        '<td><input style="text-align:center" type="number" min="1" step="1" oninput="modificarSubtotales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
		select+
        '<td><input style="text-align:center" type="number" step="0.01" oninput="modificarSubtotales()" name="descuento[]" value="'+descuento+'"></td>'+    
        '<td><input style="text-align:center" type="text" readonly="readonly" name="stock[]" value="'+stock+'"></td>'+
        '<td><span style="text-align:center" id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
        '<td><center><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash"></i></button></center></td>'+
		'</tr>';
		cont++;
		detalles=detalles+1;
		articuloAdd= articuloAdd + idproducto + "-"; //aca concatemanos los idarticulos xvg: 1-2-5-12-20
		$('#detalles1').append(fila);
		modificarSubtotales();

	}else{
		alert("error al ingresar el detalle, revisar las datos del articulo ");
	}
	}
}

function nostock(){
  	swal("Sin Stock");
  }

function modificarSubtotales(e)
{
	var cant = document.getElementsByName("cantidad[]");
    var prec = document.getElementsByName("precio_venta[]");
    var desc = document.getElementsByName("descuento[]");
    var sub = document.getElementsByName("subtotal");
    var Stoc =document.getElementsByName("stock[]");


	for (var i = 0; i < cant.length; i++) {
		var inpC=cant[i];
    	var inpP=prec[i];
    	var inpD=desc[i];
    	var inpS=sub[i];
        var inpSt=Stoc[i];


		var subtl =inpS.value=(inpC.value * inpP.value)-inpD.value;
        var subfinal= subtl.toFixed(2);
		document.getElementsByName("subtotal")[i].innerHTML=subfinal;
		
	}

	calcularTotales();
}

function calcularTotales(){

	var sub = document.getElementsByName("subtotal");
	var total=0.0;
  	var total_monto=0.0;
  	var igv_dec =0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;
		var igv=total*(no_aplica)/(no_aplica+100);
		var total_monto=(total-(igv)).toFixed(2);
		var igv_dec=igv.toFixed(2);

	}

	$.ajax({
	url: '../controladores/negocio.php?op=mostrar_simbolo',
	type:'get',
	dataType:'json',
	success: function(sim){

		simbolo=sim;

		$("#total").html(simbolo + total.toFixed(2));
		$("#total_venta").val(total.toFixed(2));
		$("#most_total2").val(total.toFixed(2));
		$("#most_total").html(total.toFixed(2));

		$("#montoDeuda").val(total);

		$("#most_imp").html(igv_dec);
		evaluar();


		}

	});
	
}

$("#formapago").change(function(){

	if($("#formapago").val() == "Efectivo"){

		document.getElementById("n1").style.display = "none";
		document.getElementById("f1").style.display = "none";

		$("#n1").hide();
		$("#n1").hide();

	}else{

		$('#n1').show();
		$('#f1').show();

	}

});

$("#tipopago").change(function(){

	if($("#tipopago").val() == "Si"){

		document.getElementById("formapagoocultar").style.display = "none";

		$("#formapagoocultar").hide();

		$('#fp1').show();

		$('#nd1').show();

		$('#fp2').show();

		document.getElementById("n1").style.display = "none";
		document.getElementById("f1").style.display = "none";

		$("#n1").hide();
		$("#n1").hide();

	}else{

		$("#formapagoocultar").show();

		document.getElementById("fp1").style.display = "none";

		document.getElementById("nd1").style.display = "none";

		document.getElementById("fp2").style.display = "none";

		$('#fp1').hide();

		$('#nd1').hide();

		$('#fp2').hide();

	}

});

function calcularPorcentaje(){

	total=$("#most_total2").val();

	porcentaje=$("#porcentaje").val();

	// tp= porcentaje / 100;

	// tp1 = total - (total * tp);

	tp1 = total - porcentaje;

	$("#total").html("$/. " + tp1.toFixed(2));

	$("#total_venta").val(tp1.toFixed(2));

	$("#montoDeuda").val(tp1.toFixed(2));

	if(porcentaje=='0'){

		calcularTotales();

	}
	
}

function calcularVuelto(){

	let totalrecibido = $('#totalrecibido').val();

	let total = $('#total_venta').val();

		let vuelto = totalrecibido - total;

		if (vuelto > 0) {

		$('#vuelto').val(vuelto);	

		}else{

			$('#vuelto').val("0.00");

		}

}

function evaluar(){

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

function eliminarDetalle(indice){
$("#fila"+indice).remove();
calcularTotales();
detalles=detalles-1;
evaluar();
articuloAdd="";
}

//función para generar el código de barras
function generarbarcode()
{
	codigo=$("#codigo").val();
	JsBarcode("#barcode", codigo);
	$("#print").show();
}

//Función para imprimir el Código de barras
function imprimir()
{
	$("#print").printArea();
}

//Función para eliminar registros
function eliminar(idcotizacion)
{
	swal({
	    title: "Eliminar?",
	    text: "¿Está seguro Que Desea Eliminar la Cotización?",
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
				$.post("../controladores/cotizaciones.php?op=eliminar", {idcotizacion : idcotizacion}, function(e){
					swal(
						'!!! Eliminado !!!',e,'success')
            tabla.ajax.reload();
    	});
	    }else {
	    swal("! Cancelado ¡", "Se Cancelo la eliminación de la Cotización", "error");
		 }
		});
}

init();