<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require_once("auth/newMyClass.php");
require_once("function.php");
$numm=array("0","1","2","3","4","5");
if(isset($_REQUEST['f']))$f=$_REQUEST['f']; else $f = '1';
if (in_array($f,$numm)){ 
	switch($f){
		case '0':fLoginCheck('L2'); break;//Проверка авторизации
		case '1':fbLoadData('L2'); break;//выбрать
		case '2':fbLoadPalk('L2'); break;//выбрать
		case '3':fbLoadAppointments('L2'); break;//выбрать
		case '4':fLogOut('L2'); break;//удалить авторизацию
		case '5':fbLoadAddvData('L2'); break;//читать доп данные
	}
}
?>