<?php

/*

CLASE PARA LA CONEXION Y LA GESTION DE LA BASE DE DATOS Y LA PAGINA WEB - MYSQL

*/



class Database {



    private $conexion;

    private $parametros = array();

    private $parametrosIn = array();

    private $values = array();

    #private $formato = "d-m-y";

    private $formato = "y-m-d";

    private $rs;

    private $stmt;

    private $stmt2;

    private $hayResult = false;



    # METODO PARA CONECTAR CON LA BASE DE DATOS



    public function Conectar() {

        if (!isset($this->conexion)) {            

            $server = "localhost";

            $usuario = "larosana_root";

            $clave = "LaRosaNautica70";

            $database = "larosana_DB_Rosa";

            $this->conexion = new mysqli($server, $usuario, $clave, $database);

            mysqli_set_charset($this->conexion,"utf8");

            if (!$this->conexion)
{
                echo 'Error al conectar la base de datos.';        }
else
{        echo 'horror..';}

        }

    }

	# METODO PARA REALIZAR UNA CONSULTA

    public function Consulta($sql) {

        $this->stmt = $this->conexion->prepare($sql);

        $this->stmt->execute();



        $data1 = '';

        if(substr($sql, 0,1)=='S'){

            $this->hayResult = true;

            $this->rs = $this->stmt->get_result(); 

            if($this->rs->num_rows > 0)     

            {

                while($arrayDatos = $this->rs->fetch_array(MYSQLI_ASSOC))

                    $data1[] = $arrayDatos;

            }        

        }



        return  $data1; 

    }



    public function Procedimiento($name) {

        $sql = "call ".$name."(";

        $es_pri = true;

        //$valores = "";

        if (count($this->parametros) == 0) {

            $this->parametros = array();

            $this->parametrosIn = array(array());

        }

        foreach($this->parametros as &$data) {

            if ($es_pri)

                $es_pri = false;

            else

                $sql .= ',';

            //$valores = $valores.'s';

            $sql .= "?";

        }

        $sql .= ")";

        $this->stmt = $this->conexion->prepare($sql); /** Preparar el procedimiento almacenado*/

        $np = array();

        array_push($np, self::valoress(count($this->parametros)));

        foreach ($this->parametrosIn as $k) {

            array_push($np, $k);

        }

        $tmp = array();

        foreach($np as $key => $value) 

            $tmp[$key] = &$np[$key];

        call_user_func_array(array($this->stmt, 'bind_param'), $tmp);

        $this->stmt->execute(); /** Ejecutar Sentencia*/

        $this->rs = $this->stmt->get_result(); /** Tomar Result*/



        $data1 = '';

        while($arrayDatos = $this->rs->fetch_array(MYSQLI_ASSOC))

            $data1[] = $arrayDatos;

        $this->parametros = array();

        $this->parametrosIn = array();

        $this->values = array();

        //unset($this->parametros);

        return $data1;

    }



    public function Parametro($p1, $p2){

        array_push($this->parametros, $p1);

        array_push($this->parametrosIn, $p2);

        //array_push($this->parametrosIn, array(&$p2, SQLSRV_PARAM_IN));

        array_push($this->values, $p2);

        //array_push($this->values, $p2, SQLSRV_PARAM_IN));

    }

    





    # METODO PARA Insertar UNA Imagen y obtener su ID

    public function ObtenId($sql) {

        $this->stmt2 = $this->conexion->query($sql);

        if (!$this->stmt2) 

        {

            return 0;

        }

        else

        {

            return $this->conexion->insert_id;

        }       

    }



    /*public function get_result( $Statement ) {

        $RESULT = array();

        $Statement->store_result();

        for ( $i = 0; $i < $Statement->num_rows; $i++ ) {

            $Metadata = $Statement->result_metadata();

            $PARAMS = array();

            while ( $Field = $Metadata->fetch_field() ) {

                $PARAMS[] = &$RESULT[ $i ][ $Field->name ];

            }

            call_user_func_array( array( $Statement, 'bind_result' ), $PARAMS );

            $Statement->fetch();

        }

        return $RESULT;

    }*/





    public function valoress($cant){

        $cadena = "";

        for ($i=0; $i < $cant; $i++) { 

            $cadena = $cadena.'s';

        }

        return $cadena;

    }  



	# METODO PARA CONTAR EL NUMERO DE RESULTADOS

    function numeroFilas($result) {

		#if(!is_resource($result)) return false;

		#return mysql_num_rows($result);

        return sqlsrv_num_rows($result);

    }



    # METODO PARA CREAR ARRAY ASOCIATIVO DESDE UNA CONSULTA

    function fetch_assoc($result) {

        if(!is_resource($result)) return false;

        #return mysql_fetch_assoc($result);

        return sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    }



    # METODO PARA CREAR ARRAY NUMÉRICO DESDE UNA CONSULTA

    function fetch_array($result) {

        if(!is_resource($result)) return false;

        #return mysql_fetch_assoc($result);

        return sqlsrv_fetch_array($result, SQLSRV_FETCH_NUMERIC);

    }



	# METODO PARA CREAR ARRAY DE OBJETOS DESDE UNA CONSULTA

    function fetch_object($result) {

      if(!is_resource($result)) return false;

		#return mysql_fetch_assoc($result);

      return sqlsrv_fetch_object($result);

  }



    # METODO PARA CERRAR LA CONEXION A LA BASE DE DATOS

  public function Desconectar() {

    if($this->hayResult)

        //$this->rs->close();

        $this->stmt->close();

    $this->conexion->close();

}



public function formatFecha($fecha) {

    $m = explode("-", $fecha);

    if (count($m) > 1)

        $fecha = $m[0].'-'.$m[1].'-'.$m[2];

    $date = new DateTime($fecha);

    if ($this->formato == "d-m-y")

        $value = $date->format('d-m-Y H:i:s');

    else if ($this->formato == "m-d-y")

        $value = $date->format('m-d-Y H:i:s');

    else if ($this->formato == "m-y-d")

        $value = $date->format('m-Y-d H:i:s');

    else if ($this->formato == "d-y-m")

        $value = $date->format('d-Y-m H:i:s');

    else if ($this->formato == "y-m-d")

        $value = $date->format('Y-m-d H:i:s');

    else if ($this->formato == "y-d-m")

        $value = $date->format('Y-d-m H:i:s');

    else

        $value = 'error.';

    return $value;

}



public function formatFechaMDA($fecha) {

    $m = explode("/", $fecha);

    if (count($m) > 1)

        $fecha = $m[1].'-'.$m[0].'-'.$m[2];

    $date = new DateTime($fecha);

    if ($this->formato == "d-m-y")

        $value = $date->format('d-m-Y H:i:s');

    else if ($this->formato == "m-d-y")

        $value = $date->format('m-d-Y H:i:s');

    else if ($this->formato == "m-y-d")

        $value = $date->format('m-Y-d H:i:s');

    else if ($this->formato == "d-y-m")

        $value = $date->format('d-Y-m H:i:s');

    else if ($this->formato == "y-m-d")

        $value = $date->format('Y-m-d H:i:s');

    else if ($this->formato == "y-d-m")

        $value = $date->format('Y-d-m H:i:s');

    else

        $value = 'error.';

    return $value;

}

}