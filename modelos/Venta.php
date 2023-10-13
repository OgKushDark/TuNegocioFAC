<?php 
//incluir la conexion de base de datos
require "../configuraciones/Conexion.php";
class Venta{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar registro
public function insertar($idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$tipopago,$formapago,$nroOperacion,$fechaDepostivo,$porcentaje,$totalrecibido,$vuelto,$idproducto,$cantidad,$precio_venta,$descuento,$fechaOperacion,$montoDeuda,$montoPagado,$comprobanteReferencia,$idmotivo,$observaciones){
	$dovEstado="";

	if($idcliente == ""){
		$idcliente = 6;
	}

	if($tipo_comprobante=="Nota"){
		$estado="Activado";
		$dovEstado="ACEPTADO";
	}else{
		$estado="Por Enviar";
	}

	if($serie_comprobante=="-" AND $num_comprobante=="-"){
		$tipo_comprobante="Anular";
	}

	$sql="INSERT INTO venta (idcliente,idpersonal,idmotivo_nota,tipo_comprobante,serie_comprobante,num_comprobante,fecha_hora,impuesto,total_venta,ventacredito,formapago,numoperacion,fechadeposito,
	descuento,totalrecibido,vuelto,estado,documento_rel,dov_Estado,observacion) VALUES 
	('$idcliente','$idpersonal','$idmotivo','$tipo_comprobante','$serie_comprobante','$num_comprobante','$fecha_hora','$impuesto','$total_venta','$tipopago','$formapago','$nroOperacion','$fechaDepostivo','$porcentaje','$totalrecibido','$vuelto','$estado','$comprobanteReferencia','$dovEstado','$observaciones')";

	 $idventanew=ejecutarConsulta_retornarID($sql);
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($idproducto)) {

	 	$sql_detalle="INSERT INTO detalle_venta (idventa,idproducto,cantidad,precio_venta,descuento) VALUES('$idventanew','$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;

	 }

	 if($comprobanteReferencia!=''){

		$sql3="UPDATE venta SET estado= CASE WHEN tipo_comprobante = 'Nota' THEN 'Anulado' ELSE 'Nota Credito' END WHERE idventa='$comprobanteReferencia'";
		ejecutarConsulta($sql3);

		$sql4="UPDATE cuentas_por_cobrar SET condicion='0' WHERE idventa='$comprobanteReferencia'";
		ejecutarConsulta($sql4);

	 	$n_elementos=0;

	 	$sx=true;


		while ($n_elementos < count($idproducto)) {

			$sql_anular="UPDATE producto a
    		JOIN detalle_venta di ON di.idproducto = a.idproducto AND di.idventa= '$idventanew' set a.stock = 
    		CASE WHEN '$idproducto[$n_elementos]' = a.idproducto THEN a.stock + ('$cantidad[$n_elementos]')*2 ELSE a.stock END";

	 		ejecutarConsulta($sql_anular) or $sx=false;


	 		$n_elementos=$n_elementos+1;

		}

		$sql1="UPDATE cuentas_por_cobrar SET condicion='0' WHERE idventa='$idventanew'";
		ejecutarConsulta($sql1);

	}

	 if ($tipopago == 'Si') {

	 	$sql2 = "INSERT INTO cuentas_por_cobrar (idventa, fecharegistro, deudatotal, fechavencimiento, abonototal) VALUES ('$idventanew','$fecha_hora','$montoDeuda','$fechaOperacion',0)";

	 	$idcpcnew = ejecutarConsulta_retornarID($sql2);

	 	if ($montoPagado > 0) {

	 		$sql_detalle2 = "INSERT INTO detalle_cuentas_por_cobrar (idcpc, montopagado, observacion) VALUES ('$idcpcnew','$montoPagado', '')";

	 		ejecutarConsulta($sql_detalle2);

	 	}
	 	
	 }

	 return $sw;
}

//metodo para editar registros
	public function editar($idventa,$idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha_hora,$impuesto,$total_venta,$tipopago,$formapago,$nroOperacion,$fechaDepostivo,$porcentaje,$totalrecibido,$vuelto,$idproducto,$cantidad,$precio_venta,$descuento,$fechaOperacion,$montoDeuda,$montoPagado,$estado){

	$sql="UPDATE venta SET idcliente='$idcliente', idpersonal='$idpersonal', tipo_comprobante='$tipo_comprobante', serie_comprobante='$serie_comprobante', num_comprobante='$num_comprobante',fecha_hora='$fecha_hora',impuesto='$impuesto',total_venta='$total_venta',ventacredito='$tipopago',formapago='$formapago',numoperacion='$nroOperacion',fechadeposito='$fechaDepostivo',descuento='$descuento',totalrecibido='$totalrecibido',vuelto='$vuelto',estado='$estado' WHERE idventa='$idventa'";

	ejecutarConsulta($sql);

	$sql2="DELETE FROM detalle_venta WHERE idventa='$idventa'";

	ejecutarConsulta($sql2);
	 
	 $num_elementos=0;
	 $sw=true;
	 while ($num_elementos < count($idproducto)) {

	 	$sql_detalle="INSERT INTO detalle_venta (idventa,idproducto,cantidad,precio_venta,descuento) VALUES('$idventa','$idproducto[$num_elementos]','$cantidad[$num_elementos]','$precio_venta[$num_elementos]','$descuento[$num_elementos]')";

	 	ejecutarConsulta($sql_detalle) or $sw=false;

	 	$num_elementos=$num_elementos+1;

	 }

	 return $sw;
}

public function anular($idventa){
	$sql="UPDATE venta SET estado='Anulado' WHERE idventa='$idventa'";
	ejecutarConsulta($sql);

	$sql1="UPDATE cuentas_por_cobrar SET condicion='0' WHERE idventa='$idventa'";
	return ejecutarConsulta($sql1);
}


//implementar un metodopara mostrar los datos de unregistro a modificar
public function mostrar($idventa){
	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, p.telefono, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.ventacredito,v.formapago,v.descuento,v.totalrecibido,v.vuelto,v.numoperacion,DATE(v.fechadeposito) as fechadeposito,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE idventa='$idventa'";
	return ejecutarConsultaSimpleFila($sql);
}

	public function mostrardetalle($idventa){
	$sql="SELECT dv.idventa,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal, v.total_venta, v.impuesto, p.nombre as cliente, v.num_comprobante FROM detalle_venta dv INNER JOIN producto a ON dv.idproducto=a.idproducto INNER JOIN venta v ON v.idventa=dv.idventa INNER JOIN persona p ON v.idcliente=p.idpersona WHERE dv.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function listarDetalle($idventa){
	$sql="SELECT dv.idventa,dv.idproducto,a.nombre,dv.cantidad,dv.precio_venta,dv.descuento,(dv.cantidad*dv.precio_venta-dv.descuento) as subtotal, v.total_venta, v.impuesto FROM detalle_venta dv INNER JOIN producto a ON dv.idproducto=a.idproducto INNER JOIN venta v ON v.idventa=dv.idventa WHERE dv.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

//listar registros
public function listar($fecha_inicio,$fecha_fin,$estado){
	if($estado == "Todos"){
		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' ORDER BY v.idventa DESC";
	}else if($estado == 'Aceptado'){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Aceptado' ORDER BY v.idventa DESC";


	}else if($estado == "Por Enviar"){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Por Enviar' ORDER BY v.idventa DESC";

	}else if($estado == "Nota Credito"){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Nota Credito' ORDER BY v.idventa DESC";

	}else{

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Rechazado' ORDER BY v.idventa DESC";

	}
	return ejecutarConsulta($sql);
}

//listar registros
public function listarTodo(){

	$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('Boleta','Factura','Nota') AND v.serie_comprobante != '-' ORDER BY v.idventa DESC";

	return ejecutarConsulta($sql);
}

//listar registros
public function listarNC($fecha_inicio,$fecha_fin,$estado){

	if($estado == "Todos"){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('NC', 'NCB') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' ORDER BY v.idventa DESC";

	}else if($estado == 'Aceptado'){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('NC', 'NCB') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Aceptado' ORDER BY v.idventa DESC";
	}else if($estado == "Por Enviar"){

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('NC', 'NCB') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Por Enviar' ORDER BY v.idventa DESC";

	}else{

		$sql="SELECT v.idventa,DATE(v.fecha_hora) as fecha,v.idcliente,p.nombre as cliente,u.idpersonal,u.nombre as personal, v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.ventacredito,v.impuesto,v.dov_Nombre,v.estado FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.tipo_comprobante IN ('NC', 'NCB') AND v.serie_comprobante != '-' AND DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' AND v.estado = 'Rechazado' ORDER BY v.idventa DESC";

	}

	
	return ejecutarConsulta($sql);
}


public function ventacabecera($idventa){
	$sql= "SELECT v.idventa, v.idcliente, p.nombre AS cliente, p.direccion, p.tipo_documento, p.num_documento, p.email, p.telefono, v.idpersonal, u.nombre AS personal, v.tipo_comprobante, v.serie_comprobante, v.num_comprobante, DATE(v.fecha_hora) AS fecha, v.impuesto, v.total_venta, v.ventacredito FROM venta v INNER JOIN persona p ON v.idcliente=p.idpersona INNER JOIN personal u ON v.idpersonal=u.idpersonal WHERE v.idventa='$idventa'";
	return ejecutarConsulta($sql);
}

public function ventadetalle($idventa){
	// $sql="SELECT a.idproducto,a.nombre AS producto, CASE WHEN a.codigo = 'SIN CODIGO' THEN '-' ELSE a.codigo END as codigo, d.cantidad, d.precio_venta, d.descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal, a.stock FROM detalle_venta d INNER JOIN producto a ON d.idproducto=a.idproducto WHERE d.idventa='$idventa'";
 //         return ejecutarConsulta($sql);

	$sql="SELECT a.idproducto,a.nombre AS producto, um.nombre as unidadmedida, a.codigo, d.cantidad, d.precio_venta, (d.descuento + v.descuento) AS descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal, a.stock, a.proigv 
	FROM detalle_venta d 
	INNER JOIN producto a 
	ON d.idproducto=a.idproducto 
	INNER JOIN unidad_medida um 
	ON a.idunidad_medida = um.idunidad_medida
	INNER JOIN venta v
	ON v.idventa = d.idventa
	WHERE d.idventa='$idventa'";
    return ejecutarConsulta($sql);
}

public function ventadetallePDF($idventa){
	$sql="SELECT a.idproducto,a.nombre AS producto, um.nombre as unidadmedida, a.proigv, CASE WHEN a.codigo = 'SIN CODIGO' THEN '-' ELSE a.codigo END as codigo, d.cantidad, d.precio_venta, (d.descuento + v.descuento) AS descuento, (d.cantidad*d.precio_venta-d.descuento) AS subtotal, a.stock 
	FROM detalle_venta d 
	INNER JOIN producto a ON 
	d.idproducto=a.idproducto 
	INNER JOIN unidad_medida um 
	ON a.idunidad_medida = um.idunidad_medida
	INNER JOIN venta v
	ON v.idventa = d.idventa
	WHERE d.idventa='$idventa'";
         return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de factura
public function numero_venta(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Factura' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}

//funcion para seleccionar la serie de la factura
public function numero_serie(){
		 
		    $sql="SELECT REPLACE(serie_comprobante,'F','') AS serie_comprobante ,num_comprobante FROM venta WHERE tipo_comprobante='Factura' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de boleta
public function numero_venta_boleta(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Boleta' ORDER BY idventa DESC limit 1 ";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la boleta
public function numero_serie_boleta(){
		 
		    $sql="SELECT REPLACE(serie_comprobante,'B','') AS serie_comprobante, num_comprobante FROM venta WHERE tipo_comprobante='Boleta' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para seleccionar la serie de la boleta
public function numero_serie_nc(){
		 
	$sql="SELECT REPLACE(serie_comprobante,'FN','') AS serie_comprobante, num_comprobante FROM venta WHERE tipo_comprobante='NC' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para seleccionar la serie de la boleta
public function numero_serie_ncb(){
		 
	$sql="SELECT REPLACE(serie_comprobante,'BN','') AS serie_comprobante, num_comprobante FROM venta WHERE tipo_comprobante='NCB' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

//funcion para selecciolnar el numero de nota de crédito
public function numero_venta_nc(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='NC' ORDER BY idventa DESC limit 1";
 			return ejecutarConsulta($sql);
		  
}

//funcion para selecciolnar el numero de nota de crédito
public function numero_venta_ncb(){
		 
	$sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='NCB' ORDER BY idventa DESC limit 1";
	 return ejecutarConsulta($sql);
  
}

//funcion para selecciolnar el numero de ticket
public function numero_venta_ticket(){
		 
		    $sql="SELECT num_comprobante FROM venta WHERE tipo_comprobante='Nota' ORDER BY idventa DESC limit 1";
 			return ejecutarConsulta($sql);
		  
}
//funcion para seleccionar la serie de la ticket
public function numero_serie_ticket(){
		 
		    $sql="SELECT REPLACE(serie_comprobante,'P','') AS serie_comprobante, num_comprobante FROM venta WHERE tipo_comprobante='Nota' ORDER BY idventa DESC limit 1";

return ejecutarConsulta($sql);
}

public function buscarProducto($codigo)
{
	$sql="SELECT p.*, um.nombre as unidadmedida FROM producto p INNER JOIN unidad_medida um ON p.idunidad_medida = um.idunidad_medida WHERE codigo='$codigo'";
	return ejecutarConsultaSimpleFila($sql);
}


}
