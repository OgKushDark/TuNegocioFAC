var tabla;

//Función que se ejecuta al inicio
function init(){
	mostrarform(false);
	listar();

	$("#imagenmuestra").show();
	$("#imagenmuestra").attr("src","../files/productos/anonymous.png");
	$("#imagenactual").val("anonymous.png");

	$("#myModal").on("submit",function(e)
	{
		guardaryeditar(e);	
	})

	$("#formularioDesempaquetar").on("submit",function(e){
		actualizarProductoEmpaquetado(e);
	});

	//Cargamos los items al select categoria
	$.post("../controladores/producto.php?op=selectCategoria", function(r){

	    $("#idcategoria").html(r);
	    $('#idcategoria').selectpicker('refresh');

	});

	$.post("../controladores/producto.php?op=selectUnidadMedida", function(r){

	    $("#idunidad_medida").html(r);
	    $('#idunidad_medida').selectpicker('refresh');

	});

	$.post("../controladores/producto.php?op=selectMarca", function(r){

	    $("#idmarca").html(r);
	    $('#idmarca').selectpicker('refresh');

	});
	

	$('#navAlmacen').addClass("treeview active");
    $('#navProducto').addClass("active");

    $("#idcategoria").change(porcentaje);
    
}

function stockProductoE(){
	var idproductoE = $("#idproductoE").val();
	$.post("../controladores/producto.php?op=mostrarStockProductoE",{idproductoE : idproductoE}, function(data,status)
	{

		data=JSON.parse(data);

		$('#productoE').val(data.stock);

		var label=document.querySelector('#productoDesempaquetar');
		label.textContent=data.stock + " - UM: " + data.unidadmedida;
			

	});
}

function stockProductoD(){
	var idproductoD = $("#idproductoD").val();
	$.post("../controladores/producto.php?op=mostrarStockProductoD",{idproductoD : idproductoD}, function(data,status)
	{

		data=JSON.parse(data);

		console.log(data);

		$('#productoD').val(data.stock);
			

	});
}

function limpiarDesempaquetado(){

	$("#idproductoE").val("");
	$("#idproductoE").selectpicker('refresh');
	$("#idproductoD").val("");
	$("#idproductoD").selectpicker('refresh');
	$("#cantidadE").val("");
	$("#cantidadD").val("");
	$("#productoE").val("");
	$("#productoD").val("");

	var label=document.querySelector('#productoDesempaquetar');
	label.textContent="0";
	
}

function actualizarProductoEmpaquetado(e){
	e.preventDefault();//no se activara la accion predeterminada 
	//$("#btnGuardar").prop("disabled",true);
	var formData=new FormData($("#formularioDesempaquetar")[0]);

	$.ajax({
		url: "../controladores/producto.php?op=actualizarProductoEmpaquetado",
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
			   $('#desempaquetar').modal('hide');
			   listar();
		}
	});

	limpiarDesempaquetado();
}

function llenarProductos(){
	$.post("../controladores/venta.php?op=selectProductoDesempaquetar", function(r){
		$("#idproductoE").html(r);
		$('#idproductoE').selectpicker('refresh');
	});

	$.post("../controladores/venta.php?op=selectProductoDesempaquetar", function(r){
		$("#idproductoD").html(r);
		$('#idproductoD').selectpicker('refresh');
	});
}

//Función limpiar
function limpiar()
{
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#marca").val("");
	$("#marca").selectpicker('refresh');
	$("#stockMinimo").val("");
	$("#precio").val("");
	$("#precioB").val("");
	$("#precioC").val("");
	$("#precioD").val("");
	$("#fecha").val("");
	$("#fecha_hora").val("");
	$("#imagenmuestra").attr("src","../files/productos/anonymous.png");
	$("#imagenactual").val("anonymous.png");
	$("#print").hide();
	$("#idproducto").val("");
	$("#idcategoria").val("");
	$("#idcategoria").selectpicker('refresh');
	$("#idunidad_medida").val("");
	$("#idunidad_medida").selectpicker('refresh');
	$("#modelo").val("");
	$("#nserie").val("");
	$("#porc").val("");
	$("#precioCompra").val("");
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
        dom: 'Bfrtip',
        lengthMenu: [
            [5,10, 25, 50, 100, -1],
            ['5 filas','10 filas', '25 filas', '50 filas','100 filas', 'Mostrar todo']
        ],
        buttons: ['pageLength','copy','excel', 'pdf'],
		"ajax":
				{
					url: '../controladores/producto.php?op=listar',
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 1, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
}

//Función para guardar o editar

function guardaryeditar(e)
{
	e.preventDefault(); //No se activará la acción predeterminada del evento
	//$("#btnGuardar").prop("disabled",true);
	var formData = new FormData($("#formulario")[0]);

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
              $('#myModal').modal('hide');	          
	          mostrarform(false);
	          tabla.ajax.reload();
	    }

	});
	limpiar();
}

function mostrar(idproducto)
{
	$.post("../controladores/producto.php?op=mostrar",{idproducto : idproducto}, function(data, status)
	{
		data = JSON.parse(data);
		mostrarform(true);

		$("#idcategoria").val(data.idcategoria);
		$('#idcategoria').selectpicker('refresh');
		$("#idunidad_medida").val(data.idunidad_medida);
		$('#idunidad_medida').selectpicker('refresh');
		$("#idmarca").val(data.idmarca);
		$('#idmarca').selectpicker('refresh');
		$("#codigo").val(data.codigo);
		$("#nombre").val(data.nombre);
		$("#stock").val(data.stock);
		$("#stockMinimo").val(data.stock_minimo);
		$("#precio").val(data.precio);
		$("#precioB").val(data.precioB);
		$("#precioC").val(data.precioC);
		$("#precioD").val(data.precioD);
		$("#precioCompra").val(data.precio_compra);
		$("#fecha_hora").val(data.fecha);
		$("#descripcion").val(data.descripcion);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/productos/"+data.imagen);
		$("#imagenactual").val(data.imagen);
 		$("#idproducto").val(data.idproducto);
 		$("#modelo").val(data.modelo);
 		$("#nserie").val(data.numserie);
 		$("#tipoigv").val(data.proigv);
 		generarbarcode();

 	})
}

//Función para desactivar registros
function desactivar(idproducto)
{
	swal({
						    title: "¿Desactivar?",
						    text: "¿Está seguro Que Desea Desactivar el Producto?",
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
									$.post("../controladores/producto.php?op=desactivar", {idproducto : idproducto}, function(e){
										swal(
											'!!! Desactivado !!!',e,'success')
					            tabla.ajax.reload();
				        	});
						    }else {
						    swal("! Cancelado ¡", "Se Cancelo la desactivacion del Producto", "error");
							 }
							});
}

//Función para activar registros
function activar(idproducto)
{
	swal({
		    title: "¿Activar?",
		    text: "¿Está seguro Que desea Activar el Producto?",
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
						$.post("../controladores/producto.php?op=activar", {idproducto : idproducto}, function(e){
						swal("!!! Activarda !!!", e ,"success");
								tabla.ajax.reload();
						});
		    }else {
		    swal("! Cancelado ¡", "Se Cancelo la activacion del Producto", "error");
			 }
			});
}

/*=============================================
SUBIENDO LA FOTO DEL PRODUCTO
=============================================*/

$("#imagen").change(function(){

  var imagen = this.files[0];
  
  /*=============================================
    VALIDAMOS EL FORMATO DE LA IMAGEN SEA JPG O PNG
    =============================================*/

    if(imagen["type"] != "image/jpeg" && imagen["type"] != "image/png"){

      $(".nuevaImagen").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen debe estar en formato JPG o PNG!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    }else if(imagen["size"] > 2000000){

      $(".nuevaImagen").val("");

       swal({
          title: "Error al subir la imagen",
          text: "¡La imagen no debe pesar más de 2MB!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });

    }else{

      var datosImagen = new FileReader;
      datosImagen.readAsDataURL(imagen);

      $(datosImagen).on("load", function(event){

        var rutaImagen = event.target.result;

        $("#imagenmuestra").attr("src", rutaImagen);

      })

    }
})

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

// Cargar Excel

function Cargar_Excel(){

	let archivo = document.getElementById('txt_archivo').value;
	if(archivo.length==0){
		return swal({
          title: "Error al subir el archivo",
          text: "Seleccione un archivo",
          type: "info",
          confirmButtonText: "¡Cerrar!"
        });
	}
	let formData = new FormData();
	let excel = $("#txt_archivo")[0].files[0];
	formData.append('excel',excel);
	$.ajax({
		url:'index.php',
		type: 'POST',
		data:formData,
		contentType:false,
		processData:false,
		success:function(resp){
            $('#importarProductos').modal('hide');	          
			listar();
		}
	});
	return false; 

}

init();