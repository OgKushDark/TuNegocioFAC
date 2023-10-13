<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Producto
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idcategoria,$idunidad_medida,$idmarca,$codigo,$nombre,$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv)
	{

		if($codigo==""){
			$codigo="SIN CODIGO";
		}

		$sql="INSERT INTO producto (idcategoria,idunidad_medida,idmarca,codigo,nombre,stock,stock_minimo,precio,precioB,precioC,precioD,precio_compra,fecha,descripcion,imagen,modelo,numserie,proigv,condicion)
		VALUES ('$idcategoria','$idunidad_medida','$idmarca','$codigo','$nombre','$stock','$stockMinimo','$precio','$precioB','$precioC','$precioD','$precioCompra','$fecha','$descripcion','$imagen','$modelo','$nserie','$tipoigv','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idproducto,$idcategoria,$idunidad_medida,$idmarca,$codigo,$nombre,$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv)
	{
		$sql="UPDATE producto SET idcategoria='$idcategoria',idunidad_medida='$idunidad_medida',idmarca='$idmarca',codigo='$codigo',nombre='$nombre',stock='$stock',stock_minimo='$stockMinimo',precio='$precio',precioB='$precioB',precioC='$precioC',precioD='$precioD',precio_compra='$precioCompra',fecha='$fecha',descripcion='$descripcion', modelo='$modelo', numserie='$nserie',proigv='$tipoigv',imagen='$imagen' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	public function mostrarStockProductoE($idproductoE)
	{

		$sql="SELECT a.stock, um.nombre as unidadmedida FROM producto a INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida WHERE idproducto = '$idproductoE'";
		return ejecutarConsultaSimpleFila($sql);

	}

	public function mostrarStockProductoD($idproductoD)
	{

		$sql="SELECT a.stock, um.nombre as unidadmedida FROM producto a INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida WHERE idproducto = '$idproductoD'";
		return ejecutarConsultaSimpleFila($sql);

	}

	public function desempaquetar($idproductoE,$idproductoD,$cantidadE,$cantidadD,$productoEmpaquetado,$productoDesempaquetar){

		$cantidadEmpaquetado = $productoEmpaquetado - $cantidadE;

		$cantidadTotalDesempacar = ($cantidadE * $cantidadD) + $productoDesempaquetar;

		$actualizarStockEmpaquetado = "UPDATE producto SET stock = '$cantidadEmpaquetado' where idproducto = '$idproductoE'";
		ejecutarConsulta($actualizarStockEmpaquetado);

		$actualizarStockDesempaquetar = "UPDATE producto SET stock = '$cantidadTotalDesempacar' where idproducto = '$idproductoD'";

		return ejecutarConsulta($actualizarStockDesempaquetar);
	}

	//Implementamos un método para desactivar registros
	public function desactivar($idproducto)
	{
		$sql="UPDATE producto SET condicion='0' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar registros
	public function activar($idproducto)
	{
		$sql="UPDATE producto SET condicion='1' WHERE idproducto='$idproducto'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idproducto)
	{
		$sql="SELECT * FROM producto WHERE idproducto='$idproducto'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function porcentaje($idcategoria)
	{
		$sql="SELECT * FROM categoria WHERE idcategoria='$idcategoria'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function marcas($idmarca)
	{
		$sql="SELECT * FROM marca WHERE idmarca='$idmarca'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idunidad_medida,um.nombre as unidad,a.fecha,c.nombre as categoria,a.codigo,a.nombre,a.stock, a.stock_minimo, a.numserie,a.descripcion,a.imagen,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida ORDER BY a.idproducto DESC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listarProductosCompra()
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idunidad_medida,a.fecha,c.nombre as categoria,um.nombre as unidadmedida,a.codigo,a.nombre,a.stock, a.numserie,a.descripcion,a.precio_compra,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida ORDER BY a.idproducto DESC";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos
	public function listarActivos()
	{
		$sql="SELECT a.idproducto,a.idcategoria,a.idunidad_medida,c.nombre as categoria,um.nombre as unidadmedida,a.codigo,a.nombre,a.stock,a.precio as precio_venta, a.precio_compra,a.descripcion,a.imagen,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros activos, su último precio y el stock (vamos a unir con el último registro de la tabla detalle_ingreso)
	public function listarActivosVenta()
	{
		// $sql="SELECT a.idproducto,a.idcategoria,c.nombre as categoria,a.codigo, a.nombre,a.stock,(SELECT precio_venta FROM detalle_compra WHERE idproducto=a.idproducto ORDER BY iddetalle_compra DESC LIMIT 0,1) AS precio_venta,a.descripcion,a.imagen,a.condicion FROM producto a INNER JOIN Categoria c ON a.idcategoria=c.idcategoria WHERE a.condicion='1'";
		$sql="SELECT a.idproducto,a.idcategoria,um.nombre as unidadmedida,a.idunidad_medida,c.nombre as categoria,a.codigo, a.nombre,a.stock,a.precio as precio_venta,a.precioB,a.precioC,a.precioD,a.descripcion,a.imagen,a.proigv,a.condicion FROM producto a INNER JOIN categoria c ON a.idcategoria=c.idcategoria INNER JOIN unidad_medida um on a.idunidad_medida = um.idunidad_medida WHERE a.condicion='1'";
		return ejecutarConsulta($sql);		
	}
}

?>