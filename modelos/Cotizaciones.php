<?php 
//incluir la conexion de base de datos
require "../configuraciones/Conexion.php";
class Cotizacion{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$total_venta,$idproducto,$cantidad,$precio_venta,$descuento){

	$sql="INSERT INTO cotizacion (idcliente,idpersonal,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,total_venta) VALUES 
	('$idcliente','$idpersonal','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$total_venta')";

	 $idventanew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($idproducto)) {

	 	$sql_detalle="INSERT INTO detalle_cotizacion (idcotizacion,idproducto,cantidad,precio_venta,descuento) VALUES('$idventanew','$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;

	 }

	 return $sw;
}

//Implementamos un método para desactivar categorías
public function eliminar($idcotizacion)
{
	$sql="UPDATE cotizacion SET condicion='0' WHERE idcotizacion='$idcotizacion'";
	return ejecutarConsulta($sql);
}

//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idcotizacion){
	$sql="SELECT c.idcotizacion,DATE(c.fecha_hora) as fecha,c.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal,p.telefono,c.tipo_comprobante,c.serie_comprobante,c.num_comprobante,c.total_venta FROM cotizacion c INNER JOIN persona p ON c.idcliente=p.idpersona INNER JOIN personal u ON c.idPersonal=u.idpersonal WHERE idcotizacion='$idcotizacion'";
	return ejecutarConsultaSimpleFila($sql);
}

	public function mostrardetalle($idcotizacion){
	$sql="SELECT dv.idcotizacion,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal, v.total_venta, p.nombre as cliente, v.num_comprobante FROM detalle_cotizacion dv INNER JOIN producto a ON dv.idproducto=a.idproducto INNER JOIN cotizacion v ON v.idcotizacion=dv.idcotizacion INNER JOIN persona p ON v.idcliente=p.idpersona WHERE dv.idcotizacion='$idcotizacion'";
	return ejecutarConsulta($sql);
}

public function listarDetalle($idcotizacion){
	$sql="SELECT dv.idcotizacion,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal, v.total_venta FROM detalle_cotizacion dv INNER JOIN producto a ON dv.idproducto=a.idproducto INNER JOIN cotizacion v ON v.idcotizacion=dv.idcotizacion WHERE dv.idcotizacion='$idcotizacion'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar(){
	$sql="SELECT c.idcotizacion,DATE(c.fecha_hora) as fecha,c.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, c.tipo_comprobante,c.serie_comprobante,c.num_comprobante,c.total_venta FROM cotizacion c INNER JOIN persona p ON c.idcliente=p.idpersona INNER JOIN personal u ON c.idPersonal=u.idpersonal WHERE c.condicion = 1 ORDER BY c.idcotizacion DESC";
	return ejecutarConsulta($sql);
}


public function ventacabecera($idcotizacion){
	$sql= "SELECT v.idcotizacion, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idpersonal, u.nombre AS personal, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.total_venta FROM cotizacion v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.idcotizacion='$idcotizacion'";
	return ejecutarConsulta($sql);
}

public function ventadetalle($idcotizacion){
	$sql="SELECT a.idproducto, a.nombre AS producto, um.nombre as unidadmedida, a.idunidad_medida, CASE WHEN a.codigo = 'SIN CODIGO' THEN '-' ELSE a.codigo END as codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal, a.stock, a.imagen, a.proigv FROM detalle_cotizacion d INNER JOIN producto a ON d.idproducto=a.idproducto INNER JOIN unidad_medida um ON a.idunidad_medida = um.idunidad_medida WHERE d.idcotizacion='$idcotizacion'";
         return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de factura
public function numero_venta(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Factura' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}

//funcion para seleccionar la serie de la factura
public function numero_serie(){
		 
		    $sql="SELECT serie_comprobante ,num_comprobante FROM venta WHERE tipo_comprobante='Factura' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de boleta
public function numero_venta_boleta(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Boleta' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la boleta
public function numero_serie_boleta(){
		 
		    $sql="SELECT serie_comprobante ,num_comprobante FROM venta WHERE tipo_comprobante='Boleta' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de ticket
public function numero_venta_ticket(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Ticket' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la ticket
public function numero_serie_ticket(){
		 
		    $sql="SELECT serie_comprobante ,num_comprobante FROM venta WHERE tipo_comprobante='Ticket' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de ticket
public function numero_venta_cotizacion(){
		 
		    $sql="SELECT num_comprobante FROM cotizacion WHERE tipo_comprobante='Cotización' ORDER BY idcotizacion DESC limit 1";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la ticket
public function numero_serie_cotizacion(){
		 
		    $sql="SELECT serie_comprobante ,num_comprobante FROM cotizacion WHERE tipo_comprobante='Cotización' ORDER BY idcotizacion DESC limit 1";

return ejecutarConsulta($sql);
}

public function buscarProducto($codigo)
{
	$sql="SELECT * FROM producto WHERE codigo='$codigo'";
	return ejecutarConsultaSimpleFila($sql);
}


}

 ?>
