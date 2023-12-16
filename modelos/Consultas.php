<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Consultas
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}
	

	public function ListaBeneficiario($idcomite)
	{
		
			$sql="SELECT idbeneficiario, nombre, DNI, edad, tipo, responsable, DNIr, condicion FROM beneficiario WHERE idcomite ='$idcomite'";
		
		
		
		return ejecutarConsulta($sql);		
	}
	public function ListaBeneficiarioComite($idcomite)
	{
	
					$sql="SELECT b.idbeneficiario, c.nombre FROM beneficiario b
							inner join comite c on c.idcomite =b.idcomite
					 		WHERE b.idcomite ='$idcomite'
					 		group by c.nombre";
		
		
		
		return ejecutarConsulta($sql);		
	}

	public function mostrarC($idcomite)
	{
		$sql="SELECT nombre FROM comite WHERE idcomite='$idcomite'";
		return ejecutarConsultaSimpleFila($sql);
	}

	public function mostrar($idbeneficiario)
	{
		$sql="SELECT * FROM beneficiario WHERE idbeneficiario='$idbeneficiario'";
		return ejecutarConsultaSimpleFila($sql);
	}
	public function editarB($idbeneficiario,$beneficiario,$DNI,$edad, $tipo, $responsable,$DNIr)
	{
		$sql="UPDATE beneficiario SET nombre='$beneficiario', DNI ='$DNI' , edad ='$edad',responsable='$responsable', DNIr='$DNIr'
								
		WHERE idbeneficiario='$idbeneficiario'";
		return ejecutarConsulta($sql);
	}
	//Implementamos un método para desactivar categorías
	public function desactivarB($idbeneficiario)
	{
		$sql="UPDATE beneficiario SET condicion='0' WHERE idbeneficiario='$idbeneficiario'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para activar categorías
	public function activarB($idbeneficiario)
	{
		$sql="UPDATE beneficiario SET condicion='1' WHERE idbeneficiario='$idbeneficiario'";
		return ejecutarConsulta($sql);
	}
}

?>