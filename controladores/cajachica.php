<?php 
require_once "../modelos/Cajachica.php";

$cajachica=new Cajachica();

$idmovimiento=isset($_POST["idmovimiento"])? limpiarCadena($_POST["idmovimiento"]):"";

$opcionEI=isset($_POST["opcionEI"])? limpiarCadena($_POST["opcionEI"]):"";
$nuevoVendedor=isset($_POST["nuevoVendedor"])? limpiarCadena($_POST["nuevoVendedor"]):"";
$montoPagar=isset($_POST["montoPagar"])? limpiarCadena($_POST["montoPagar"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";

switch ($_GET["op"]){

	case 'guardaryeditar':

		if (empty($idmovimiento)){
			$rspta=$cajachica->insertar($opcionEI,$nuevoVendedor,$montoPagar,$descripcion);
			echo $rspta ? "Movimiento registrada" : "Movimiento no se pudo registrar";
		}
		else {
			$rspta=$cajachica->editar($idmovimiento,$opcionEI,$nuevoVendedor,$montoPagar,$descripcion);
			echo $rspta ? "Movimiento actualizado" : "Movimiento no se pudo actualizar";
		}

	break;

	case 'mostrar':
		$rspta=$cajachica->mostrar($idmovimiento);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
 		break;
	break;

	case 'eliminar':
		$rspta=$cajachica->eliminar($idmovimiento);
 		echo $rspta ? "Movimiento eliminado" : "Movimiento no se puede eliminar";
	break;

	case 'listar':

		$fecha_inicio=$_REQUEST["fecha_inicio"];
		$fecha_fin=$_REQUEST["fecha_fin"];

		$rspta=$cajachica->listar($fecha_inicio,$fecha_fin);
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->descripcion,
 				"2"=>($reg->tipo == 'Egresos')?'<span class="badge bg-red">EGRESO</span>':
 				'<span class="badge bg-green">INGRESO</span>',
 				"3"=>$reg->monto,
 				"4"=>'<div class="dropdown">
						  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-list-ul"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						    <li style="cursor:pointer;"><a onclick="mostrar('.$reg->idmovimiento.')">Editar</a></li>
						    <li style="cursor:pointer;"><a onclick="eliminar('.$reg->idmovimiento.')">Eliminar</a></li>
						  </ul>
						</div>',
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