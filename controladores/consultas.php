<?php
ob_start();
if (strlen(session_id()) < 1) {
	session_start(); //Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"])) {
	header("Location: ../vistas/login.html"); //Validamos el acceso solo a los usuarios logueados al sistema.
} else {
	require_once "../modelos/Consultas.php";

	$consulta = new Consultas();

	$idbeneficiario=isset($_POST["idbeneficiario"])? limpiarCadena($_POST["idbeneficiario"]):"";
	$beneficiario=isset($_POST["beneficiario"])? limpiarCadena($_POST["beneficiario"]):"";
	$DNI=isset($_POST["DNI"])? limpiarCadena($_POST["DNI"]):"";
	$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";
	$edad=isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
	$DNIr=isset($_POST["DNIr"])? limpiarCadena($_POST["DNIr"]):"";
	$tipo=isset($_POST["tipo_opcion"])? limpiarCadena($_POST["tipo_opcion"]):"";
	switch ($_GET["op"]) {

		

		case 'mostrar':
			$rspta=$consulta->mostrar($idbeneficiario);
	 		//Codificar el resultado utilizando json
	 		echo json_encode($rspta);
	 		break;
		break;

		case 'ListaBeneficiario':
			$idcomite = $_REQUEST["idcomite"];

			$rspta = $consulta->ListaBeneficiario($idcomite);
			//Vamos a declarar un array
			$data = array();

			while ($reg = $rspta->fetch_object()) {
				$data[] = array(
					"0" => $reg->nombre,
					"1" => $reg->DNI,
					"2" => $reg->edad,
					"3" => $reg->tipo,
					"4" => $reg->responsable,
					"5" => $reg->DNIr,
					"6"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 					'<span class="badge bg-red">DESACTIVADO</span>',
					"7"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idbeneficiario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivarB('.$reg->idbeneficiario.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idbeneficiario.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activarB('.$reg->idbeneficiario.')"><i class="fa fa-check"></i></button>',
				);
			}
			$results = array(
				"sEcho" => 1, //Información para el datatables
				"iTotalRecords" => count($data), //enviamos el total registros al datatable
				"iTotalDisplayRecords" => count($data), //enviamos el total registros a visualizar
				"aaData" => $data
			);
			echo json_encode($results);

			break;

		case 'editarB':
		
			$rspta=$consulta->editarB($idbeneficiario,$beneficiario,$DNI,$edad, $tipo, $responsable,$DNIr);
			echo $rspta ? "Beneficiario actualizado" : "Beneficiario no se pudo actualizar";
		
		break;

		case 'desactivarB':
		$rspta=$consulta->desactivarB($idbeneficiario);
 		echo $rspta ? "Beneficiario Desactivado" : "Beneficiario no se puede desactivar";
 		break;
	break;

	case 'activarB':
		$rspta=$consulta->activarB($idbeneficiario);
 		echo $rspta ? "Beneficiario activado" : "Beneficiario no se puede activar";
 		break;
	break;

		

		
	}
}
ob_end_flush();
