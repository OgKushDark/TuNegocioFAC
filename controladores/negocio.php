<?php 
session_start();
require_once "../modelos/Negocio.php";

$negocio=new Negocio();

$id_negocio=isset($_POST["id_negocio"])? limpiarCadena($_POST["id_negocio"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$ndocumento=isset($_POST["ndocumento"])? limpiarCadena($_POST["ndocumento"]):"";
$documento=isset($_POST["documento"])? limpiarCadena($_POST["documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$pais=isset($_POST["pais"])? limpiarCadena($_POST["pais"]):"";
$ciudad=isset($_POST["ciudad"])? limpiarCadena($_POST["ciudad"]):"";
$nombre_impuesto=isset($_POST["nombre_impuesto"])? limpiarCadena($_POST["nombre_impuesto"]):"";
$monto_impuesto=isset($_POST["monto_impuesto"])? limpiarCadena($_POST["monto_impuesto"]):"";
$moneda=isset($_POST["moneda"])? limpiarCadena($_POST["moneda"]):"";
$simbolo=isset($_POST["simbolo"])? limpiarCadena($_POST["simbolo"]):"";
$logo=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

$usuario_sol=isset($_POST["usuario_sol"])? limpiarCadena($_POST["usuario_sol"]):"";
$clave_sol=isset($_POST["clave_sol"])? limpiarCadena($_POST["clave_sol"]):"";
$ruta_certificado=isset($_POST["ruta_certificado"])? limpiarCadena($_POST["ruta_certificado"]):"";
$clave_certificado=isset($_POST["clave_certificado"])? limpiarCadena($_POST["clave_certificado"]):"";
$estado_certificado=isset($_POST["estado_certificado"])? limpiarCadena($_POST["estado_certificado"]):"";

switch ($_GET["op"]) {
	case 'guardaryeditar':

	if (!file_exists($_FILES['imagen']['tmp_name'])|| !is_uploaded_file($_FILES['imagen']['tmp_name'])) {
		$logo=$_POST["imagenactual"];
	}else{
		$ext=explode(".", $_FILES["imagen"]["name"]);
		if ($_FILES['imagen']['type']=="image/jpg" || $_FILES['imagen']['type']=="image/jpeg" || $_FILES['imagen']['type']=="image/png") {
			$logo=round(microtime(true)).'.'. end($ext);
			move_uploaded_file($_FILES["imagen"]["tmp_name"], "../reportes/".$logo);
		}
	}

	if(!file_exists($_FILES['ruta_certificado']['tmp_name'])|| !is_uploaded_file($_FILES['ruta_certificado']['tmp_name'])){

		$ruta_certificado="";

	}else{

		$ext=explode(".", $_FILES["ruta_certificado"]["name"]);

		$ruta_certificado=$_FILES["ruta_certificado"]["name"];

		move_uploaded_file($_FILES["ruta_certificado"]["tmp_name"], "../public/FACT_WebService/Facturacion/src/".$ruta_certificado);


	}

	if (empty($id_negocio)) {
		$rspta=$negocio->insertar($nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo,$usuario_sol,$clave_sol,$ruta_certificado,$clave_certificado,$estado_certificado);
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar todos los datos del negocio";
	}else{
		$rspta=$negocio->editar($id_negocio,$nombre,$ndocumento,$documento,$direccion,$telefono,$email,$logo,$pais,$ciudad,$nombre_impuesto,$monto_impuesto,$moneda,$simbolo,$usuario_sol,$clave_sol,$ruta_certificado,$clave_certificado,$estado_certificado);
		echo $rspta ? "Datos actualizados correctamente" : "No se pudo actualizar los datos";
	}
	break;
	

	case 'desactivar':
	$rspta=$negocio->desactivar($id_negocio);
	echo $rspta ? "Datos desactivados correctamente" : "No se pudo desactivar los datos";
	break;

	case 'activar':
	$rspta=$negocio->activar($id_negocio);
	echo $rspta ? "Datos activados correctamente" : "No se pudo activar los datos";
	break;
	
	case 'mostrar':
	$rspta=$negocio->mostrar($id_negocio);
	echo json_encode($rspta);
	break;
case 'mostrar_registros':
		$rspta=$negocio->mostrar_registros();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numeroid=$reg->id_negocio
              );
		}
		$numeroid_negocio = (int)$numeroid;
		echo json_encode($numeroid_negocio);
		break;
	case 'mostrar_impuesto':
		$rspta=$negocio->mostrar_impuesto();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numeroimp=$reg->monto_impuesto

              );
		}
		$impuesto = (floatval($numeroimp));
		echo json_encode($impuesto);
		break;
		case 'nombre_impuesto':
		$rspta=$negocio->nombre_impuesto();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $nombreimp=$reg->nombre_impuesto

              );
		}
		echo json_encode($nombreimp);
		break;
case 'mostrar_simbolo':
		$rspta=$negocio->mostrar_simbolo();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $simbolo=$reg->simbolo
              );
		}
		echo json_encode($simbolo);
		break;
	case 'listar':
	$rspta=$negocio->listar();
	$data=Array();

	while ($reg=$rspta->fetch_object()) {
		$data[]=array(
			"0"=>"<img src='../reportes/".$reg->logo."' height='50px' width='50px'>",
			"1"=>$reg->nombre,
			"2"=>$reg->ndocumento.'-'.$reg->documento,
			"3"=>$reg->direccion,
			"4"=>$reg->telefono,
			"5"=>$reg->email,
			"6"=>$reg->ciudad.'-'.$reg->pais,
			"7"=>$reg->nombre_impuesto.' '.$reg->monto_impuesto.' %',
			"8"=>$reg->simbolo.'- '.$reg->moneda,
			"9"=>'<button class="btn btn-warning btn-xs" id="btn_lista" onclick="mostrar('.$reg->id_negocio.')"><i class="fa fa-pencil"></i></button>',
		);
	}

	$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
	echo json_encode($results);
	break;
	
}
?>

