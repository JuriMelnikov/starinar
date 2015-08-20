<?php
phpinfo(); 
// function autoload($className) {
//     set_include_path('./Classes/');
//     spl_autoload($className); //replaces include/require
// }
// spl_autoload_extensions('.php');
// spl_autoload_register('autoload');
// $access=new ToBase();
// echo "<br>подключились к базе";
//     // $access=new toBase();
//     // if(!$access->accessYes($idPage)){
//     //     $toJS['login']=false;
//     //     echo json_encode($toJS);
//     //     exit;
//     // }
//     // $toJS['login']=true;

//      $date_now=date("Y-m-d H:i:s");
//     $res=new Result2($access->getConnDB());
//     $toJS=$res->getMonthTable('13','5','2015');
//     echo "запуск ";
//     print_r($toJS);
//         // $toJS["data"][$i]=array(
//         //  "r_id"=>$res->getWeekTable["r_id"],
//         //  "serial"=>$res->getWeekTable["serial"],
//         //  "order"=>$res->getWeekTable["order"],
//         //  "model"=>$res->getWeekTable["mName"],
//         //  "section"=>$res->getWeekTable["lSection"],
//         //  "operate"=>$res->getWeekTable["descript"],
//         //  "count"=>$res->getWeekTable["countDid"],
//         //  "payment"=>$res->getWeekTable["payment"],
//         //  "time"=>$res->getWeekTable["time"]*$row["countDid"],
//         //  "sum"=>$res->getWeekTable["payment"]*$res->getWeekTable["countDid"]*$res->getWeekTable["time"]
//         //  );


//     // $data = json_decode($_REQUEST["data"]);// принимаем POST-данные и декодируем их
//     // $t_id=(int)$data->t_id; //id операции
//     // $sl_id=(int)$data->sl_id;//id секции
//     // $a_id=(int)$data->a_id;//id ордера
//     // $m_id=(int)$data->m_id;//id модели
//     // $w_id=(int)$data->w_id;// id работника
//     // $week=(int)$data->week;
//     // $month=(int)$data->month;
//     // $year=(int)$data->year;
//     // $countDid=(int)$data->countDid; //сколько выполненно выбранной операции

//     // $query="SELECT `dayStop` FROM `ns_filters` WHERE `f_id`=1";
//     // $result=$access->resQuery($query);
//     // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//     // $dayStop=$row["dayStop"];
//     // // Если хотя бы одна переменная не инициализирована, то 
//     // // посылаем скрипту день стоп из базы
//     // // и статус = 0
//     // if(0==$t_id || 0==$sl_id || 0==$a_id || 0==$m_id || 
//     //     0==$w_id || 0==$week || 0==$month || 0==$year || 
//     //     0==$countDid){
//     //     $toJS['dayStop']=$dayStop;
//     //     $toJS["status"]=0;
//     //     echo json_encode($toJS);
//     //     exit;
//     // }

//     // /**
//     // * проверка на количесвто добавленных операций
//     // * написать запрос где считается все countDid для sl_id,m_id,o_id
//     // **/

//     // // $query="SELECT `o_id` FROM `ns_admin` WHERE `a_id`='$a_id'";
//     // // $result=$access->resQuery($query);
//     // // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//     // // $o_id=$row["o_id"];
//     // $o_id=$a_id;
//     // $a_id=(int)110;
//     // $o_id=(int)110;
//     // $year=(int)2015;
//     // $month=(int)8;
//     // $week=(int)32;
//     // $w_id=(int)42;
//     // $m_id=(int)679;
//     // $ml_id=(int)50;
//     // $t_id=(int)2499;
//     // $sl_id=(int)8;
//     // $query="SELECT `count` FROM `ns_counts` WHERE `a_id`='$a_id' AND `m_id`='$m_id'";
//     // $result=$access->resQuery($query);
//     // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//     // $count=$row["count"];

//     // $query="SELECT SUM(countDid) AS sumCountDid FROM `ns_results1` WHERE `a_id`='$o_id' AND `t_id`='$t_id'";
//     // $result=$access->resQuery($query);
//     // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//     // $sumCountDid=$row["sumCountDid"];

//     // if($count < $sumCountDid){
//     //     $toJS['addYes']="No";
//     //     exit;
//     // }else{ 
//     //     $toJS['addYes']="Yes";
//     // }
//     //$toJS['addYes']=$count<$row["sumCountDid"];
//    //  $cMonth=date("n");
    
//    // $cYear=date("Y");$cDay=date("j");
  

//   // if(!(($cMonth==$month && $year==$cYear) || 
//   //       ($cMonth==1 && $month==12 && $year<$cYear && $dayStop>$cDay) ||
//   //       ($cMonth>1 && $month<=$cMonth && $month>=$cMonth-1 &&
//   //        $year<=$cYear && $dayStop>$cDay)))
//   //   {//(Если текущий месяц и год не совпадают с выбранными)
//         // || (текущий месяц январь и выбранный месяц декабрь 
//         //и выбранный год < текущего и день Стоп > текущего дня)
//         // || (текущий месяц февраль и больше и выбранный год текущий или прошлый  
//         //и день Стоп больше сегодня
//         // Добавление невозможно
//     //     $toJS['test']="(($cMonth=$month && $year==$cYear && $dayStop>$cDay) || 
//     //     ($cMonth==1 && $month==12 && $year<$cYear && $dayStop>$cDay) ||
//     //     ($cMonth>1 && $month<=$cMonth && $month>=$cMonth-1 && $year<=$cYear && $dayStop>$cDay))";
                        
//     //     $toJS['dayStop']=false;
//     //     $toJS["status"]=0;
//     //     echo json_encode($toJS);
//     //     exit;
//     // }else{//иначе можно швеи добавить свою работу
//     //     $toJS['dayStop']=true;
//         //надо найти t_id - идентификатор по $serial и $newSection
//         // $query="SELECT o_id FROM ns_admin WHERE a_id='$a_id'";
//         // $result=$access->resQuery($query);
//         // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//         // $o_id=$row['o_id'];
//         // $o_id=$a_id;
//         // // $query="SELECT ml_id FROM ns_models WHERE m_id='$m_id'";
//         // // $result=$access->resQuery($query);
//         // // $row=mysql_fetch_array($result,MYSQL_ASSOC);
//         // // $ml_id=$row['ml_id'];

//         // $m=new Models($access->getConnDB());
//         // echo "<br>создаем экз. класса Models";
//         // //echo "<br>ml_id=";
//         // $ml_id=$m->getMlId($m_id);
//         // echo "<br>model=";
//         // $model=$m->getNameModel($m_id);
//         // echo "<br>model=$model";
        
//         // $o=new Orders($access->getConnDB());
//         // echo "<br>Создаем экз. класса Orders";
//         // $order_name=$o->getOrderName($o_id);
//         // echo "<br>order_name = $order_name";
        
//         // $sl=new SectionsList($access->getConnDB());
//         // $section=$sl->getNameSection($sl_id);
//         // echo "<br>section=$section";

//         // $w=new Workers($access->getConnDB());
//         // $family=$w->getFamily($w_id);
//         // $name=$w->getName($w_id);
//         // $w_id_payment=$w->getPayment($w_id);
//         // echo "<br>family=$family<br>name=$name<br>w_id_payment=$w_id_payment";

//         // $t=new Techmap($access->getConnDB());
//         // $operateTime=$t->getTime($t_id);
//         // echo "<br>operate_time=$operateTime";

//         // $query="INSERT INTO `ns_results1`(
//         //     `t_id`, 
//         //     `a_id`,
//         //     `order_name`,
//         //     `m_id`, 
//         //     `model`, 
//         //     `section`, 
//         //     `w_id`,
//         //     `family`,
//         //     `name`,
//         //     `w_id_payment`,
//         //     `operate_time`, 
//         //     `date`, `week`, `month`, `year`, `countDid`) 
//         // VALUES ('$t_id','$a_id','$order_name',
//         //     '$m_id','$model','$section','$w_id',
//         //     '$family','$name','$w_id_payment','$operateTime',
//         //     '$date_now','$week','$month','$year','2')";
        
//         // $result=$access->resQuery($query);
//         // echo "<br>Запускаем getPayment с параметрами w_id=$w_id month=$month year=$year";
//         // echo "<br>Создаем экз. класса Result1";
//         // $res=new Result1($access->getConnDB());
//         // $payment=$res->getPayment($w_id,$month,$year);
//         // echo "<br>Зарплата = ".$payment;
//         // echo "<br>Время работы = ".$payment['time'];        
//         // echo "<br>".$name." ".$family;
//     // }


