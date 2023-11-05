<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Comite
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($nombre,$direccion,$responsable,$DNI,$dirresponsable,$cocinero, $DNIc,$idzona)
	{
		$sql="INSERT INTO comite (nombre,direccion, responsable,DNI, dirresponsable, cocinero,DNIc, idzona,condicion)
		VALUES ('$nombre','$direccion','$responsable','$DNI','$dirresponsable','$cocinero','$DNIc','$idzona','1')";
		return ejecutarConsulta($sql);
	}

	public function insertarB($beneficiario, $DNI,$edad, $tipo , $responsable,$DNIr,$idcomites)
	{
		$sql="INSERT INTO beneficiario (nombre,DNI, edad, tipo, responsable,DNIr, idcomite,condicion)
		VALUES ('$beneficiario', '$DNI','$edad','$tipo', '$responsable','$DNIr','$idcomites','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idcomite,$nombre,$direccion,$responsable,$DNI,$dirresponsable,$cocinero, $DNIc,	$idzona)
	{
		$sql="UPDATE comite SET nombre='$nombre', direccion='$direccion',responsable='$responsable', 
								DNI ='$DNI',dirresponsable='$dirresponsable',cocinero='$cocinero',DNIc='$DNIc', idzona='$idzona'
		WHERE idcomite='$idcomite'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para desactivar categorías
	public function desactivar($idcomite)
	{
		$sql="UPDATE comite SET condicion='0' WHERE idcomite='$idcomite'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activar($idcomite)
	{
		$sql="UPDATE comite SET condicion='1' WHERE idcomite='$idcomite'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idcomite)
	{
		$sql="SELECT * FROM comite WHERE idcomite='$idcomite'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function beneficiario($idcomite)
	{
		$sql="SELECT idcomite, nombre FROM comite WHERE idcomite='$idcomite'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function beneficiarioL($idcomite)
	{
		$sql="SELECT c.idcomite,c.nombre as Comite, b.nombre,b.DNI,  b.responsable, b.DNIr 
				FROM comite c
				inner join beneficiario b on b.idcomite = c.idcomite where c.idcomite='$idcomite' and 
				b.condicion='1'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listar()
	{
		$sql="SELECT c.idcomite, c.nombre, c.direccion, c.responsable, c.DNI, c.dirresponsable,  c.cocinero,c.DNIc, z.nombre as Zona, c.condicion
 					 FROM comite c
 					 inner join zona z on z.idzona = c.idzona";
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