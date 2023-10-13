
var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrar_impuesto();
   mostrarform(false);
   listar();

   origin = window.location.origin

   pathName = window.location.pathname
   arrPath = pathName.split("/")
   lastPath = arrPath[arrPath.length - 3]

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   });

   //cargamos los items al select cliente
   $.post("../controladores/venta.php?op=selectCliente", function(r){
   	$("#idcliente").html(r);
   	$('#idcliente').selectpicker('refresh');
   });

   //cargamos los items al select comprobantes
   $.post("../controladores/venta.php?op=selectComprobante2", function(c){ 
   	$("#tipo_comprobante").html(c);
   	$("#tipo_comprobante").selectpicker('refresh');
   });

   //cargamos los items al select documentos
   CargarDocumentosReferencia();

   //cargamos los items al select motivos
   $.post("../controladores/venta.php?op=selectMotivos", function(c){ 
   	$("#idmotivo").html(c);
   	$("#idmotivo").selectpicker('refresh');
   });

   $("#fecha_inicio").change(listar);
   $("#fecha_fin").change(listar);
   $("#estado").change(listar);

	$('#navVentasV').addClass("treeview active");
    $('#navNCreditosLi').addClass("active");

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

function CargarDocumentosReferencia(){
	$.post("../controladores/venta.php?op=selectDocumentos", function(c){ 
		$("#comprobanteReferencia").html(c);
		$("#comprobanteReferencia").selectpicker('refresh');
	});
}

function EnviarSunat(tipoc,idventa, idcol){

	$url='../public/FACT_WebService/Facturacion/NotaCredito.php?idnc=';

	$.ajax({

		url: $url+idventa+'&codColab='+idcol,

		type: 'get',
			dataType: 'text',
			beforeSend: function(){

				$ ( ".modal" ) .show ();

    	},
    	success: function(resp){

	    	listar();

	    	swal({
				  title: 'SUNAT',
				  type: 'success',
					text:resp
				});

		},
            complete: function () {
                $ ( ".modal" ) .hide ();
        }

	});


}

function PDFNC(idventa,idcol){

	$url='../public/FACT_WebService/Facturacion/NotaCredito.php?idnc=';

	$.ajax({

		url: $url+idventa+'&codColab='+idcol,

		type: 'get',
			dataType: 'text',
			beforeSend: function(){

				$ ( ".modal" ) .show ();

    	},
    	success: function(resp){

	    	listar();

	    	swal({
				  title: 'SUNAT',
				  type: 'success',
					text:resp
				});

	    	window.open(origin+'/'+lastPath+'/'+'reportes/exFactura.php?id='+idventa)

		},
            complete: function () {
                $ ( ".modal" ) .hide ();
        }

	});

}

function TicketNC(idventa,idcol){

	$url='../public/FACT_WebService/Facturacion/NotaCredito.php?idnc=';

	$.ajax({

		url: $url+idventa+'&codColab='+idcol,

		type: 'get',
			dataType: 'text',
			beforeSend: function(){

				$ ( ".modal" ) .show ();

    	},
    	success: function(resp){

	    	listar();

	    	swal({
				  title: 'SUNAT',
				  type: 'success',
					text:resp
				});

	    	window.open(origin+'/'+lastPath+'/'+'reportes/exTicket.php?id='+idventa)

		},
            complete: function () {
                $ ( ".modal" ) .hide ();
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

	$("#idmotivo").val('1');
	$("#idmotivo").selectpicker('refresh');

	$("#comprobanteReferencia").val('');
	$("#comprobanteReferencia").selectpicker('refresh');

	CargarDocumentosReferencia();

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

//__________________________________________________________________________
//mostramos el num_comprobante de la boleta
function numFactura(){
	$.ajax({
		url: '../controladores/venta.php?op=mostrar_num_nc',
		type:'get',
		dataType:'json',
		success: function(d){
				 iva=d;
		$("#num_comprobante").val( ('0000000' + iva).slice(-7) ); // "0001"
		$("#nFacturas").html( ('0000000' + iva).slice(-7) ); // "0001"
	}
});}
//mostramos la serie_comprobante de la boleta
function mostrar_serie_nc(){
	$.ajax({
		url: '../controladores/venta.php?op=mostrar_serie_nc',
		type:'get',
		dataType:'json',
		success: function(s){
			 series=s;
		$("#numeros").html( ('000' + series).slice(-3) ); // "0001"
		$("#serie_comprobante").val('FN' + ('0' + series).slice(-3) ); // "0001"
	}
});}

//mostramos el num_comprobante de la boleta
function numBoleta(){
	$.ajax({
		url: '../controladores/venta.php?op=mostrar_num_ncb',
		type:'get',
		dataType:'json',
		success: function(d){
				 iva=d;
		$("#num_comprobante").val( ('0000000' + iva).slice(-7) ); // "0001"
		$("#nFacturas").html( ('0000000' + iva).slice(-7) ); // "0001"
	}
});}
//mostramos la serie_comprobante de la boleta
function mostrar_serie_ncb(){
	$.ajax({
		url: '../controladores/venta.php?op=mostrar_serie_ncb',
		type:'get',
		dataType:'json',
		success: function(s){
			 series=s;
		$("#numeros").html( ('000' + series).slice(-3) ); // "0001"
		$("#serie_comprobante").val('BN' + ('0' + series).slice(-3) ); // "0001"
	}
});}
//_______________________________________________________________________________________________

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	numFactura();
	mostrar_serie_nc();
	// $("#serie_comprobante").val( "FN01" );
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnagregar").hide();
		listarArticulos();

		$("#btnCancelar").show();
		detalles=0;
		$("#btnAgregarArt").show();


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

	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var estado = $("#estado").val();

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
			url:'../controladores/venta.php?op=listarNC',
			data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin,estado: estado},
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
			url:'../controladores/venta.php?op=listarArticulos',
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
     	url: "../controladores/venta.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		swal({
				  title: '',
				  type: 'success',
					text:datos
				});
     		mostrarform(false);
     		listar();
     	}
     });

     limpiar();
}

let idventa;

function mostrarE(){

	$("#btnGuardar").show();

	idventa=$("#comprobanteReferencia").val();

	$.post("../controladores/venta.php?op=mostrar",{idventa : idventa}, function(data,status)
		{
			data=JSON.parse(data);

			$('#nuevoVendedor').val(data.personal);
			$('#idcliente').val(data.idcliente);
			$('#idcliente').selectpicker('refresh');

	 		let num=(data.serie_comprobante).substr(0,1);

	 		if(num=="P"){

	 			$('#serie_comprobante').val("-");
	 			$('#num_comprobante').val("-");

	 		}else if(num=="B"){

	 			// $('#serie_comprobante').val(num+"N01");
	 			// numFactura();
				 numBoleta();
				 mostrar_serie_ncb();

				 $("#tipo_comprobante").val('NCB');
   				 $("#tipo_comprobante").selectpicker('refresh');


	 		}else{
				 numFactura();
				 mostrar_serie_nc();

				 $("#tipo_comprobante").val('NC');
   				 $("#tipo_comprobante").selectpicker('refresh');

			 }



		});
		
		$.post("../controladores/venta.php?op=listarDetalleVenta",{idventa : idventa}, function(data,status)
		{
			data=JSON.parse(data);

			for(var y=0; y<50;y++){

				eliminarDetalles(y);

			}

			for(var i=0; i < data.length; i++){

				agregarDetalle(data[i][0],data[i][1],data[i][2],data[i][3],data[i][4],data[i][5],data[i][6])

			}

		});

}

function EnviarComprobante(idventa){
		
		$.post("../controladores/venta.php?op=mostrar",{idventa : idventa}, function(data,status){
			data=JSON.parse(data);

			window.open("https://api.whatsapp.com/send?phone=51"+data.telefono+"&text=https://localhost/"+lastPath+"/reportes/documentos/"+data.tipo_comprobante+"-"+data.num_comprobante+".pdf");

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

function agregarDetalle(idproducto,producto,cant,desc,precio_venta,stock,proigv){
	//aquí preguntamos si el idarticulo ya fue agregado
    if(articuloAdd.indexOf(idproducto)!= -1)
    { //reporta -1 cuando no existe
     // swal( producto +" ya se agrego");

     let cant = document.getElementsByName("cantidad[]");

     let id = document.getElementsByName("idproducto[]");

     for (var i = 0; i < cant.length; i++) {

     	if(id[i].value == idproducto){

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

	if (idproducto!="") {
		var subtotal=cantidad*precio_venta;
		var fila='<tr class="filas" id="fila'+cont+'">'+
        '<td><input style="text-align:center" type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td>'+
        '<td><input style="text-align:center" type="number" min="1" step="1" oninput="modificarSubtotales()" name="cantidad[]" id="cantidad[]" value="'+cantidad+'"></td>'+
        '<td><input style="text-align:center" type="number" step="0.01" oninput="modificarSubtotales()" name="precio_venta[]" id="precio_venta[]" value="'+precio_venta+'"></td>'+
        '<td><input style="text-align:center" type="number" step="0.01" oninput="modificarSubtotales()" name="descuento[]" value="'+descuento+'"></td>'+    
        '<td><input style="text-align:center" type="text" readonly="readonly" name="stock[]" value="'+stock+'"></td>'+
        '<td><span style="text-align:center" id="subtotal'+cont+'" name="subtotal">'+subtotal+'</span></td>'+
        '<td><center><button type="button" class="btn btn-danger" onclick="eliminarDetalle('+cont+')"><i class="fa fa-trash"></i></button></center></td>'+
        '<td><span style="text-align:center" id="proigv'+cont+'" name="proigv">'+proigv+'</span></td>'+
		'</tr>';
		cont++;
		detalles=detalles+1;
		articuloAdd= articuloAdd + idproducto + "-"; //aca concatemanos los idarticulos xvg: 1-2-5-12-20
		$('#detalles').append(fila);
		modificarSubtotales();

	}else{
		alert("error al ingresar el detalle, revisar las datos del articulo ");
	}
	}
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

        
             inpC.style.backgroundColor="#FFFFFF";
             inpSt.style.backgroundColor="#FFFFFF";
		document.getElementsByName("subtotal")[i].innerHTML=subfinal;
		
	}

	calcularTotales();
}

function calcularTotales(){

	var sub = document.getElementsByName("subtotal");
	var total=0.0;
  	var total_monto=0.0;
  	var igv_dec =0.0;
  	var totalConIgv=0.0;

	for (var i = 0; i < sub.length; i++) {
		total += document.getElementsByName("subtotal")[i].value;

		var proigv = document.getElementsByName("proigv")[i].innerHTML;

		if(proigv == "Gravada"){
			totalConIgv += document.getElementsByName("subtotal")[i].value;
			var igv=totalConIgv*(no_aplica)/(no_aplica+100);
			var total_monto=(totalConIgv-(igv)).toFixed(2);
			var igv_dec=igv.toFixed(2);
		}


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


		}

	});
	
}

function eliminarDetalle(indice){
$("#fila"+indice).remove();
calcularTotales();
detalles=detalles-1;
articuloAdd="";
}

function eliminarDetalles(indice){
$("#fila"+indice).remove();
detalles=0;
articuloAdd="";
}

init();