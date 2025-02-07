<?php

// export all data to CSV file
use GERcontactos\Database;

require_once('config.php');
require_once('libraries/Database.php');

$database = new Database(MYSQL_CONFIG);
$results = $database->execute_query("SELECT * FROM contactos");

$rows = $results->results;

// store data into csv file
$filename = 'contatos_' . time() . '.csv';
$file = fopen($filename, 'w');

// store header
$header = [];
foreach($rows[0] as $key => $value){
    $headers[] = $key;
}
fputcsv($file, $headers);

// store rows
$tmp = [];
foreach($rows as $row){
    $obj = (array)$row;
    fputcsv($file, $obj);
}

fclose($file);

// download file
header("Content-Description: File Transfer");
header("Content-Type: application/octet-stream");
header('Content-Disposition: attachement; filename="' . $filename . '"');
header('Expires: 0');
header('Cache-Control: mut-revelidate');
header('Pragma: public');
header('Content-Lengh: ' . filesize($filename));
readfile($filename);