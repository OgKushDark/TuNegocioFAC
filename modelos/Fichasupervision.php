<?php 
//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

Class Fichasupervision
{
	//Implementamos nuestro constructor
	public function __construct()
	{

	}

	//Implementamos un método para insertar registros
	public function insertar($idComite,$nombre_presidenta,$dni_presidenta,$dir_presidenta,$resp_cocina,$total_beneficiarios,
	$total_madres_responsables,$raciones_distribuidas,$racion_diaria_leche,$racion_diaria_hojuelas,$nro_dias_preparados,
	$nro_dias_preparados_hojuelas,$cantidad_utilizada_leche,$cantidad_utilizada_hojuelas,$stock_leche,$stock_hojuelas,
	$stock_leche_dia_visita,$stock_hojuelas_dia_visita,$cantidad_faltante_leche,$cantidad_faltante_hojuelas,
	$cantidad_sobrante_leche,$cantidad_sobrante_hojuelas,$idOpcion_condicion_producto,$observacion_condicion_producto,
	$idOpcion_condicion_higiene,$observacion_codicion_higiene,$idOpcion_estado_utensilios,$observacion_estado_utensilios,
	$idOpcion_apilado,$observacion_apilado,$idOpcion_humedad,$observacion_humedad,$idOpcion_seguridad,$observacion_seguridad,
	$idOpcion_ventilacion,$observacion_ventilacion,$idOpcion_iluminacion,$observacion_iluminacion,$idOpcion_limpieza,
	$observacion_limpieza,$resolucion_municipal,$acta_instalacion_comite,$libro_actas,$cartel_identificacion,$sello_comite,
	$idOpcion_control_preparacion_diario,$idOpcion_control_diario_beneficiarios,$idOpcion_participacion_rol_cocina,
	$idOpcion_apoyo_gastos,$idOpcion_asistencia_asamblea_civil,$idOpcion_asistencia_actividad_mdc,
	$idOpcion_desarrollo_otras_actividades,$observaciones_recomendaciones)
	{
		$sql="INSERT INTO ficha_supervision (idComite,nombre_presidenta,dni_presidenta,direccion_presidenta,
		nombre_responsable_cocina,total_beneficiarios,total_madres_responsables,raciones_distribuidas_visita,
		racion_diaria_leche,racion_diaria_hojuelas,nro_dias_preparados,nro_dias_preparados_hojuelas,
		cantidad_utilizada_leche,cantidad_utilizada_hojuelas,stock_leche,stock_hojuelas,stock_leche_dia_visita,
		stock_hojuelas_dia_visita,cantidad_faltante_leche,cantidad_faltante_hojuelas,cantidad_sobrante_leche,
		cantidad_sobrante_hojuelas,idOpcion_condicion_producto,observacion_condicion_producto,idOpcion_condicion_higiene,
		observacion_codicion_higiene,idOpcion_estado_utensilios,observacion_estado_utensilios,idOpcion_apilado,
		observacion_apilado,idOpcion_humedad,observacion_humedad,idOpcion_seguridad,observacion_seguridad,idOpcion_ventilacion,
		observacion_ventilacion,idOpcion_iluminacion,observacion_iluminacion,idOpcion_limpieza,observacion_limpieza,
		resolucion_municipal,acta_instalacion_comite,libro_actas,cartel_identificacion,sello_comite,idOpcion_control_preparacion_diario,
		idOpcion_control_diario_beneficiarios,idOpcion_participacion_rol_cocina,idOpcion_apoyo_gastos,idOpcion_asistencia_asamblea_civil,
		idOpcion_asistencia_actividad_mdc,idOpcion_desarrollo_otras_actividades,observaciones_recomendaciones,estado)
		VALUES ('$idComite','$nombre_presidenta','$dni_presidenta','$dir_presidenta','$resp_cocina','$total_beneficiarios','$total_madres_responsables',
		'$raciones_distribuidas','$racion_diaria_leche','$racion_diaria_hojuelas','$nro_dias_preparados','$nro_dias_preparados_hojuelas',
		'$cantidad_utilizada_leche','$cantidad_utilizada_hojuelas','$stock_leche','$stock_hojuelas','$stock_leche_dia_visita','$stock_hojuelas_dia_visita',
		'$cantidad_faltante_leche','$cantidad_faltante_hojuelas','$cantidad_sobrante_leche','$cantidad_sobrante_hojuelas','$idOpcion_condicion_producto',
		'$observacion_condicion_producto','$idOpcion_condicion_higiene','$observacion_codicion_higiene','$idOpcion_estado_utensilios','$observacion_estado_utensilios',
		'$idOpcion_apilado','$observacion_apilado','$idOpcion_humedad','$observacion_humedad','$idOpcion_seguridad','$observacion_seguridad',
		'$idOpcion_ventilacion','$observacion_ventilacion','$idOpcion_iluminacion','$observacion_iluminacion','$idOpcion_limpieza','$observacion_limpieza',
		'$resolucion_municipal','$acta_instalacion_comite','$libro_actas','$cartel_identificacion','$sello_comite','$idOpcion_control_preparacion_diario',
		'$idOpcion_control_diario_beneficiarios','$idOpcion_participacion_rol_cocina','$idOpcion_apoyo_gastos','$idOpcion_asistencia_asamblea_civil',
		'$idOpcion_asistencia_actividad_mdc','$idOpcion_desarrollo_otras_actividades','$observaciones_recomendaciones','1')";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para editar registros
	public function editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$fecha_hora,$idzona)
	{
		$sql="UPDATE persona SET tipo_persona='$tipo_persona',nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email', fecha='$fecha_hora', idzona=,'$idzona' WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementamos un método para eliminar categorías
	public function eliminar($idpersona)
	{
		$sql="DELETE FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para mostrar los datos de un registro a modificar
	public function mostrar($idpersona)
	{
		$sql="SELECT * FROM persona WHERE idpersona='$idpersona'";
		return ejecutarConsultaSimpleFila($sql);
	}

	//Implementar un método para listar los registros
	public function listarp()
	{
		$sql="SELECT * FROM persona WHERE tipo_persona='Proveedor'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros 
	public function listarc()
	{
		$sql="SELECT * FROM persona WHERE tipo_persona='Cliente'";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar las fichas de supervisión
	public function listarFichasSupervision()
	{
		$sql = "SELECT * FROM ficha_supervision WHERE estado = '1'";
		return ejecutarConsulta($sql);
	}

	//Implementar un método para listar los registros 
	public function listarv()
	{
		$sql="SELECT * FROM personal";
		return ejecutarConsulta($sql);		
	}

	//Implementar un método para listar los registros y mostrar en el select
	public function select()
	{
		$sql="SELECT * FROM opciones where condicion=1 and tipo='CONDICIÓN DE HIGIENE Y PREPARACION'";
		return ejecutarConsulta($sql);		
	}
	public function select1()
	{
		$sql="SELECT * FROM opciones where condicion=1 and tipo='ALMACENAMIENTO DE LOS ALIMENTOS EN LOS COMITE DE VASO DE LECHE'";
		return ejecutarConsulta($sql);		
	}
	public function select2()
	{
		$sql="SELECT * FROM opciones where condicion=1 and tipo='CONTROL DE DOCUMENTACION'";
		return ejecutarConsulta($sql);		
	}
	public function SelectComites()
	{
		$sql = "SELECT * FROM comite";
		return ejecutarConsulta($sql);
	}
	public function obtenerDataPorComite($comiteID){
		$sql = "SELECT s.direccion, s.responsable,s.dni ,s.dirresponsable,s.cocinero
				FROM zona z
				INNER JOIN comite s on s.idzona = z.idzona
				WHERE s.idcomite = '$comiteID'";
		
		return ejecutarConsulta($sql);
	}

}

?>