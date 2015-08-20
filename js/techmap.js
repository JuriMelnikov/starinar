$('#_upload').click(function() {
	location('upload.php')
})
function onliNumer(num){
num = num.toString().replace(/\,/g, '.');//замена запятой на точку
if (isNaN(num)) num = "0.000";// определяем переменную 
for(var i=0;i<num.length-1;i++){
	if(num[i]=='.'){
		num=Number(num);
		return num.toFixed(3);
	}
}
return(num);
}
//создание объекта XMLHttpRequest
function ajaxConnect() {
  var xmlhttp;
if ( window.XMLHttpRequest ) {
  // Для современных браузеров IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp = new XMLHttpRequest();
} else {
  // Для старых браузеров IE6, IE5
  xmlhttp = new ActiveXObject ( "Microsoft.XMLHTTP" );
}
    return xmlhttp;
}

function logout(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange = function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
			//alert("logout.fromPHPs="+fromPHPs);
			try{
				location.reload();
			}catch(e){
				alert("logout: "+fromPHPs+" : "+e);
			}
		
		}
	};
	xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=8",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}
var setIntervalID=0;
var delay=5;
function display(){
	if(delay>1){
		delay--;
		document.getElementById("sec").innerHTML=delay;
		
	}else{
	delay=5;
		document.getElementById("login").value="";
		document.getElementById("pass").value="";
		document.getElementById("btnLogin").disabled=false;
		document.getElementById("delay_txt").innerHTML="<h3>Пожалуйста, введите логин и пароль!</h3>";
		document.getElementById("login").focus();
		//if(setIntervalID!="undefined")
		clearInterval(setIntervalID);
	}
}

function loginCheck(){
	//alert("111");
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		//alert('000');
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
//alert("loginCheck.fromPHPs=".fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){
				//document.getElementById("delay_txt").innerHTML='<h3>Начать авторизацию можно через <span id="sec"></span>&nbsp;секунд.</h3>';
					//setIntervalID=setInterval('display()',1000);
					
					showLoginWindow(fromPHPobj["count"]);
		//alert("loginCheck="+fromPHPobj["loginCheck"]);
				}else{
		//alert("loginCheck="+fromPHPobj["loginCheck"]);
					closeLoginWindow();
					second=0;
					clearInterval(setIntervalID);
					loadSectionList();
				}
			}catch(e){
				alert("loginCheck: "+e);
			}
		
		}
	};
	xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=0",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
	//alert("222");
}	
function showLoginWindow($count){
   // Отображаем и центрируем окно
    var loginWindow = $('#account');
    loginWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - loginWindow.outerWidth()  ) / 2,
        top:   300,
        'z-index': '100'
    });
    loginWindow.show();
	document.getElementById("login").focus();
    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay"></div>';
	
	document.getElementById("delay_txt").innerHTML="<h3>Пожалуйста, введите логин и пароль!</h3>";
	if($count>0){
	document.getElementById("btnLogin").disabled=true;
	document.getElementById("delay_txt").innerHTML='<H3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</H3>';
		clearInterval(setIntervalID);
		setIntervalID=setInterval('display()',1000);
	}else document.getElementById("btnLogin").disabled=false;
}
// Закрытие окна
function closeLoginWindow(){
document.getElementById("login").value='';
document.getElementById("pass").value='';
	 // Отключаем окно
    $('#account').hide();
    // Выключаем задник
	if(document.getElementById("bgOverlay").style.display="block"){
    	$('#bgOverlay').empty();
	}
	clearInterval(setIntervalID);
	
} 
function clickLoginButton(){
if(delay>0 && delay<5) {
	exit;
}
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
	//alert("clickLoginButton.fromPHPs=".fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){
					loginCheck();
					document.getElementById("delay_txt").innerHTML='<h3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</h3>';
					second=1;
					clearInterval(setIntervalID);
					setIntervalID=setInterval('display()',1000);
				}else{
					loginCheck();
				}
			}catch(e){
				alert("clickLoginButton: "+e);
			}
		}
	}
	
	data={};
	data.login=document.getElementById("login").value;
	data.pass=document.getElementById("pass").value;
//alert(data.login+" "+data.pass);
	if(data.login!='' && data.pass!=''){
		document.getElementById("btnLogin").disabled=true;
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=0",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}
// Открытие модального окна
function openModalWindow(s){
    // Отображаем и центрируем окно
    var modalWindow = $('#modalWindow');
    modalWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - modalWindow.outerWidth()  ) / 2,
        top:  ( $(document).height() - modalWindow.outerHeight() ) / 2,
        'z-index': '100'
    });
	
	var arg=s;
	switch (arg){
		case "1":document.getElementById("mod_txt").innerHTML="Из базы будет удалена операция!<br>Продолжить?";
							document.getElementById("whatDel").value=arg;
							break;
		case "2":document.getElementById("mod_txt").innerHTML="Из базы будет удалена выбранная модель!<br>Продолжить?";
							document.getElementById("whatDel").value=arg;
							break;
		case "3":document.getElementById("mod_txt").innerHTML="Из базы будет удален выбранный раздел!<br>Продолжить?";
							document.getElementById("whatDel").value=arg;
							break;
	}
    modalWindow.show();
	

    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay1"></div>';
}
// Закрытие окна
function closeModalWindow(bool){
var s=document.getElementById("whatDel").value;
if(bool){
switch (s){
		case "1":	{btnDeleteClick();
					document.getElementById("whatDel").value="";
					break;}
		case "2":	{delSelModel();
					document.getElementById("whatDel").value="";
					break;}
		case "3":	{delSelSection();
					document.getElementById("whatDel").value="";
					break;}
	}
	}
    // Отключаем окно
    $('#modalWindow').hide();

    // Выключаем задник
	if(document.getElementById("bgOverlay").style.display="block"){
    	$('#bgOverlay').empty();
	}
	
}
//Показываем редактор добавления нового раздела и прячем селект выбора раздела "ДОБИВИТЬ"
function showInputNewSection(){
document.getElementById("showInputNewSection").style.display="none";
document.getElementById("showSelSection").style.display="block";
document.getElementById("newSection").style.display="block";
document.getElementById("selSection").style.display="none";
document.getElementById("spanNewSection").style.display="block";
document.getElementById("spanSection").style.display="none";
document.getElementById("yesNewSection").value=1;
document.getElementById("newSection").value="";
//alert(document.getElementById("yesNewSection").value);
}
//Показываем селект выбора раздела и прячем редактор добавления нового раздела "СПИСОК"
function showSelSection(){
document.getElementById("showInputNewSection").style.display="block";
document.getElementById("showSelSection").style.display="none";
document.getElementById("spanNewSection").style.display="none";
document.getElementById("spanSection").style.display="block";
document.getElementById("newSection").style.display="none";
document.getElementById("selSection").style.display="block";
document.getElementById("yesNewSection").value=0;
//alert(document.getElementById("yesNewSection").value);
}
//показываем редактор для добавления навой модели и убираем селектор
function showSelModel(){
	document.getElementById("newSpanModel").style.display="block";
	document.getElementById("spanModel").style.display="none";
	document.getElementById("showNewModel").style.display="none";
	document.getElementById("showSelModel").style.display="block";
	document.getElementById("selModel").style.display="none";//селектор
	document.getElementById("newModel").style.display="block";//редактор
	document.getElementById("yesNewModel").value='1';//new
	document.getElementById("newModel").value="";
//alert(document.getElementById("yesNewModel").value);
}
//убираем редактор и показываем селектор(нажатие на ДОБАВИТЬ 
function showNewModel(){
	document.getElementById("newSpanModel").style.display="none";
	document.getElementById("spanModel").style.display="block";
	document.getElementById("showNewModel").style.display="block";
	document.getElementById("showSelModel").style.display="none";
	
	document.getElementById("selModel").style.display="block";//селектор
	document.getElementById("newModel").style.display="none";//редактор
	document.getElementById("yesNewModel").value='0';//"sel"
	//document.getElementById("newModel").value="";
//alert(document.getElementById("yesNewModel").value);
}


///////////////////////////////////////////////////

//выбор модели
function selectModel(){
document.getElementById("selectModelIndex").value=document.getElementById("selModel").selectedIndex;
document.getElementById("note1").innerHTML="";
selectSection();
}
//исполняется при загрузке страницы
//загружается список разделов и список моделей
function loadSectionList(){

var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		
		var fromPHPs=xmlhttp.responseText;
		//alert("loadSectionList.fromPHPs="+xmlhttp.responseText);
		try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			var objSel = document.getElementById("selModel");
				objSel.options.length=0;
				var option = document.createElement("option");//пуастая строка
				for(var i in fromPHPobj["models"]){
						option = document.createElement("option");
						option.text=fromPHPobj["models"][i];
						option.value=fromPHPobj["ml_id"][i];
						objSel.add(option, null);
				}
				objSel.selectedIndex=-1;
				
			var objSel = document.getElementById("selSection");
				objSel.options.length=0;
				var option = document.createElement("option");//пуастая строка 
				for(var i in fromPHPobj["sections"]){
					
						option = document.createElement("option");
						option.text=fromPHPobj["sections"][i];
						option.value=fromPHPobj["sl_id"][i];
						objSel.add(option, null);
					
				}
				objSel.selectedIndex=-1;
			
		}catch(e){
			alert("loadSectionList: Что то не то с ответом  loadSectionList.FromPHPs="+FromPHPs);
		} 
				

	}
  }

	
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=1",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
	
}

///////////////////////////////////////////////////

//Нажатие на УДАЛИТЬ модель
function delSelModel(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("delSelModel.fromPHPs="+fromPHPs);
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		if(fromPHPobj.status==1){
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Модель удалена</span>';
			loadSectionList();
		}
		if(fromPHPobj.status==0){
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Модель не удалена</span>';
		}
	}catch(e){alert("Что то не так с возвратом delSelModel"+e);}
  }
 }
var data={};
data.ml_id=document.getElementById("selModel").value;
//alert("data.section="+data.section+" yesNewSection="+document.getElementById("yesNewSection").value);
	if(data.ml_id==""){
		alert("Вы не заполнили необходимые поля");
		
	}else{
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=9",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
//alert("data="+JSON.stringify(data));
	}


}

///////////////////////////////////////////////////

//Нажатие на УДАЛИТЬ раздел
function delSelSection(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("delSelSection.fromPHPs="+fromPHPs);
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		if(fromPHPobj.status==1){
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Раздел удален</span>';
			loadSectionList();
		}
		if(fromPHPobj.status==0){
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Раздел не удален</span>';
		}
	}catch(e){alert("Что то не так с возвратом delSelSection"+e);}
  }
 }
var data={};
data.sl_id=document.getElementById("selSection").value;
	if(data.sl_id==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=10",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
//alert("data="+JSON.stringify(data));
	}


}
///////////////////////////////////////////////////

//Нажатие на кнопку Добавить
function btnAddClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("btnAddClick.fromPHPs="+fromPHPs);
	try{
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");

	
	loadSectionList();
		showNewModel();//убираем редактор и показываем селектор
		showSelSection();//Показываем селект выбора раздела и прячем редактор добавления нового раздела
		
		selectSection();
	
	
	if(fromPHPobj.status==1){
		document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Данные добавлены успешно</span>';
	}
	if(fromPHPobj.status==0){
		document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Данные не добавлены</span>';
	}
	}catch(e){alert("Что то не так с возвратом btnAddClick"+e);}
  }
 }
var data = new Object();
data.serial=document.getElementById("serial").value; 
data.descript=document.getElementById("descript").value;
data.yesNewModel=document.getElementById("yesNewModel").value;

	if(data.yesNewModel==1){//новая модель
		data.mName=document.getElementById("newModel").value;
		data.ml_id=0;
	}
	if(data.yesNewModel==0){//выбранная модель
		data.ml_id=document.getElementById("selModel").value;
		data.mName='';
	}
data.time=document.getElementById("time").value;
//data.price=document.getElementById("price").value;
//data.note=document.getElementById("note").value;
data.yesNewSection=document.getElementById("yesNewSection").value;
//alert("dataNewSection="+data.yesNewSection);
	if(data.yesNewSection==1){//новый раздел
		data.newSection=document.getElementById("newSection").value;
		data.sl_id=0;
	}
	if(data.yesNewSection==0){//выбранный раздел
		data.sl_id=document.getElementById("selSection").value;
		data.newSection='';
		
	}
	//alert("data.sl_id="+data.sl_id);
//data.f='2';
//alert("f="+data.f);

	if((data.descript!="" || data.time!="") || (data.mName!='' && data.ml_id!=0) || (data.section!='' && data.sl_id!=0)){
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=2",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}else{
		alert("Вы не заполнили необходимые поля");
//alert("data="+JSON.stringify(data));
	}
}



////////////////////////////////////////////

//Нажатие на кнопку Изменить
function btnUpdateClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
{
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("btnUpdateClick.fromPHPs="+fromPHPs);
	
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
		
		if(fromPHPobj['status']==1){
			loadSectionList();//загружается список разделов и список моделей
			showNewModel();//убираем редактор и показываем селектор
			showSelSection();//Показываем селект выбора раздела и прячем редактор добавления нового раздела		
				//очищаем инпуты
			document.getElementById("t_id").value="";
			document.getElementById("descript").value="";
			document.getElementById("selModel").selectedIndex=document.getElementById("selectModelIndex").value;
			document.getElementById("time").value="";
			document.getElementById("serial").value="";
			document.getElementById("selSection").selectedIndex=document.getElementById("selectSectionIndex").value;
			//запускаем функцию выбора раздела
			selectSection();
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Изменения выполнены</span>';
		}else{
			document.getElementById("note1").innerHTML='<span id=\"spanNote1\">Изменения не сделаны</span>';
		}
		
		
	}catch(e){
		alert("Что то не так с возвратом btnUpdateClick");
	}
  }
 };
var data={};
data.t_id=document.getElementById("t_id").value;
data.serial=document.getElementById("serial").value; 
data.descript=document.getElementById("descript").value;
data.yesNewModel=document.getElementById("yesNewModel").value;
	if(data.yesNewModel==1){//новая модель
		data.mName=document.getElementById("newModel").value;
		data.ml_id=0;
	}
	if(data.yesNewModel=='0'){//выбранная модель
		data.ml_id=document.getElementById("selModel").value;
		data.mName='';
	}
data.time=document.getElementById("time").value;
//data.price=document.getElementById("price").value;
//data.note=document.getElementById("note").value;
data.yesNewSection=document.getElementById("yesNewSection").value;
//alert("dataNewSection="+data.yesNewSection);
	if(data.yesNewSection==1){//новый раздел
		data.newSection=document.getElementById("newSection").value;
		data.sl_id=0;
	}
	if(data.yesNewSection==0){//выбранный раздел
		data.sl_id=document.getElementById("selSection").value;
		data.newSection='';
	}
	if( (data.descript=="" || data.time=="" || (data.mName=="") && data.ml_id==0) || (data.newSection=="" && data.sl_id==0)){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=3",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
//alert("btnUpdateClick.data="+JSON.stringify(data));
	}
}

///////////////////////////////////////////////

//Нажатие на кнопку Удалить

function btnDeleteClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	//alert("Сейчас будет ответ");
	var fromPHPs=xmlhttp.responseText;
//alert("fromPHPs="+fromPHPs);
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
		if(fromPHPobj["status"]==true)document.getElementById("note1").innerHTML='<span>Данные удалены!</span>';
		else document.getElementById("note1").innerHTML='<span>Данные не удалены!</span>';
		
		selectSection(document.getElementById("selSection").value);
		document.getElementById("serial").value="";
		//document.getElementById("selSection").value="";
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		// clearInput();
		selectSection();//запускаем функцию обновления выбранного раздела
	}
  }

var t_id=document.getElementById("t_id").value; 
//alert("t_id="+t_id);
//alert("f="+data.f+"aList="+data.a_id);
//alert("value="+JSON.stringify(data));
if(t_id==""){
	alert("Вы не выбрали строку для удаления");	
}else {xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=4",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("t_id="+t_id);
}
}

//выбирам раздел
function selectSection(){

var xmlhttp=ajaxConnect(); 

	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			
			var fromPHPs=xmlhttp.responseText;
	//alert("selectSection.fromPHPs="+fromPHPs);
				try{
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
						if(fromPHPobj["status"]==1){
							var tblTr='';
							tblTr+='<table id="tbl">';
							tblTr+='<tr id="trTable">';
							tblTr+='<th id="thSerial">№ опер.</td>';
							tblTr+='<th id="thDescript">Описание</td>';
							tblTr+='<th id="thTime">Норма времени</td>';
							//tblTr+='<th id="thPrice">Расценка</td>';
							//tblTr+='<th id="thNote">Пояснения</td>';
							tblTr+='</tr>';
							
							for(var i in fromPHPobj["data"]){
								tblTr += '<tr class="trTable">';
								tblTr += '<td class="tdSerial"><a name="'+fromPHPobj["data"][i]["t_id"]+'">'+fromPHPobj["data"][i]["serial"]+'</a></td>';
								tblTr += '<td class="tdDescript" onClick="tdClick('+fromPHPobj["data"][i]["t_id"]+')"><a href="#top">'+fromPHPobj["data"][i]["descript"]+'</a></td>';
								tblTr += '<td class="tdTime">'+fromPHPobj["data"][i]["time"]+'</td>';
								//tblTr += '<td class="tdPrice">'+fromPHPobj["data"][i]["price"]+'</td>';
								//tblTr += '<td class="tdNote">'+fromPHPobj["data"][i]["note"]+'</td>';
								tblTr += '</tr>';
							}
							tblTr+='</table><div id="footer"></div>';
							//alert ("tblTr="+tblTr);
							document.getElementById("spanTable").innerHTML=tblTr;
							document.getElementById("t_id").value="";
							document.getElementById("descript").value="";
							//document.getElementById("selModel").value="";
							document.getElementById("time").value="";
							//document.getElementById("price").value="";
							//document.getElementById("note").value="";
							document.getElementById("serial").value="";
							if(document.getElementById("selSection").selectedIndex!=-1)
							document.getElementById("selectSectionIndex").value=document.getElementById("selSection").selectedIndex;
						
						}else{
							document.getElementById("spanTable").innerHTML=" ";
						}
					}
				catch(e){
					alert("Что то не то с ответом:techmap.selectSection. "+e);
					}
		}
	} 
document.getElementById("note1").innerHTML="";
var data={};
data.yesNewModel=document.getElementById("yesNewModel").value;
	if(data.yesNewModel==1){//новая модель
		data.mName=document.getElementById("newModel").value;
		data.ml_id=0;
	}
	if(data.yesNewModel==0){//выбранная модель
		data.ml_id=document.getElementById("selModel").value;
		data.mName='';
	}
data.yesNewSection=document.getElementById("yesNewSection").value;
	if(data.yesNewSection==1){//новый раздел
		data.newSection=document.getElementById("newSection").value;
		data.sl_id=0;
	}
	if(data.yesNewSection==0){//выбранный раздел
		data.sl_id=document.getElementById("selSection").value;
		data.newSection='';
	}

xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=6",false);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("data="+JSON.stringify(data));

}

function tdClick(t_id){
	//alert("t_id="+t_id);
var xmlhttp=ajaxConnect();
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
//alert("tdClick.fromPHPs="+fromPHPs);
		
		try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		
			showNewModel();//убираем редактор и показываем селектор
			showSelSection();//Показываем селект выбора раздела и прячем редактор добавления нового раздела		
		
			document.getElementById("t_id").value=fromPHPobj["t_id"];
			document.getElementById("serial").value=fromPHPobj["serial"];
			document.getElementById("selSection").selectedIndex=document.getElementById("selectSectionIndex").value;
			document.getElementById("descript").value=fromPHPobj["descript"];
			document.getElementById("selModel").selectedIndex=document.getElementById("selectModelIndex").value;
			document.getElementById("time").value=fromPHPobj["time"];
			//document.getElementById("price").value=fromPHPobj["price"];
			//document.getElementById("note").value=fromPHPobj["note"];
			document.getElementById("go").innerHTML='<a href="#'+fromPHPobj["t_id"]+'">>></a>';
			
		}catch(e){
			alert("tdClick: Что то не так с возвратом tdClick: "+e);
		}
	}
 }	
	data={};
	data.t_id=t_id;
	document.getElementById("note1").innerHTML="";
	xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=7",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));	
		//alert("data="+JSON.stringify(data));
}
