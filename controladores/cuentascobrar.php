<?php 
require_once "../modelos/CuentasCobrar.php";

$cuentascobrar=new CuentasCobrar();

$idcpc=isset($_POST["idcpc"])? limpiarCadena($_POST["idcpc"]):"";
$idventa=isset($_POST["idventa"])? limpiarCadena($_POST["idventa"]):"";
$montopagado=isset($_POST["montoPagar"])? limpiarCadena($_POST["montoPagar"]):"";
$observacion=isset($_POST["observacion"])? limpiarCadena($_POST["observacion"]):"";

$fechaPago=isset($_POST["fechaPago"])? limpiarCadena($_POST["fechaPago"]):"";
$formapago=isset($_POST["formapago"])? limpiarCadena($_POST["formapago"]):"";

	switch ($_GET["op"]){

		case 'guardaryeditar':
		
			$rspta=$cuentascobrar->insertar($idcpc,$montopagado,$observacion,$fechaPago,$formapago);
			echo $rspta ? "Abono registrado" : "Abono no se pudo registrar";
			
		break;

		case 'listar':

			$fecha_inicio=$_REQUEST["fecha_inicio"];
			$fecha_fin=$_REQUEST["fecha_fin"];
			$estado=$_REQUEST["estado"];

			$rspta=$cuentascobrar->listar($fecha_inicio,$fecha_fin,$estado);
	 		//Vamos a declarar un array
	 		$data= Array();

	 		while ($reg=$rspta->fetch_object()){
	 			$url1='../reportes/exTicketCC.php?id=';
	 			$data[]=array(
	 				"0"=>$reg->fecharegistro,
	 				"1"=>$reg->tipo_comprobante,
	 				"2"=>$reg->nombre,
	 				"3"=>$reg->num_documento,
	 				"4"=>$reg->deudatotal,
	 				"5"=>$reg->abonototal,
	 				"6"=>$reg->fechavencimiento,
	 				"7"=>($reg->deudatotal == $reg->abonototal)?'<center><span class="badge bg-green">Cancelado</span></center>':'<center><span class="badge bg-red">Por Cancelar</span></center>',
	 				"8"=>'<center><a target="_blank" href="'.$url1.$reg->idventa.'" data-toggle="tooltip" title="" target="blanck" data-original-title="Ticket"> <button class="btn btn-primary btn-xs"><i class="fa fa-file-text"></i></button></a></center>',	
	 				"9"=>($reg->deudatotal == $reg->abonototal)?'<div class="dropdown">
						  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-list-ul"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						    <li style="cursor:pointer;"><a onclick="mostrarAbonos('.$reg->idcpc.')">Ver abonos</a></li>
						  </ul>
						</div>':'<div class="dropdown">
						  <button class="btn dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-list-ul"></i>
						  <span class="caret"></span></button>
						  <ul class="dropdown-menu">
						    <li style="cursor:pointer;"><a onclick="mostrar('.$reg->idcpc.')">Crear abonos</a></li>
						    <li style="cursor:pointer;"><a onclick="mostrarAbonos('.$reg->idcpc.')">Ver abonos</a></li>
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

		case 'listarDetalle':

			$idcpc=$_REQUEST["idcpc"];

			$rspta=$cuentascobrar->listarDetalle($idcpc);
	 		//Vamos a declarar un array
	 		$data= Array();

	 		while ($reg=$rspta->fetch_object()){
	 			$data[]=array(
	 				"0"=>$reg->fechapago,
	 				"1"=>$reg->montopagado,
	 				);
	 		}
	 		$results = array(
	 			"sEcho"=>1, //Información para el datatables
	 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
	 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
	 			"aaData"=>$data);
	 		echo json_encode($results);

		break;

		case 'mostrar':
		$rspta=$cuentascobrar->mostrar($idcpc);
		echo json_encode($rspta);
		break;

	}

?>