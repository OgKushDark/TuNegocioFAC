<?php 
//incluir la conexion de base de datos
require "../configuraciones/Conexion.php";
class Comprobantes{

//implementamos nuestro constructor
public function __construct(){

}

public function editar($id_comp_pago,$nombre,$serie_comprobante,$num_comprobante){
	$sql="UPDATE comp_pago SET nombre='$nombre',serie_comprobante='$serie_comprobante',num_comprobante='$num_comprobante' 
	WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}
public function desactivar($id_comp_pago){
	$sql="UPDATE comp_pago SET condicion='0' WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}
public function activar($id_comp_pago){
	$sql="UPDATE comp_pago SET condicion='1' WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsulta($sql);
}

//metodo para mostrar registros
public function mostrar($id_comp_pago){
	$sql="SELECT * FROM comp_pago WHERE id_comp_pago='$id_comp_pago'";
	return ejecutarConsultaSimpleFila($sql);
}

//listar registros
public function listar(){
	$sql="SELECT * FROM comp_pago WHERE nombre != 'Cotización'";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function select(){
	$sql="SELECT * FROM comp_pago WHERE condicion=1 AND nombre != 'Cotización' AND nombre != 'NC' AND nombre != 'NCB'";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function selectNC(){
	$sql="SELECT * FROM comp_pago WHERE condicion=1 AND nombre IN ('NC', 'NCB')";
	return ejecutarConsulta($sql);
}
//listar y mostrar en selct
public function selectDocumentos(){
	$sql="SELECT idventa, serie_comprobante, num_comprobante FROM venta WHERE dov_Estado='ACEPTADO' AND (estado != 'Nota Credito' AND estado !='Anulado') AND tipo_comprobante IN ('Boleta','Factura','Nota')";
	return ejecutarConsulta($sql);
}

public function selectMotivos(){
	$sql="SELECT * FROM motivos_nota WHERE condicion = '1'";
	return ejecutarConsulta($sql);
}

//listar y mostrar en selct
public function select2(){
	$sql="SELECT * FROM comp_pago WHERE condicion=1 AND nombre = 'Cotización'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_ticket(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='Nota de Venta'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_ticket(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='Nota de Venta'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_boleta(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='Boleta'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_boleta(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='Boleta'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_nc(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='NC'";
	return ejecutarConsulta($sql);
}

public function mostrar_numero_ncb(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='NCB'";
	return ejecutarConsulta($sql);
}

public function mostrar_serie_nc(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='NC'";
	return ejecutarConsulta($sql);
}

public function mostrar_serie_ncb(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='NCB'";
	return ejecutarConsulta($sql);
}

public function mostrar_serie_factura(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='Factura'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_factura(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='Factura'";
	return ejecutarConsulta($sql);
}
public function mostrar_serie_cotizacion(){
	$sql="SELECT serie_comprobante, num_comprobante FROM comp_pago WHERE nombre='Cotización'";
	return ejecutarConsulta($sql);
}
public function mostrar_numero_cotizacion(){
	$sql="SELECT num_comprobante FROM comp_pago WHERE nombre='Cotización'";
	return ejecutarConsulta($sql);
}
}

?>