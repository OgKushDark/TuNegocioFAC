<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Zona
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre)
	{
		$sql="INSERT INTO zona (nombre,condicion)
		VALUES ('$nombre','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idzona,$nombre)
	{
		$sql="UPDATE zona SET nombre='$nombre' WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idzona)
	{
		$sql="UPDATE zona SET condicion='0' WHERE idzona='$idzona';";
		return ejecutarConsulta($sql);
	}
	public function desactivarC($idzona)
	{
		$sql="UPDATE comite SET condicion='0' WHERE  idzona='$idzona';";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idzona)
	{
		$sql="UPDATE zona SET condicion='1' WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}
	public function activarC($idzona)
	{
		$sql="UPDATE comite SET condicion='1' WHERE idzona='$idzona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idzona)
	{
		$sql="SELECT * FROM zona WHERE idzona='$idzona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM zona";
		return ejecutarConsulta($sql);		
	}
	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM zona where condicion=1";
		return ejecutarConsulta($sql);		
	}
}

?>