<!DOCTYPE html>
<html>
 <head>
   <title>МОДЕЛИ И ОПЕРАЦИИ</title>
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
   <link rel="stylesheet" type="text/css" href="style/reset.css">
   <link rel="stylesheet" type="text/css" href="style/tstyle.css">
    <!-- // <script type="text/javascript" src="http://scriptjava.net/source/scriptjava/scriptjava.js"></script> -->
	<script type="text/javascript" src="./json2/json2.js"></script>
	<script type="text/javascript" src="./jquery/js/jquery-1.7.2.min.js"></script>
    <script type="text/javascript" src="./jquery/js/jquery-ui-1.8.21.custom.min.js"></script>
	<!-- // <script type="text/javascript" src="js/ajaxupload.min.js"></script> -->
    <!-- // <script type="text/javascript" src="js/techmap-ajax.js"></script> -->
	<script type="text/javascript" src="js/techmap.js"></script>
 </head>
 <body onload="loginCheck()">
  <input type="button" id="btnLogout" value="Выйти" onclick="logout();">
<div id="account">
<div id="delay_txt">
<h3>Начать авторизацию можно через <span id="sec"></span>&nbsp;секунд.</h3>
</div><br>
	Логин:<br>
	<input type="text" id="login"><br>
	Пароль:<br>
	<input type="password" id="pass" onkeydown="if(event.keyCode==13){clickLoginButton()}"><br><br>
	<input type="button" id="btnLogin" value="Авторизоваться" onClick="clickLoginButton()">
	
</div> 
  <div id="modalWindow">
  <div id="mod_txt"></div>
    <input type="button" id="yes" value="Да" onClick="closeModalWindow(true)" >
	<input type="button" id="no" value="Нет" onClick="closeModalWindow(false)">
	<input type="hidden" id="whatDel">
</div>
<div id="bgOverlay"></div>

 
 <div id="tposition">
	<div id="title">МОДЕЛИ И ОПЕРАЦИИ<br>(первый участок)</div>
	 <div id="note1"></div>
	 <a href="orders.php" id="back"><<</a>
	 <a href="worker.php" id="forward">>></a>
	 <span id="spanModel">Модель:</span>
	 <span id="newSpanModel">Новая модель:</span>
	 <span id="spanSection">Раздел:</span>
	 <span id="spanNewSection">Новый раздел:</span>
	 <span id="spanN">Номер операции:</span>
	 <span id="spanDescript">Описание:</span>
	 <span id="spanTime">Норма времени:</span>
	 <div id="showNewModel" onClick="showSelModel()"><< ДОБАВИТЬ</div>
	 <div id="delModel" onClick="openModalWindow('2')">УДАЛИТЬ</div>
	 <div id="showSelModel" onClick="showNewModel()">>> СПИСОК</div>
	 <input type="hidden" id="t_id">
	 <input type="hidden" id="selectSectionIndex">
	 <input type="hidden" id="selectModelIndex">
	 <input type="hidden" id="yesNewModel" value="0" >
	 <!-- Модель и раздел -->
	 <input type="text" id="newModel">
	 <select id="selModel" onChange="selectModel()"></select>
	 <select id="selSection" onChange="selectSection()"></select>
	 <input type="text" id="newSection" >
	 <input type="text" id="serial">
	 <!-- Модель и раздел -->
	 <!-- Загрузка файла -->
	 <div id="upload_file">
	 <form enctype="multipart/form-data"  
		 action="upload.php" method="post" id="form1" name="_form1">
		 <table>
		 <tr>
		 <td><input type="hidden" name="MAX_FILE_SIZE" value="20000000">
		 <input type="file" name="file"></td>
		 <td><input type="submit" name="upload" value="Загрузить"></td>
		 </tr>
		 </table>
	 </form>
	 </div>
	 <!-- end Загрузка файла -->
	 <textarea id="descript"></textarea>
	 <input type="text" id="time" onBlur="this.value=onliNumer(this.value)">

	 
	 <input type="button" value="Добавить" id="btnAdd" onClick="btnAddClick()" >
	 <input type="button" value="Изменить" id="btnUpdate" onClick="btnUpdateClick()" >
	 <input type="button" value="Удалить" id="btnDelete" onClick="openModalWindow('1')" >
	 <input type="hidden" id="yesNewSection" value="0" >
	 <div id="showInputNewSection" onClick="showInputNewSection()"><< ДОБАВИТЬ</div>
	 <div id="showSelSection" onClick="showSelSection()">>> СПИСОК</div>
	 <div id="divDelSelectSection" onClick="openModalWindow('3')">УДАЛИТЬ</div>
	 <span id="go"><span>
	<!-- <select id="tList" size=15 onChange=listClick() > </select>
	-->

 </div>
 <div id="spanTable">
 
 </div>
 
</body>
</html>
