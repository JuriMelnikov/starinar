/* $(document).ready(function () {
          loadWorkers();
		  btnDisabled(true);
		  // Скроем окно до лучших времен
			//document.getElementById('modalWindow').style.display=none;
	});
 */	
function logout(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
	//		alert("logout.fromPHPs="+fromPHPs);
			try{
				loginCheck();
				
			}catch(e){
				alert("logout: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=9",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}

var setIntervalID=0;
var second=0;
var delay=5;
function display(){
	if(delay>1){
		delay--;
		document.getElementById("sec").innerHTML=delay;
		document.getElementById("btnLogin").disabled=true;
	}else{
	delay=5;
		document.getElementById("login").value="";
		document.getElementById("pass").value="";
		document.getElementById("btnLogin").disabled=false;
		document.getElementById("delay_txt").innerHTML="<h3>Пожалуйста, введите логин и пароль!</h3>";
		document.getElementById("login").focus();
		clearInterval(setIntervalID);
	}
}

function loginCheck(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
		//	alert("loginCheck.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){
				
					showLoginWindow();
					
				//	alert("loginCheck="+fromPHPobj["loginCheck"]);
				}else{
				
				//alert("loginCheck="+fromPHPobj["loginCheck"]);
					 // Отключаем окно
					$('#loginWindow').hide();
					// Выключаем задник
					//if(document.getElementById("bgOverlay").style.display="block") 
					$('#bgOverlay').empty();
					second=0;
					clearInterval(setIntervalID);
					loadWorkers();
					//btnDisabled(true);
				}
			}catch(e){
				alert("loginCheck: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=0",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}	
function showLoginWindow(){
   // Отображаем и центрируем окно
    var loginWindow = $('#loginWindow');
    loginWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - loginWindow.outerWidth() ) / 2,
        top:   300,
        'z-index': '100'
    });
    loginWindow.show();
	document.getElementById("login").focus();
    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay"></div>';
	document.getElementById("delay_txt").innerHTML="<h3>Пожалуйста, введите логин и пароль!</h3>";
	if(second>0){
		clearInterval(setIntervalID);
		setIntervalID=setInterval('display()',1000);
	}
}
// Закрытие окна
function closeLoginWindow(){
document.getElementById("login").value='';
document.getElementById("pass").value='';
	 // Отключаем окно
    $('#loginWindow').hide();
    // Выключаем задник
    $('#bgOverlay').empty();
	clearInterval(setIntervalID);
	//loginCheck();
}
function clickLoginButton(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
	//		alert("clickLoginButton.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj['loginCheck']){
					loginCheck();
					document.getElementById("delay_txt").innerHTML='<h3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</h3>';
					second=1;
					clearInterval(setIntervalID);
					setIntervalID=setInterval('display()',1000);
				}else{
					closeLoginWindow();
				}
			}catch(e){
				alert("clickLoginButton: "+e);
			}
		}
	}
	data={};
	data.login=document.getElementById("login").value;
	data.pass=document.getElementById("pass").value;
	if(data.login!='' && data.pass!=''){
		document.getElementById("btnLogin").disabled=true;
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=0",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}	


function idCorrect(id){
if((id != '')){
	btnDisabled(false);
	if(id.length < 11){
		alert("Вы ввели неправильный ID номер!");
		btnDisabled(true);
	}else
	if((id.charAt(0) != "3") && (id.charAt(0) != "4") && (id.charAt(0)!="5") && (id.charAt(0) != "6")){
		alert("Вы ввели неправильный ID номер!");
		btnDisabled(true);
	}else
	if(isNaN(id)){
		alert("Вы ввели неправильный ID номер!");
		btnDisabled(true);
	}
}	
else
{
	btnDisabled(true);

}
//(id.length<11) && 
//&& 

}
function btnDisabled(value){
	document.getElementById("btnAdd").disabled=value;
	document.getElementById("btnUpdate").disabled=value;
	document.getElementById("btnDelete").disabled=value;
}
//Удаление работника
function delWorker(){
    // Отображаем и центрируем окно
    var delWindow = $('#delWorker');
    delWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - delWindow.outerWidth()  ) / 2,
        top:  ( $(document).height() - delWindow.outerHeight() ) / 2,
        'z-index': '100'
    });
	
		document.getElementById("mod_txtW").innerHTML="Из базы будет удален работник!<br>Продолжить?";

		delWindow.show();
    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay1"></div>';
	
}
//Удаление должности
function delAppointment(){
    // Отображаем и центрируем окно
    var delWindow = $('#delAppointment');
    delWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - delWindow.outerWidth()  ) / 2,
        top:  ( $(document).height() - delWindow.outerHeight() ) / 2,
        'z-index': '100'
    });
	
	document.getElementById("mod_txtA").innerHTML="Из базы будет удалена должность работника!<br>Продолжить?";
	
    delWindow.show();
	
    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay1"></div>';
	
}
// Закрытие окна 
function closeDelWorker(bool){
    // Отключаем окно
    $('#delWorker').hide();
    // Выключаем задник
    $('#bgOverlay').empty();
	if(bool) btnDeleteClick();
}
// Закрытие окна
function closeDelAppointment(bool){
    // Отключаем окно
    $('#delAppointment').hide();
    // Выключаем задник
    $('#bgOverlay').empty();
	if(bool) btnDelAppointmentClick();
}

// Открытие окна назначения доступа
function openAccountWindow(){
   
	document.getElementById("note").innerHTML="";
		var xmlhttp=ajaxConnect();  
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			var fromPHPs=xmlhttp.responseText;
			//alert("openAccountWindow.fromPHPs="+fromPHPs);
				
			try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				if(fromPHPobj["login"]){
				document.getElementById("newLogin").value=fromPHPobj["login"];
				document.getElementById("newPass").value='';
			}else{
				document.getElementById("newLogin").value='';
				document.getElementById("newPass").value='';
			}
				modalWindow.show();
				// включаем задник
				document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay1"></div>';
						
			}catch(e){alert("Что то не так с возвратом openAccountWindow");}
		  }
		 }
		
	//document.getElementById("level").value=level;	
	data={};
	data.w_id=document.getElementById("selectWorkersList").value;
	//data.level=level;
	if(!(data.w_id=="")){
		 // Отображаем и центрируем окно
			var modalWindow = $('#account');
			modalWindow.css(
			{
				position: 'absolute',
				left: ($(document).width()-modalWindow.outerWidth())/2,
				top:  ($(document).height()-modalWindow.outerHeight())/2,
				'z-index': '100'
			});
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=7",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
		//alert("value="+JSON.stringify(data));
	}
}
// закрытие окна назначения доступа 
function closeAccountWindow(){
// Отключаем окно
$('#account').hide();
// Выключаем задник
$('#bgOverlay').empty();
}

// закрытие окна назначения доступа с записью аккаунта
function insertAccountWindow(){
    // Отображаем и центрируем окно
    var modalWindow = $('#account');
    modalWindow.css(
    {
        position: 'absolute',
        left: ($(document).width()-modalWindow.outerWidth())/2,
        top:  ($(document).height()-modalWindow.outerHeight())/2,
        'z-index': '100'
    });
	document.getElementById("note").innerHTML="";
		var xmlhttp=ajaxConnect();  
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			var fromPHPs=xmlhttp.responseText;
	//alert("insertAccountWindow.fromPHPs="+fromPHPs);
			try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			   if(fromPHPobj["status"]==1)document.getElementById("note").innerHTML="Аккаунт установлен";
				else document.getElementById("note").innerHTML="Аккаунт не был изменен";
				document.getElementById("level").value='';
				// Отключаем окно
				$('#account').hide();
				// Выключаем задник
				$('#bgOverlay').empty();
						
			}catch(e){alert("Что то не так с возвратом insertAccountWindow");}
		  }
		 }
		//alert("value="+JSON.stringify(data));
	data={};
	data.w_id=document.getElementById("selectWorkersList").value;
	data.login=document.getElementById("newLogin").value;
	data.pass=document.getElementById("newPass").value;
	//data.level=document.getElementById("level").value;
	if(data.login=="" || data.pass==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=8",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}
// закрытие окна назначения доступа с удалением аккаунта
function deleteAccountWindow(){
    // Отображаем и центрируем окно
    var modalWindow = $('#account');
    modalWindow.css(
    {
        position: 'absolute',
        left: ($(document).width()-modalWindow.outerWidth())/2,
        top:  ($(document).height()-modalWindow.outerHeight())/2,
        'z-index': '100'
    });
	document.getElementById("note").innerHTML="";
		var xmlhttp=ajaxConnect();  
		xmlhttp.onreadystatechange=function()
		  {
		  if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
			var fromPHPs=xmlhttp.responseText;
	//alert("deleteAccountWindow.fromPHPs="+fromPHPs);
			try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			   if(fromPHPobj["status"]==1)document.getElementById("note").innerHTML="Аккаунт удален";
				else document.getElementById("note").innerHTML="Аккаунт не был изменен";
				document.getElementById("level").value='';
				// Отключаем окно
				$('#account').hide();
				// Выключаем задник
				$('#bgOverlay').empty();
						
			}catch(e){alert("Что то не так с возвратом deleteAccountWindow");}
		  }
		 }
		//alert("value="+JSON.stringify(data));
	data={};
	data.w_id=document.getElementById("selectWorkersList").value;

	//data.level=document.getElementById("level").value;
	if(data.w_id!=''){
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=10",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
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

function addAppointClick(){
document.getElementById("divNewAppointment").style.display="none";
document.getElementById("divSelectAppointment").style.display="block";
document.getElementById("newAppointment").style.display="block";
document.getElementById("selectAppointment").style.display="none";
document.getElementById("newAppointment").value="";
document.getElementById("ListOrNew").value="New";
}
function changeAppointClick(){
document.getElementById("divNewAppointment").style.display="block";
document.getElementById("divSelectAppointment").style.display="none";
document.getElementById("newAppointment").style.display="none";
document.getElementById("selectAppointment").style.display="block";
document.getElementById("ListOrNew").value="List";
}

function btnAddClick(){
document.getElementById("note").innerHTML="";
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	
	
	var fromPHPs=xmlhttp.responseText;
//alert("btnAddClick.fromPHPs="+fromPHPs);
		
	try{
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
	//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
	var newApp='';
	if(fromPHPobj['newApp'])newApp='Добавлена новая должность';
	if(fromPHPobj['status'])
	document.getElementById("note").innerHTML='<span id=\"spanNote\">Данные добавлены<br>'+newApp+'</span>';
	//document.getElementById("aList").innerHTML=fromPHPobj.aList;
	loadWorkers();
	changeAppointClick();
	//selectChange(document.getElementById("section").value);
	}catch(e){alert("Что то не так с возвратом btnAddClick");}
  }
 }
//alert("selectAppointment="+document.getElementById("selectAppointment").value);
//alert("newAppointment="+document.getElementById("newAppointment").value);
var data=new Object();
data.family=document.getElementById("family").value; 
data.name=document.getElementById("name").value;
data.kood=document.getElementById("kood").value;

var ListOrNew=document.getElementById("ListOrNew").value;
if(ListOrNew=="New"){data.appointment=document.getElementById("newAppointment").value;}
if(ListOrNew=="List"){data.appointment=document.getElementById("selectAppointment").value;}
data.ListOrNew=ListOrNew;
data.telefon=document.getElementById("telefon").value;
data.bankCount=document.getElementById("bankCount").value;
data.city=document.getElementById("city").value;
data.adress=document.getElementById("adress").value;
data.payment=document.getElementById("payment").value;
if(document.getElementById("L1").checked)data.L1=1;else data.L1=0;
if(document.getElementById("L2").checked)data.L2=1;else data.L2=0;
if(document.getElementById("L3").checked)data.L3=1;else data.L3=0;
if(document.getElementById("L4").checked)data.L4=1;else data.L4=0;
if(document.getElementById("L5").checked)data.L5=1;else data.L5=0;
//alert("data.appointment="+data.appointment);

//alert("f="+data.f);
//
	if(data.family=="" || data.name =="" || data.kood=="" || data.appointment=="" || data.bankCount==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=2",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("value="+JSON.stringify(data));
		//alert("value="+JSON.stringify(data));
	}
}

function loadWorkers(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		
		var fromPHPs=xmlhttp.responseText;
//alert("loadWorkers.fromPHPs="+fromPHPs);
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		if(fromPHPobj["List2"][i]=="false"){
			document.getElementById("note").innerHTML="База пуста";}
		else{
			var objSel1 = document.getElementById("selectAppointment");
				objSel1.options.length=0;
				//var option1 = document.createElement("option");
					var n=0;
					for( var i in fromPHPobj["List1"]){
						if (fromPHPobj["List1"] != " ")
						objSel1.options[n]=new Option(fromPHPobj["List1"][i]['appointment'],fromPHPobj["List1"][i]['wa_id']);
						n++;
					}	
				objSel1.selectedIndex=-1;
						//alert(option1.text);
					
			var objSel2 = document.getElementById("selectWorkersList");
				objSel2.options.length=0;
				var option2 = document.createElement("option");
					
				
				for( var i=0;i<fromPHPobj["List2"].length;i++){
				objSel2.options[i]=new Option(fromPHPobj["List2"][i]['family']+' '+fromPHPobj["List2"][i]['name'],fromPHPobj["List2"][i]['w_id']);
				}
				objSel2.selectedIndex=-1;
			
			var objSel3 = document.getElementById("dayStop");
				objSel3.options.length=0;
				var option3 = document.createElement("option");
					
				
				for( var i=1;i<=31;i++){
				objSel3.options[i-1]=new Option(i,i);
				}
				objSel3.selectedIndex=fromPHPobj["dayStop"]-1;
		}
			var str='<img src="images/help3.png" width="15px" height="15px">'; 
			str+='<span>Для добавления нового работника заполните поля и нажмите кнопку ДОБАВИТЬ.<br><br>';
			str+='Назначьте страницы, которые работник имеет право просматривать.<br><br>';
			str+='Назначьте логин и пароль для входа в систему. Для этого выберите<br>работника и нажмите на кнопку "Доступ работнику"</span>';
			document.getElementById("help2").innerHTML=str;
	}catch(e){
		alert("Что то не то с ответом :( loadWorkers");
	} 

	}
  }
//var data=new Object();
//alert("f="+data.f);
//alert(JSON.stringify(data));
	
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=1",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
	
}
function SetDayStop(){
var xmlhttp=ajaxConnect(); 
	var data={};
		data.dayStop=document.getElementById("dayStop").value;
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=12",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	//alert("data="+JSON.stringify(data));
}


function btnDelAppointmentClick(){
var xmlhttp=ajaxConnect(); 

	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var fromPHPs=xmlhttp.responseText;
			//alert("btnDelAppointmentClick.fromPHPs="+fromPHPs);
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			if(fromPHPobj.status) document.getElementById("note").innerHTML="Должность удалена";
			else document.getElementById("note").innerHTML="Должность удалить не удалось";
			loadWorkers();
			
		}
	}
	var data={};
	if(document.getElementById("selectAppointment").value != ''){
		data.wa_id=document.getElementById("selectAppointment").value;
		//alert("data="+data);
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=6",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}else{alert("Не выбрана должность");}
}

function selectWorkersListClick(value){

document.getElementById("note").innerHTML="";
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		
		var fromPHPs=xmlhttp.responseText;
		//alert("selectWorkersListClick.fromPHPs="+fromPHPs);
		try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			document.getElementById("w_id").value=fromPHPobj["w_id"];
			document.getElementById("family").value=fromPHPobj["family"]; 
			document.getElementById("name").value=fromPHPobj["name"];
			document.getElementById("kood").value=fromPHPobj["kood"];
			document.getElementById("selectAppointment").value=fromPHPobj["wa_id"];
			document.getElementById("telefon").value=fromPHPobj["telefon"];
			document.getElementById("bankCount").value=fromPHPobj["bankCount"];
			document.getElementById("city").value=fromPHPobj["city"];
			document.getElementById("adress").value=fromPHPobj["adress"];
            document.getElementById("payment").value=fromPHPobj["payment"];
			if(fromPHPobj["L1"]==1)document.getElementById("L1").checked=true;
			else document.getElementById("L1").checked=false;
			if(fromPHPobj["L2"]==1)document.getElementById("L2").checked=true;
			else document.getElementById("L2").checked=false;
			if(fromPHPobj["L3"]==1)document.getElementById("L3").checked=true;
			else document.getElementById("L3").checked=false;
			if(fromPHPobj["L4"]==1)document.getElementById("L4").checked=true;
			else document.getElementById("L4").checked=false;
			if(fromPHPobj["L5"]==1)document.getElementById("L5").checked=true;
			else document.getElementById("L5").checked=false;
			//делаем доступной кнопку Изменить
			//document.getElementById("btnUpdate").disabled="false";
			var str='<img src="images/help3.png" width="15px" height="15px">';
			str+='<span>Для добавления должности нажмите на строку "НОВАЯ" и впишите<br>новую должность.<br><br>При ';
			str+='нажатии на кнопку "УДАЛИТЬ ДОЛЖНОСТЬ", выбранная должность<br>будет удалена.<br><br>Кнопка "Фильтр" ';
			str+='назначает должность, работники которой будут выводится<br>на странице ';
			str+='"Результаты работы"</span>';
			document.getElementById("help2").innerHTML=str;
		}catch(e){
			alert("Что то не то с ответом :( selectWorkersListClick");
		} 

	}
  }	
	if(value==""){
			document.getElementById("w_id").value="";
			document.getElementById("family").value=""; 
			document.getElementById("name").value="";
			document.getElementById("kood").value="";
			document.getElementById("selectAppointment").value="";
			document.getElementById("telefon").value="";
			document.getElementById("bankCount").value="";
			document.getElementById("city").value="";
			document.getElementById("adress").value="";
            document.getElementById("payment").value="";
		
	}else{
	data={};
	data.w_id=value;
	xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=5",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}

//Нажатие на кнопку Изменить
function btnUpdateClick(){
document.getElementById("note").innerHTML="";
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("btnUpdateClick.fromPHPs="+fromPHPs);
	
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
		
		
		loadWorkers();
		changeAppointClick();

		//alert(document.getElementById("w_id").value);
		
		
		if(fromPHPobj.newApp==1){var newApp="Добавлена новая должность";}
		else{var newApp=" ";}
		if(fromPHPobj.status==1){
			document.getElementById("note").innerHTML='<span id=\"spanNote\">Изменения произведены успешно<br>'+newApp+'</span>';
		}else{
			document.getElementById("note").innerHTML='<span id=\"spanNote\">Изменения не сделаны<br>'+newApp+'</span>';
		}
		//делаем недоступной кнопку
		//document.getElementById("btnUpdate").disabled="true";
	selectWorkersListClick(document.getElementById("w_id").value);
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		
		//запускаем функцию обновления выбранного раздела
		//selectChange(document.getElementById("section").value);
		
		//очищаем инпуты
		//document.getElementById("w_id").value="";
		
		//document.getElementById("section").value="";
	}catch(e){
		alert("btnUpdateClick: Что то не так с возвратом");
	}
  }
 }
var data=new Object();
			data.w_id=document.getElementById("w_id").value;
			data.family=document.getElementById("family").value; 
			data.name=document.getElementById("name").value;
			data.kood=document.getElementById("kood").value;
			var ListOrNew=document.getElementById("ListOrNew").value;
	//alert("ListOrNew="+ListOrNew);
			if(ListOrNew=="New"){data.appointment=document.getElementById("newAppointment").value;}
			if(ListOrNew=="List"){data.appointment=document.getElementById("selectAppointment").value;}
			data.ListOrNew=ListOrNew;
			data.telefon=document.getElementById("telefon").value;
			data.bankCount=document.getElementById("bankCount").value;
			data.city=document.getElementById("city").value;
			data.adress=document.getElementById("adress").value;
            data.payment=document.getElementById("payment").value;
			if(document.getElementById("L1").checked)data.L1=1;else data.L1=0;
			if(document.getElementById("L2").checked)data.L2=1;else data.L2=0;
			if(document.getElementById("L3").checked)data.L3=1;else data.L3=0;
			if(document.getElementById("L4").checked)data.L4=1;else data.L4=0;
			if(document.getElementById("L5").checked)data.L5=1;else data.L5=0;

//alert("data.appointment="+data.appointment);
//alert("data="+JSON.stringify(data));
	if(data.w_id=="" || data.kood=="" || data.bankCount=="" || data.appointment=="" || data.family=="" || data.name==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=3",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
		//alert("value="+JSON.stringify(data));
	}
}



//Нажатие на кнопку Удалить

function btnDeleteClick(){
document.getElementById("note").innerHTML="";
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	//alert("Сейчас будет ответ");
	var fromPHPs=xmlhttp.responseText;
//alert("btnDeleteClick.fromPHPs="+fromPHPs);
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
		if(fromPHPobj['login'] && fromPHPobj['status'])
		document.getElementById("note").innerHTML='<span>Удаление работника успешно</span>';
		else document.getElementById("note").innerHTML='<span>Удалить работника не удалось</span>';
		//selectChange(document.getElementById("section").value);
		
		//document.getElementById("section").value="";
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		// clearInput();
			document.getElementById("w_id").value="";
			document.getElementById("family").value=""; 
			document.getElementById("name").value="";
			document.getElementById("kood").value="";
			document.getElementById("selectAppointment").value="";
			document.getElementById("telefon").value="";
			document.getElementById("bankCount").value="";
			document.getElementById("city").value="";
			document.getElementById("adress").value="";
            document.getElementById("payment").value="";
			
			loadWorkers();
		
	}
  }
var data={};
	data.w_id=document.getElementById("w_id").value; 
	//alert("t_id="+t_id);
	//alert("f="+data.f+"aList="+data.a_id);
	//alert("value="+JSON.stringify(data));
	if(data.w_id==""){
		alert("Вы не выбрали что удалять");	
	}else {xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=4",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}
/*Установка фильтра для показа работников на странице "Результаты работы"*/
function btnSetFiltr(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
//alert("btnSetFiltr.fromPHPs="+fromPHPs);
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		if (fromPHPobj["status"])
			alert("Фильтр установлен");
		else 
			alert("Фильтр не изменен");
	}
	}
var data={};
data.wa_id=document.getElementById("selectAppointment").value; ;
if(data.wa_id!=""){
	xmlhttp.open("POST","scr_worker.php?timeStamp="+new Date().getTime()+"&f=11",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
}

}