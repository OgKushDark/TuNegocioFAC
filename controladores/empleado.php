<?php 
require_once "../modelos/Empleado.php";

$empleado=new Empleado();

$idpersonal=isset($_POST["idpersonal"])? limpiarCadena($_POST["idpersonal"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':

		if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/personal/" . $imagen);
			}
		}
		if (empty($idpersonal)){
			$rspta=$empleado->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$imagen);
			echo $rspta ? "Empleado registrado" : "Empleado no se pudo registrar";
		}
		else {
			$rspta=$empleado->editar($idpersonal,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$imagen);
			echo $rspta ? "Empleado actualizado" : "Empleado no se pudo actualizar";
		}
	break;

	case 'desactivar':
		$rspta=$empleado->desactivar($idpersonal);
 		echo $rspta ? "Empleado Desactivado" : "Empleado no se puede desactivar";
	break;

	case 'activar':
		$rspta=$empleado->activar($idpersonal);
 		echo $rspta ? "Empleado activado" : "Empleado no se puede activar";
	break;

	case 'mostrar':
		$rspta=$empleado->mostrar($idpersonal);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		
	break;

	case 'listar':
		$rspta=$empleado->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
		 			$data[]=array(
		 				"0"=>$reg->nombre,
		 				"1"=>$reg->tipo_documento,
		 				"2"=>$reg->num_documento,
		 				"3"=>$reg->telefono,
		 				"4"=>$reg->email,
		 				"5"=>"<img src='../files/personal/".$reg->imagen."' height='50px' width='50px' >",
		 				"6"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
		 				'<span class="badge bg-red">DESACTIVADO</span>',
		 				"7"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersonal.')"><i class="fa fa-pencil"></i></button>'.
		 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idpersonal.')"><i class="fa fa-close"></i></button>':
		 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idpersonal.')"><i class="fa fa-pencil"></i></button>'.
		 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idpersonal.')"><i class="fa fa-check"></i></button>'
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