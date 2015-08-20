<?php
echo "hello";
function autoload($className) {
    set_include_path('./Classes/');
    spl_autoload($className); //replaces include/require
}
spl_autoload_extensions('.php');
spl_autoload_register('autoload');
echo "<br>Будем подключаться";
$access=new ToBase();
echo "Подключились к ToBase";
// $sql="SELECT `mName` FROM `ns_model_list` WHERE `ml_id`=88";
//         $res=mysql_query($sql,$access->getConnDB());
//         while($row=mysql_fetch_array($res,MYSQL_ASSOC)){
//             echo "<br>".$row['mName'];
//         }
$year=2015;
$month=8;
$week=34;
$models[0]='Модель H258-1;';
$models[1]='Модель H258-2;';
$sl_id=56;
$counts[0]=2;
$counts[1]=2;
$order='222';
$o_id=179;
// $r=new Result($access->getConnDB());
// $arg=compact('sl_id','week','month','year','o_id','ml_id');
// $data=$r->checkOrder($arg);
// var_dump($data);

//                     $str='<table id="tblR">';
//                     $str.='<tbody id="tblRBody">';
//                     $str.='<tr>';
//                     $str.='<th id="tblRBodyF">Фамилия, Имя</th>';
//                     $str.='<th id="tblRBodyS">№</th>';
//                     $str.='<th id="tblRBodyC">Количе-<br>ство</th>';
//                     $str.='</tr>';
//                     for( $i=0;$i< count($data["List"]);$i++){
//                         $str.='<tr>';
//                         $str.='<td class="tdRF">'.$data["List"][$i]["family"].' '.$data["List"][$i]["name"].'</td>';
//                         $str.='<td class="tdRS">'.$data["List"][$i]["serial"].'</td>';
//                         $str.='<td class="tdRС">'.$data["List"][$i]["countDid"].'</td>';
//                         $str.='</tr>';
//                     }
//                     $str.='</tbody>';
//                     $str.='</table>';
//          echo $str;
//$m=new Models($access->getConnDB());
// echo "<br> addMod:Надо создать OrderTime";

// $ot=new OrderTime($access->getConnDB());

// echo "<br> addMod:создали OrderTime";
// $vars=compact('order','month','week','year','models','counts');
// $ot->addOrder($vars);
// echo"<br>addMod:Загрузили ордер";
// echo "<br>Создаем Orders";
// $o=new Orders($access->getConnDB());
// echo "<br>Теперь добудем o_id";
//     if(!$o_id=$o->getIdOrder($order)){
//         echo "<br> добавим";
//         $o->addOrder($order);
//         $o_id=$o->getLastId();
//     }
// // echo "<br>o_id=$o_id";
// echo "<br>Создаем OrderTime";
// $ot=new OrderTime($access->getConnDB());
//     if($ot->existsOrder($o_id)){
//         echo "<br>o_id есть, можно запускать дубл";
//         //insertDubl($o_id,$month,$week,$year);
//         //exit;
//     }
//     echo "<br>o_id нет, добавляем";

//     if(!$last_a_id=$ot->addOrder($o_id,$month,$week,$year)){
//         echo "Не могу добавить ордер.";
//         exit;
//     }
//     echo "<br>Добавили ордер с id = $last_a_id";
//     for($i=0;$i < count($ml_id);$i++){
//         $m=new Models($access->getConnDB());
//             if(!$last_m_id=$m->addModel($last_a_id,$ml_id[$i])){
//                 echo "Не могу добавить модель.";
//                 exit;
//             }

//         $c=new Counts($access->getConnDB());
//             if(!$c->addCounts($last_a_id,$last_m_id,$count[$i])){
//                 echo "Не могу добавить количество моделей.";
//                 exit;
//             }
//     }
//     echo "<br> Выберем ордер с номером $a_id";
//     echo "<br>Название ордера = ";
//     echo $ord=$o->getOrderName($a_id);

