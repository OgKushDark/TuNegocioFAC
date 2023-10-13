<?php

require '../vendor/autoload.php';

//Incluímos inicialmente la conexión a la base de datos
require "../configuraciones/Conexion.php";

class MyReadFilter implements \PhpOffice\PhpSpreadsheet\Reader\IReadFilter
{

	public function readCell($column, $row, $worksheetName = '')
	{
		// Read title row and rows 20 - 30
		if ($row > 1) {
			return true;
		}
		return false;
	}
}

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();

$inputFileName = $_FILES['excel']['tmp_name'];

/**  Identify the type of $inputFileName  **/
$inputFileType = \PhpOffice\PhpSpreadsheet\IOFactory::identify($inputFileName);
/**  Create a new Reader of the type that has been identified  **/
$reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);

// Leer datos de una celda específica

$reader->setReadFilter(new MyReadFilter());

/**  Load $inputFileName to a Spreadsheet Object  **/
$spreadsheet = $reader->load($inputFileName);

$cantidad = $spreadsheet->getActiveSheet()->toArray();
foreach ($cantidad as $row) {
	if ($row[0] != "") {

		// echo ''.$row[0]. ''.$row[1]. ''.$row[2]. ''.$row[3]. ''.$row[4]. ''.$row[5]. ''.$row[6]. ''.$row[7]. ''.$row[8];

		$sql = "SELECT idproducto,codigo FROM producto ORDER BY idproducto DESC";
		$rspta = ejecutarConsulta($sql);

		while ($reg = $rspta->fetch_object()) {

			if ($row[1] == $reg->codigo) {

				$sql = "UPDATE producto SET idcategoria='$row[0]',nombre='$row[2]',stock='$row[3]',precio='$row[4]',fecha='$row[5]',descripcion='$row[6]', modelo='$row[7]', numserie='$row[8]' WHERE codigo='$row[1]'";
				ejecutarConsulta($sql);
			} else {

				$sql1 = "INSERT INTO producto(idcategoria,codigo,nombre,stock,precio,fecha,descripcion,modelo,numserie,condicion)
				VALUES ('$row[0]','$row[1]','$row[2]','$row[3]','$row[4]','$row[5]','$row[6]','$row[7]','$row[8]','1')";
				ejecutarConsulta($sql1);
			}
		}
	}
}
