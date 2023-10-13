<?php 
require_once "../modelos/UnidadMedida.php";

$unidadmedida=new UnidadMedida();

$idunidad_medida=isset($_POST["idunidad_medida"])? limpiarCadena($_POST["idunidad_medida"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idunidad_medida)){
			$rspta=$unidadmedida->insertar($nombre);
			echo $rspta ? "Unidad de Medida registrada" : "Unidad de Medida no se pudo registrar";
		}
		else {
			$rspta=$unidadmedida->editar($idunidad_medida,$nombre);
			echo $rspta ? "Unidad de Medida actualizada" : "Unidad de Medida no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$unidadmedida->desactivar($idunidad_medida);
 		echo $rspta ? "Unidad de Medida Desactivada" : "Unidad de Medida no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$unidadmedida->activar($idunidad_medida);
 		echo $rspta ? "Unidad de Medida activada" : "Unidad de Medida no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$unidadmedida->mostrar($idunidad_medida);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$unidadmedida->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"2"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idunidad_medida.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idunidad_medida.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idunidad_medida.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idunidad_medida.')"><i class="fa fa-check"></i></button>'
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