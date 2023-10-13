<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class CuentasCobrar
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	public function insertar($idcpc,$montopagado,$observacion,$fechaPago,$formapago){

		$sql="INSERT INTO detalle_cuentas_por_cobrar (idcpc,montopagado,observacion,formapago)
		VALUES ('$idcpc','$montopagado','$observacion','$formapago')";
		ejecutarConsulta($sql);

		$sql1="UPDATE cuentas_por_cobrar SET fechavencimiento='$fechaPago' WHERE idcpc='$idcpc'";
		return ejecutarConsulta($sql1);
		
	}

	//Implementar un método para listar los registros
	public function listar($fecha_inicio,$fecha_fin,$estado)
	{


		if($estado == "Todos"){

			$sql="SELECT cc.idcpc,DATE(cc.fecharegistro) as fecharegistro, v.tipo_comprobante, c.nombre, c.num_documento, cc.deudatotal, cc.abonototal, cc.fechavencimiento, cc.idventa 
				FROM venta v 
				INNER JOIN cuentas_por_cobrar cc
		        ON v.idventa = cc.idventa
		        INNER JOIN persona c
		        ON c.idpersona = v.idcliente
		        WHERE DATE(cc.fecharegistro)>='$fecha_inicio' AND DATE(cc.fecharegistro)<='$fecha_fin' AND condicion=1
		        ORDER BY cc.idcpc desc";

		}else if($estado == "Cancelado"){

			$sql="SELECT cc.idcpc,DATE(cc.fecharegistro) as fecharegistro, v.tipo_compro bante, c.nombre, c.num_documento, cc.deudatotal, cc.abonototal, cc.fechavencimiento, cc.idventa 
				FROM venta v 
				INNER JOIN cuentas_por_cobrar cc
		        ON v.idventa = cc.idventa
		        INNER JOIN persona c
		        ON c.idpersona = v.idcliente
		        WHERE DATE(cc.fecharegistro)>='$fecha_inicio' AND DATE(cc.fecharegistro)<='$fecha_fin' AND cc.deudatotal = cc.abonototal AND condicion=1
		        ORDER BY cc.idcpc desc";

		}else{

			$sql="SELECT cc.idcpc,DATE(cc.fecharegistro) as fecharegistro, v.tipo_comprobante, c.nombre, c.num_documento, cc.deudatotal, cc.abonototal, cc.fechavencimiento, cc.idventa 
				FROM venta v 
				INNER JOIN cuentas_por_cobrar cc
		        ON v.idventa = cc.idventa
		        INNER JOIN persona c
		        ON c.idpersona = v.idcliente
		        WHERE DATE(cc.fecharegistro)>='$fecha_inicio' AND DATE(cc.fecharegistro)<='$fecha_fin' AND cc.deudatotal > cc.abonototal AND condicion=1
		        ORDER BY cc.idcpc desc";

		}
		
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros
	public function listarDetalle($idcpc)
	{
		$sql="SELECT * FROM detalle_cuentas_por_cobrar
				WHERE idcpc = '$idcpc'
		        ORDER BY iddcpc asc";
		return ejecutarConsulta($sql);		
	}

	public function mostrar($idcpc)
	{

		$sql="SELECT v.idventa,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,cc.idcpc,DATE(cc.fecharegistro) as fecharegistro, v.tipo_comprobante, c.nombre,TRUNCATE(cc.deudatotal - cc.abonototal,2) as deudatotal, cc.deudatotal as deuda, cc.abonototal,cc.fechavencimiento 
				FROM venta v 
				INNER JOIN cuentas_por_cobrar cc
		        ON v.idventa = cc.idventa
		        INNER JOIN persona c
		        ON c.idpersona = v.idcliente
		        WHERE cc.idcpc = '$idcpc'";
		return ejecutarConsultaSimpleFila($sql);

	}

	public function mostrarTicket($idventa)
	{

		$sql="SELECT v.idventa,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,cc.idcpc,DATE(cc.fecharegistro) as fecharegistro, v.tipo_comprobante, c.nombre,TRUNCATE(cc.deudatotal - cc.abonototal,2) as deudatotal, cc.deudatotal as deuda, cc.abonototal,cc.fechavencimiento 
				FROM venta v 
				INNER JOIN cuentas_por_cobrar cc
		        ON v.idventa = cc.idventa
		        INNER JOIN persona c
		        ON c.idpersona = v.idcliente
		        WHERE cc.idventa = '$idventa'";
		return ejecutarConsulta($sql);

	}

	public function mostrarDeuda($idVenta){
		$sql="SELECT * FROM cuentas_por_cobrar WHERE idventa='".$idVenta."'";
		return ejecutarConsulta($sql);
	}

}

?>