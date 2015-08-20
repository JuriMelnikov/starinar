<!DOCTYPE html>
<html>
 <head>
   <title>ЗАРАБОТНАЯ ПЛАТА</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="style/reset.css">
   <link rel="stylesheet" type="text/css" href="style/bstyle.css">
	<script type="text/javascript" src="./json2/json2.js"></script>
	<script type="text/javascript" src="./jquery/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="js/buch.js"></script>
		
 </head>
 
<body onload="loginCheck();">
<input type="button" id="btnLogout" value="Выйти" onclick="logout();">
<div id="loginWindow">
<div id="delay_txt">
<h3>Пожалуйста, введите логин и пароль!</h3>
</div><br>
	Логин:<br>
	<input type="text" id="login"><br>
	Пароль:<br>
	<input type="password" id="pass" onkeydown="if(event.keyCode==13){clickLoginButton()}"><br><br>
	<input type="button" id="btnLogin" value="Авторизоваться" onClick="clickLoginButton()">

</div> 
<div id="bgOverlay"></div>
 <div id="bPosition">
 <div id="titl">ЗАРАБОТНАЯ ПЛАТА<br>первый участок<br>
 <a href="worker.php" id="back"><<</a>
 <a href="#" id="toPrint" onClick="printIt()">(распечатать)</a></div>
	<div id="selectors">
		<div id="txtAppointment" >ПРОФЕССИЯ</div>
		<div id="txtFamily">ФАМИЛИЯ ИМЯ</div>
		<div id="txtMonth">МЕСЯЦ</div>
		<div id="txtYear">ГОД</div>
			<br>
		<select id="selAppointment" onChange="setSelected();"></select>
		<select id="selFamily"  onChange="loadPalk(this.value);"></select>
		<select id="selMonth" onChange="selMonth()"></select>
		<select id="selYear" onChange="selYear()"></select>		
	</div>
	<div id="divTable"></div>
	<div id="note"></div>
 </div>

</body>
</html>