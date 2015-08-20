<!DOCTYPE html>
<html>
 <head>
   <title>ОРДЕРА</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="style/reset.css">
   <link rel="stylesheet" type="text/css" href="style/astyle.css">
	<script type="text/javascript" src="./json2/json2.js"></script>
	<script type="text/javascript" src="./jquery/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<script type="text/javascript" src="js/orders.js"></script>
 </head>
<body onload="loginCheck();">
 <input type="button" id="btnLogout" value="Выйти" onclick="logout();">
<div id="account">
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
<div id="bgOverlay"></div>

 <div id="aposition">
 <a href="techmap.php" id="nextPage">>></a>
 <a href="seamstress.php" id="back"><<</a>
 <div id="title">ОРДЕРА<br>(первый участок)</div>	
<div id="divCalendar"></div>

 <div id="top">
	<div id="date"> 
	
		<div id="UweekMonthYear" >
			<select id="UselWeek" ></select>
			<select id="UselMonth" ></select>
			<select id="UselYear" ></select>
		</div>
		<div id="txtUpdateDate">ИЗМЕНЕНИЕ</div>		
		<div id="txtWeek">НЕДЕЛЯ</div>
		<div id="txtMonth">МЕСЯЦ</div>
		<div id="txtYear">ГОД</div>
		<div id="weekMonthYear" >
			<select id="selWeek"  onChange="loadOrders();"></select>
			<select id="selMonth"  onChange="loadOrders();"></select>
			<select id="selYear" onChange="loadOrders();"></select>
		</div>
	</div>	
</div>
	<div id="elements">
		<div id="divCheck">
			<div id="textCheck">ПРОВЕРКА</div>
			<input type="checkbox" id="check" onChange="check(this.value)">
		</div>
	<div id="divTxtOrder">ОРДЕР</div>
		<input type="text" id="aOrder">
	
		<div id="txtModel">МОДЕЛЬ - КОЛИЧЕСТВО</div>
			
		<div id="models"></div>
		
	
		<select id="countInputs" onChange="countInputs(this.value)">
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
			<option value="6">6</option>
			<option value="7">7</option>
			<option value="8">8</option>
			<option value="9">9</option>
			<option value="10">10</option>
		</select>
		<input type="button" id="plus" value="+" onClick="addInput()" >
		<input type="button" id="minus" value="-" onClick="removeInput()" >
		
	</div>
	<div id="raport"></div>
	<div id="right">
		
		<input type="button" id="abtnAdd"  value="ДОБАВИТЬ" onClick="aAddClick()" >
		<input type="button" id="abtnDubl"  value="ДУБЛЬ" onClick="aDublClick()" >
		<input type="button" id="abtnChange"  value="ИЗМЕНИТЬ" onClick="aUpdateClick()" >
		<input type="button" id="abtnDeleteOrder" value="УДАЛИТЬ"  onClick="aDeleteClick()" >
		<input type="button" id="abtnCanselChange" value="ОТМЕНИТЬ"  onClick="aCanselClick()" >
		<div id="table_div">
		
		</div>
	</div>
	


	<div id="note"></div>
 </div>
<input type="hidden" id="valueSelectOrderId" />
<input type="hidden" id="valueSelectOrder" />
</body>
</html>