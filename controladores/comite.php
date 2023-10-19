<?php 
require_once "../modelos/Comite.php";

$comite=new Comite();

$idcomite=isset($_POST["idcomite"])? limpiarCadena($_POST["idcomite"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$responsable=isset($_POST["responsable"])? limpiarCadena($_POST["responsable"]):"";
$dirresponsable=isset($_POST["dirresponsable"])? limpiarCadena($_POST["dirresponsable"]):"";
$cocinero=isset($_POST["cocinero"])? limpiarCadena($_POST["cocinero"]):"";
$idzona=isset($_POST["idzona"])? limpiarCadena($_POST["idzona"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcomite)){
			$rspta=$comite->insertar($nombre,$direccion, $responsable, $dirresponsable, $cocinero,$idzona);
			echo $rspta ? "Comite registrada" : "Comite no se pudo registrar";
		}
		else {
			$rspta=$categoria->editar($idcategoria,$nombre);
			echo $rspta ? "Categoría actualizada" : "Categoría no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$categoria->desactivar($idcategoria);
 		echo $rspta ? "Categoría Desactivada" : "Categoría no se puede desactivar";
 		break;
	break;

	case 'activar':
		$rspta=$categoria->activar($idcategoria);
 		echo $rspta ? "Categoría activada" : "Categoría no se puede activar";
 		break;
	break;

	case 'mostrar':
		$rspta=$categoria->mostrar($idcategoria);
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
 				"1"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"2"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcomite.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idcomite.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcomite.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idcomite.')"><i class="fa fa-check"></i></button>'
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