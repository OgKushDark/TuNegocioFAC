<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Cajachica
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($tipo,$vendedor,$monto,$descripcion)
	{
		$sql="INSERT INTO movimiento (tipo,vendedor,monto,descripcion)
		VALUES ('$tipo','$vendedor','$monto','$descripcion')";
		return ejecutarConsulta($sql);
	}

	public function listar($fecha_inicio,$fecha_fin)
	{
		$sql="SELECT * FROM movimiento WHERE DATE(fecha)>='$fecha_inicio' AND DATE(fecha)<='$fecha_fin' ORDER BY idmovimiento desc";
		return ejecutarConsulta($sql);		
	}

	public function editar($idmovimiento,$tipo,$vendedor,$monto,$descripcion)
	{
		$sql="UPDATE movimiento SET tipo='$tipo', vendedor='$vendedor', monto='$monto', descripcion='$descripcion' WHERE idmovimiento='$idmovimiento'";
		return ejecutarConsulta($sql);
	}

	public function eliminar($idmovimiento)
	{
		$sql="DELETE FROM movimiento WHERE idmovimiento='$idmovimiento'";
		return ejecutarConsulta($sql);
	}

	public function mostrar($idmovimiento)
	{
		$sql="SELECT * FROM movimiento WHERE idmovimiento='$idmovimiento'";
		return ejecutarConsultaSimpleFila($sql);
	}
	
}

?>