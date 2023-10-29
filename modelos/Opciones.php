<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Opciones
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre, $tipo_opcion)
	{
		$sql="INSERT INTO opciones (nombre, tipo,condicion)
		VALUES ('$nombre','$tipo_opcion','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idopciones,$nombre)
	{
		$sql="UPDATE opciones SET nombre='$nombre' WHERE idopciones='$idopciones'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idopciones)
	{
		$sql="UPDATE opciones SET condicion='0' WHERE idopciones='$idopciones'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idopciones)
	{
		$sql="UPDATE opciones SET condicion='1' WHERE idopciones='$idopciones'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idopciones)
	{
		$sql="SELECT * FROM opciones WHERE idopciones='$idopciones'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT * FROM opciones";
		return ejecutarConsulta($sql);		
	}
	
}

?>