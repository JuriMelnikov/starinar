<?php
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require_once("auth/newMyClass.php");
require_once("function.php");
$numm=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
if(isset($_REQUEST['f']))$f=$_REQUEST['f']; else $f = '0';
if (in_array($f,$numm)){ 
	switch($f){
		case '0':fLoginCheck('L5'); break;//Проверка авторизации
		case '1':fwLoadWorkers('L5'); break;//выбрать
		case '2':fwAddClick('L5'); break;//Добвавить
		case '3':fwUpdateClick('L5'); break;//Изменить
		case '4':fwDeleteClick('L5'); break;//Удалить
		case '5':fwListClick('L5'); break;//Удалить
		case '6':fwDelAppointment('L5'); break;//Удалить должность
		case '7':fwSelectAccount('L5'); break;//
		case '8':fwInsertAccount('L5'); break;//
		case '9':fLogOut('L5'); break;//удалить авторизацию
		case '10':fwDeleteAccount('L5'); break;//удаление акаунта
		case '11':fwSetFiltr('L5'); break;//удаление акаунта
		case '12':fwSetDayStop('L5'); break;//setDayStop
	}
}
?>