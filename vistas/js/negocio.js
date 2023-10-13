var tabla;

//funcion que se ejecuta al inicio
function init(){
   mostrarform(false);
   listar();
   mostrar_registros();

   $("#formulario").on("submit",function(e){
   	guardaryeditar(e);
   })

   $('#navConfiguracion').addClass("treeview active");
   $('#navConfiguracionLi').addClass("active");

   $("#imagenmuestra").show();
   $("#imagenmuestra").attr("src","../files/personal/user.png");
   $("#imagenactual").val("user.png");

}

function mostrar_registros(){
$.ajax({
url: '../controladores/negocio.php?op=mostrar_registros',
type:'get',
dataType:'json',
success: function(i){
	 registros=i;
	 if (registros==0) {
	$("#btnagregar").show();
	 }else{
	 	$("#btnagregar").hide();
	 }
}

	});}
//funcion limpiar
function limpiar(){
	$("#codigo").val("");
	$("#nombre").val("");
	$("#ndocumento").val("");
	$("#documento").val("");
	$("#direccion").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#imagenmuestra").attr("src","../files//personal/user.png");
	$("#imagenactual").val("user.png");
	$("#pais").val("");
	$("#ciudad").val("");
	$("#nombre_impuesto").val("");
	$("#monto_impuesto").val("");
	$("#moneda").val("");
	$("#simbolo").val("");
	$("#id_negocio").val("");
	mostrar_registros();
}

//funcion mostrar formulario
function mostrarform(flag){
	limpiar();
	if(flag){
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
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
			url:'../controladores/negocio.php?op=listar',
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
     $("#btnGuardar").prop("disabled",true);
     var formData=new FormData($("#formulario")[0]);

     $.ajax({
     	url: "../controladores/negocio.php?op=guardaryeditar",
     	type: "POST",
     	data: formData,
     	contentType: false,
     	processData: false,

     	success: function(datos){
     		swal({
				  title: 'Empresa',
				  type: 'success',
					text:datos
				});
     		mostrarform(false);
     		tabla.ajax.reload();
     	}
     });

     limpiar();
}

function mostrar(id_negocio){
	$.post("../controladores/negocio.php?op=mostrar",{id_negocio : id_negocio},
		function(data,status)
		{
			data=JSON.parse(data);
			console.log(data);
			mostrarform(true);
			$("#clave_certificado").val(data.clave_certificado);
			$("#estado_certificado").val(data.estado_certificado);
			$("#codigo").val(data.codigo);
			$("#nombre").val(data.nombre);
			$("#ndocumento").val(data.ndocumento);
			$("#documento").val(data.documento);
			$("#direccion").val(data.direccion);
			$("#telefono").val(data.telefono);
			$("#email").val(data.email);
			$("#imagenmuestra").show();
			$("#imagenmuestra").attr("src","../reportes/"+data.logo);
			$("#imagenactual").val(data.logo);
			$("#pais").val(data.pais);
			$("#ciudad").val(data.ciudad);
			$("#nombre_impuesto").val(data.nombre_impuesto);
			$("#monto_impuesto").val(data.monto_impuesto);
			$("#moneda").val(data.moneda);
			$("#simbolo").val(data.simbolo);
			$("#id_negocio").val(data.id_negocio);
			$("#usuario_sol").val(data.usuario_sol);
			$("#clave_sol").val(data.clave_sol);
			$("#ruta_certificado").val(data.ruta_certificado);

		});
}


//funcion para desactivar
function desactivar(id_negocio){
	bootbox.confirm("¿Esta seguro de desactivar este dato?", function(result){
		if (result) {
			$.post("../controladores/negocio.php?op=desactivar", {id_negocio : id_negocio}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
}

function activar(id_negocio){
	bootbox.confirm("¿Esta seguro de activar este dato?" , function(result){
		if (result) {
			$.post("../controladores/negocio.php?op=activar" , {id_negocio : id_negocio}, function(e){
				bootbox.alert(e);
				tabla.ajax.reload();
			});
		}
	})
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


init();