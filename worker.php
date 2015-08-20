<?php
//print_r($_REQUEST);
//define('L','L4');
//include("access.php");
?>
<!DOCTYPE html>
<html>
 <head>
   <title>РАБОТНИКИ</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="style/reset.css">
   <link rel="stylesheet" type="text/css" href="style/wstyle.css">
	<script type="text/javascript" src="./json2/json2.js"></script>
	<script type="text/javascript" src="./jquery/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="js/worker.js"></script>
 </head>
 <body onload="loginCheck()">
 <input type="button" id="btnLogout" value="Выйти" onclick="logout();">
<div id="loginWindow">
<div id="delay_txt">
<h3>Начать авторизацию можно через <span id="sec"></span>&nbsp;секунд.</h3>
</div>
<br>
	Логин:<br>
	<input type="text" id="login"><br>
	Пароль:<br>
	<input type="password" id="pass" onkeydown="if(event.keyCode==13){clickLoginButton()}"><br><br>
	<input type="button" id="btnLogin" value="Авторизоваться" onClick="clickLoginButton()">
	
</div> 
<div id="account"><br>
	Логин:<br>
	<input type="text" id="newLogin"><br>
	Пароль:<br>
	<input type="password" id="newPass"><br><br>
	<input type="button" id="record" value="Назначить" onClick="insertAccountWindow()">
	<input type="button" id="delete" value="Удалить" onClick="deleteAccountWindow()">
	<input type="button" id="cansel" value="Отменить" onClick="closeAccountWindow()">
</div>
<div id="delWorker">
  <div id="mod_txtW"></div>
    <input type="button" id="yesW" value="Да" onClick="closeDelWorker(true)" >
	<input type="button" id="noW" value="Нет" onClick="closeDelWorker(false)">
	
</div>

<div id="delAppointment">
  <div id="mod_txtA"></div>
    <input type="button" id="yesA" value="Да" onClick="closeDelAppointment(true)" >
	<input type="button" id="noA" value="Нет" onClick="closeDelAppointment(false)">
	
</div>
<div id="bgOverlay"></div>

<input type="hidden" id="level">
 <div id="tposition">
 <div id="title">РАБОТНИКИ<br>(первый участок)</div>
 <div id="note"></div>
 <a href="techmap.php" id="back"><<</a>
 <a href="buch.php" id="buch">>></a>
 
 <a id="help2" class="tooltip" href="#"></a>
 <span id="spanFamily">Фамилия:</span><span id="spanName">Имя:</span>
 <span id="spanL1">"Результаты работы" (швеи)</span>
 <span id="spanL2">"Заработная плата" (бухгалтер)</span>
 <span id="spanL3">"Ордера" (технолог)</span>
 <span id="spanL4">"Модели и операции"</span>
 <span id="spanL5">"Работники"</span>
 <span id="spanKood">Личный код:</span>
 <span id="spanAppointment">Должность:</span>
 <span id="spanTelefon">Телефон:</span> 
 <span id="spanBankCount">Номер счета:</span>
 <span id="spanCity">Город:</span>
 <span id="spanAdress">Адрес:</span>
 <span id="spanPayment">Расценка:</span>
 <span id="spanWorkersList">Работники:</span>
 <span id="spanDayStop">День "Стоп" до:</span>
 <input type="hidden" id="w_id" >
 
 <input type="text" id="family">
 <input type="text" id="name">
 <input type="checkbox" id="L1">
 <input type="checkbox" id="L2">
 <input type="checkbox" id="L3">
 <input type="checkbox" id="L4">
 <input type="checkbox" id="L5">
 <input type="text" id="kood" maxlength="11"  onBlur="idCorrect(this.value)"> 
 <input type="hidden" id="ListOrNew" value="List">
 <input type="text" id="newAppointment">
 <select id="selectAppointment"></select>
 <input type="text" id="telefon">
 <input type="text" id="bankCount">
 <input type="text" id="city">
 <input type="text" id="adress">
 <input type="text" id="payment">
 <input type="button" value="Фильтр >>" id="btnFiltr" onClick="btnSetFiltr()" >
 <select id="selectWorkersList" onChange="selectWorkersListClick(this.value)"></select>
 <input type="button" value="Добавить" id="btnAdd" onClick="btnAddClick()">
 <input type="button" value="Изменить" id="btnUpdate" onClick="btnUpdateClick()">
 <input type="button" value="Удалить" id="btnDelete" onClick="delWorker()">
 <input type="button" value="Удалить должность" id="btnDelAppointment" onClick="delAppointment()">
 <div id="divNewAppointment" onClick="addAppointClick()"><< НОВАЯ</div>
 <div id="divSelectAppointment" onClick="changeAppointClick()">>> СПИСОК</div>
<input type="button" value="Доступ работнику" id="btnWorker" onClick="openAccountWindow()">
<select id="dayStop" onChange="SetDayStop()"></select>

<span id="note"></span>
 </div>
 
</body>
</html>