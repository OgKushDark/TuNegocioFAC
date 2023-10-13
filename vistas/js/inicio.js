//Función que se ejecuta al inicio
function init(){

    mostrarInicio();

	//Cargamos los items al select vendedor
	$.post("../controladores/venta.php?op=selectVendedor", function(r){

        $("#idvendedor").html(r);
        $('#idvendedor').selectpicker('refresh');

    });
	
}

function listar(){
    mostrarInicio();
}

function mostrarInicio(){

    var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
    var idvendedor = $("#idvendedor").val();

    $.post("../controladores/consultas.php?op=totalcomprahoy",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin, idvendedor : idvendedor}, function(data,status)
	{

		data=JSON.parse(data);
		var label=document.querySelector('#lblComprasHoy');
		label.textContent=data.total_compra;	

	});

    $.post("../controladores/consultas.php?op=totalventahoy",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin, idvendedor : idvendedor}, function(data,status)
	{

		data=JSON.parse(data);
		var label=document.querySelector('#lblVentasHoy');
		label.textContent=data.total_venta;	

	});

    $.post("../controladores/consultas.php?op=totalusuariosr", function(data,status)
	{

		data=JSON.parse(data);
		var label=document.querySelector('#lblEmpleados');
		label.textContent=data.idpersonal;	

	});

    $.post("../controladores/consultas.php?op=totalproveedoresr", function(data,status)
	{

		data=JSON.parse(data);
		var label=document.querySelector('#lblProveedores');
		label.textContent=data.idpersona;	

	});

    $.post("../controladores/consultas.php?op=totalventachoy",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin, idvendedor : idvendedor}, function(data,status)
	{

		data=JSON.parse(data);
		var label=document.querySelector('#lblTotalVentasC');
		label.textContent=data.total_venta;	

	});

    $.post("../controladores/consultas.php?op=totalcuentasporcobrar",{fecha_inicio : fecha_inicio, fecha_fin : fecha_fin, idvendedor : idvendedor}, function(data,status)
	{

		data=JSON.parse(data);
        console.log(data);
		var label=document.querySelector('#lblCuentasCobrar');
		label.textContent=data.totaldeuda;	

	});

}

init();