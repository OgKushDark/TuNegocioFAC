	var tabla;

//Función que se ejecuta al inicio
function init(){

	listar();

	//Cargamos los items al select producto
	$.post("../controladores/venta.php?op=selectProducto", function(r){
	            $("#idproducto").html(r);
	            $('#idproducto').selectpicker('refresh');
	});

	//Cargamos los items al select vendedor
	$.post("../controladores/venta.php?op=selectVendedor", function(r){
	            $("#idvendedor").html(r);
	            $('#idvendedor').selectpicker('refresh');
	});
	
	$('#navConsultaV').addClass("treeview active");
    $('#navConsultaProductoVLi').addClass("active");
}


//Función Listar
function listar()
{
	var fecha_inicio = $("#fecha_inicio").val();
	var fecha_fin = $("#fecha_fin").val();
	var idproducto = $("#idproducto").val();
	var idvendedor = $("#idvendedor").val();

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
					url: '../controladores/consultas.php?op=ventasfechaproducto',
					data:{fecha_inicio: fecha_inicio,fecha_fin: fecha_fin, idproducto: idproducto, idvendedor: idvendedor},
					type : "get",
					dataType : "json",						
					error: function(e){
						console.log(e.responseText);	
					}
				},
		"footerCallback": function ( row, data, start, end, display ) {
        
        total = this.api()
            .column(3)//numero de columna a sumar
            //.column(1, {page: 'current'})//para sumar solo la pagina actual
            .data()
            .reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0 );

        $(this.api().column(3).footer()).html("S/ " + total);

        cantidad = this.api()
            .column(2)//numero de columna a sumar
            //.column(1, {page: 'current'})//para sumar solo la pagina actual
            .data()
            .reduce(function (a, b) {
                return parseFloat(a) + parseFloat(b);
            }, 0 );

        $(this.api().column(2).footer()).html("S/ " + cantidad);

		totalCompra = this.api()
			.column(4)
			.data()
			.reduce(function (a, b){
				return parseFloat(a) + parseFloat(b);
			}, 0 );

        $(this.api().column(4).footer()).html("S/ " + totalCompra);

		utilidad = this.api()
			.column(5)
			.data()
			.reduce(function (a, b){

				return parseFloat(a) + parseFloat (b);

			}, 0 );

        $(this.api().column(5).footer()).html("S/ " + utilidad);
            
        },
		"bDestroy": true,
		"iDisplayLength": 5,//Paginación
	    "order": [[ 0, "desc" ]]//Ordenar (columna,orden)
	}).DataTable();
	
}


init();