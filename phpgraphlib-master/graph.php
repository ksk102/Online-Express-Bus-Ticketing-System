<?php
require 'Database/db_con.php';
include("phpgraphlib.php");
$graph = new PHPGraphLib(500,300);

$dataArray=array();
  
//get data from database
//retrieve and count total revenue and number of ticket sold in a month and year 
$sql="SELECT * FROM transaction GROUP BY TRANS_DATE";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
if ($result) {
  while ($row = mysql_fetch_assoc($result)) {
      $trans_date=$row["TRANS_DATE"];
      $count=$row["count"];
      //add to data areray
      $dataArray[$trans_date]=$count;
  }
}
  
//configure graph
$graph->addData($dataArray);
$graph->setTitle("Sales by Group");
$graph->setGradient("lime", "green");
$graph->setBarOutlineColor("black");
$graph->createGraph();
?>