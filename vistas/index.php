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


