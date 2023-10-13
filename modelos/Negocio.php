<?php 
//incluir la conexion de base de datos
require "../configuraciones/Conexion.php";
class Negocio{


	//implementamos nuestro constructor
public function __construct(){

}

//metodo insertar regiustro
public function insertar($nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo,$usuario_sol,$clave_sol,$ruta_certificado,$clave_certificado,$estado_certificado){
	$sql="INSERT INTO datos_negocio (nombre,ndocumento,documento,direccion,telefono,email,logo,pais,ciudad,nombre_impuesto,monto_impuesto,moneda,simbolo,usuario_sol,clave_sol,estado_certificado,ruta_certificado,clave_certificado,condicion)
	 VALUES ('$nombre','$ndocumento','$documento','$direccion','$telefono','$email','$logo','$pais','$ciudad','$nombre_impuesto','$monto_impuesto','$moneda','$simbolo','$usuario_sol','$clave_sol','$estado_certificado','$ruta_certificado','$clave_certificado','1')";
	return ejecutarConsulta($sql);
}

public function editar($id_negocio,$nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo,$usuario_sol,$clave_sol,$ruta_certificado,$clave_certificado,$estado_certificado){
	$sql="UPDATE datos_negocio SET nombre='$nombre',ndocumento='$ndocumento',documento='$documento',direccion='$direccion',telefono='$telefono',email='$email',logo='$logo',pais='$pais',ciudad='$ciudad',nombre_impuesto='$nombre_impuesto',monto_impuesto='$monto_impuesto',moneda='$moneda',simbolo='$simbolo',usuario_sol='$usuario_sol',clave_sol='$clave_sol',ruta_certificado='$ruta_certificado',clave_certificado='$clave_certificado',estado_certificado='$estado_certificado'
	WHERE id_negocio='$id_negocio'";
	 return ejecutarConsulta($sql);
}

public function desactivar($id_negocio){
	$sql="UPDATE datos_negocio SET condicion='0' WHERE id_negocio='$id_negocio'";
	return ejecutarConsulta($sql);
}
public function activar($id_negocio){
	$sql="UPDATE datos_negocio SET condicion='1' WHERE id_negocio='$id_negocio'";
	return ejecutarConsulta($sql);
}
//metodo para mostrar registros
public function mostrar($id_negocio){
	$sql="SELECT * FROM datos_negocio WHERE id_negocio='$id_negocio'";
	return ejecutarConsultaSimpleFila($sql);
}

public function mostrar_impuesto(){
	$sql="SELECT monto_impuesto FROM datos_negocio";
	return ejecutarConsulta($sql);
}
public function nombre_impuesto(){
	$sql="SELECT nombre_impuesto FROM datos_negocio";
	return ejecutarConsulta($sql);
}
public function mostrar_registros(){
	$sql="SELECT id_negocio FROM datos_negocio";
	return ejecutarConsulta($sql);
}
public function mostrar_simbolo(){
	$sql="SELECT simbolo FROM datos_negocio";
	return ejecutarConsulta($sql);
}
//listar registros
public function listar(){
	$sql="SELECT * FROM datos_negocio";
	return ejecutarConsulta($sql);
}

}

 ?>
