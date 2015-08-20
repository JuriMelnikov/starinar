<?php
 print_r($_REQUEST);
 $value = json_decode($_REQUEST["value"]);
$data=array(
	Week=>$value->Week,
	Year=>$value->Year
);


echo json_encode($data);
?>