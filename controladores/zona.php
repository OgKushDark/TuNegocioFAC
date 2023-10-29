<?php 
require_once "../modelos/zona.php";

$zona=new zona();

$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idzona)){
			$rspta=$zona->insertar($nombre);
			echo $rspta ? "Zona registrada" : "Zona no se pudo registrar";
		}
		else {
			$rspta=$zona->editar($idzona,$nombre);
			echo $rspta ? "Zona actualizada" : "Zona no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$zona->desactivar($idzona);
 		echo $rspta ? "Zona Desactivada" : "Zona no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$zona->activar($idzona);
 		echo $rspta ? "Zona activada" : "Zona no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$zona->mostrar($idzona);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$zona->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"2"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idzona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idzona.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idzona.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idzona.')"><i class="fa fa-check"></i></button>'
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