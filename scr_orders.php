<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require_once("auth/newMyClass.php");
require_once("function.php");
$numm=array("0","1","2","3","4","5","6","7","8","9","10","11","12","13");
if(isset($_REQUEST['f']))$f=$_REQUEST['f']; else $f = '0';
if (in_array($f,$numm)){ 
	switch($f){
		case '0':fLoginCheck('L3'); break;//Проверка авторизации
		case '1':faLoadOrders('L3'); break;//список ордеров
		case '2':faSelectOrder('L3'); break;//выбранный ордер
		case '3':faAdd('L3'); break;//Добавить
		case '4':faUpdate('L3'); break;//Обновить
		case '5':faDelete('L3'); break;//Удалить
		case '6':faNumCarrentWeek('L3'); break;//текущая неделя
		case '7':faCreateSelectModel('L3'); break;//список моделей
		case '8':faDublOrder('L3'); break;//дублирование ордера
		case '9':faCheckOrder('L3'); break;//Проверка ордера
		case '10':fLogOut('L3'); break;//удалить авторизацию
		case '11':currentDate('L3'); break; //текущая неделя
		case '12':faDeleteDublOrder('L3'); break; //удалить dubl ордера
		case '13':fLoginGet('L3'); break;//авторизация
		
	}
}
?>