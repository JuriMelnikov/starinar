<?php
//include("./passin.php");
//print_r($_REQUEST);
// function __autoload($class_name){
//     //class directories
//     $directorys = array(
//         'Classes/',
//         'auth/'
//     );
    
//     //for each directory
//     foreach($directorys as $directory)
//     {
//         //see if the file exsists
//         if(file_exists($directory.$class_name . '.php'))
//         {
//             require_once($directory.$class_name . '.php');
//             return;
//         }            
//     }
// }
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
//require_once('JSON.php');
	//include("config.php");
	//include("class/php_class.php");
 //include_once("auth/newMyClass.php");
	
/* $link =mysql_connect($host, $user, $pass)or die("Соединения с базой нет:: " . mysql_error());
  //  print "Соединения с базой произошло успешно:<br>";
	mysql_select_db($db) or die("Такой базы нет:");
	mysql_query('SET NAMES utf8');
 */	
//echo "Hello!";
include_once("function.php");
$numm=array("0","1","2","3","4","5","6","7","8","9","10","11","12");
if(isset($_REQUEST['f']))$f=$_REQUEST['f']; else $f = '0';



//print_r($_REQUEST);
//echo "value=".$value;
if (in_array($f,$numm)){ 
	switch($f){
		case '0':fLoginCheck('L4'); break;//Проверка авторизации
		case '1':ftLoadList('L4'); break;//считать разделы в список
		case '2':ftAddClick('L4'); break;//Добвавить
		case '3':ftUpdateClick('L4'); break;//Изменить
		case '4':ftDeleteClick('L4'); break;//Удалить
		case '5':ftselectModel('L4'); break;//выбор модели
		case '6':ftSelectChange('L4'); break;//выбор раздела
		case '7':ftTrClick('L4'); break;//выбор строки в таблице
		case '8':fLogOut('L4'); break;//удалить авторизацию
		case '9':ftDelSelModel('L4'); break;
		case '10':ftDelSelSection('L4'); break;
		case '11':ftUploadFile('L4'); break; // загрузка файла на сервер
		case '12':ftLoadModelFormFile('L4'); break; //загрузить данные из файла в базу
	}
}
//echo "Усе у порядке";



//mysql_close($link);