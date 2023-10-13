<?php 
require_once "../modelos/Cotizaciones.php";
if (strlen(session_id())<1) 
	session_start();

$venta = new Cotizacion();

$idcotizacion=isset($_POST["idcotizacion"])? limpiarCadena($_POST["idcotizacion"]):"";
$idcliente=isset($_POST["idcliente"])? limpiarCadena($_POST["idcliente"]):"";
$idpersonal=$_SESSION["idpersonal"];
$tipo_comprobante=isset($_POST["tipo_comprobante"])? limpiarCadena($_POST["tipo_comprobante"]):"";
$serie_comprobante=isset($_POST["serie_comprobante"])? limpiarCadena($_POST["serie_comprobante"]):"";
$num_comprobante=isset($_POST["num_comprobante"])? limpiarCadena($_POST["num_comprobante"]):"";
$fecha=isset($_POST["fecha"])? limpiarCadena($_POST["fecha"]):"";
$impuesto=isset($_POST["impuesto"])? limpiarCadena($_POST["impuesto"]):"";
$total_venta=isset($_POST["total_venta"])? limpiarCadena($_POST["total_venta"]):"";

$totalrecibido=isset($_POST["totalrecibido"])? limpiarCadena($_POST["totalrecibido"]):"";

require_once "../modelos/Persona.php";

$persona=new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$fecha_hora=isset($_POST["fecha_hora"])? limpiarCadena($_POST["fecha_hora"]):"";

switch ($_GET["op"]) {

	case 'guardaryeditar':

	if (empty($idcotizacion)) {
		$rspta=$venta->insertar($idcliente,$idpersonal,$tipo_comprobante,$serie_comprobante,$num_comprobante,$fecha,$total_venta,$_POST["idproducto"],$_POST["cantidad"],$_POST["precio_venta"],$_POST["descuento"]); 
		echo $rspta ? "Datos registrados correctamente" : "No se pudo registrar los datos";
	}else{
        
	}
	
	break;

	case 'guardarCliente':
		if (empty($idpersona)){
			$rspta=$persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$fecha_hora);
			echo $rspta ? "Cliente registrado" : "Cliente no se pudo registrar";
		}
	break;

	case 'eliminar':
		$rspta=$venta->eliminar($idcotizacion);
 		echo $rspta ? "Cotización Eliminada" : "Cotización No Se Puedo Eliminar";
	break;

	case 'anular':
		$rspta=$venta->anular($idcotizacion);
		echo $rspta ? "Ingreso anulado correctamente" : "No se pudo anular el ingreso";
		break;
	
	case 'mostrar':
		$rspta=$venta->mostrar($idcotizacion);
		echo json_encode($rspta);
		break;

		case 'mostrardetalle':

		//recibimos el idcotizacion
		$id=$_GET['id'];

		$rspta=$venta->mostrardetalle($id);
		$total=0;
		$c=1;
		while ($reg=$rspta->fetch_object()) {

			if($c == 1){

				echo 'Pedido N° ';

				echo $reg->num_comprobante;

				echo ', CLIENTE: ';

				echo $reg->cliente;

				echo ',  LISTA DE PEDIDO: ';

			}

			echo '('.$c.')';
			echo '. '.$reg->nombre. ',  CANTIDAD:  ' .$reg->cantidad. '     ';
			$c=$c+1;
		}

		break;

		//_______________________________________________________________________________________________________

		//opcion para mostrar la numeracion y la serie_comprobante de la ticket
		case 'mostrar_num_ticket':
		//mostrando el numero de boleta de la tabla comprobantes
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_numero_cotizacion();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
            	$num_comp_tic=$reg->num_comprobante
              	);
				}
				$numero_tic_comp = (int)$num_comp_tic;
		//fin de mostrar numero de boleta de la tabla comprobantes
		$rspta=$venta->numero_venta_cotizacion();
		$data=Array();
		$numerot=$numero_tic_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numerot=$reg->num_comprobante
              );
		}
		$numero_ticket = (int)$numerot;
		$new_ticket='';

		if($numero_ticket==9999999 or empty($numerot)){
			$new_ticket='0000001';
			echo json_encode($new_ticket);
		}elseif($numerot==9999999){
			$new_ticket='0000001';
			echo json_encode($new_ticket);

		}else{
			$sumatic=$numero_ticket+1;
			echo json_encode($sumatic);
		} 
		//$num = (int)$numerof; 
		//echo json_encode($numerof);
		break;
	case 'mostrar_s_ticket':
	//mostrando el numero de factura de la tabla comprobantes
	require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->mostrar_serie_cotizacion();
			$data=Array();
			while ($reg=$rspta->fetch_object()) {
				$data[]=array(
				$serie_comp_tic=$reg->serie_comprobante,
				$num_comp_tic=$reg->num_comprobante
              	);
				}
				$serie_tic_comp = (int)$serie_comp_tic;
				$num_tic_comp = (int)$num_comp_tic;
//fin de mostrar numero de factura de la tabla comprobantes
		$rspta=$venta->numero_serie_cotizacion();
		$data=Array();
		$numero_s_tic=$serie_tic_comp;
		$numero_bolet=$num_tic_comp;

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            $numero_s_tic=$reg->serie_comprobante,
            $numero_bolet=$reg->num_comprobante
              );
		}
		$num_s_ticket = (int)$numero_s_tic;
		$nuew_serie_ticket=0;
		$numbo = (int)$numero_bolet;
		if($numbo==9999999 or empty($numero_s_tic)){
			$nuew_serie_ticket=$num_s_ticket+1;
			echo json_encode($nuew_serie_ticket);
		}else{
			echo json_encode($num_s_ticket);
		} 
		break;//fin de opcion de mostrar num_comprobante y serie_comprobante del ticket
		
		//______________________________________________________________________________________________


	case 'listarDetalle':

		require_once "../modelos/Negocio.php";
		  $cnegocio = new Negocio();
		  $rsptan = $cnegocio->listar();
		  $regn=$rsptan->fetch_object();
		  if (empty($regn)) {
		    $smoneda='Simbolo de moneda';
		  }else{
		    $smoneda=$regn->simbolo;
		    $nom_imp=$regn->nombre_impuesto;
		};

		//recibimos el idcotizacion
		$id=$_GET['id'];

		$rspta=$venta->listarDetalle($id);
		$total=0;
		echo ' <thead style="background-color:#A9D0F5">
        <th>Opciones</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio Venta</th>
        <th>Descuento</th>
        <th>Subtotal</th>
       </thead>';
		while ($reg=$rspta->fetch_object()) {
			echo '<tr class="filas">
			<td></td>
			<td>'.$reg->nombre.'</td>
			<td>'.$reg->cantidad.'</td>
			<td>'.$reg->precio_venta.'</td>
			<td>'.$reg->descuento.'</td>
			<td>'.$reg->subtotal.'</td></tr>';
			$total=$reg->total_venta;

		}

		echo '<tfoot>
         <th></th>
         <th></th>
         <th></th>
         <th></th>
         <th>TOTAL</th>
         <th><h4 id="total">'.$smoneda.' '.$total.'</h4><input type="hidden" name="total_venta" id="total_venta"></th>
       </tfoot>';

		break;

		case 'listarDetalleCotizacion':

		$rspta=$venta->ventadetalle($idcotizacion);

		$data=Array();

 		while ($reg=$rspta->fetch_object()) {

				$data[]=array(
					"0"=>$reg->idproducto,
					"1"=>$reg->producto,
					"2"=>$reg->cantidad,
					"3"=>$reg->descuento,
					"4"=>$reg->precio_venta,
					"5"=>$reg->stock,
					"6"=>$reg->proigv,
					"7"=>$reg->unidadmedida
				);
			}

			echo json_encode($data);


	break;

    case 'listar':

		$rspta=$venta->listar();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
                 	$url1='../reportes/exTicketCoti.php?id=';
                    $url2='../reportes/exFacturaCoti.php?id=';

			$data[]=array(
            "0"=>$reg->fecha,
            "1"=>$reg->cliente,
            "2"=>$reg->personal,
            "3"=>$reg->tipo_comprobante,
            "4"=>$reg->serie_comprobante. '-' .$reg->num_comprobante,
            "5"=>$reg->total_venta,
            "6"=>'<button class="btn btn-warning btn-xs" onclick="mostrar('.$reg->idcotizacion.')" data-toggle="tooltip" title="" target="blanck" data-original-title="VER"><i class="fa fa-eye"></i></button>'.' '.
            '<button class="btn btn-danger btn-xs" onclick="mostrarE('.$reg->idcotizacion.')" data-toggle="tooltip" title="" target="blanck" data-original-title="DUPLICAR COTIZACIÓN"><i class="fa fa-copy"></i></button>'.
            '<a target="_blank" href="'.$url2.$reg->idcotizacion.'" data-toggle="tooltip" title="" target="blanck" data-original-title="PDF"> <button class="btn btn-info btn-xs"><i class="fa fa-file"></i></button></a>'.
            '<a target="_blank" data-toggle="tooltip" title="" target="blanck" data-original-title="ENVIAR COMPROBANTE"> <button class="btn btn-success btn-xs" onclick="EnviarComprobante('.$reg->idcotizacion.')"><i class="fa fa-whatsapp"></i></button></a>'.
            ' <button class="btn btn-danger btn-xs" onclick="eliminar('.$reg->idcotizacion.')"><i class="fa fa-trash"></i></button>'
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);
		break;

		case 'selectCliente':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarc();

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersona.'>'.$reg->nombre. ' - ' .$reg->num_documento.'</option>';
			}
		break;

		case 'selectProducto':
			require_once "../modelos/Producto.php";
			$persona = new Producto();

			$rspta = $persona->listar();

			echo '<option value="Todos">Todos</options>';

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idproducto.'>'.$reg->nombre. '</option>';
			}
		break;

		case 'selectVendedor':
			require_once "../modelos/Persona.php";
			$persona = new Persona();

			$rspta = $persona->listarv();

			echo '<option value="Todos">Todos</options>';

			while ($reg = $rspta->fetch_object()) {
				echo '<option value='.$reg->idpersonal.'>'.$reg->nombre. ' - ' .$reg->num_documento.'</option>';
			}
		break;

			case 'listarArticulos':
			require_once "../modelos/Producto.php";
			$producto=new Producto();

				$rspta=$producto->listarActivosVenta();
		$data=Array();

		while ($reg=$rspta->fetch_object()) {
			$data[]=array(
            "0"=>(($reg->stock==0)?'<button class="btn btn-danger" onclick="nostock()"> <span class="fa fa-shopping-cart"></span></button>':'<button class="btn btn-success" onclick="agregarDetalle('.$reg->idproducto.',\''.$reg->nombre.'\',1,0,\''.$reg->precio_venta.'\',\''.$reg->precioB.'\',\''.$reg->precioC.'\',\''.$reg->precioD.'\',\''.$reg->stock.'\',\''.$reg->unidadmedida.'\')"><span class="fa fa-shopping-cart"></span></button>'),
            "1"=>$reg->nombre,
            "2"=>$reg->categoria,
            "3"=>$reg->codigo,
            "4"=>$reg->stock,
            "5"=>$reg->precio_venta,
            "6"=>"<img src='../files/productos/".$reg->imagen."' height='50px' width='50px'>"
          
              );
		}
		$results=array(
             "sEcho"=>1,//info para datatables
             "iTotalRecords"=>count($data),//enviamos el total de registros al datatable
             "iTotalDisplayRecords"=>count($data),//enviamos el total de registros a visualizar
             "aaData"=>$data); 
		echo json_encode($results);

				break;

	case 'selectComprobante':
			require_once "../modelos/Comprobantes.php";
			$comprobantes=new Comprobantes();

			$rspta=$comprobantes->select2();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->nombre.'>'.$reg->nombre.'</option>';
			}
			break;

	case 'selectCotizaciones':
			require_once "../modelos/Cotizaciones.php";
			$venta=new Cotizacion();

			$rspta=$venta->listar();

			while ($reg=$rspta->fetch_object()) {
				echo '<option value=' . $reg->idcotizacion.'>'.$reg->serie_comprobante.'-'.$reg->num_comprobante.'</option>';
			}
	break;	

	case 'buscarProducto':

		$codigo=$_REQUEST["codigo"];

		$rspta=$venta->buscarProducto($codigo);
 		//Codificar el resultado utilizando json
 		echo json_encode($rspta);

	break;
}
 ?>