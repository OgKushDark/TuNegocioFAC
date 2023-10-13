<?php 
require_once "../modelos/Producto.php";

$producto=new Producto();

$idproducto=isset($_POST["idproducto"])? limpiarCadena($_POST["idproducto"]):"";
$idcategoria=isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]):"";
$idunidad_medida=isset($_POST["idunidad_medida"])? limpiarCadena($_POST["idunidad_medida"]):"";
$idmarca=isset($_POST["idmarca"])? limpiarCadena($_POST["idmarca"]):"";
$codigo=isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$stockMinimo=isset($_POST["stockMinimo"])? limpiarCadena($_POST["stockMinimo"]):"";
$precio=isset($_POST["precio"])? limpiarCadena($_POST["precio"]):"";
$precioB=isset($_POST["precioB"])? limpiarCadena($_POST["precioB"]):"";
$precioC=isset($_POST["precioC"])? limpiarCadena($_POST["precioC"]):"";
$precioD=isset($_POST["precioD"])? limpiarCadena($_POST["precioD"]):"";
$precioCompra=isset($_POST["precioCompra"])? limpiarCadena($_POST["precioCompra"]):"";
$fecha=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";
$descripcion=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";
$modelo=isset($_POST["modelo"])? limpiarCadena($_POST["modelo"]):"";
$nserie=isset($_POST["nserie"])? limpiarCadena($_POST["nserie"]):"";

$tipoigv=isset($_POST["tipoigv"])? limpiarCadena($_POST["tipoigv"]):"";

$idproductoE=isset($_POST["idproductoE"])? limpiarCadena($_POST["idproductoE"]):"";
$idproductoD=isset($_POST["idproductoD"])? limpiarCadena($_POST["idproductoD"]):"";
$cantidadE=isset($_POST["cantidadE"])? limpiarCadena($_POST["cantidadE"]):"";
$cantidadD=isset($_POST["cantidadD"])? limpiarCadena($_POST["cantidadD"]):"";
$productoEmpaquetado=isset($_POST["productoE"])? limpiarCadena($_POST["productoE"]):"";
$productoDesempaquetar=isset($_POST["productoD"])? limpiarCadena($_POST["productoD"]):"";


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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/productos/" . $imagen);
			}
		}
		if (empty($idproducto)){
			$rspta=$producto->insertar($idcategoria,$idunidad_medida,$idmarca,$codigo,$nombre,$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv);
			echo $rspta ? "Producto registrado" : "Producto no se pudo registrar";
		}
		else {
			$rspta=$producto->editar($idproducto,$idcategoria,$idunidad_medida,$idmarca,$codigo,$nombre,$stock,$stockMinimo,$precio,$precioB,$precioC,$precioD,$precioCompra,$fecha,$descripcion,$imagen,$modelo,$nserie,$tipoigv);
			echo $rspta ? "Producto actualizado" : "Producto no se pudo actualizar";
		}
	break;

	case 'actualizarProductoEmpaquetado':
			$rspta=$producto->desempaquetar($idproductoE,$idproductoD,$cantidadE,$cantidadD,$productoEmpaquetado,$productoDesempaquetar);
			echo $rspta ? "Producto desempaquetado" : "Producto no se puede desempaquetar";
	break;

	case 'desactivar':
		$rspta=$producto->desactivar($idproducto);
 		echo $rspta ? "Producto Desactivado" : "Producto no se puede desactivar";
	break;

	case 'activar':
		$rspta=$producto->activar($idproducto);
 		echo $rspta ? "Producto activado" : "Producto no se puede activar";
	break;

	case 'mostrar':
		$rspta=$producto->mostrar($idproducto);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'porcentaje':
		$rspta=$producto->porcentaje($idcategoria);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listar':
		$rspta=$producto->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->nombre,
				"1"=>$reg->unidad,
 				"2"=>$reg->categoria,
 				"3"=>$reg->codigo,
 				"4"=>($reg->stock > $reg->stock_minimo)?$reg->stock:
 				'<span class="badge bg-red">'.$reg->stock.'</span>',
 				"5"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px' >",
 				"6"=>($reg->condicion)?'<span class="badge bg-green">ACTIVADO</span>':
 				'<span class="badge bg-red">DESACTIVADO</span>',
 				"7"=>($reg->condicion)?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="desactivar('.$reg->idproducto.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idproducto.')"><i class="fa fa-pencil"></i></button>'.
 					' <button class="btn btn-primary btn-xs" onclick="activar('.$reg->idproducto.')"><i class="fa fa-check"></i></button>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	case "selectCategoria":
		require_once "../modelos/Categoria.php";
		$categoria = new Categoria();

		$rspta = $categoria->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
				}
	break;

	case "selectUnidadMedida":
		require_once "../modelos/UnidadMedida.php";
		$unidadmedida = new UnidadMedida();

		$rspta = $unidadmedida->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idunidad_medida . '>' . $reg->nombre . '</option>';
				}
	break;
	
	case "selectMarca":
		require_once "../modelos/Marca.php";
		$marca = new Marca();

		$rspta = $marca->select();

		while ($reg = $rspta->fetch_object())
				{
					echo '<option value=' . $reg->idmarca . '>' . $reg->nombre . '</option>';
				}
	break;

	case 'mostrarStockProductoE':

		$idproducto = $_REQUEST["idproductoE"];

		$rspta = $producto->mostrarStockProductoE($idproducto);
		echo json_encode($rspta);

		break;

	case 'mostrarStockProductoD':

		$idproducto = $_REQUEST["idproductoD"];

		$rspta = $producto->mostrarStockProductoD($idproducto);
		echo json_encode($rspta);

		break;
}
?>