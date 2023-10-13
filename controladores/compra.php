<?php
ob_start();
if (strlen(session_id()) < 1){
	session_start();//Validamos si existe o no la sesión
}
if (!isset($_SESSION["nombre"]))
{
  header("Location: ../vistas/login.html");//Validamos el acceso solo a los usuarios logueados al sistema.
}
else
{
//Validamos el acceso solo al usuario logueado y autorizado.
if ($_SESSION['compras']==1)
{
require_once "../modelos/Compra.php";

$compra=new Compra();

$idcompra=isset($_POST["idcompra"])? limpiarCadena($_POST["idcompra"]):"";
$idproveedor=isset($_POST["idproveedor"])? limpiarCadena($_POST["idproveedor"]):"";
//Almacenar lo que tenemos en la variable sesion
$idpersonal=$_SESSION["idpersonal"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_compra=isset($_POST["total_compra"])? limpiarCadena($_POST["total_compra"]):"";

switch ($_GET["op"]){
	case 'guardaryeditar':
		if (empty($idcompra)){
			$rspta=$compra->insertar($idproveedor,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha,$impuesto,$total_compra,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_compra"],$_POST["precio_venta"]);
			echo $rspta ? "Compra registrada" : "No se pudieron registrar todos los datos de la Compra";
		}
		else {
		}
	break;

	case 'anular':
		$rspta=$compra->anular($idcompra);
 		echo $rspta ? "Compra Anulada" : "Compra no se puede anular";
	break;

	case 'mostrar':
		$rspta=$compra->mostrar($idcompra);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);
	break;

	case 'listarDetalle':
		//Recibimos el idingreso
		$id=$_GET['id'];

		$rspta = $compra->listarDetalle($id);
		$total=0;
		echo '<thead style="background-color:#A9D0F5">
									<th>Opciones</th>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Subtotal</th>
                                </thead>';

		while ($reg = $rspta->fetch_object())
				{
					echo '<tr class="filas">
					<td></td>
					<td>'.$reg->nombre.'</td>
					<td>'.$reg->cantidad.'</td>
					<td>'.$reg->precio_compra.'</td>
					<td>'.$reg->precio_venta.'</td>
					<td>'.$reg->precio_compra*$reg->cantidad.'</td>
					<td></td>
					</tr>';
					$total=$total+($reg->precio_compra*$reg->cantidad);
				}
				echo '<tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><h4 id="total">S/.'.$total.'</h4><input type="hidden" name="total_compra" id="total_compra"></th> 
                                </tfoot>';
	break;

	case 'listar':
		$rspta=$compra->listar();
 		//Vamos a declarar un array
 		$data= Array();

 		while ($reg=$rspta->fetch_object()){
 			$data[]=array(
 				"0"=>$reg->fecha,
 				"1"=>$reg->proveedor,
 				"2"=>$reg->personal,
 				"3"=>$reg->tipo_comprobante,
 				"4"=>$reg->serie_comprobante.'-'.$reg->num_comprobante,
 				"5"=>$reg->total_compra,
 				"6"=>($reg->estado=='Aceptado')?'<span class="badge bg-green">ACEPTADO</span>':
 				'<span class="badge bg-red">ANULADO</span>',
 				"7"=>(($reg->estado=='Aceptado')?'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcompra.')"><i class="fa fa-eye"></i></button>'.
 					' <button class="btn btn-danger btn-xs" onclick="anular('.$reg->idcompra.')"><i class="fa fa-close"></i></button>':
 					'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcompra.')"><i class="fa fa-eye"></i></button>').
 					'<a target="_blank" href="../reportes/exCompra.php?id='.$reg->idcompra.'"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>'
 				);
 		}
 		$results = array(
 			"sEcho"=>1, //Información para el datatables
 			"iTotalRecords"=>count($data), //enviamos el total registros al datatable
 			"iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
 			"aaData"=>$data);
 		echo json_encode($results);

	break;

	//el lisyado de todos los proveedores lo vamos a mostrar en la vista ingreso
	case 'selectProveedor':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarp();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre.' - '.$reg->num_documento.'</option>';
			}
	break;

	case 'listarArticulos':
			require_once "../modelos/Producto.php";
			$producto=new Producto();

				$rspta=$producto->listarActivos();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>$reg->nombre,
            "1"=>$reg->unidadmedida,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px'>",
            "6"=>'<button class="btn btn-warning" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',\''.$reg->precio_venta.'\',\''.$reg->precio_compra.'\',\''.$reg->unidadmedida.'\')"><span class="fa fa-plus"></span></button>'
          
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
//Fin de las validaciones de acceso
}
else
{
  require 'noacceso.php';
}
}
ob_end_flush();
?>
