<?php
ini_set("display_errors", On);
error_reporting(E_ALL);
header("Content-type:text/html;charset=UTF-8");
include('common_db/sql_queries.php');

/*************************************/
/*   各種必要な情報群(POST情報)	     　  */
/*************************************/

$temperature = $_GET['temperature'];
$humid = $_GET['humid'];

//データー初入力時
$suucess_flg = sqlQueries::insert_temperature(
         $temperature
        ,$humid
);

?>
