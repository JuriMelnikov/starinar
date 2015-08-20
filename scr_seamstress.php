<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require_once('JSON.php');
//require_once("auth/newMyClass.php");
require_once("function.php");
$numm=array("0","1","2","3","4","5","6","7","8","9","10","13","14");
if(isset($_REQUEST['f']))$f=$_REQUEST['f']; else $f = '1';
if(isset($_REQUEST['value']))$value=$_REQUEST['value'];//else $value="1";
if (in_array($f,$numm)){ 
	switch($f){
		case '0':currentDate('L1'); break; //текущая неделя
		case '1':fsLoadFamily('L1'); break;//фамилии в выпадающий список/таблица
		case '2':fsLoadOrder('L1'); break;//ордера в выпадающий список 
		case '3':fsLoadSectons('L1'); break;//читаем из ns_techmap
		case '4':fsAdd('L1'); break;//Добавляем данные выбранные работником
		case '5':fsFamilySelect('L1'); break;// показываем все данные за текущую неделю работника
		case '6':fsDeleteRecord('L1'); break;
		case '7':fsSelectOrder('L1');break;
		case '8':fsSelectOperate('L1');break;
		case '9':fLoginCheck('L1');break;
		case '10':fGetLogin('L1');break;
		
		case '13':fsNumOperates('L1'); break;//
		case '14':fLogOut('L1'); break;//удалить авторизацию
	}
}
?>