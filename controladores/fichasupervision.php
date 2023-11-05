<?php 
require_once "../modelos/Fichasupervision.php";

$ficha=new Fichasupervision();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";

//OBTENEMOS LOS CAMPOS DE LA FICHA
$idComite=isset($_POST["idComite"])? $_POST["idComite"] : '' ;
$nombre_presidenta = isset($_POST["txtNombrePresidenta"]) ? $_POST["txtNombrePresidenta"] : "";
$dni_presidenta = isset($_POST["txtDni"]) ? $_POST["txtDni"] : "";
$dir_presidenta = isset($_POST["txtDireccion"]) ? $_POST["txtDireccion"] : "";
$resp_cocina = isset($_POST["txtResponsableCocina"]) ? $_POST["txtResponsableCocina"] : "";
$total_beneficiarios = isset($_POST["txtBeneficiarios"]) ? $_POST["txtBeneficiarios"]: "";
$total_madres_responsables = isset($_POST["txtMadresBeneficiarias"]) ? $_POST["txtMadresBeneficiarias"] : "";
$raciones_distribuidas = isset($_POST["txtRacionesDistribuidas"]) ? $_POST["txtRacionesDistribuidas"]: "";
$racion_diaria_leche = isset($_POST["txtRacionLeche"]) ? $_POST["txtRacionLeche"] : "";
$racion_diaria_hojuelas = isset($_POST["txtRacionHojuelas"]) ? $_POST["txtRacionHojuelas"] : "";
$nro_dias_preparados = isset($_POST["txtDias"]) ? $_POST["txtDias"] : "";
$nro_dias_preparados_hojuelas = isset($_POST["txtDiasHojuelas"]) ? $_POST["txtDiasHojuelas"] : "";
$cantidad_utilizada_leche = isset($_POST["txtCantidad"]) ? $_POST["txtCantidad"] : "";
$cantidad_utilizada_hojuelas = isset($_POST["txtCantidadHojuelas"]) ? $_POST["txtCantidadHojuelas"] : "";
$stock_leche = isset($_POST["txtStock"]) ? $_POST["txtStock"] : "";
$stock_hojuelas = isset($_POST["txtStockHojuelas"]) ? $_POST["txtStockHojuelas"] : "";
$stock_leche_dia_visita = isset($_POST["txtStockVisita"]) ? $_POST["txtStockVisita"] : "";
$stock_hojuelas_dia_visita = isset($_POST["txtStockVisitaHojuelas"]) ? $_POST["txtStockVisitaHojuelas"] : "";
$cantidad_faltante_leche = isset($_POST["txtCantidadFaltante"]) ? $_POST["txtCantidadFaltante"] : "";
$cantidad_faltante_hojuelas = isset($_POST["txtFaltanteHojuelas"]) ? $_POST["txtFaltanteHojuelas"] : "";
$cantidad_sobrante_leche = isset($_POST["txtCantidadSobrante"]) ? $_POST["txtCantidadSobrante"] : "";
$cantidad_sobrante_hojuelas = isset($_POST["txtSobranteHojuelas"]) ? $_POST["txtSobranteHojuelas"] : "";
$idOpcion_condicion_producto = isset($_POST["cbxCondicionProducto"]) ? $_POST["cbxCondicionProducto"] : "";
$observacion_condicion_producto = isset($_POST["txtObservacionProducto"]) ? $_POST["txtObservacionProducto"] : "";
$idOpcion_condicion_higiene = isset($_POST["cbxCondicionPreparacion"]) ? $_POST["cbxCondicionPreparacion"] : "";
$observacion_codicion_higiene = isset($_POST["txtObservacionPreparacion"]) ? $_POST["txtObservacionPreparacion"] : "";
$idOpcion_estado_utensilios = isset($_POST["cbxHigieneUtensilios"]) ? $_POST["cbxHigieneUtensilios"] : "";
$observacion_estado_utensilios = isset($_POST["txtObservacionUtensilios"]) ? $_POST["txtObservacionUtensilios"] : "";
$idOpcion_apilado = isset($_POST["cbxApilado"]) ? $_POST["cbxApilado"] : "";
$observacion_apilado = isset($_POST["observacion_apilado"]) ? $_POST["observacion_apilado"] : "";
$idOpcion_humedad = isset($_POST["cbxHumedad"]) ? $_POST["cbxHumedad"] : "";
$observacion_humedad = isset($_POST["txtObservacionHumedad"]) ? $_POST["txtObservacionHumedad"] : "";
$idOpcion_seguridad = isset($_POST["cbxSeguridad"]) ? $_POST["cbxSeguridad"] : "";
$observacion_seguridad = isset($_POST["txtObservacionSeguridad"]) ? $_POST["txtObservacionSeguridad"] : "";
$idOpcion_ventilacion = isset($_POST["cbxVentilacion"]) ? $_POST["cbxVentilacion"] : "";
$observacion_ventilacion = isset($_POST["txtObservacionVentilacion"]) ? $_POST["txtObservacionVentilacion"] : "";
$idOpcion_iluminacion = isset($_POST["cbxIluminacion"]) ? $_POST["cbxIluminacion"] : "";
$observacion_iluminacion = isset($_POST["txtObservacionIluminacion"]) ? $_POST["txtObservacionIluminacion"] : "";
$idOpcion_limpieza = isset($_POST["cbxLimpieza"]) ? $_POST["cbxLimpieza"] : "";
$observacion_limpieza = isset($_POST["txtObservacionLimpieza"]) ? $_POST["txtObservacionLimpieza"] : "";

$resolucion_municipal = isset($_POST["rdbResolucionMunicipalSiNo"]) ? $_POST["rdbResolucionMunicipalSiNo"] : "" ;
$acta_instalacion_comite = isset($_POST["rdbActaInstalacionSiNo"]) ? $_POST["rdbActaInstalacionSiNo"] : "" ;
$libro_actas = isset($_POST["rdbLibroActasSiNo"]) ? $_POST["rdbLibroActasSiNo"] : "";
$cartel_identificacion = isset($_POST["rdbCartelIdentificacionSiNo"]) ? $_POST["rdbCartelIdentificacionSiNo"] : "";
$sello_comite = isset($_POST["rdbSelloComiteSiNo"]) ? $_POST["rdbSelloComiteSiNo"] : "";

$idOpcion_control_preparacion_diario = isset($_POST["cbxControlDocumentacion"]) ? $_POST["cbxControlDocumentacion"] : "";
$idOpcion_control_diario_beneficiarios = isset($_POST["cbxControlBeneficiarios"]) ? $_POST["cbxControlBeneficiarios"] : "";
$idOpcion_participacion_rol_cocina = isset($_POST["cbxParticipacion"]) ? $_POST["cbxParticipacion"] : "";
$idOpcion_apoyo_gastos = isset($_POST["cbxApoyoGastos"]) ? $_POST["cbxApoyoGastos"] : "";
$idOpcion_asistencia_asamblea_civil = isset($_POST["cbxAsistenciaAsamblea"]) ? $_POST["cbxAsistenciaAsamblea"] : "";
$idOpcion_asistencia_actividad_mdc = isset($_POST["cbxAsistenciaActividad"]) ? $_POST["cbxAsistenciaActividad"] : "";
$idOpcion_desarrollo_otras_actividades = isset($_POST["cbxDesarrolloParticipacion"]) ? $_POST["cbxDesarrolloParticipacion"] : "";
$observaciones_recomendaciones = isset($_POST["txtObservacion"]) ? $_POST["txtObservacion"] : "";





switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($$idComite)){
			$rspta=$ficha->insertar($idComite,$nombre_presidenta,$dni_presidenta,$dir_presidenta,$resp_cocina,$total_beneficiarios,
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
			$idOpcion_desarrollo_otras_actividades,$observaciones_recomendaciones);
			echo $rspta ? "Ficha registrada" : "Ficha no se pudo registrar";
		}
		else {
			$rspta=$persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$fecha_hora,$idzona);
			echo $rspta ? "Persona actualizado" : "Persona no se pudo actualizar";
		}
	break;

	case 'eliminar':
		$rspta=$persona->eliminar($idpersona);
 		echo $rspta ? "Persona eliminado" : "Persona no se puede eliminar";
	break;

	case 'mostrar':
		$rspta=$persona->mostrar($idpersona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarp':
		$rspta=$persona->listarp();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->tipo_documento,
 				"2"=>$reg->num_documento,
 				"3"=>$reg->telefono,
 				"4"=>$reg->email,
 				"5"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case 'listarc':
		$rspta=$persona->listarc();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->tipo_documento,
 				"2"=>$reg->num_documento,
 				"3"=>$reg->telefono,
 				"4"=>$reg->email,
 				"5"=>$reg->fecha,
 				"6"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;
	case 'listarFichasSupervision':
		$fichas = new Fichasupervision();

		$rspta = $fichas->listarFichasSupervision();

		$data = Array();

		while($reg=$rspta->fetch_object()){
			$data[]=array(
				"0" => $reg->idFicha,
				"1" => $reg->nombre_presidenta,
				"2" => $reg->nombre_responsable_cocina,
			);
		}
			$results = array(
				"sEcho"=>1, 
 				"iTotalRecords"=>count($data), 
 				"iTotalDisplayRecords"=>count($data), 
 				"aaData"=>$data);
		echo json_encode($results);
		
		break;
	case "selectOpciones":
		require_once "../modelos/Fichasupervision.php";
		$fichas = new Fichasupervision();

		$rspta = $fichas->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idopciones . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectOpciones1":
		require_once "../modelos/Fichasupervision.php";
		$fichas = new Fichasupervision();

		$rspta = $fichas->select1();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idopciones . '>' . $reg->nombre . '</option>';
				}
	break;
	case "selectOpciones2":
		require_once "../modelos/Fichasupervision.php";
		$fichas = new Fichasupervision();

		$rspta = $fichas->select2();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idopciones . '>' . $reg->nombre . '</option>';
				}
	break;
	case "selectComites":	
		$fichas = new Fichasupervision();

		$rspta = $fichas->SelectComites();

		while($reg = $rspta->fetch_object())
				{
					echo '<option value=' .$reg->idcomite . '>' . $reg->nombre . '</option>';
				}
	break;
	case "selectComites1":	
		$fichas = new Fichasupervision();

  // Suponemos que $idzona contiene la zona seleccionada (puede obtenerse desde el formulario o la solicitud AJAX)
  $idzona = $_POST['zona']; // Asegúrate de validar y limpiar los datos recibidos desde la solicitud AJAX

  $rspta = $fichas->SelectComites1($idzona);

  // Inicializamos una variable para almacenar las opciones HTML
  $options = "";

  while ($reg = $rspta->fetch_object()) {
    // Generamos las opciones HTML basadas en los datos recuperados de la base de datos
    $options .= '<option value="' . $reg->idcomite . '">' . $reg->nombre . '</option>';
  }

  // Devolvemos las opciones como respuesta a la solicitud AJAX
  echo $options;
	break;
	case "obtenerDataPorComite":
		$fichas = new Fichasupervision();
		$rspta = $fichas->obtenerDataPorComite($idComite);
		/*echo "<script>alert(".$idComite.")</script>";*/

		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->direccion,
 				"1"=>$reg->responsable,
 				"2"=>$reg->dni,
 				"3"=>$reg->dirresponsable,
 				"4"=>$reg->cocinero
 				);
 		}
		 $results = array(
			"sEcho"=>1, //Información para el datatables
			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
			"aaData"=>$data);
 		
		echo json_encode($results);

	break;


}
