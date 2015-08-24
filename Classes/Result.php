<?php
class Result{
	
	private $results;
	private $connDB;

	public function __construct($connDB)
	{
		$this->connDB=$connDB;
		//echo "<br>Это Result1 класс";
		$sql="SELECT * FROM `ns_results` WHERE 1";
		$res=mysql_query($sql,$connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
		while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
			$this->results[]=$row;
		}
	   // echo "<br>Инициировали массив results";
		//print_r($this->results);
	}
	/**
	*   возвращает отработанное работником время за месяц
	*/
	public function getTime($w_id,$month,$year)
	{ 
		foreach ($this->results as $key => $value) {
			if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
			   $time+=$value['operate_time'];
			}        
		}   
		return $time;
	}
	/**
	*   возвращает данные для функции faCheckOrder
	*
	*/
	public function checkOrder()
	{
		$year=2015;
		$month=8;
		$week=34;
		$order='11';
		$model="Модель H258-1;";
		$sl_id=55;
echo "<br>это checkOrder";
		// $week=(int)$value->week;
		// $month=(int)$value->month;
		// $year=(int)$value->year;
		// $order=mysql_real_escape_string(trim((string)$value->order));
		// $model=mysql_real_escape_string(trim((string)$value->mName));
		// $sl_id=(int)$value->sl_id;
		// $w_idArray=array();
		$i=0;
		//Делаем выборку работников в массив $d, которые выполнили 
		//заданный ордер, модель из заданного раздела
		foreach ($this->results as $key => $row) {
		  if($row['week']==$week AND 
			  $row['month']==$month AND 
				$row['year']==$year AND 
				  $row['order_name']==$order AND 
					$row['model']==$model AND 
					  $row['sl_id']==$sl_id ){
			  //$data["List"][$i]=array(
				$d[$i]=array(
								  "w_id"=>$row["w_id"],
								  "family"=>$row["family"],
								  "name"=>$row["name"],
								  "serial"=>$row["serial"],
								  "countDid"=>$row["countDid"]
			  );
		  }
		  $i++;
		}
echo "<br> создали массив d";
		//Создаем массивы по столбцам выборки
		foreach ($d as $key => $value) {
			$w_id[]=$value['w_id'];
			$serial[]=$value['serial'];
			$count[]=$value['countDid'];
			$family[]=$value['family'];
			$name[]=$value['name'];
		}
echo "<br> создали массивы слолбцов";
		// Проходим по столбцу serial и с каждым значением проверяем 
		// столбец w_id. 
		
		foreach ($serial as $i => $s) {
echo "<br> Faaamilyyy";
			$ar[$i]=new Family(); // Создаем экз. объекта Family 

			foreach ($w_id as $n => $w) {
				//По порядку сравниваем значения в w_id друг с другом
				if($w_id[$i]==$w){
				//если есть совпадения, добавляем в массив $ar объект Family
					if($ar[$i]->family==''){
					//если объект Family не инициализирован - инициализируем
						$ar[$i]->setW_id($w_id[$i]);
						$ar[$i]->setSerial($serial[$i]);
						$ar[$i]->setFamily($family[$i]);
						$ar[$i]->setName($name[$i]);
						$ar[$i]->setCount($ar[$i]->getCount()+$count[$n]);
					}else{ // иначе сумируем со значением из количества
						$ar[$i]->setCount($count[$n]);
					}
					echo "ar=".$ar[$i]->getFamily();
				}
			}
		}
echo "<br> Создали Family и ar";
		//echo $ar->getFamily();
		 // foreach ($data as $key => $value) {
		 //   if(!in_array($w_id, $data2)){
			//   $data2=array(
			// 	'w_id'=>$value['w_id'],
			// 	'family'=>$value['family'],
			// 	'name'=>$value['name'],
			// 	'serial'=>$value['serial'],
			// 	'countDid'=$value['countDid']
			// 	 );
			// if($data2['serial']==$value['serial']){

			  
			// }
		 //   }
		 // }

		//var_dump($ar);
		// Получили массив $ar, который состоит из объекта Family,
		// причем каждый объект содержит уникальное сочетание фамилии 
		// и раздела. Это то, что нужно показать в виде.
		// Инициируем массив для вида.
		//$i=0;
		foreach ($ar as $key => $value) {
			$data["List"][$key]=array(
								"w_id"=>$value->getW_id(),
								"family"=>$value->getFamily(),
								"name"=>$value->getName(),
								"serial"=>$value->getSerial(),
								"countDid"=>$value->getCount()
			);
			//$i++;
		}
		echo "<br>создали массив data";
		return $data; 
// $k=$row['name'];
//             $w_id=$row["w_id"];//$$w_id(_11)=
//             //$var=$data['List'][$i]['w_id'].$data['List'][$i]['name'].$data['List'][$i]['serial'];
//             if($w_idArray[$w_id]['w_id']==$w_id AND $w_idArray[$w_id]['w_id']==''){
			  
//               $w_idArray[$w_id['count']]=$row['countDid'];
//               $w_idArray[$w_id['family']]=$row['family'];
//               $w_idArray[$w_id['name']]=$row['name'];
//               $w_idArray[$w_id['serial']]=$row['serial'];
//               //$k['fam']=$w_idArray[$w_id]['family'];
//               //$k['w_id']=$w_id;
//             }else{
//               $w_idArray[$w_id['count']]+=$row["countDid"];
//             }
//             $i++;
//           }
//         }
//          $i=0;
//         foreach ($w_idArray as $key => $value) {
//           if($key == $data['List'][$i]['w_id']){
//             $dt['List'][$i]=array(
//               'family'=>$key['family'],
//               'name'=>$key['name'],
//               'serial'=>$key['serial'],
//               'count'=>$key['count']
//               );
//             // $res[]=new Family($data['List'][$key]['countDid'],
			//                       $data['List'][$key]['family'],
			//                       $data['List'][$key]['name'],
			//                       $data['List'][$key]['serial']
			//                       );
			
	}
	/**
	*   возвращает массив для вывода таблицы выполненной работы за неделю 
	*/
	public function getWeekTable($w_id,$week,$month,$year)
	{ 
		$i=0;
		$sql="SELECT * FROM `ns_results` WHERE `w_id`='$w_id' AND `week`='$week' AND `year`='$year' ORDER BY date DESC";
			   //echo $sql;
	   $result=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
	   
	   while($value=mysql_fetch_array($result,MYSQL_ASSOC)){
		   $res['data'][$i]['r_id']=$value['r_id'];
		   $res['data'][$i]['t_id']=$value['t_id'];
		   $res['data'][$i]['serial']=$value['serial'];
		   $res['data'][$i]['order']=$value['order_name'];
		   $res['data'][$i]['model']=$value['model'];
		   $res['data'][$i]['section']=$value['section'];
		   $res['data'][$i]['operate']=$value['operate'];
		   $res['data'][$i]['countDid']=$value['countDid'];
		   $res['data'][$i]['payment']=$value['w_id_payment'];
		   $res['data'][$i]['time']=$value['operate_time'];
		   $res['data'][$i]['sum']+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
		   $sumTime+=$value['operate_time'];
		   $sumPayment+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
		   $i++;
	   }
			$res['sumTime']=round($sumTime,2);
			$res['sumPayment']=round($sumPayment,2);
		if($result > 0){
			$res['status']=true;
			return $res;
		}else return false; 
		
	}
	 /**
	*   возвращает массив для вывода таблицы выполненной работы за месяц 
	*/
	public function getMonthTable($w_id,$month,$year)
	{ 
		$i=0;
		$sql="SELECT * FROM `ns_results` WHERE `w_id`='$w_id' AND `month`='$month' AND `year`='$year' ORDER BY date DESC";
			   //echo $sql;
	   $result=mysql_query($sql,$this->connDB) or die("Ошибка выполнения: ".$sql." errors: ".mysql_error());
	   
	   while($value=mysql_fetch_array($result,MYSQL_ASSOC)){
		   $res['data'][$i]['r_id']=$value['r_id'];
		   $res['data'][$i]['t_id']=$value['t_id'];
		   $res['data'][$i]['serial']=$value['serial'];
		   $res['data'][$i]['order']=$value['order_name'];
		   $res['data'][$i]['model']=$value['model'];
		   $res['data'][$i]['section']=$value['section'];
		   $res['data'][$i]['operate']=$value['operate'];
		   $res['data'][$i]['countDid']=$value['countDid'];
		   $res['data'][$i]['payment']=$value['w_id_payment'];
		   $res['data'][$i]['time']=$value['operate_time'];
		   $res['data'][$i]['sum']=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
		   $sumTime+=$value['operate_time'];
		   $sumPayment+=$value['w_id_payment']*$value['operate_time']*$value['countDid'];
		   $i++;
	   }
			$res['sumTime']=round($sumTime,2);
			$res['sumPayment']=round($sumPayment,2);
		if($result > 0){
			$res['status']=true;
			return $res;
		}else return false; 
	}
	 /**
	*   Добавляет результаты работы швеи в таблицу 
	*/
	public function getAdd($args)
	{ 
		extract($args);

		$sql="INSERT INTO `ns_results`(`t_id`,`a_id`,`o_id`,`order_name`,`m_id`, `ml_id`, `model`, `sl_id`, `serial`, `section`, `w_id`,`family`,`name`,`w_id_payment`,`operate`,`operate_time`, `date`, `week`, `month`, `year`, `countDid`) 
							 VALUES ('$t_id','$a_id','$o_id','$order','$m_id','$ml_id','$model_name','$sl_id','$serial','$section_name','$w_id','$family','$name','$payment','$descript','$time','$date_now','$week', '$month','$year','$countDid')";
		$res=mysql_query($sql,$this->connDB) or die("Ошибка выполнения Result:getAdd ".$sql." errors: ".mysql_error());
		if($res>0) 
			return true;
		else 
			false;  
	}
	/**
	*   возвращает зарплату работника за месяц и год
	*/
	public function getPayment($w_id,$month,$year)
	{
		//echo "<br> Теперь добываем зарплату для $w_id,$month,$year";
		foreach ($this->results as $key => $value) {
			if(($value['w_id']==$w_id) && ($value['month']==$month) && ($value['year']==$year)){
			   $payment+=$value['operate_time']*$value['w_id_payment']*$value['countDid'];
			}        
		}
		
		return $payment;
	}


}