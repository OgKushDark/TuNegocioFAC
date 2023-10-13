<?php


use Greenter\Data\StoreTrait;

use Greenter\Model\DocumentInterface;

use Greenter\Model\Response\CdrResponse;

use Greenter\Report\HtmlReport;

use Greenter\Report\PdfReport;

use Greenter\Report\Resolver\DefaultTemplateResolver;
use Greenter\XMLSecLibs\Certificate\X509Certificate;
use Greenter\XMLSecLibs\Certificate\X509ContentType;

use Greenter\See;

use Greenter\Data\SharedStore;

use Greenter\Data\GeneratorFactory;
//session_start();



final class Util 
{

        /**
     * @var Util
     */
    private static $current;
    /**
     * @var SharedStore
     */
    public $shared;

    private function __construct()
    {
        $this->shared = new SharedStore();
    }

    public static function getInstance()
    {
        if (!self::$current instanceof self) {
            self::$current = new self();
        }
        return self::$current;
    }

     public function abrirConexion()
    {
        $server = "localhost";
        $usuario = "root";
        $clave = "";
        $database = "bdtunegociov2";
        $conexion = mysqli_connect($server, $usuario, $clave, $database);

        return $conexion;
    }
    public  function desconectar($conexion)
    {
        mysqli_close($conexion);
    }
    
    /**

     * @param string $endpoint

     * @return See

     */
    public function getSee($endpoint)
    {

            $conexion = $this->abrirConexion();

            $resultado = mysqli_query($conexion,"SELECT * from datos_negocio");
            
            if ($resultado) {  
              foreach ($resultado as $column) {
                $ruc=$column['documento'];
                $usuario=$column['usuario_sol'];
                $contrasena=$column['clave_sol'];
                $contrasenacertificado=$column['clave_certificado'];
                }	
            }
    
            $see = new See();
            $see->setService($endpoint);

            // Para pruebas
            
            $pfx = file_get_contents(__DIR__ .'/certificado.pem');

            $see->setCertificate($pfx);
            

            // Para producción

            // $pfx = file_get_contents(__DIR__ . '/certificado.p12');

            // $password = $contrasenacertificado;
            // $certificate = new X509Certificate($pfx, $password);

            // $see->setCertificate($certificate->export(X509ContentType::PEM));

           
            $see->setCredentials($ruc.''.$usuario, $contrasena);
            $see->setCachePath(__DIR__ . '/../cache');
            
            error_get_last();
            Usage: print_r(error_get_last());
            return $see;     

            $this->desconectar($conexion);
    }
    
    public function showResponse(DocumentInterface $document, CdrResponse $cdr,$id,$tipo,$EMP)

    {
        $filename = $document->getName();

            $conexion = $this->abrirConexion();
            if ($cdr->isAccepted())
            {
                if ($tipo == "DocVenta")
                {
                    $sql0=mysqli_query($conexion,"UPDATE venta set dov_Estado='ACEPTADO', estado='Aceptado', dov_Nombre = '".$filename."', dov_IdEmpleado='".$EMP."' WHERE idventa='".$id."'");
                }
                elseif ($tipo == "Nota")
                {
                    $sql0=mysqli_query($conexion,"UPDATE venta SET dov_Estado='ACEPTADO', estado='Aceptado',dov_Nombre='".$filename."',dov_IdEmpleado='".$EMP."' WHERE idventa='".$id."'");
                }
            }
            else
            {
                if ($tipo == "DocVenta")
                {
                    $sql0=mysqli_query($conexion,"UPDATE venta set dov_Estado='RECHAZADO' ,estado='Rechazado', dov_IdEmpleado='".$EMP."' WHERE idventa='".$id."'");
                }
                elseif ($tipo == "Nota")
                {
                    $sql0=mysqli_query($conexion,"UPDATE venta set dov_Estado='RECHAZADO' ,estado='Rechazado', dov_IdEmpleado='".$EMP."' WHERE idventa='".$id."'");
                }
            }
            
             if ($cdr->isAccepted()==1)
            {
                
                if ($tipo == "ComunicacionBaja")
                {
                      
                    
                    $sql0=mysqli_query($conexion,"UPDATE comunicacion_baja SET COB_Nombre ='".$filename."', COB_Estado ='ACEPTADO' WHERE COB_Id ='".$id."'");
                 //   echo $sql0;
          
                }
            }else{
                if ($tipo == "ComunicacionBaja")
                {
                    $sql0=mysqli_query($conexion,"UPDATE comunicacion_baja SET COB_Nombre ='".$filename."', COB_Estado ='RECHAZADO' WHERE COB_Id ='".$id."'");
                }
            }
            
            $this->desconectar($conexion);
     /*       mysqli_close($conexion);
        }
        else
        {
            echo 'error al conectar';
        }*/
    }



    public function getErrorResponse(\Greenter\Model\Response\Error $error)

    {

        $result = <<<HTML

        Error

        Código: {$error->getCode()}

        Descripción: {$error->getMessage()}

HTML;



        return $result;

    }



    public function writeXml(DocumentInterface $document, $xml)

    {

        $this->writeFile($document->getName().'.xml', $xml);

    }

    public function getGenerator(string $type): ?DocumentGeneratorInterface
    {
        $factory = new GeneratorFactory();
        $factory->shared = $this->shared;

        return $factory->create($type);
    }


    public function writeCdr(DocumentInterface $document, $zip)

    {

        $this->writeFile('R-'.$document->getName().'.zip', $zip);

    }



    public function writeFile($filename, $content)

    {

        if (getenv('GREENTER_NO_FILES')) {

            return;

        }
        //ECHO("FACT_WebService/Facturacion/files/".$filename."--------------------------".$content);
        file_put_contents(__DIR__ .'/../files/'.$filename, $content);
     //   echo $filename;
      //  print_r($content);

    }



    public function getPdf(DocumentInterface $document): ?string
    {
        $html = new HtmlReport('', [
            'cache' => __DIR__ . '/../cache',
            'strict_variables' => true,
        ]);
        $resolver = new DefaultTemplateResolver();
        $template = $resolver->getTemplate($document);
        $html->setTemplate($template);

        $render = new PdfReport($html);
        $render->setOptions( [
            'no-outline',
            'print-media-type',
            'viewport-size' => '1280x1024',
            'page-width' => '21cm',
            'page-height' => '29.7cm',
            'footer-html' => __DIR__.'/../resources/footer.html',
        ]);
        $binPath = self::getPathBin();
        if (file_exists($binPath)) {
            $render->setBinPath($binPath);
        }
        $hash = $this->getHash($document);
        $params = self::getParametersPdf();
        $params['system']['hash'] = $hash;
        $params['user']['footer'] = '<div>consulte en <a href="https://github.com/giansalex/sufel">sufel.com</a></div>';

        $pdf = $render->render($document, $params);

        if ($pdf === null) {
            $error = $render->getExporter()->getError();
            echo 'Error: '.$error;
            exit();
        }

        // Write html
        $this->writeFile($document->getName().'.html', $render->getHtml());

        return $pdf;
    }   



    public static function generator($item, $count)

    {

        $items = [];



        for ($i = 0; $i < $count; $i++) {

            $items[] = $item;

        }



        return $items;

    }



    public function showPdf(?string $content, ?string $filename): void
    {
        $this->writeFile($filename, $content);
        header('Content-type: application/pdf');
        header('Content-Disposition: inline; filename="' . $filename . '"');
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: ' . strlen($content));

        echo $content;
    }




    public function imprimePdf($content)

    {

        $handle = printer_open();

        printer_write($handle, $content);

        printer_close($handle);

    }



    public static function getPathBin()

    {

        $path = __DIR__.'/../vendor/bin/wkhtmltopdf';

        if (self::isWindows()) {

            $path .= '.exe';

        }



        return $path;

    }



    public static function isWindows()

    {

        return strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

    }



    public static function inPath($command) {

        $whereIsCommand = self::isWindows() ? 'where' : 'which';



        $process = proc_open(

            "$whereIsCommand $command",

            array(

                0 => array("pipe", "r"), //STDIN

                1 => array("pipe", "w"), //STDOUT

                2 => array("pipe", "w"), //STDERR

            ),

            $pipes

        );

        if ($process !== false) {

            $stdout = stream_get_contents($pipes[1]);

            stream_get_contents($pipes[2]);

            fclose($pipes[1]);

            fclose($pipes[2]);

            proc_close($process);



            return $stdout != '';

        }



        return false;

    }



    private function getHash(DocumentInterface $document)

    {

        $see = $this->getSee('');

        $xml = $see->getXmlSigned($document);



        $hash = (new \Greenter\Report\XmlUtils())->getHashSign($xml);



        return $hash;

    }



    private static function getParametersPdf(): array
    {
        $logo = file_get_contents(__DIR__.'/../resources/logo.png');

        return [
            'system' => [
                'logo' => $logo,
                'hash' => ''
            ],
            'user' => [
                'resolucion' => '212321',
                'header' => 'Telf: <b>(056) 123375</b>',
                'extras' => [
                    ['name' => 'FORMA DE PAGO', 'value' => 'Contado'],
                    ['name' => 'VENDEDOR', 'value' => 'GITHUB SELLER'],
                ],
            ]
        ];
    }

}