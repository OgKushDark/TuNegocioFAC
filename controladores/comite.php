<?php 
require_once "../modelos/Comite.php";

$comite=new Comite();

$idcomite=isset($_POST["idcomite"])? limpiarCadena($_POST["idcomite"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$beneficiario=isset($_POST["beneficiario"])? limpiarCadena($_POST["beneficiario"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$DNI=isset($_POST["DNI"])? limpiarCadena($_POST["DNI"]):"";
$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";
$dirresponsable=isset($_POST["dirresponsable"])? limpiarCadena($_POST["dirresponsable"]):"";
$cocinero=isset($_POST["cocinero"])? limpiarCadena($_POST["cocinero"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";
$edad=isset($_POST["edad"])? limpiarCadena($_POST["edad"]):"";
$DNIr=isset($_POST["DNIr"])? limpiarCadena($_POST["DNIr"]):"";
$idcomites=isset($_POST["idcomites"])? limpiarCadena($_POST["idcomites"]):"";
switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcomite)){
			$rspta=$comite->insertar($nombre,$direccion, $responsable,$DNI, $dirresponsable, $cocinero,$idzona);
			echo $rspta ? "Comite registrada" : "Comite no se pudo registrar";
		}
		else {
			$rspta=$comite->editar($idcomite,$nombre,$direccion, $responsable,$DNI, $dirresponsable, 	$cocinero,$idzona);
			echo $rspta ? "Comite actualizada" : "Comite no se pudo actualizar";
		}
	break;

	case 'guardarB':

		if (empty($idcomite)){
			$rspta=$comite->insertarB($beneficiario, $DNI,$edad, $responsable,$DNIr,$idcomites);
			echo $rspta ? "Beneficiario registrado" : "beneficiario no se pudo registrar";
		}
		
	break;

	case 'desactivar':
		$rspta=$comite->desactivar($idcomite);
 		echo $rspta ? "Comite Desactivada" : "Comite no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$comite->activar($idcomite);
 		echo $rspta ? "Comite activada" : "Comite no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$comite->mostrar($idcomite);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'beneficiario':
		$rspta=$comite->beneficiario($idcomite);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'listar':
		$rspta=$comite->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
 				"1"=>$reg->direccion,
 				"2"=>$reg->responsable,
 				"3"=>$reg->DNI,
 				"4"=>$reg->dirresponsable,
 				"5"=>$reg->cocinero,
 				"6"=>$reg->Zona,
 				"7"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"8"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcomite.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idcomite.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcomite.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcomite.')"><i class="fa fa-check"></i></button>',
 				"9"=>'<button class="btn btn-success btn-xs" onclick="beneficiario('.$reg->idcomite.')"><i class="fa fa-user"></i></button>'
 					
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectZona":
		require_once "../modelos/Comite.php";
		$comite = new comite();

		$rspta = $comite->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idzona . '>' . $reg->nombre . '</option>';
				}
	break;
}
?>