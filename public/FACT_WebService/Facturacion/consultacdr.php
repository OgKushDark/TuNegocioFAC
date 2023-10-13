<?php
header("Content-type: text/html; charset=utf8");


declare(strict_types=1);

require_once 'vendor/autoload.php';

use Greenter\Model\Response\StatusCdrResult;
use Greenter\Ws\Services\ConsultCdrService;
use Greenter\Ws\Services\SoapClient;
use Greenter\Ws\Services\SunatEndpoints;



//require_once '../Facturacion/vendor/autoload.php';

$errorMsg = null;
$filename = null;



$idVenta = $_GET['idventa'];
$codColab = $_GET['codColab'];

/**
 * @param array<string, string> $items
 * @return bool
 */
function validateFields(array $items): bool
{
    global $errorMsg;
    $validateFiels = ['rucSol', 'userSol', 'passSol', 'ruc', 'tipo', 'serie', 'numero'];
    foreach ($items as $key => $value) {
        if (in_array($key, $validateFiels) && empty($value)) {
            $errorMsg = 'El campo '.$key.', es requerido';
            return false;
        }
    }

    return true;
}

/**
 * @param string $user
 * @param string $password
 * @return ConsultCdrService
 */
function getCdrStatusService(?string $user, ?string $password): ConsultCdrService
{
    $ws = new SoapClient(SunatEndpoints::FE_CONSULTA_CDR.'?wsdl');
    $ws->setCredentials($user, $password);

    $service = new ConsultCdrService();
    $service->setClient($ws);

    return $service;
}

/**
 * @param string $filename
 * @param string $content
 */
function savedFile(?string $filename, ?string $content): void
{

    
    $fileDir = __DIR__.'/files/';

    if (!file_exists($fileDir)) {
        mkdir($fileDir, 0777, true);
    }
    $pathZip = $fileDir.DIRECTORY_SEPARATOR.$filename;
    file_put_contents($pathZip, $content);
}

/**
 * @param array<string, string> $fields
 * @return StatusCdrResult|null
 */
function process(array $fields): ?StatusCdrResult
{
    global $filename;

    if (!isset($fields['rucSol'])) {
        return null;
    }

    if (!validateFields($fields)) {
        return null;
    }

    $service = getCdrStatusService($fields['rucSol'].$fields['userSol'], $fields['passSol']);




    $arguments = [
        $fields['ruc'],
        $fields['tipo'],
        $fields['serie'],
        intval($fields['numero'])
    ];

    if (!isset($fields['cdr'])) {
        $result = $service->getStatusCdr(...$arguments);
        if ($result->getCdrZip()) {

$arguments[3]=Correlativo(strval($arguments[3]));
            $filename = implode('-', $arguments);

            savedFile('R-'.$filename.'.zip', $result->getCdrZip());
        }



        return $result;
   
    }


    return $service->getStatus(...$arguments);
}

function Correlativo($Correlativo){

    if(strlen($Correlativo) == 1){

        return '000000'.$Correlativo;

    }else if(strlen($Correlativo) == 2){
        return '00000'.$Correlativo;
    }else if(strlen($Correlativo) == 3){
        return '0000'.$Correlativo;
    }else if(strlen($Correlativo) == 4){
        return '000'.$Correlativo;
    }else if(strlen($Correlativo) == 5){
        return '00'.$Correlativo;
    }else if(strlen($Correlativo) == 6){
        return '0'.$Correlativo;
    }

}

//-----------------------------------------------------------------------------------------------------------------


        $util = Util::getInstance();
        $conexion = $util->abrirConexion(); 


            $resultado = mysqli_query($conexion,"SELECT * from datos_negocio");
            
            if ($resultado) {  
              foreach ($resultado as $column) {
                $ruc=$column['documento'];
                $usuario=$column['usuario_sol'];
                $contrasena=$column['clave_sol'];
                }   
            }
            
            
            
    $resultado = mysqli_query($conexion,"SELECT v.idventa as id,v.tipo_comprobante as tipoDoc,v.num_comprobante as numDoc,v.serie_comprobante as serDoc

    from detalle_venta dv

    inner join venta v on dv.idventa=v.idventa

    WHERE dv.idventa='".$idVenta."'");
    

  if ($resultado) {  
      foreach ($resultado as $column) {
        $tipoDocVenta=$column['tipoDoc'];
        $numeroDOC=$column['numDoc'];
        $serieDOC=$column['serDoc'];
        $IdDOV=$column['id'];
    }   
}



$fields['rucSol']=$ruc;
$fields['userSol']=$usuario;
$fields['passSol']=$contrasena;

if($tipoDocVenta=='Factura')
{
    $tipo='01'; 
}
if($tipoDocVenta=='Boleta')
{
    $tipo='03';
}
if($tipoDocVenta=='Nota')
{

?>
    <script type="text/javascript">
            window.location="/SistemaFAC/vistas/venta.php";
    
   </script>

<?php 

}

$fields['ruc']=$ruc;
$fields['tipo']=$tipo;
$fields['serie']=$serieDOC;
$fields['numero']=$numeroDOC;

/////////////////////////////////////////////
$result =process($fields);


if($result->getMessage()=='La constancia existe')
{

   $sql0=mysqli_query($conexion,"UPDATE venta set dov_Estado='ACEPTADO', estado='Aceptado', dov_Nombre = '".$filename."', dov_IdEmpleado='".$codColab."' WHERE idventa='".$IdDOV."'");

   echo "El Comprobante esta informado a SUNAT";
   
?>

<?php

}
elseif($result->getMessage()=='El ticket no existe')
{
    
    echo "El Comprobante no esta informado a SUNAT";

}
else
{

    echo ($result->getMessage());
   
}

?>



