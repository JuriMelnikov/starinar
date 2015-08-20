<?php 

// function autoload($className) {
//     set_include_path(__DIR__.'/Classes/');
//     spl_autoload($className); //replaces include/require
// }
// spl_autoload_extensions('.php');
// spl_autoload_register('autoload');


include_once 'Classes/ToBase.php';
include_once 'Classes/Workers.php';
include_once 'Classes/Techmap.php';
include_once 'Classes/SectionsList.php';
include_once 'Classes/Result.php';
include_once 'Classes/OrderTimeDubl.php';
include_once 'Classes/OrderTime.php';
include_once 'Classes/Orders.php';
include_once 'Classes/ModelsList.php';
include_once 'Classes/Models.php';
include_once 'Classes/Counts.php';
include_once 'Classes/AppointmentsList.php';





//отменяем авторизацию, ничего не возвращаем
function fLogOut(){
$user=new ToBase();
$user->logout($_SERVER['PHP_SELF']);
}

function fLoginCheck($idPage){
$access=new ToBase();
//echo "подключена база";
$level=$access->accessYes($idPage);
//return $value['level']=$level;
if($level!=0){//доступ есть
	$value['loginCheck']=true;
	$value['levelM']=$level;
	$value['count']=0;
	echo json_encode($value);
	exit;
}
if($level==0){//доступа нет
	if(isset($_REQUEST["data"])){
		$data = json_decode($_REQUEST["data"]);
		$login=substr((string)$data->login,0,19);
		$pass=substr((string)$data->pass,0,19);
		$logPassTrue=$access->login($login,$pass,$idPage);
		if($logPassTrue){
			$value['loginCheck']=true;
			$value['levelM']=$access->accessYes($idPage);
			if($value['levelM']!=0)
				$value['loginCheck']=true;
			else
				$value['loginCheck']=false;
			$value['count']=$access->getCount();
			echo json_encode($value);   
			exit;
		}else{
			$value['loginCheck']=false;
			$value['count']=$access->getCount();
			$value['levelM']=0;
			echo json_encode($value);
			exit;
		}
		
	}else{
		$value['loginCheck']=false;
		$value['count']=$access->getCount();
			$value['levelM']=0;
		echo json_encode($value);
		exit;
	}
}
}
function calendar(){
  /*Проверяем какой год, если високосный то в феврале 29 дней иначе 28*/
  if (date("L") == 1)
   {
   $m['01'] = 31;
   $m['02'] = 29;
   $m['03'] = 31;
   $m['04'] = 30;
   $m['05'] = 31;
   $m['06'] = 30;
   $m['07'] = 31;
   $m['08'] = 31;
   $m['09'] = 30;
   $m['10'] = 31;
   $m['11'] = 30;
   $m['12'] = 31;
  }
  else
   {
   $m['01'] = 31;
   $m['02'] = 28;
   $m['03'] = 31;
   $m['04'] = 30;
   $m['05'] = 31;
   $m['06'] = 30;
   $m['07'] = 31;
   $m['08'] = 31;
   $m['09'] = 30;
   $m['10'] = 31;
   $m['11'] = 30;
   $m['12'] = 31;
  }
 $FORM="";
			 $Mon = "&nbsp;";
			 $Tue = "&nbsp;";
			 $Wed = "&nbsp;";
			 $Thu = "&nbsp;";
			 $Fri = "&nbsp;";
			 $Sat = "&nbsp;";
			 $Sun = "&nbsp;";
	$rusMonth=array("ЯНВАРЬ","ФЕВРАЛЬ","МАРТ","АПРЕЛЬ","МАЙ","ИЮНЬ","ИЮЛЬ","АВГУСТ","СЕНТЯБРЬ","ОКТЯБРЬ","НОЯБРЬ","ДЕКАБРЬ");
	$month=date("n");
	$$month=$rusMonth[$month-1];
	 //$m[date("m")] - число дней в текущем месяце
  for ($i=1;$i<=$m[date("m")];$i++)
  {
	 $dn = date("D",mktime (0,0,0,date("n"),$i,date("Y"))); // День недели
	 $$dn = date("j",mktime (0,0,0,date("n"),$i,date("Y"))); // Дата
	 if($$dn==date("j"))$$dn='<span id="toDay">'.$$dn.'</span>';
	 //если день недели == Sun или день==последнему дню в текущем месяце
		if (date("D",mktime (0,0,0,date("n"),$i,date("Y"))) == "Sun" || $i == $m[date("m")]){
			$week=date("W",mktime (0,0,0,date("n"),$i,date("Y")));
			//записываем строку шаблонов с названиями дней недели
			$FOR_CH="<tr><td class='week'>#week#</td><td>#Mon#</td><td>#Tue#</td><td>#Wed#</td><td>#Thu#</td><td>#Fri#</td><td class='holyday'>#Sat#</td><td class='holyday'>#Sun#</td></tr>";
			//заменяем в этой переменной шаблон на значения переменных
			$FORM.=str_replace(array("#week#","#Mon#","#Tue#","#Wed#","#Thu#","#Fri#","#Sat#","#Sun#"),array($week,$Mon,$Tue,$Wed,$Thu,$Fri,$Sat,$Sun),$FOR_CH);
			 $Mon = "&nbsp;";
			 $Tue = "&nbsp;";
			 $Wed = "&nbsp;";
			 $Thu = "&nbsp;";
			 $Fri = "&nbsp;";
			 $Sat = "&nbsp;";
			 $Sun = "&nbsp;";
		}
   }
   $calendar="<table id=\"tblCalendar\"><tr><td colspan=\"8\">".$$month."</td></tr>
   <tr><td><b>Неделя</b></td><td><b>Пн</b></td><td><b>Вт</b></td><td><b>Ср</b></td><td><b>Чт</b></td><td><b>Пт</b></td><td><b>Сб</b></td><td><b>Вс</b></td></tr>
   $FORM
   </table>";
 return $calendar;
}

function currentDate(){
date_default_timezone_set ( 'Europe/Helsinki' );
$day=date("j");//день месяща без ведущих нулей
$countDayInMonth=date("t");//количество дней в месяце
$dayInWeek=date("w");
if($dayInWeek==0)$dayInWeek=7;
//echo "Дней в текущем месяце: ".$countDayInMonth." ";
$beforeMonth=date("n")-1;
if($beforeMonth<1)$beforeMonth=12;
//echo "прошлый месяц: $beforeMonth ";
$dayInBeforeMonth=date("t",mktime(0,0,0,$beforeMonth));
//echo "Дней в прошлом месяце: ".$dayInBeforeMonth;
	$firstD=$day-$dayInWeek+1;
	if($firstD < 0){
		$firstD=$dayInBeforeMonth-($day-$firstD);
	}
	//if($firstD<1) $firstD=date("t")+$firstD;//первый день недели
	
	$lastD=$firstD+6;//последний день недели
	if($lastD>$countDayInMonth){
		$nextMonth=date("n")+1;
		if($nextMonth>12)$nextMonth=12;
		$dayInNextMonth=date("t",mktime(0,0,0,$nextMonth));
		
		$lastD=$lastD-$dayInNextMonth;
	}
$data=array(
	"week"=>date("W"),
	"month"=>date("m"),
	"year"=>date("Y"),
	"firstD"=>$firstD,
	"lastD"=>$lastD,
	"calendar"=>calendar()
);
echo  json_encode($data);
}

//Изменение недели
function faСhangeWeek(){
	$data = json_decode($_REQUEST["data"]); 
$week=(int)$data->week;
$month=(int)$data->month;
$year=(int)$data->year;
//---------начало расчета
//текущая дата
 




//----------конец расчета
$newWeek=array(
	"newFirstD"=>$newFirstD,
	"newLastD"=>$newLastD,
	"calendar"=>calendar()
	
);
}


//список моделей для создания селектов aModel
function faCreateSelectModel($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	$data['status']=0;
	echo json_encode($data);
	exit;
}
$value = json_decode($_REQUEST["data"]);
$check=(bool)$value->check;
if(!$check){//addInput
$query="SELECT * FROM ns_model_list ORDER BY mName";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
if($result)$data["status"]=1;else $data["status"]=0;
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["models"][$i]=$row['mName'];
	$data["ml_id"][$i]=$row['ml_id'];
	$i++;
}
echo json_encode($data);
}
if($check){//addInputCheck
$query="SELECT * FROM `ns_model_list` ORDER BY mName";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
if($result)$data["status"]=1;else $data["status"]=0;
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["models"][$i]=$row['mName'];
	$data["ml_id"][$i]=$row['ml_id'];
	$i++;
}
$query="SELECT * FROM `ns_section_list` ORDER BY lSection";
$result=$access->resQuery($query);
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["sections"][$i]=$row['lSection'];
	$data["sl_id"][$i]=$row['sl_id'];
	$i++;
}
echo json_encode($data);
}
}


//обновление списка ордеров
function faLoadOrders($idPage){
// принимаем POST-данные и декодируем их
//$json = new Services_JSON();
//Проверяем достаточен ли уровень  доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$aList["login"]=false;
	$aList['status']=0;
	echo json_encode($aList);
	exit;
}
$aList['login']=true;                                                               
$aList['status']=0;
$data = json_decode($_REQUEST["data"]);
$aWeek=mysql_real_escape_string((int)$data->aWeek);
$month=mysql_real_escape_string((int)$data->month);
$aYear=mysql_real_escape_string((int)$data->aYear);
$query="SELECT ns_admin.a_id,ns_orders.order FROM ns_admin,ns_orders WHERE aWeek='$aWeek' AND month='$month' AND aYear='$aYear' AND ns_admin.o_id=ns_orders.o_id  ORDER BY a_id";   
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос loadList не выполнен".mysql_error());
$i=0;
if ( @mysql_num_rows($result) != 0 ){
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$aList['data'][$i]=array(
					"a_id"=>$row["a_id"],
					 "order"=>$row["order"]
					);
		$i++;
	}
	$aList['status']=1;
}

$query="SELECT ns_order_dubl.a_id,ns_orders.order FROM ns_order_dubl,ns_orders WHERE ns_order_dubl.week='$aWeek' AND ns_order_dubl.month='$month' AND ns_order_dubl.year='$aYear' AND ns_order_dubl.o_id=ns_orders.o_id  ORDER BY a_id";    
$result=$access->resQuery($query);

if ( @mysql_num_rows($result) != 0 ){
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$aid=$row["a_id"];
		$ord=$row["order"]." (double)";
		$aList['data'][$i]=array(
					"a_id"=>$aid,
					 "order"=>$ord
					);
		$i++;
	}
	$aList['status']=1;
}


//echo "$aList=".$aList;

echo json_encode($aList);
}




//выбрана строка в таблице с ордерами
function faSelectOrder($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
//print_r($_REQUEST);
// принимаем POST-данные и декодируем их
//$json = new Services_JSON();
$value = json_decode($_REQUEST["data"]);    
$check=mysql_real_escape_string((bool)$value->check);
$a_id=mysql_real_escape_string((int)$value->a_id);
//считываем данные из ns_admin по полю a_id
$query="SELECT aYear,aWeek,month,ns_orders.order 
FROM ns_admin,ns_orders 
WHERE a_id='$a_id' AND ns_admin.o_id=ns_orders.o_id";
			//$data["query1"]=$query." ";

$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$data["aYear"]=$row["aYear"];
$data["aWeek"]=$row["aWeek"];
$data["month"]=$row["month"];
$data["order"]=$row["order"];//Имя ордера

if($check){/*Проверка выбрана*/
//считываем из ns_models,ns_model_list -> m_id - ид модели, mName-имя модели и ml_id модели
	$query="SELECT m_id,mName,ns_models.ml_id 
	FROM ns_models,ns_model_list 
	WHERE a_id='$a_id' AND ns_models.ml_id=ns_model_list.ml_id";    
	//echo $query;
//$data["query2"]=$query." ";
	$result=$access->resQuery($query);
	$i=0;/*добавляем в массив выбранные модели */
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$data["models"][$i]["m_id"]=$row["m_id"];
			$data["models"][$i]["model"]=$row["mName"]; 
			$data["models"][$i]["ml_id"]=$row["ml_id"];
	$i++;
	}
	$k=count($data["models"]);
	$data["k"]=$k;
/*Считываем список разделов и их ид*/
	$query="SELECT * FROM `ns_section_list` ORDER BY lSection";
$data["query3"]=$query." ";
	$result=$result=$access->resQuery($query);//mysql_query($query2)or die("Запрос $query не выполнен. ".mysql_error());
	$j=0;
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$data["sections"][$j]["section"]=$row["lSection"];
		$data["sections"][$j]["sl_id"]=$row["sl_id"];
		$j++;
	}
	
	$data["n"]=$i;//количество моделей в ордере

	//print_r($data);
	echo json_encode($data);
	exit;
}
//$data["check"]=$check;
//отсылаем js по какому сценарию работать.
if(!$check){/*Проверка не выбрана*/
	//считываем из ns_models,ns_model_list -> m_id - ид модели, mName-имя модели
	$query="SELECT m_id,mName 
	FROM ns_models,ns_model_list 
	WHERE a_id='$a_id' AND ns_models.ml_id=ns_model_list.ml_id";    
//$data["query"]=$query." ";
	$result=$access->resQuery($query);
	$i=0;/*добавляем в массив выбранные модели и количество изделий*/
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$data["models"][$i]["m_id"]=$row["m_id"];
			$data["models"][$i]["model"]=$row["mName"]; 
	$i++;
	}
	if($i>0)
	$k=count($data["models"]);
	else 
	$k=0;
	$data["k"]=$k;
/*Считываем количество изделий для определенной модели*/
	for($j=0;$j<$k;$j++){
	$mid=$data["models"][$j]["m_id"];
		$query2="SELECT count FROM ns_counts WHERE  a_id='$a_id' AND m_id='$mid'";          
		$result2=$result=$access->resQuery($query2);//mysql_query($query2)or die("Запрос $query не выполнен. ".mysql_error());
		$row2=mysql_fetch_array($result2,MYSQL_ASSOC);
		$data["models"][$j]["count"]=$row2["count"];
	}
	$data["n"]=$i;

	//print_r($data);
	echo json_encode($data);
	exit;
}

}
//проверка ордера 
function faCheckOrder($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
	// принимаем POST-данные и передаем их в класс
	$value = json_decode($_REQUEST["data"]);
	$r=new Result($access->getConnDB());
	$data=$r->checkOrder($value);
	$data['login']=true;
	echo json_encode($data);
}

function faAdd($idPage){

	//Проверяем достаточен ли уровень доступа
	//verifity("admin");
	$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
	$data['login']=true;

	// принимаем POST-данные и декодируем их
	$orders = json_decode($_REQUEST["order"]);
	//print_r($_REQUEST);
	$data['data']=$year=(int)$orders->aYear;
	$data['month']=$month=(int)$orders->month;
	$data['order']=$order=mysql_real_escape_string(trim($orders->aOrder));//название ордера
	$data['week']=$week=(int)$orders->aWeek;
	$data['models']=$models = json_decode($_REQUEST["models"]);
	$data['counts']=$counts = json_decode($_REQUEST["counts"]);
	
	$ot=new OrderTime($access->getConnDB());

	$vars=compact('order','month','week','year','models','counts');
	$ot->addOrder($vars);
	//$data["enter"]=$aYear." ".$month." ".$order." ".$week;
	/*определяем существует ли имя ордера, если да то считываем его o_id
	если нет, то добавляем новое имя ордера и считываем его o_id */
	// $o=new Orders(connDB());
	// if(!$o_id=$o->getIdOrder($order)){
	// 	$o->addOrder($order);
	// 	$o_id=$o->getLastId();
	// }

// 	// $query="SELECT `o_id` FROM `ns_orders` WHERE `order`='$order'";
// 	// $result=$access->resQuery($query);
// 	// $num_rows = @mysql_num_rows($result);
// 	// if($num_rows){
// 	// 	$row=mysql_fetch_array($result,MYSQL_ASSOC);
// 	// 	$o_id=$row['o_id'];
// 	// }else{
// 	// 	$query="INSERT INTO `ns_orders`(`order`) VALUES ('$order')";
// 	// 	$result=$access->resQuery($query);
// 	// 	$o_id=mysql_insert_id();
// 	// }
// 	//$data['o_id']=$o_id;
	
// //==================
	/*Проверяем уникальность записи в ns_admin по o_id*/
	// $ot=new OrderTime($this->getConnDB()());
	// if($ot->existsOrder($o_id)){
	// 	insertDubl($o_id,$month,$week,$year);
	// 	exit;
	// }
	// if(!$last_a_id=$ot->addOrder($o_id,$month,$week,$year)){
	// 	echo "Не могу добавить ордер.";
	// 	exit;
	// }
// 	//================
// 	// $query="SELECT * FROM ns_admin WHERE `o_id`='$o_id'";
// 	// $result=$access->resQuery($query);
// 	// $num_rows = @mysql_num_rows($result);
// 	// if($num_rows > 0){
// 	// $row=mysql_fetch_array($result,MYSQL_ASSOC);
// 	// $a_id=$row["a_id"];
// 	// 	insertDubl($a_id,$month,$week,$year);
// 	// 	exit;
// 	// }

// 	// $query="INSERT INTO `ns_admin`(`o_id`,`aYear`,`month`,`aWeek`) VALUES ('$o_id','$year','$month','$week')";
//  // $data['query']="insert ns_admin: ".$query;//!!!!!!!!!!!!!!!!!!!!!!!!!!
// 	// //$result=$access->resQuery($query);
// 	// mysql_query($query) or die("Запрос $query не выполнен. ".mysql_error());
// 	// $last_a_id=mysql_insert_id();
// 	// print_r($ml_ids);
// 	//=====================
 	// for($i=0;$i<count($ml_ids);$i++){
 	// 	$ml_id=mysql_real_escape_string(trim($ml_ids[$i]));
// 		//===============
// 		//$mod=mb_convert_encoding($mod, 'utf-8', mb_detect_encoding($mod));
// // 		$query="SELECT ml_id FROM ns_model_list WHERE `ml_id`='$mod'";
// // $data['SelectModel_query']=$query;
// // 		$result=$access->resQuery($query);
// // 		$row=mysql_fetch_array($result,MYSQL_ASSOC);
// // 		$ml_id=$row['ml_id'];
// 		//=================
		// $m=new Models(connDB());
		// if(!$last_m_id=$m->addModel($last_a_id,$ml_id)){
		// 	echo "Не могу добавить модель.";
		// 	exit;
		// }
// 		//==================
// //  $data['ml_id']='ml_id='.$ml_id;
// // 		$query="INSERT INTO ns_models (a_id,ml_id) VALUES ('$last_a_id', '$ml_id')";
// //  $data['InsertModel_query']='<br>эта добавление модели - '.$query;
// // 		$result=$access->resQuery($query);
// // 		//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
// // 		$last_m_id=mysql_insert_id();
// // $data['last_m_id']='last_m_id='.$last_m_id;
// 		//==================
		// $ncount=mysql_real_escape_string((int)$count[$i]);
		// $c=new Counts(connDB());
		// if(!$c->addCounts($last_a_id,$last_m_id,$ncount)){
		// 	echo "Не могу добавить количество моделей.";
		// 	exit;
		// }
// 		//===================
// // 		$query="INSERT INTO ns_counts (a_id, m_id,count) VALUES ('$last_a_id','$last_m_id','$ncount')";
// //  //$data['InsertCount_query']=$query;    
// // $data['query2']='query2='.$query;  
// // 		$result=$access->resQuery($query);
// 		//$result=mysql_query($query);//or die("Запрос $query не выполнен. ".mysql_error());
// 		//$data["enter2"]=$last_a_id." ".$last_m_id;
 	// }

	echo json_encode($data);
	
}
//нажатие на кнопку Дубль
function faDublOrder($idPage){
//Проверяем достаточен ли уровень доступа
	$access=new ToBase();
if(!$access->accessYes($idPage)){
	$toJS["status"]=0;
	echo json_encode($toJS);
	exit;
}
$data = json_decode($_REQUEST["data"]);
$month=mysql_real_escape_string((int)$data->month);
$week=mysql_real_escape_string((int)$data->week);
$year=mysql_real_escape_string((int)$data->year);
$a_id=mysql_real_escape_string((int)$data->a_id);
insertDubl($a_id,$month,$week,$year);
}


function insertDubl($a_id,$month,$week,$year){
$query="SELECT * FROM `ns_admin` WHERE `a_id`='$a_id'";
//echo $query;
//$toJS["query1"]=$query;
$access=new ToBase();
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
if($month==$row['month'] AND $week==$row['aWeek'] AND $year==$row['aYear']){
$toJS["status"]=0;
	echo json_encode($toJS);
	exit;
}else{$o_id=$row["o_id"];}
$query="SELECT * FROM ns_order_dubl WHERE `a_id`='$a_id'";
//$toJS["query2"]=$query;
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
if($month==$row['month'] AND $week==$row['week'] AND $year==$row['year']){
$toJS["status"]=0;
	echo json_encode($toJS);
	exit;
}
$query="INSERT INTO `ns_order_dubl` SET `a_id`='$a_id',`o_id`='$o_id', `week`='$week', `month`='$month', `year`='$year'";
//$toJS["query3"]=$query;
$result=$access->resQuery($query);
if($result)
	$toJS["status"]=1;
else
	$toJS["status"]=0;
	
echo json_encode($toJS);    
}


//нажатие на кнопку Вставить
function faUpdate($idPage){
	
	//Проверяем достаточен ли уровень доступа

	$access=new ToBase();
if(!$access->accessYes($idPage)){
	$toJS["status"]=0;
	echo json_encode($toJS);
	exit;
}
//echo "Привет1";print_r($_REQUEST);
	$data = json_decode($_REQUEST["data"]);
	$month=mysql_real_escape_string((int)trim($data->month));
	$order=mysql_real_escape_string(trim($data->order));
	$week=mysql_real_escape_string((int)trim($data->week));
	$year=mysql_real_escape_string((int)trim($data->year));
	$a_id=mysql_real_escape_string((int)trim($data->a_id));
	
	if($month==0 || $order=="" || $week==0 || $year==0)
	return json_encode($toJS["status"]=0);
	
	$m_id=(array)$data->m_id;
	$model=(array)$data->model;
	$count=(array)$data->count_;
	
	//изменяем месяц, неделю, год, в ns_admin по a_id
		$query="UPDATE `ns_admin` SET `month`='$month', `aWeek`='$week', `aYear`='$year' WHERE `a_id`='$a_id'";
		//$toJS['upAdmin']=$query;
		$result=$access->resQuery($query);
	//считываем o_id из ns_admin по $a_id
		$query="SELECT `o_id` FROM `ns_admin` WHERE `a_id`='$a_id'";
		//$toJS['selO_ID']=$query;
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$o_id=$row['o_id'];
	//изменяем имя ордера в списке ордеров ns_orders по $o_id
		$query="UPDATE `ns_orders` SET `order`='$order' WHERE `o_id`='$o_id'";
		//$toJS['upOrders']=$query;
		$result=$access->resQuery($query);
	//echo $query;
		//модели и количество
		for($i=0;$i<count($model);$i++){
			$mod=mysql_real_escape_string(trim($model[$i]));
			$mid=mysql_real_escape_string((int)$m_id[$i]);
		//определяем по названию новой модели mod из ns_lodel_list  ml_id новой модели
			$query="SELECT ml_id FROM ns_model_list WHERE mName='$mod'";
			$toJS['upModel'][$i]=$query;
			$result=$access->resQuery($query);
			$row=mysql_fetch_array($result,MYSQL_ASSOC);
			$ml_id=$row['ml_id'];
		//исправляем в ns_models $ml_id по m_id
			$query="UPDATE ns_models SET ml_id='$ml_id' WHERE m_id='$mid'";
			//$toJS['upModelList'][$i]=$query;
			$result=$access->resQuery($query);
		//исправляем в ns_counts количество на новое по m_id
			$newCount=mysql_real_escape_string((int)$count[$i]);            
			$query="UPDATE ns_counts SET count='$newCount' WHERE m_id='$mid'";
			//$toJS['upCount'][$i]=$query;
			$result=$access->resQuery($query);
		}
	$toJS["status"]=1;
	echo json_encode($toJS);
}



//нажатие на кнопку Удалить
function faDelete($idPage){
//echo "Привет";    
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($note);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);
$a_id=(int)$value->a_id;
if($a_id !='') {
$query="DELETE FROM `ns_models` WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);
$query="DELETE FROM `ns_counts` WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);
$query="SELECT o_id FROM ns_admin WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$o_id=$row['o_id'];
$query="DELETE FROM `ns_orders` WHERE `o_id`='$o_id'";
$result=$access->resQuery($query);
$query="DELETE FROM `ns_admin` WHERE `o_id`='$o_id'";
$result=$access->resQuery($query);
$query="DELETE FROM `ns_order_dubl` WHERE `o_id`='$o_id'";
$result=$access->resQuery($query);
	if($result==true){
		$data["status"]=1;
	}else{
		$data["status"]=0;
	}
}
echo json_encode($data);

}

function faDeleteDublOrder($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($note);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);
$a_id=(int)$value->a_id;
$month=(int)$value->month;
$year=(int)$value->year;
// принимаем POST-данные и декодируем их
if($a_id !='') {
/* $query="DELETE FROM `ns_models` WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
$query="DELETE FROM `ns_counts` WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());

$query="SELECT o_id FROM ns_admin WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$o_id=$row['o_id'];
 $query="DELETE FROM `ns_orders` WHERE `o_id`='$o_id'";
$result=$access->resQuery($query);
$query="DELETE FROM `ns_admin` WHERE `o_id`='$o_id'";
$result=$access->resQuery($query);//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
*/
 $query="DELETE FROM `ns_order_dubl` WHERE `a_id`='$a_id' AND `month`='$month' AND `year`='$year'";
$result=$access->resQuery($query);
	if($result==true){
		$data["status"]=1;
	}else{
		$data["status"]=0;
	}
}
echo json_encode($data);

}
///////////////////////////////////////////
//          для scr_techmap.php
//////////////////////////////////////////

//обновление списка 
function ftLoadList($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;

$query="SELECT * FROM ns_section_list ORDER BY lSection";

$result=$access->resQuery($query);//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["sections"][$i]=$row['lSection'];
	$data["sl_id"][$i]=$row['sl_id'];
	$i++;
}
$query="SELECT * FROM ns_model_list  ORDER BY mName";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["models"][$i]=$row['mName'];
	$data["ml_id"][$i]=$row['ml_id'];
	$i++;
}
//echo 't_id='.$row['t_id'];
echo json_encode($data);
}


///////////////////////////////////////////////////

//нажатие на кнопку УДАЛИТЬ модель
function ftDelSelModel($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);
$ml_id=(int)$value->ml_id;
$qDelM="DELETE FROM `ns_model_list` WHERE `ml_id`='$ml_id'";
$result=$access->resQuery($qDelM);
$qDelM="DELETE FROM `ns_techmap` WHERE `ml_id`='$ml_id'";
$result=$access->resQuery($qDelM);
//$data["zapros"]=$qDelM;
if($result)
	$data["status"]=true;
else 
	$data["status"]=false;
echo json_encode($data);
}


///////////////////////////////////////////////////

//нажатие на кнопку УДАЛИТЬ раздел
function ftDelSelSection($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);
$sl_id=(int)$value->sl_id;
$qDelS="DELETE FROM `ns_section_list` WHERE `sl_id`='$sl_id'";
$result=$access->resQuery($qDelS);
$qDelS="DELETE FROM `ns_techmap` WHERE `sl_id`='$sl_id'";
$result=$access->resQuery($qDelS);
if($result)$data["status"]=1;
else $data["status"]=0;
echo json_encode($data);
}

///////////////////////////////////////////////////

//нажатие на кнопку Добавить
function ftAddClick($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
//print_r($_REQUEST);
$data['login']=true; 
// принимаем POST-данные и декодируем их
$value = json_decode($_REQUEST["data"]);
$serial=mysql_real_escape_string(trim($value->serial));
$descript=mysql_real_escape_string(trim($value->descript));
//$note=mysql_real_escape_string(trim($value->note));
$time=$value->time;
$time=preg_replace("/[^0-9,.]/",'',$time);
$time=round(preg_replace("/,/", ".",$time),2);
$yesNewModel=(int)$value->yesNewModel;
if($yesNewModel==1){
	$mName=mysql_real_escape_string(trim($value->mName)); 
	//делаем заглавной первую букву строки
	$mName=mb_substr(mb_strtoupper($mName,'utf-8'),0,1,'utf-8').mb_substr($mName,1,mb_strlen($mName,'utf-8'),'utf-8');  
}
if($yesNewModel==0)
	$ml_id=(int)$value->ml_id;

//$price=(float)$value->price;
$yesNewSection=(int)$value->yesNewSection;
if($yesNewSection==1){
	$Section=mysql_real_escape_string(trim($value->newSection));
	//делаем заглавной первую букву строки
	$Section=mb_substr(mb_strtoupper($Section,'utf-8'),0,1,'utf-8').mb_substr($Section,1,mb_strlen($Section,'utf-8'),'utf-8');
}
if($yesNewSection==0)
	$sl_id=(int)$value->sl_id;
//print_r($value);
$data["yesNewModel"]=$yesNewModel;
$data["yesNewSection"]=$yesNewSection;

if($yesNewModel){//mName!=false и ml_id==false, т.е. нет $ml_id
	if($yesNewSection){ //lSection!=false и sl_id = false, т.е нет и $sl_id
		if($serial != "" || $descript !="" ||  $time !=0 || $Section!='' || $sl_id==false || $mName!='' || $ml_id==false){
			$qInsM="INSERT INTO `ns_model_list`(`mName`) VALUES('$mName')";
			$qInsS="INSERT INTO `ns_section_list`(`lSection`) VALUES('$Section')";
			$access->resQuery($qInsM);
			$m_id=mysql_insert_id();
			$access->resQuery($qInsS);
			$sl_id=mysql_insert_id();
			//$data["qInsMS"]="qInsM=".$qInsM." qInsS=".$qInsS;
		}
	}else{// lSection==false и sl_id != false, т.е. $sl_id есть, а $ml_id нет
		if($serial != "" || $descript !="" ||  $time !=0 || $Section!='' || $sl_id==false || $mName!='' || $ml_id==false){
			$qInsM="INSERT INTO `ns_model_list`(`mName`) VALUES('$mName')";
			$access->resQuery($qInsM);
			$ml_id=mysql_insert_id();
			//$data["qInsM"]="qInsM=".$qInsM;
		}
	}
}else{//mName==false и ml_id!=false, т.е. $ml_id есть
	if($yesNewSection){//lSection!=false и sl_id == false, т.е. $sl_id нет
		if($serial != "" || $descript !="" || $ml_id!=0 || $time !=0 || $Section!=""){
			$qInsS="INSERT INTO `ns_section_list`(`lSection`) VALUES('$Section')";
			$access->resQuery($qInsS);
			$sl_id=mysql_insert_id();
			//$data["qInsS"]="qInsS=".$qInsS;
		}
	}

}
if(!isset($sl_id)){
	$query="SELECT `sl_id` FROM `ns_section_list` WHERE `lSection`='$Section'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$sl_id=$row["sl_id"];
}
if(!isset($ml_id)){
	$query="SELECT `ml_id` FROM `ns_model_list` WHERE `mName`='$mName'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$ml_id=$row["ml_id"];
}
$note='';
$qInsMaS="INSERT INTO `ns_techmap`( `serial`, `descript`, `ml_id`, `time`, `sl_id`) VALUES(
			'$serial',
			'$descript',
			'$ml_id',
			'$time',
			'$sl_id')";
//$data["qInsMaS"]="qInsMaS=".$qInsMaS;
$result=$access->resQuery($qInsMaS);
if($result)
	$data["status"]=1;
else 
	$data["status"]=0;
	
echo json_encode($data);

}



//////////////////////////////////////////////

function ftUpdateClick($idPage){
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}

$data['login']=true;
$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$serial=mysql_real_escape_string(trim($value->serial));
$serial=preg_replace("/,/", ".", $serial);
$descript=mysql_real_escape_string(ucfirst(trim($value->descript)));
$yesNewModel=(int)$value->yesNewModel;
if($yesNewModel==1)
	$mName=mysql_real_escape_string(trim($value->mName));
if($yesNewModel==0)
	$ml_id=(int)$value->ml_id;
$time=round(preg_replace("/,/",".",$value->time),2);
//$note=mysql_real_escape_string(trim($value->note));
//$price=(float)$value->price;
$yesNewSection=(int)$value->yesNewSection;
if($yesNewSection==1)
	$Section=mysql_real_escape_string(trim($value->newSection));
if($yesNewSection==0)
	$sl_id=(int)$value->sl_id;
$t_id=mysql_real_escape_string((int)$value->t_id);
//$data['values']=" yesNewSection=".$yesNewSection." yesNewModel=".$yesNewModel." m_Name=".$mName." ml_id=".$ml_id." "." lSection=".$Section." sl_id=".$sl_id;
if($t_id==false){
	$data["status"]=0;
	echo json_encode($data);
	exit;
}

if($yesNewModel){//mName!=false и ml_id==false, т.е. нет $ml_id
	if($yesNewSection){ //lSection!=false и sl_id = false, т.е нет и $sl_id
		if($serial != "" || $descript !="" ||  $time !=0 || $Section!='' || $sl_id==false || $mName!='' || $ml_id==false){
			$qInsM="INSERT INTO `ns_model_list`(`mName`) VALUES('$mName')";
			$qInsS="INSERT INTO `ns_section_list`(`lSection`) VALUES('$Section')";
			$access->resQuery($qInsM);
			$m_id=mysql_insert_id();
			$access->resQuery($qInsS);
			$sl_id=mysql_insert_id();
			//$data["qInsMS"]="qInsM=".$qInsM." qInsS=".$qInsS;
		}
	}else{// lSection==false и sl_id != false, т.е. $sl_id есть, а $ml_id нет
		if($serial != "" || $descript !="" ||  $time !=0 || $Section!='' || $sl_id==false || $mName!='' || $ml_id==false){
			$qInsM="INSERT INTO `ns_model_list`(`mName`) VALUES('$mName')";
			$access->resQuery($qInsM);
			$ml_id=mysql_insert_id();
			//$data["qInsM"]="qInsM=".$qInsM;
		}
	}
}else{//mName==false и ml_id!=false, т.е. $ml_id есть
	if($yesNewSection){//lSection!=false и sl_id == false, т.е. $sl_id нет
		if($serial != "" || $descript !="" || $ml_id!=0 || $time !=0 || $Section!=""){
			$qInsS="INSERT INTO `ns_section_list`(`lSection`) VALUES('$Section')";
			$access->resQuery($qInsS);
			$sl_id=mysql_insert_id();
			//$data["qInsS"]="qInsS=".$qInsS;
		}
	}

}           
if(!isset($sl_id)){
	$query="SELECT `sl_id` FROM `ns_section_list` WHERE `lSection`='$Section'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$sl_id=$row["sl_id"];
}
if(!isset($ml_id)){
	$query="SELECT `ml_id` FROM `ns_model_list` WHERE `mName`='$mName'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$ml_id=$row["ml_id"];
}
		$query="UPDATE `ns_techmap` SET 
		`serial`='$serial',
		`descript`='$descript',
		`ml_id`='$ml_id',
		`time`='$time',
		`sl_id`='$sl_id' 
		WHERE `t_id`='$t_id'";
		$data['sql']=$query;
		if($ml_id!=0 || $sl_id!=0)
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
		//echo $query;
		if($result==true)$data["status"]=1;
		else $data["status"]=0;
		echo json_encode($data);

}

//////////////////////////////////////////////////

//нажатие на кнопку Удалить
function ftDeleteClick($idPage){
//echo "Привет";    
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;

$t_id = $_REQUEST["t_id"];// принимаем POST-данные и декодируем их
$t_id=mysql_real_escape_string((int)$t_id);
if($t_id !=0) {
$query="DELETE FROM ns_techmap WHERE t_id='$t_id'";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());

if($result==true)$data["status"]=1;
else $data["status"]=0;

echo json_encode($data);

}else {
	$data["status"]=0;
	echo json_encode($data);
}


}
/////////////////////////////////////////////////////

//выбор раздела в селекте
function ftSelectChange($idPage){
//print_r($_REQUEST);
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$tList['login']=true;

$value=json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$yesNewModel=(int)$value->yesNewModel;
if($yesNewModel==1)
	$mName=mysql_real_escape_string(trim($value->mName));
if($yesNewModel==0)
	$ml_id=(int)$value->ml_id;
$yesNewSection=(int)$value->yesNewSection;
if($yesNewSection==1)
	$Section=mysql_real_escape_string(trim($value->newSection));
if($yesNewSection==0)
	$sl_id=(int)$value->sl_id;

if(!isset($sl_id)){
	$query="SELECT `sl_id` FROM `ns_section_list` WHERE `lSection`='$Section'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$sl_id=$row["sl_id"];
}
if(!isset($ml_id)){
	$query="SELECT `ml_id` FROM `ns_model_list` WHERE `mName`='$mName'";
	$result=$access->resQuery($query);
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$ml_id=$row["ml_id"];
}

//if($newSection==""){echo "function.ftselectChange:Вы выбрали выбрали "+$sect; exit;}
	$query="SELECT * FROM `ns_techmap` WHERE `sl_id`='$sl_id' AND `ml_id`='$ml_id' ORDER BY (serial+0)";
	//echo $query;
	$result=$access->resQuery($query);
	//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
	$i=0;
	$tList["status"]=0;
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$tList["data"][$i]=array("t_id"=>(int)$row["t_id"],
						"serial"=>$row['serial'],
						"descript"=>$row['descript'],
						"time"=>$row['time'],
						//"price"=>$row['price'],
						"note"=>$row['note']

		);
	$i++;
	$tList["status"]=1;
	}
	//print($tList);
//echo "t_id=".$row['t_id'];
//echo "query=".$query;
echo json_encode($tList);
}

function ftTrClick($idPage){
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$tList["login"]=false;
	echo json_encode($tList);
	exit;
}
$tList['login']=true;
$data=json_decode($_REQUEST["data"]);
$t_id=(int)$data->t_id;

if($t_id==""){echo json_encode($tList["status"]=0); exit;}
	$query="SELECT `t_id`,`serial`, `descript`, `time`  FROM `ns_techmap` WHERE t_id='$t_id'";
	//echo $query;
	$result=$access->resQuery($query);
	//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
	
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$tList=array("t_id"=>$row["t_id"],
						"serial"=>$row['serial'],
						"descript"=>$row['descript'],
						"time"=>$row['time'],
						//"price"=>$row['price'],
						//"note"=>$row['note']
		);
	
//echo "t_id=".$row['t_id'];
//echo "query=".$query;
echo json_encode($tList);
}

function ftDeleteModel($idPage){
//Проверяем достаточен ли уровень доступа
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$tList["login"]=false;
	echo json_encode($tList);
	exit;
}
$tList['login']=true;
$t_id=json_decode($_REQUEST["data"]);
$t_id=mysql_real_escape_string((int)$t_id);
if($t_id==""){echo json_encode($tList["status"]=0); exit;}
	$query="DELETE FROM ns_techmap WHERE t_id='$t_id'";
	//echo $query;
	$result=$access->resQuery($query);
	//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
	
	$row=mysql_fetch_array($result,MYSQL_ASSOC);

echo json_encode($tList);
}

///////////////////////////////////////////////////
//  от scr_worker.php
///////////////////////////////////////////////////



function fwAddClick($idPage){
//require_once('JSON.php');
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$data["text"]="Данные не добавлены";
// принимаем POST-данные и декодируем их
$value = json_decode($_REQUEST["value"]);


$appointment=mysql_real_escape_string(trim($value->appointment));
if(is_string($appointment))
//делаем заглавной первую букву строки
$appointment=mb_substr(mb_strtoupper($appointment,'utf-8'),0,1,'utf-8').mb_substr($appointment,1,mb_strlen($appointment,'utf-8'),'utf-8');
$ListOrNew=mysql_real_escape_string(trim($value->ListOrNew));

$family=mysql_real_escape_string(trim($value->family));
if(is_string($family))
//делаем заглавной первую букву строки
$family=mb_substr(mb_strtoupper($family,'utf-8'),0,1,'utf-8').mb_substr($family,1,mb_strlen($family,'utf-8'),'utf-8');

$name=mysql_real_escape_string(trim($value->name));
if(is_string($name))
//делаем заглавной первую букву строки
$name=mb_substr(mb_strtoupper($name,'utf-8'),0,1,'utf-8').mb_substr($name,1,mb_strlen($name,'utf-8'),'utf-8');

$kood=mysql_real_escape_string(trim($value->kood));
$telefon=mysql_real_escape_string(trim($value->telefon));
$bankCount=mysql_real_escape_string(trim($value->bankCount));
$city=mysql_real_escape_string(trim($value->city));
$adress=mysql_real_escape_string(trim($value->adress));
$payment=preg_replace('/,/', '.', $value->payment);
$payment=preg_replace('/[^0-9.]/', '', $payment);
$L1=(int)$value->L1;
$L2=(int)$value->L2;
$L3=(int)$value->L3;
$L4=(int)$value->L4;
$L5=(int)$value->L5;
if($ListOrNew=='List'){
		$query="SELECT * FROM `ns_appointments` WHERE wa_id='$appointment'";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die ("Запрос не выполнен".mysql_error());
		$num_rows = mysql_num_rows($result);
		// if($num_rows!=0){
			// $row=mysql_fetch_array($result,MYSQL_ASSOC);
			// $wa_id=$row['wa_id'];
		// }
		
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			if ($row["wa_id"]==$appointment){
				$wa_id=$row['wa_id'];
				$appointment=$row['appointment']; /* !!!! Меняется значение $appointment с wa_id на название профессии*/
				break;
			}
		}
	}
	$data["newApp"]=0;
	if($ListOrNew=='New'){
			
		//if($num_rows==0){
			$query="INSERT INTO ns_appointments(appointment) VALUES ('$appointment')";
			$sussec=$access->resQuery($query);
			//$sussec=mysql_query($query)or die ("Запрос этот вот:$query не выполнен. ".mysql_error());
			if($sussec){
				$data["newApp"]=1;  
				$wa_id=mysql_insert_id();
				
			}
		//}
	}

$query="INSERT INTO `ns_workers`(`L1`,`L2`,`L3`,`L4`,`L5`,`family`,`name`,`kood`,`wa_id`,`telefon`,`bankCount`,`city`,`adress`,`payment`) 
	VALUES ('$L1','$L2','$L3','$L4','$L5','$family','$name','$kood', '$wa_id',
	'$telefon','$bankCount','$city','$adress','$payment')";
	$result=$access->resQuery($query);
	$w_id=mysql_insert_id();
	$query2="INSERT INTO `auth_members` (`w_id`) VALUES ('$w_id')"; 
	$result=$access->resQuery($query2);
//$result=mysql_query($query)or die ("Запрос $query не выполнен. ".mysql_error());
		//$data["tList"]=ftloadList();
		if($result)$data['status']=1;
		else $data['status']=0;
		
echo json_encode($data);    
}

//Эта функция запускается после загрузки страницы.
//1 отсылает в List1 список профессий
//2 отсылает в List2 список id Фамилии Имя работника (в выпадающие списки)
function fwLoadWorkers($idPage){
//Проверяем достаточен ли уровень доступа
//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$wList['login']=false;
	echo json_encode($wList);
	exit;
}
$wList['login']=true;
$query="SELECT `dayStop` FROM `ns_filters`";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$wList["dayStop"]=$row["dayStop"];
$query="SELECT * FROM ns_appointments";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен");

$i=1;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$wList["List1"][$i]=array(
						'appointment'=>$row["appointment"],
						'wa_id'=>$row["wa_id"]
						);
	$i++;
}
$query="SELECT * FROM ns_workers ORDER BY family";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
if ( @mysql_num_rows($result) == 0 ){
	$wList["status"]=0;
}else {
	$wList["status"]=1;
}
$wList["List2"][0]="false";
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
if($row['family']=='Administrator')continue;
	$wList["List2"][$i]=array("w_id"=>$row['w_id'],
					"family"=>$row['family'],
					"name"=>$row['name']
				);
	$i++;

}

//echo 't_id='.$row['t_id'];
echo json_encode($wList);
}
function fwSetDayStop($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	exit;
}

// принимаем POST-данные и декодируем их
$data = json_decode($_REQUEST["data"]);
$dayStop=(int)$data->dayStop;
$query="UPDATE `ns_filters` SET `dayStop`='$dayStop' WHERE `f_id`=1";
$result=$access->resQuery($query);
}
function fwListClick($idPage){

$access=new ToBase();
if(!$access->accessYes($idPage)){
	$wList['login']=false;
	echo json_encode($wList);
	exit;
}
$wList['login']=true;
// принимаем POST-данные и декодируем их
$data = json_decode($_REQUEST["data"]);

$w_id=mysql_real_escape_string((int)$data->w_id);
$query="SELECT * FROM `ns_workers` WHERE `w_id`='$w_id'";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die ("Запрос не выполнен".mysql_error());

while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$wList = array("w_id"=>$row['w_id'],
					"family"=>$row['family'],
					"name"=>$row['name'],
					"kood"=>$row['kood'],
					"wa_id"=>$row['wa_id'],
					"telefon"=>$row['telefon'],
					"bankCount"=>$row['bankCount'],
					"city"=>$row['city'],
					"adress"=>$row['adress'],
					"payment"=>$row['payment'],
					"L1"=>$row['L1'],   
					"L2"=>$row['L2'],
					"L3"=>$row['L3'],
					"L4"=>$row['L4'],
					"L5"=>$row['L5'],
	);
}
$query="SELECT * FROM `ns_appointments` WHERE `wa_id`='".$wList['wa_id']."'";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die ("Запрос не выполнен".mysql_error());
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$wList['appointment']=$row['appointment'];

echo json_encode($wList);

}


//нажатие на кнопку Удалить
function fwDeleteClick($idPage){
	//Проверяем достаточен ли уровень доступа
	//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
	$data['login']=true;
	//echo "Привет";
$value = json_decode($_REQUEST["data"]);    // принимаем POST-данные 
	$result=false;
	$w_id=mysql_real_escape_string((int)$value->w_id);
	if($w_id !='') {
		$query="DELETE ns_workers,auth_members FROM ns_workers,auth_members WHERE ns_workers.w_id=auth_members.w_id AND ns_workers.w_id='$w_id'";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
	}
	if($result)
		$data["status"]=1;  
	else
		$data["status"]=0;
	
	echo json_encode($data);
}

//Принимает данные для замены в таблице ns_worters по id работника, 
//который получен при выборе работкника из выпад. списка
function fwUpdateClick($idPage){
//print_r($_REQUEST);
//Проверяем достаточен ли уровень доступа
	//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$toJS['login']=false;
	echo json_encode($toJS);
	exit;
}
$toJS['login']=true;
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$family=mysql_real_escape_string(trim($data->family));
$name=mysql_real_escape_string(trim($data->name));
$kood=mysql_real_escape_string(trim($data->kood));
$appointment=mysql_real_escape_string(trim($data->appointment));
$ListOrNew=mysql_real_escape_string(trim($data->ListOrNew));
$telefon=mysql_real_escape_string(trim($data->telefon));
$bankCount=mysql_real_escape_string(trim($data->bankCount));
$city=mysql_real_escape_string(trim($data->city));
$adress=mysql_real_escape_string(trim($data->adress));
$payment=preg_replace('/,/', '.', $data->payment);
$payment=preg_replace('/[^0-9.]/', '', $payment);
$w_id=mysql_real_escape_string((int)$data->w_id);
$L1=(int)$data->L1;
$L2=(int)$data->L2;
$L3=(int)$data->L3;
$L4=(int)$data->L4;
$L5=(int)$data->L5;
	if($ListOrNew=='List'){
		$query="SELECT * FROM `ns_appointments` WHERE wa_id='$appointment'";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die ("Запрос не выполнен".mysql_error());
		$num_rows = mysql_num_rows($result);
		// if($num_rows!=0){
			// $row=mysql_fetch_array($result,MYSQL_ASSOC);
			// $wa_id=$row['wa_id'];
		// }
		
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			if ($row["wa_id"]==$appointment){
				$wa_id=$row['wa_id'];
				$appointment=$row['appointment']; /* !!!! Меняется значение $appointment с wa_id на название профессии*/
				break;
			}
		}
	}
	$toJS["newApp"]=0;
	if($ListOrNew=='New'){
			
		//if($num_rows==0){
			$query="INSERT INTO ns_appointments(appointment) VALUES ('$appointment')";
			$sussec=$access->resQuery($query);
			//$sussec=mysql_query($query)or die ("Запрос этот вот:$query не выполнен. ".mysql_error());
			if($sussec){
				$toJS["newApp"]=1;  
				$wa_id=mysql_insert_id();
			}
		//}
	}
	$query="UPDATE `ns_workers` 
	SET `family`='$family',`name`='$name', `kood`='$kood',`wa_id`='$wa_id',`telefon`='$telefon',
	`bankCount`='$bankCount',`city`='$city',`adress`='$adress',`payment`='$payment',`L1`='$L1',`L2`='$L2',`L3`='$L3',`L4`='$L4',`L5`='$L5'
	WHERE `w_id`='$w_id'";
	//echo $query;
	$result=$access->resQuery($query);
	//if(mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error())){
	if($result) 
		$toJS["status"]=1;
	else
		$toJS["status"]=0;
	
	echo json_encode($toJS);

		
		
}
function fwDelAppointment($idPage){

	//Проверяем достаточен ли уровень доступа
	//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$toJS['login']=false;
	echo json_encode($toJS);
	exit;
}   $toJS['login']=true;    
	$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
	//$data['login']=true;
	$wa_id = $value->wa_id;// принимаем POST-данные 
	$wa_id=mysql_real_escape_string((int)$wa_id);
	if($wa_id !=''){
		$query="DELETE FROM `ns_appointments` WHERE `wa_id`='$wa_id'";
		$result=$access->resQuery($query);
		//mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
		$toJS["status"]=1;;
	}else{
		$toJS["status"]=1;
	}
	echo json_encode($toJS);
}

function fwSelectAccount($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$value["login"]=false;
	echo json_encode($value);
	exit;
}
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их

$w_id=(int)$data->w_id;
$user=new ToBase();
$login=$user->getLogin($w_id);
if($login) 
	$value["login"]=$login; 
else 
	$value["login"]=false;
echo json_encode($value);
}

function fwInsertAccount($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$value["status"]=false;
	echo json_encode($value);
	exit;
}
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их

$w_id=(int)$data->w_id;

$login=(string)$data->login;
$pass=(string)$data->pass; 

if($access->setAccount($w_id,$login,$pass)){
	$value["status"]=1;
}else{
	$value["status"]=0;
}
echo json_encode($value);

}

function fwDeleteAccount($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$value["status"]=false;
	echo json_encode($value);
	exit;
}
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их

$w_id=(int)$data->w_id;
$query="DELETE FROM `auth_members` WHERE `w_id`='$w_id'";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());

if($result){
	$value["status"]=1;
}else{
	$value["status"]=0;
}
echo json_encode($value);
}

/*Устанавливаем фильтр для отбора професси на стр "Результаты работы"*/
function fwSetFiltr($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["status"]=false;
	echo json_encode($data);
	exit;
}
$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$wa_id=(int)$value->wa_id;
$query="UPDATE `ns_filters` SET `work_show`='$wa_id' WHERE `f_id`=1";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
if($result)
$data["status"]=true;
else
$data["status"]=false;

echo json_encode($data);
}
/////////////////////////////////////////////////
// from scr_seamstress.php
// 
//////////////////////////////////////////////////

function fsLoadFamily($idPage){
	//Проверяем достаточен ли уровень доступа
	
	$access=new ToBase();
	$level=$access->accessYes($idPage);
	if($level==0){
		$wList["status"]=false;
		$wList["level"]=0;
		echo json_encode($wList);
		exit;
	}

	/*считываем фильтр, который указывает какую профессию выводить*/
	$query="SELECT `work_show` FROM ns_filters WHERE `f_id`=1";
	$result=$access->resQuery($query);
	//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
	$row=mysql_fetch_array($result,MYSQL_ASSOC);
	$filtr=$row["work_show"];

	/*если это не швея ($level=-1) выводим список работников*/
	if($level<0){
		$query="SELECT * FROM ns_workers WHERE `wa_id`='$filtr' ORDER BY family";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
		$i=0;
		if ( @mysql_num_rows($result) == 0 ){
			$wList["status"]=0;
		}else {
			$wList["status"]=1;
		}
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$wList["data"][$i]=array("w_id"=>$row['w_id'],
							"family"=>$row['family'],
							"name"=>$row['name']
						);
			$i++;
		}
		$wList["List"]=1; /*указывает на вывод списка фамилий*/
	}
	/*если это швея ($level>0) выводим тоько данные этой швеи*/
	if($level>0){
		$query="SELECT * FROM ns_workers WHERE `wa_id`='$filtr' AND `w_id`='$level'";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());

		if ( @mysql_num_rows($result) == 0 ){
			$wList["status"]=0;
		}else {
			$wList["status"]=1;
		}
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
			$wList["data"]=array("w_id"=>$row['w_id'],
							"family"=>$row['family'],
							"name"=>$row['name']
						);
		$wList["List"]=0;   /*Указывает, что списка нет, только одна фамилия*/
	}

	echo json_encode($wList);/*отсылаем данные*/
}


function fsFamilySelect($idPage)
{
	$access=new ToBase();
	if(!$access->accessYes($idPage)){
		$toJS['login']=false;
		echo json_encode($toJS);
		exit;
	}
//print_r($_REQUEST);

	$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
	$period=mysql_real_escape_string($data->period);
		if($period=="week") $week=mysql_real_escape_string((int)$data->week);
		if($period=="month") $month=mysql_real_escape_string((int)$data->month);
	//$month=mysql_real_escape_string((int)$data->month);
	//$week=mysql_real_escape_string((int)$data->week);
	$year=mysql_real_escape_string((int)$data->year);
	$w_id=mysql_real_escape_string((int)$data->w_id);

 	if($res=new Result($access->getConnDB())){
		if($period=="week"){
			$toJS=$res->getWeekTable($w_id,$week,$month,$year);
		}else if($period=="month"){
			$toJS=$res->getMonthTable($w_id,$month,$year);
		}
	}else{
		$toJS['status']=0;
	}
//print_r($toJS);
	$toJS['login']=true;
	echo json_encode($toJS);
 }

// if($period=="week"){
// 	$query="SELECT `ns_orders.order`,`ns_model_list.mName`,`ns_model_list.lSection`,`ns_techmap.serial`,`ns_techmap.descript`,`ns_techmap.time`,`ns_workers.payment`,`ns_results.countDid`,`ns_counts.count`,`ns_results.r_id`
// FROM `ns_workers`,`ns_orders`,`ns_results`,`ns_model_list`,`ns_section_list`,`ns_techmap`,`ns_counts`
// WHERE 
// 	ns_results.o_id=ns_orders.o_id 
// AND ns_results.w_id='$w_id' 
// AND ns_results.week='$week'
// AND ns_results.month='$month'
// AND ns_results.year='$year'
// AND ns_results.ml_id=ns_model_list.ml_id
// AND ns_results.sl_id=ns_section_list.sl_id
// AND ns_results.sl_id=ns_techmap.sl_id
// AND ns_results.t_id=ns_techmap.t_id
// AND ns_results.m_id=ns_counts.m_id
// 	ORDER BY date DESC";
// }else if($period=="month"){
// 	$query="SELECT `ns_orders.order`,`ns_model_list.mName`,`ns_section_list.lSection`,`ns_techmap.serial`,`ns_techmap.descript`,`ns_techmap.time`,`ns_workers.payment`,`ns_results.countDid`,`ns_counts.count`,`ns_results.r_id`
// FROM `ns_workers`,`ns_orders`,`ns_results`,`ns_model_list`,`ns_section_list`,`ns_techmap`,`ns_counts`
// WHERE ns_results.o_id=ns_orders.o_id 
// AND ns_results.w_id='$w_id' 
// AND ns_results.month='$month'
// AND ns_results.year='$year'
// AND ns_results.ml_id=ns_model_list.ml_id
// AND ns_results.sl_id=ns_section_list.sl_id
// AND ns_results.sl_id=ns_techmap.sl_id
// AND ns_results.t_id=ns_techmap.t_id
// AND ns_results.m_id=ns_counts.m_id
// 	ORDER BY date DESC";
// }
/*отладка*/
//$toJS["query"]=$query;
//echo '$query='.$query;
//$result=$access->resQuery($query);

// if ( @mysql_num_rows($result) == 0 ){
// 		$toJS["status"]=0;
// }else {$toJS["status"]=1;}
// $res=new Result(connDB());
// if($period=="week"){
// 	$toJS=res->getMonthTable($w_id,$month,$year);
// 	//$konto+=(float)$row["payment"]*$row["countDid"];
// 		// $toJS["data"][$i]=array(
// 		// 	"r_id"=>$res->getWeekTable["r_id"],
// 		// 	"serial"=>$res->getWeekTable["serial"],
// 		// 	"order"=>$res->getWeekTable["order"],
// 		// 	"model"=>$res->getWeekTable["mName"],
// 		// 	"section"=>$res->getWeekTable["lSection"],
// 		// 	"operate"=>$res->getWeekTable["descript"],
// 		// 	"count"=>$res->getWeekTable["countDid"],
// 		// 	"payment"=>$res->getWeekTable["payment"],
// 		// 	"time"=>$res->getWeekTable["time"]*$row["countDid"],
// 		// 	"sum"=>$res->getWeekTable["payment"]*$res->getWeekTable["countDid"]*$res->getWeekTable["time"]
// 		// 	);

// // }elseif($period=="month"){
// 	$toJS=res->getMonthTable($w_id,$month,$year);
// 		// $toJS["data"][$i]=array(
// 		// 	"r_id"=>$res->getWeekTable["r_id"],
// 		// 	"serial"=>$res->getWeekTable["serial"],
// 		// 	"order"=>$res->getWeekTable["order"],
// 		// 	"model"=>$res->getWeekTable["mName"],
// 		// 	"section"=>$res->getWeekTable["lSection"],
// 		// 	"operate"=>$res->getWeekTable["descript"],
// 		// 	"count"=>$res->getWeekTable["countDid"],
// 		// 	"payment"=>$res->getWeekTable["payment"],
// 		// 	"time"=>$res->getWeekTable["time"]*$row["countDid"],
// 		// 	"sum"=>$res->getWeekTable["payment"]*$res->getWeekTable["countDid"]*$res->getWeekTable["time"]
// 		// 	);
// }
// $i=0;
// (int)$sumTime=0;
// (float)$sum=0;
// (int)$count=0;
// (float)$konto=0;
// while($row=mysql_fetch_array($result,MYSQL_ASSOC)){

// $sumTime+=$row["time"]*$row["countDid"];
// $konto+=(float)$row["payment"]*$row["countDid"];
// 		$toJS["data"][$i]=array(
// 			"r_id"=>$row["r_id"],
// 			"serial"=>$row["serial"],
// 			"order"=>$row["order"],
// 			"model"=>$row["mName"],
// 			"section"=>$row["lSection"],
// 			"operate"=>$row["descript"],
// 			"count"=>$row["countDid"],
// 			"payment"=>$row["payment"],
// 			"time"=>$row["time"]*$row["countDid"],
// 			"sum"=>(float)$row["payment"]*$row["countDid"]*$row["time"]
// 			);
// $i++;
// }
 // $toJS["sumTime"]=$sumTime;
 // $toJS["konto"]=$konto;
// $toJS['login']=true;
// echo json_encode($toJS);
//}


function fsSelectOrder($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
//$data['login']=true;
$value = json_decode($_REQUEST["data"]); //принимаем POST-данные и декодируем их
$a_id=(int)$value->a_id;

	if($a_id != ""){
		$query="SELECT `m_id`, `mName`  FROM `ns_models`, `ns_model_list` WHERE `a_id`='$a_id' AND ns_models.ml_id=ns_model_list.ml_id";
		//echo $query;
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
		$i=0;
			while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
				$data["val"][$i]=array(     
								"m_id"=>$row["m_id"],
								"model"=>$row["mName"],
								);
				$i++;
			}               
		//print_r($data);


		//echo 't_id='.$row['t_id'];
		$data['status']=1;
		
	}else{
		$data['status']=0;
	}
echo json_encode($data);
}
//выбираем все операции из таблицы ns_techmap
function fsLoadModel($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$query="SELECT `nd_techmant.t_id`,`nd_techmant.descript`,`nd_techmant.model`,`nd_techmant.time`,`nd_workers.payment` FROM ns_techmap, ns_workers ";
//echo $query;
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$operatesList[$i]=array("t_id"=>$row['t_id'],
					"descript"=>$row['descript'],
					"model"=>$row['model'],
					"time"=>$row['time'],
					"payment"=>$row['payment']
				);
	$i++;
}

echo json_encode($operatesList);
}

// считываем данные из таблицы ns_admin за указанную неделю указанного года
function fsLoadOrder($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$sList['login']=false;
	echo json_encode($sList);
	exit;
}
$sList['login']=true;
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$week=mysql_real_escape_string((int)$data->week);
$month=mysql_real_escape_string((int)$data->month);
$year=mysql_real_escape_string((int)$data->year);

$query="SELECT `a_id`,`order` FROM `ns_admin`,`ns_orders` WHERE `month`='$month' AND `aWeek`='$week' AND `aYear`='$year' AND ns_orders.o_id=ns_admin.o_id";
//$sList["query1"]= $query;
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
$sList["status"]='0';
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$sList["data"][$i]=array(
							"a_id"=>$row['a_id'],
							"aOrder"=>$row['order']
						);
		$i++;
		$sList["status"]='1';
	}
$query="SELECT `a_id`,`order` FROM `ns_order_dubl`,`ns_orders` WHERE `month`='$month' AND `week`='$week' AND `year`='$year' AND ns_orders.o_id=ns_order_dubl.o_id";
//$sList["query2"]= $query;
$result=$access->resQuery($query);
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$sList["data"][$i]=array(
						"a_id"=>$row['a_id'],
						"aOrder"=>$row['order']
						);
		$i++;
	$sList["status"]='1';
	}
echo json_encode($sList);
}



//читаем разделы
function fsLoadSectons($idPage){
//Проверяем достаточен ли уровень доступа

//verifity("admin");
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data["login"]=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;

$query="SELECT * FROM ns_section_list ORDER BY lSection";

$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["sections"][$i]=$row['lSection'];
	$data["sl_id"][$i]=$row['sl_id'];
	$i++;
}

//echo 't_id='.$row['t_id'];
echo json_encode($data);
}

//выбираем номера операций заданного раздела и заданной модели из таблицы ns_techmap
function fsNumOperates($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;

$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$sl_id=(int)$value->sl_id;
$m_id=(int)$value->m_id;
//определяем название модели по ее m_id
$query="SELECT `ml_id` FROM `ns_models` WHERE `m_id`='$m_id'";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$ml_id=$row['ml_id'];

$query="SELECT t_id,serial FROM `ns_techmap` WHERE `ml_id`='$ml_id' AND `sl_id`='$sl_id' ORDER BY (serial+0)";
//echo $query;
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$i=0;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data['serials'][$i]=$row['serial'];
	$data['t_id'][$i]=$row['t_id'];
	$i++;
}

echo json_encode($data);
}

//выбор номера операции, считывание ее и определение сколько раз ее можно выполнить
function fsSelectOperate($idPage){
//print_r($_REQUEST);
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$a_id=(int)$value->a_id;
$m_id=(int)$value->m_id;
$w_id=(int)$value->w_id;
$sl_id=(int)$value->sl_id;
$t_id=(int)$value->t_id;
$year=(int)$value->year;  //new 4.08.2014
//определяем ид имени ордера
$query="SELECT o_id FROM ns_admin WHERE a_id='$a_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC); 
$o_id=$row["o_id"];
//считаем записи из ns_result по o_id 
$query="SELECT SUM(countDid) AS sumCountDid FROM `ns_results` WHERE `o_id`='$o_id' AND `t_id`='$t_id' AND `year`='$year'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC); 
$sumCountDid=$row["sumCountDid"];

//выбираем количество запланированных с этой операцией изделий
$query="SELECT count FROM ns_counts WHERE m_id='$m_id'";
$result=$access->resQuery($query);
$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$count=$row['count'];
//выбираем данные выбранной операции по t_id
$query="SELECT `serial`,`descript`, `mName`, `time`, `payment`, `lSection` 
FROM `ns_techmap`,`ns_model_list`,`ns_section_list`,`ns_workers` 
WHERE `w_id`='$w_id' AND `t_id`='$t_id' AND ns_techmap.ml_id=ns_model_list.ml_id AND ns_techmap.sl_id=ns_section_list.sl_id";
$result=$access->resQuery($query);
$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$data['list']=array(
	"serial"=>$row["serial"],
	"descript"=>$row["descript"],
	"model"=>$row["mName"],
	"time"=>$row["time"],
	"payment"=>$row["payment"],
	"newSection"=>$row["lSection"],
	"count"=>$count-$sumCountDid
);

echo json_encode($data);
}

function fsAdd($idPage){
$access=new ToBase();
	if(!$access->accessYes($idPage)){
		$toJS['login']=false;
		echo json_encode($toJS);
		exit;
	}
$toJS['login']=true;
$date_now=date("Y-m-d H:i:s");
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$t_id=(int)$data->t_id; //id операции
$sl_id=(int)$data->sl_id;//id секции
$a_id=(int)$data->a_id;//id ордера
$m_id=(int)$data->m_id;//id модели
$w_id=(int)$data->w_id;// id работника
$week=(int)$data->week;
$month=(int)$data->month;
$year=(int)$data->year;
$countDid=(int)$data->countDid; //сколько выполненно выбранной операции

$query="SELECT `dayStop` FROM `ns_filters` WHERE `f_id`=1";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$dayStop=$row["dayStop"];

	if(0==$t_id || 0==$sl_id || 0==$a_id || 0==$m_id || 0==$w_id || 0==$week || 0==$month || 0==$year || 0==$countDid){
		$toJS['dayStop']=$dayStop;
		$toJS["status"]=0;
		echo json_encode($toJS);
		exit;
	}

/**
* проверка на количесвто добавленных операций
* написать запрос где считается все countDid для sl_id,m_id,o_id
**/
$query="SELECT `o_id` FROM `ns_admin` WHERE `a_id`='$a_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$o_id=$row["o_id"];
//$o_id=$a_id;
$query="SELECT `count` FROM `ns_counts` WHERE `a_id`='$a_id' AND `m_id`='$m_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$count=$row["count"];
$query="SELECT SUM(countDid) AS sumCountDid FROM `ns_results` WHERE `o_id`='$o_id' AND `t_id`='$t_id'";
$result=$access->resQuery($query);
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$sumCountDid=$row["sumCountDid"];
	if($count < $sumCountDid)
		{$toJS['addYes']="No";
		exit;
	}else{
		$toJS['addYes']="Yes";
	}
//$toJS['addYes']=$count<$row["sumCountDid"];
$cMonth=date("n");
//$toJS["cMonth"]=$cMonth;
$cYear=date("Y");
$cDay=date("j");
	if(!(($cMonth==$month && $year==$cYear) || 
		($cMonth==1 && $month==12 && $year<$cYear && $dayStop>$cDay) ||
			($cMonth>1 && $month<=$cMonth && $month>=$cMonth-1 && $year<=$cYear && $dayStop>$cDay))){
		
		$toJS['test']="(($cMonth=$month && $year==$cYear && $dayStop>$cDay) || 
		($cMonth==1 && $month==12 && $year<$cYear && $dayStop>$cDay) ||
		($cMonth>1 && $month<=$cMonth && $month>=$cMonth-1 && $year<=$cYear && $dayStop>$cDay))";
						
			$toJS['dayStop']=false;
			$toJS["status"]=0;
			echo json_encode($toJS);
			exit;
	}else{
		$toJS['dayStop']=true;
		//надо найти t_id - идентификатор по $serial и $newSection
		// $query="SELECT o_id FROM ns_admin WHERE a_id='$a_id'";
		// $result=$access->resQuery($query);
		// $row=mysql_fetch_array($result,MYSQL_ASSOC);
		// $o_id=$row['o_id'];
		
		
		$query="SELECT `ml_id` FROM `ns_models` WHERE `m_id`='$m_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$ml_id=$row['ml_id'];

		$query="SELECT `mName` FROM `ns_model_list` WHERE `ml_id`='$ml_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$model_name=$row['mName'];
		
		$query="SELECT `lSection` FROM `ns_section_list` WHERE `sl_id`='$sl_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$section_name=$row['lSection'];
		
		$query="SELECT `descript`,`time`,`serial` FROM `ns_techmap` WHERE `t_id`='$t_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$operate=$row['descript'];
		$time=$row['time'];
		$serial=$row['serial'];

		$query="SELECT `family`,`name`,`payment` FROM `ns_workers` WHERE `w_id`='$w_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$payment=$row['payment'];
		$family=$row['family'];
		$name=$row['name'];
		$query="SELECT `order` FROM `ns_orders` WHERE `o_id`='$o_id'";
		$result=$access->resQuery($query);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$order=$row['order'];

		$arg=compact("t_id","a_id","o_id","fa_id","family","name","order","m_id","ml_id","model_name","sl_id","section_name",
			"w_id","serial","payment","descript","time","date_now","week","month","year","countDid");
		//print_r($arg);
		 $res=new Result($access->getConnDB());
		 if($res->getAdd($arg)){
			$toJS["status"]=1; 			
		}else{
			$toJS["status"]=0; 
		 }
		// $query="INSERT INTO `ns_results`(`t_id`, `a_id`,`o_id`, `m_id`, `ml_id`,`model_name`, `sl_id`,`section_name`, `w_id`,`payment`, `date`, `week`, `month`, `year`, `countDid`) 
		// VALUES ('$t_id','$a_id','$o_id','$m_id','$ml_id','$model_name',$sl_id','$section_name`,$w_id','$payment',$date_now','$week','$month','$year','$data->countDid')";
		// //$toJS["query="]=$query;
		// $result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());

		echo json_encode($toJS);
	}
}

function fsDeleteRecord($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$toJS['login']=false;
	echo json_encode($toJS);
	exit;
}
$toJS['login']=true;
$data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
	$r_id = $data->r_id; 
	$r_id=mysql_real_escape_string((int)$r_id);
	$w_id=$data->w_id;
	$w_id=mysql_real_escape_string((int)$w_id);
	$query="DELETE FROM ns_results WHERE r_id='$r_id'";
	$result=$access->resQuery($query);
	//$result=mysql_query($query)or die("Запрос $query не выполнен. ".mysql_error());
	if($result)$toJS["status"]=1;
	else $toJS["status"]=0;
	echo json_encode($toJS);
}


/////////////////////////////////////////////////////////////////////////////////////
//
//          for buch.php
//

// 
function fbLoadAppointments($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;

/*считываем фильтр, который указывает какую профессию выводить*/
$query="SELECT `work_show` FROM ns_filters WHERE `f_id`=1";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен".mysql_error());
$row=mysql_fetch_array($result,MYSQL_ASSOC);
$data["filtr"]=$row["work_show"];

$query="SELECT * FROM ns_appointments WHERE 1";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен");
if($result!=false){$data["status"]=1;}else{$data["status"]=0;}
$i=1;
	while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
		$data["appointments"][$i]=$row["appointment"];
		$data["wa_id"][$i]=$row["wa_id"];
		$i++;
	}
echo json_encode($data);
}

function fbLoadData($idPage){
$access=new ToBase();
if(!$access->accessYes($idPage)){
	$data['login']=false;
	echo json_encode($data);
	exit;
}
$data['login']=true;
$value = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
$wa_id=(int)$value->wa_id;
$data["month"]=date("m");
$data["year"]=date("Y");

$query="SELECT `family`,`name`,`w_id` FROM ns_workers WHERE wa_id='$wa_id' ORDER BY family";
$result=$access->resQuery($query);
//$result=mysql_query($query)or die("Запрос не выполнен");
if($result!=false){$data["status"]=1;}else{$data["status"]=0;}
$i=1;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["family"][$i]=$row["family"];
	$data["name"][$i]=$row["name"];
	$data["w_id"][$i]=$row["w_id"];
	$i++;
}
echo json_encode($data);
}
//дополнительные данные
function fbLoadAddvData($idPage){
//Проверяем достаточен ли уровень доступа
	$access=new ToBase();
	$level=$access->accessYes($idPage);
	if($level!=0)
		$data['login']=$level;
	if($level==0){
		$data['login']=false;
		echo json_encode($data);
		exit;
	}

$value = json_decode($_REQUEST["data"]);
$wa_id=(int)$value->wa_id;
$data["year"]=date("Y");
$data["month"]=date("m");
$data["week"]=date("W");
$query="SELECT `w_id`,`family`,`name` FROM `ns_workers` WHERE wa_id='$wa_id' ORDER BY family";
$result=$access->resQuery($query);
if($result!=false)
	{$data["status"]=1;
}else{
	$data["status"]=0;
}
$i=1;
while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
	$data["family"][$i]=$row["family"];
	$data["name"][$i]=$row["name"];
	$data["w_id"][$i]=$row["w_id"];
	$i++;
}
echo json_encode($data);
}



function timeStr($a){
	$h=floor($a/3600);
	$a-=3600*$h;    
	$m=floor($a/60);
	if($m<10){$m='0'+$m;}
	$s=$a-60*$m;
	if($s<10){$s='0'+$s;}
	$time=$h.":".$m.":".$s;
	return $time;

}
function fbLoadPalk($idPage){
//Проверяем достаточен ли уровень доступа
	//verifity("buch");
	$access=new ToBase();
	$level=$access->accessYes($idPage);
	if($level!=0)$dt['login']=$level;
	if($level==0){
		$dt['login']=false;
		echo json_encode($dt);
		exit;
	}
//print_r($_REQUEST);
$data=json_decode($_REQUEST["data"]);

//print_r($data);

/*
алгоротм:
получить список w_id по указанной профессии
в цикле просчитать каждую фамилию
массив с данными клиенту
*/
$w_id=0;
	//if(!empty($data->w_id)){
		$w_id=(int)$data->w_id;//работник
	//}
	$wa_id=(int)$data->wa_id;//должность

	$month=(int)$data->month;
	$year=(int)$data->year;

	if(0==$w_id){//echo "w_id=".$w_id; выбраны все пользователи
		$query="SELECT `w_id` FROM `ns_workers` WHERE `wa_id`='$wa_id'";
		$result=$access->resQuery($query);
		//$result=mysql_query($query)or die("Запрос не выполнен ".mysql_error());
		if ( @mysql_num_rows($result) == 0 ){//нет результатов выборки
			$dt["f"]=0;
			echo json_encode($dt);
			exit;
		}
		//Есть результаты выборки
		$i=0;
		while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
			$id_workers[$i]=$row["w_id"]; //массив работников
			$i++;
		}
		$kokku=0;
		//print_r($id_workers);
		foreach($id_workers as $num=>$w_id){
			// $query="SELECT ns_results.countDid, ns_workers.family, ns_workers.name, ns_workers.payment, ns_techmap.time
			// FROM ns_results, ns_workers, ns_admin, ns_models, ns_techmap
			// WHERE 
			// ns_results.year='$year' AND 
			// ns_workers.w_id='$w_id' AND
			// ns_workers.w_id=ns_results.w_id AND 
			// ns_results.a_id=ns_admin.a_id AND 
			// ns_results.month='$month' AND 
			// ns_results.m_id=ns_models.m_id AND 
			// ns_results.t_id=ns_techmap.t_id";
			$query="SELECT `family`,`name`,`w_id_payment`,`operate_time`,`countDid` FROM `ns_results` WHERE `w_id`='$w_id' AND `year`='$year' AND `month`='$month'";
			$result=$access->resQuery($query);
						
			if($result==false){//запрос пуст
				$dt["status"]=0;
				echo json_encode($dt);
				exit;
			}else{// запрос не пуст
				$dt["status"]=1;
				
				$sumPayment=0; //сумма заработка пользователя
				$sumTime=0; //время работы пользователя
				
				
					while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
					
						
						$dt["data"][$num]["family"]=$row["family"];
						$dt["data"][$num]["name"]=$row["name"];
								$sumPayment+=$row["countDid"]*$row["w_id_payment"]*$row['operate_time'];
								$sumTime+=$row["operate_time"]*$row["countDid"];
								
					}
					if($sumPayment!=0 || $sumTime!=0){
						$dt["data"][$num]["sumPrice"]=$sumPayment;
						$dt["data"][$num]["sumTime"]=$sumTime;//$sumTime;
						$kokku+=$sumPayment;
					}
			}
		}   
			$dt["kokku"]=$kokku;
			$dt["f"]=0;
			
		echo json_encode($dt);
	}else{//    echo "w_id=".$w_id; выбран 1 пользователь
		// $query="SELECT ns_results.countDid, ns_workers.family, ns_workers.name, ns_workers.payment, ns_techmap.time
		// FROM ns_results, ns_workers, ns_admin, ns_models, ns_techmap
		// WHERE 
		// ns_workers.w_id='$w_id' AND 
		// ns_results.month='$month' AND 
		// ns_results.year='$year' AND 
		// ns_workers.w_id=ns_results.w_id AND 
		// ns_results.a_id=ns_admin.a_id AND 
		// ns_results.m_id=ns_models.m_id AND 
		// ns_results.t_id=ns_techmap.t_id";
			$query="SELECT `family`,`name`,`w_id_payment`,`operate_time`,`countDid` FROM `ns_results` WHERE `w_id`='$w_id' AND `year`='$year' AND `month`='$month'";
			$result=$access->resQuery($query);
			$sumPayment=0;
			$sumTime=0;
			if($result==false){
				$dt["status"]=0;
				echo json_encode($dt);
				exit;
			}else{
				$dt["status"]=1;
				
				while($row=mysql_fetch_array($result,MYSQL_ASSOC)){
				//print_r ($row);
					$dt["family"]=$row["family"];
					$dt["name"]=$row["name"];
							$sumPayment+=$row["countDid"]*$row["w_id_payment"]*$row['operate_time'];
							$sumTime+=$row["operate_time"]*$row["countDid"];
							
				}
				if($sumPayment!=0 || $sumTime!=0){
					$dt["sumPrice"]=$sumPayment;
					$dt["sumTime"]=$sumTime;//$sumTime;
					
				}else{
					$dt["family"]="Нет данных";
					$dt["name"]=" ";
					$dt["sumPrice"]="Нет данных";
					$dt["sumTime"]="Нет данных";
					$dt["kokku"]="0";
				}
				$dt["f"]=1;
				echo json_encode($dt);
			}
	}   
}

							
							