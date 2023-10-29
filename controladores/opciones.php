<?php 
require_once "../modelos/Opciones.php";

$opciones=new Opciones();

$idopciones=isset($_POST["idopciones"])? limpiarCadena($_POST["idopciones"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_opcion=isset($_POST["tipo_opcion"])? limpiarCadena($_POST["tipo_opcion"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idopciones)){
			$rspta=$opciones->insertar($nombre, $tipo_opcion);
			echo $rspta ? "Opción registrada" : "Opción no se pudo registrar";
		}
		else {
			$rspta=$opciones->editar($idopciones,$nombre, $tipo_opcion);
			echo $rspta ? "Opción registrada" : "Opción no se pudo registrar";
		}
	break;

	case 'desactivar':
		$rspta=$opciones->desactivar($idopciones);
 		echo $rspta ? "Opción Desactivada" : "Opción no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$opciones->activar($idopciones);
 		echo $rspta ? "Opción activada" : "Opción no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$opciones->mostrar($idopciones);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$opciones->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->tipo,
 				"2"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"3"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idopciones.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idopciones.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idopciones.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idopciones.')"><i class="fa fa-check"></i></button>'
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
?>