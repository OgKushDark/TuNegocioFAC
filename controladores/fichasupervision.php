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


$idComite=isset($_POST["idComite"])? $_POST["idComite"] : '' ;

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$fecha_hora,$idzona);
			echo $rspta ? "Persona registrado" : "Persona no se pudo registrar";
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
?>