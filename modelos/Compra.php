<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Compra
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	//Incluyendo los detalles del ingreso
	public function insertar($idproveedor,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_compra,$idproducto,$cantidad,$precio_compra,$precio_venta)
	{
		$sql="INSERT INTO compra (idproveedor,idpersonal,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_compra,estado)
		VALUES ('$idproveedor','$idpersonal','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_compra','Aceptado')";
		//return ejecutarConsulta($sql);
		//ejecutar la funcion de la clase consulta que retorna el id
		//devuelve la llave primaria del ingreso que se ha registrado
		$idingresonew=ejecutarConsulta_retornarID($sql);

		$num_elementos=0;
		$sw=true;
		//determinar cuantos detalles estamos recibiendo en la funcion insertar
		//cuenta cuantos indices tiene el array idproducto
		while ($num_elementos < count($idproducto))
		{
			$sql_detalle = "INSERT INTO detalle_compra(idcompra,idproducto,cantidad,precio_compra,precio_venta) VALUES ('$idingresonew', '$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio_compra[$num_elementos]','$precio_venta[$num_elementos]')";
			ejecutarConsulta($sql_detalle) or $sw = false;
			$num_elementos=$num_elementos + 1;
		}

		return $sw;
	}

	//Implementamos un método para anular categorías
	public function anular($idcompra)
	{
		$sql="UPDATE compra SET estado='Anulado' WHERE idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcompra)
	{	
		$sql="SELECT i.idcompra,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idpersonal,u.nombre as personal,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM compra i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN personal u ON i.idpersonal=u.idpersonal WHERE i.idcompra='$idcompra'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function listarDetalle($idcompra)
	{
		$sql="SELECT di.idcompra,di.idproducto,a.nombre,di.cantidad,di.precio_compra,di.precio_venta FROM detalle_compra di inner join producto a on di.idproducto=a.idproducto where di.idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT i.idcompra,DATE(i.fecha_hora) as fecha,i.idproveedor,p.nombre as proveedor,u.idpersonal,u.nombre as personal,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado FROM compra i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN personal u ON i.idpersonal=u.idpersonal ORDER BY i.idcompra desc";
		return ejecutarConsulta($sql);		
	}

	public function ingresocabecera($idcompra){
		$sql="SELECT i.idcompra,i.idproveedor,p.nombre as proveedor,p.direccion,p.tipo_documento,p.num_documento,p.email,p.telefono,i.idpersonal,u.nombre as personal,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,date(i.fecha_hora) as fecha,i.impuesto,i.total_compra FROM compra i INNER JOIN persona p ON i.idproveedor=p.idpersona INNER JOIN personal u ON i.idpersonal=u.idpersonal WHERE i.idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}

	public function ingresodetalle($idcompra){
		$sql="SELECT a.nombre as producto,um.nombre as unidadmedida,CASE WHEN a.codigo = 'SIN CODIGO' THEN '-' ELSE a.codigo END as codigo,d.cantidad,d.precio_compra,d.precio_venta,(d.cantidad*d.precio_compra) as subtotal FROM detalle_compra d INNER JOIN producto a ON d.idproducto=a.idproducto INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida WHERE d.idcompra='$idcompra'";
		return ejecutarConsulta($sql);
	}
}

?>