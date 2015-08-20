<!DOCTYPE html>
<html>
 <head>
   <title>ШВЕИ</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="style/sstyle.css">
	<script type="text/javascript" src="./json2/json2.js"></script>
	<script type="text/javascript" src="./jquery/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="js/seamstress.js"></script>	
 </head>
 <body onload="loginCheck()">

 <input type="button" id="btnLogout" value="Выйти" onclick="logout();">
<div id="account">
<div id="delay_txt">
<h3>Пожалуйста, введите логин и пароль!</h3>
</div>
<br>
	Логин:<br>
	<input type="text" id="login" tabindex="1"><br>
	Пароль:<br>
	<input type="password" id="pass" tabindex="2" onkeydown="if(event.keyCode==13){clickLoginButton()}"><br><br>
	<input type="button" tabindex="3" id="btnLogin" value="Авторизоваться" onblur="document.getElementById('login').focus;" onClick="clickLoginButton()">
	
	
</div>
<div id="bgOverlay"></div>
 <div id="sPosition">
 <div id="title">РЕЗУЛЬТАТЫ РАБОТЫ<br>(первый участок)</div>
 <div id="note" ></div>
	<div id="top">
		<span id="txtShow1">Неделя </span><input type="radio" id="radioPeriod1" name="period" checked value="week" onClick="checkWeek()">
		<span id="txtShow2">Месяц </span><input type="radio" id="radioPeriod2" name="period" value="toMonth" onClick="checkMonth()">
		<select id="toMonth" onChange="changeDate(document.getElementById('w_id').value);"></select>
		<select id="sWeek" onChange="changeDate(document.getElementById('w_id').value);"></select>
		<select id="sYear" onChange="changeDate(document.getElementById('w_id').value);"></select>
		
		<input type="hidden" id="w_id" >
	</div>
	 <div id="elements">
		<div id="divCalendar"></div>
		<a href="orders.php" id="back">>></a>
		<div id="sNameFamily">Имя Фамилия: </div>
		<select id=sSelectNameFamily onChange="selectFamily(this.value,-1);"></select>
		<input type="text" id=sInputNameFamily>
		<div id="stxtOrder">Ордер:</div> 
		<select id="sOrder" onChange="selectOrder(this.value)"></select>
		<input type="hidden" id="selOrd" value="-1">
		<div id="stxtModel">Модель:</div>
		<select id="sModel" onChange="selectModel(this.value)"></select>
		<input type="hidden" id="selMod" ><input type="hidden" id="m_id" >
		<div id="stxtSection">Раздел:</div>
		<select id="sSection" onChange="selectSection(this.value)"></select>
		<input type="hidden" id="selSect" >
		<div id="stxtOperate">№ операции:</div>
		<select id="sOperate" onChange="selectOperate(this.value)" ></select>
		<input type="hidden" id="selOper" >
		<div id="stxtCount">Количество изделий:</div>
		<select id="sCount"></select><br>
		
		<input type="button" id="sAdd"  value="Добавить" onClick="btnAdd()">



	
	</div>
		
	<!--
		<input type="submit" id="sEditCount" value="Редактировать количество">
		<input type="submit" id="sDeleteOrder" value="Удалить ордер">
	-->
	<div id="sRaportOperate"></div>
		<div id="divTable"></div>

 </div>

</body>
</html>