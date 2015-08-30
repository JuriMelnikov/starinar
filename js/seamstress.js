var test=0;
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

/*$(document).ready(function () {
          setCurrentWeek(); loadFamily(); _getDate();
       });
*/	   
function _getDate() {
	var month_names = new Array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октоября", "Ноября", "Декабря");	
	var d = new Date();
	var current_date = d.getDate();
	var current_month = d.getMonth();
	var current_year = d.getFullYear();
	
	var date_now = "Сегодня: <b>"+current_date + " " + month_names[current_month] 	+ " " + current_year + " г.</b>";
	//document.getElementById("currentDate").innerHTML=date_now;
	
}	   

function timeStr(a){	
		h=Math.floor(a/3600);
		a-=3600*h;
		m=Math.floor(a/60);if(m<10){m='0'+m}
		s=a-60*m;if(s<10){s='0'+s}
		return "Затраченное время: "+h+":"+m+":"+s;
}

function switchPeriod(){
	if(document.getElementById("switchPeriod").checked){
		document.getElementById("txtShow").innerHTML="Показать за месяц ";
		document.getElementById("divTable").innerHTML="";
		document.getElementById("sRaportOperate").innerHTML="";
		document.getElementById("sSelectNameFamily").selectedIndex=-1;
	}else{
		document.getElementById("txtShow").innerHTML="Показать за неделю";
		document.getElementById("divTable").innerHTML="";
		document.getElementById("sRaportOperate").innerHTML="";
		document.getElementById("sSelectNameFamily").selectedIndex=-1;
	}
}
function checkMonth(){
	document.getElementById("toMonth").style.display="block";
	document.getElementById("sWeek").style.display="none";
	document.getElementById("sAdd").disabled=true;
	changeDate(document.getElementById('w_id').value,-1)
	//selectFamily(document.getElementById('w_id').value);
}
function checkWeek(){
	//document.getElementById("toMonth").style.display="none";
	document.getElementById("sWeek").style.display="block";
	document.getElementById("sAdd").disabled=false;
	changeDate(document.getElementById('w_id').value,-1)
	//selectFamily(document.getElementById('w_id').value);
}
function setCurrentWeek(){
	var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				//
				var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("setCurrntWeek.fromPHPs="+fromPHPs);
				try{
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					
					var cd=new Date();
				
					var Year=cd.getFullYear();//alert(Year);
					var Month=cd.getMonth(); //alert(Month);
					/////////////
					var objSelW = document.getElementById("sWeek");
						for(var i=0;i<53;i++){
							objSelW.options[i] = new Option(i+1, i+1);
						}
					objSelW.selectedIndex = fromPHPobj["week"]-1; // устанавливаем текущий номер недели
					/////////////////
					var objSelM = document.getElementById("toMonth");
						for(var i=0;i<12;i++){
							objSelM.options[i] = new Option(i+1, i+1);
						}
					objSelM.selectedIndex = Month; // устанавливаем текущий номер недели
					
					//////////////////////	
					var obj=document.getElementById("sYear");
					obj.options.length=0;
					var option='';
					for(var j=Year-2;j<=Year+1;j++){
						option = document.createElement("option");
						option.text=j;
						option.value=j;
						obj.add(option,null);
					}
					document.getElementById("sYear").value = fromPHPobj["year"];
					document.getElementById("divCalendar").innerHTML = fromPHPobj["calendar"];
					//loadFamily();
				}catch(e){
					alert("Что то не то с ответом setCurrentWeek: "+e);
				} 		
		
			}
	}			
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=0",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
}

function logout(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("logout.fromPHPs="+fromPHPs);
			try{
				location.reload();
			}catch(e){
				alert("logout: "+e);
			}
		}
	}
	xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=14",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}

setIntervalID=0;
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
			
		if(test==1)	alert("loginCheck.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){//нет аутентификации
					showLoginWindow(fromPHPobj["count"]);
				}else{//есть аутентификация
				
				if(fromPHPobj["levelM"]<0){
					document.getElementById("back").style.display="block"
					setCurrentWeek();
					loadFamily(0);
				}
				if(fromPHPobj["levelM"]>0){
					document.getElementById("back").style.display="none"
					setCurrentWeek();
					loadFamily(fromPHPobj["levelM"]);
				}
					/*  // Отключаем окно
					$('#account').hide();
					// Выключаем задник
					if(document.getElementById("bgOverlay").style.display="block")
					 $('#bgOverlay').empty();	
					*/
					closeLoginWindow()					
				}
			}catch(e){
				alert("loginCheck: "+e);
			}
		
		}
	}
	
	xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=9",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}

/* function getLogin(w_id){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
			if(test==1) alert("getLogin.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
					if(fromPHPobj["getLogin"]){
						document.getElementById("login").value=fromPHPobj["getLogin"];
						document.getElementById("login").disabled=true;
					}else{
						document.getElementById("login").value='';
						document.getElementById("w_id").value='';
					}
				
			}catch(e){
				alert("getLogin: "+e);
			}
		
		}
	}
	data={};
	data.w_id=w_id;
	xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=10",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
} */

function showLoginWindow(count){
   // Отображаем и центрируем окно
    var loginWindow = $('#account');
    loginWindow.css(
    {
        position: 'absolute',
        left: ( $(document).width()  - loginWindow.outerWidth()  ) / 2,
        top:   300,
        'z-index': '100'
    });
	//alert("w_id="+w_id);
	//if(w_id!=0)	getLogin(w_id);
		
    loginWindow.show();
	document.getElementById("login").focus();
	/*if($newLogin!='')
	document.getElementById("login").value=$newLogin;
	else
	document.getElementById("login").value='';
	*/
    // включаем задник
    document.getElementById("bgOverlay").innerHTML= '<div id="TB_overlay"></div>';
	if(count>0){
	document.getElementById("btnLogin").disabled=true;
	document.getElementById("delay_txt").innerHTML='<h3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</h3>';
		clearInterval(setIntervalID);
		setIntervalID=setInterval('display()',1000);
	}
}

// Закрытие окна
function closeLoginWindow(){
document.getElementById("sPosition").style.display="block";
document.getElementById("btnLogout").style.display="block"
	 // Отключаем окно
    $('#account').hide();
    // Выключаем задник
	if(document.getElementById("bgOverlay").style.display="block");
    $('#bgOverlay').empty();
	clearInterval(setIntervalID);
	//loginCheck();
}

function clickLoginButton(){
if(delay>0 && delay<5) exit;
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			if(test==1) alert("clickLoginButton.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){
				//логин не верный
					logout();
					if(fromPHPobj["count"]>0){
						clearInterval(setIntervalID);
						setIntervalID=setInterval('display()',1000);
					}
				}else{//логин верный
					
					loginCheck();
				}
				/* if(fromPHPobj["loginCheck"] && fromPHPobj["levelM"]>0){
					setCurrentWeek();
					loadFamily(fromPHPobj["levelM"]);
				}else {
					loadFamily(fromPHPobj["levelM"]);
					selectFamily(document.getElementById("w_id").value);
				}
				closeLoginWindow();
			
				if(fromPHPobj["levelM"]<0)document.getElementById("back").style.display="block" */
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
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=9",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}


//////////////////////////////////////////////////////////

//исполняется при загрузке страницы
function loadFamily(levelM){
if(levelM>0){
	document.getElementById("sSelectNameFamily").style.display='none';
	document.getElementById("sInputNameFamily").style.display='block';
}
if(levelM<0){
	document.getElementById("sSelectNameFamily").style.display='block';
	document.getElementById("sInputNameFamily").style.display='none';
}
//hiddenInsert()
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
		if(test==1) alert("loadFamily.fromPHPs="+fromPHPs);
		try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			if(fromPHPobj["status"]==0){
				document.getElementById("note").innerHTML="Список работников пуст"
			}else{
				if(fromPHPobj["List"]==1){
					document.getElementById("w_id").value='';
				
					var objSel = document.getElementById("sSelectNameFamily");
						var option='';
						for(var i=0;i<fromPHPobj["data"].length;i++){
							option = document.createElement("option");
							option.text=fromPHPobj["data"][i]['family']+' '+fromPHPobj["data"][i]['name'];
							option.value=fromPHPobj["data"][i]['w_id'];
							objSel.add(option, null);
						}
				
						objSel.selectedIndex=-1;
						
					document.getElementById("sOrder").options.length=0;
					document.getElementById("sModel").options.length=0;
					document.getElementById("sOperate").options.length=0;
					document.getElementById("sCount").options.length=0;
					//Обнуляем таблицу
					document.getElementById("divTable").innerHTML='';
					 // Отключаем окно
					//$('#account').hide();
					// Выключаем задник
					//if(document.getElementById("bgOverlay").style.display="block")
					//$('#bgOverlay').empty();
					//if(w_id!='')loadOrder();
					//closeLoginWindow();
				}
				if(fromPHPobj["List"]==0){
				document.getElementById("w_id").value=fromPHPobj["data"]["w_id"];
				document.getElementById("sInputNameFamily").value=fromPHPobj["data"]['family']+' '+fromPHPobj["data"]['name'];
				document.getElementById("sInputNameFamily").disabled=true;						
					document.getElementById("sOrder").options.length=0;
					document.getElementById("sModel").options.length=0;
					document.getElementById("sOperate").options.length=0;
					document.getElementById("sCount").options.length=0;
					//Обнуляем таблицу
					document.getElementById("divTable").innerHTML='';
					
					selectFamily(fromPHPobj["data"]["w_id"]);
					 // Отключаем окно
					//$('#account').hide();
					// Выключаем задник
					//if(document.getElementById("bgOverlay").style.display="block")
					//$('#bgOverlay').empty();
					//if(w_id!='')loadOrder();
					//closeLoginWindow();
				}
			}		
		}catch(e){
			alert("Что то не то с ответом loadFamily: "+e);
		} 
				
	}
  }
//var data=new Object();
//alert("f="+data.f);
//alert(JSON.stringify(data));
	data={};
	data.levelM=levelM;
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=1",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
		//alert("Посылаем запрос в "+new Date());
	
}
function changeDate(w_id,ord){
selectFamily(w_id,ord);
//Обнуляем селекторы и в скрытых полях устанавливаем индекс -1
				document.getElementById("sOrder").options.length=0;
					//document.getElementById("sOrder").selectedIndex=-1;
				document.getElementById("selOrd").value="-1";
					document.getElementById("sOrder").options.length=0;
				document.getElementById("selMod").value="-1";
					document.getElementById("sModel").options.length=0;
				document.getElementById("selSect").value="-1";
					document.getElementById("sSection").options.length=0;
				document.getElementById("selOper").value="-1";
					document.getElementById("sOperate").options.length=0;
				document.getElementById("sRaportOperate").innerHTML="";
}
/**
* при выборе фамилии
* отсылаем w_id, week, month, year, period
* получаем данные учтенной работы -> в таблицу.
* публикуем таблицу и обнуляем note и таб. со сведениями о доб. операции sRaportOperate
* clearOrd - определяет выбор из формы или из функции;
* -1 - из формы
* 0 - из функции
*/
var clearOrd=-1;
function selectFamily(w_id,ord){
//text=document.getElementById("sSelectNameFamily").text;
document.getElementById("note").innerHTML='';
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			var fromPHPs=xmlhttp.responseText;

if(test==1)	alert("selectFamily.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				var i=0;
				var per='';
				if(fromPHPobj["login"]==true){
					// if(document.getElementById("radioPeriod1").checked)
					// 	per="Неделя";
					// if(document.getElementById("radioPeriod2").checked)
					// 	per="Месяц";
				//строим таблицу сделанного (внизу)
					if(fromPHPobj["status"]=="1"){
						var tblTr='';
						var tblTrH='';
						tblTrH+='<table id="tbl"><tr id="trTable">';
						tblTrH+='<th id="thId"></th>';
						//tblTr+='<th id="thFamily">Фамилия</th>';
						//tblTr+='<th id="thYear">Год</th>';
						//tblTr+='<th id="thWeek">'+per+'</th>';
						tblTrH+='<th id="thOrder">Ордер</th>';
						tblTrH+='<th id="thModel">Модель</th>';
						tblTrH+='<th id="thSection">Раздел</th>';
						tblTrH+='<th id="thOperate">Операция</th>';
						tblTrH+='<th id="thCount">Коли-<br>чество</th>';
						tblTrH+='<th id="thTime">Время</th>';
						//tblTrH+='<th id="thPrice">Расценка</th>';
						tblTrH+='<th id="thSum">Стоимость</th>';
						tblTrH+='</tr>';
						tblTrH+='<tbody>';
						
						//var sumTime=0;
						//var sum=0;
						
						for(i in fromPHPobj["data"]){
							// if(document.getElementById("radioPeriod1").checked)
							// 	per=data.week;
							// if(document.getElementById("radioPeriod2").checked)
							// 	per=data.month;
								
							if(fromPHPobj["data"][i]["r_id"]!=''){
								tblTr +='<tr class="trTable"><td class="tdId"><a href=# onClick="deleteRecord('+fromPHPobj["data"][i]["r_id"]+')">x</a>';//Удалить	
								tblTr += '</td><td class="tdOrder">'+fromPHPobj["data"][i]["order"];
								tblTr += '</td><td class="tdModel">'+fromPHPobj["data"][i]["model"];
								tblTr += '</td><td class="tdSection">'+fromPHPobj["data"][i]["section"];
								tblTr += '</td><td class="tdOperate">'+fromPHPobj["data"][i]["serial"];
								//tblTr += '</td><td class="tdOperate">'+fromPHPobj["data"][i]["serial"]+'. '+fromPHPobj["data"][i]["operate"];
								tblTr += '</td><td class="tdCount">'+fromPHPobj["data"][i]["countDid"];
								//sumTime+= fromPHPobj["data"][i]["time"]*fromPHPobj["data"][i]["count"];
								tblTr+='</td><td id="tdTime">'+fromPHPobj["data"][i]["time"];
								//tblTr += '</td><td class="tdPrice">'+fromPHPobj["data"][i]["price"];
								//sum = fromPHPobj["data"][i]["price"]*fromPHPobj["data"][i]["count"]
								tblTr += '</td><td class="tdSum">'+fromPHPobj["data"][i]["sum"];
								tblTr += '</td></tr>';
							}
						}
						var tblTrKonto ='<table id="tblKonto" border="0"><tr id="trTable">';//	
								tblTrKonto += '<td id="tdTimeValue" colspan="7">Время: '+fromPHPobj['sumTime'];
								tblTrKonto += '<td id="tdSum" >Сумма: ';
								tblTrKonto += '</td><td id="tdSumValue">'+fromPHPobj["sumPayment"];
								tblTrKonto += '</td></tr></table>';
						var GeneralTab=tblTrKonto;
						GeneralTab+=tblTrH;
						GeneralTab+=tblTr;
						GeneralTab+='</tbody></table>';
						GeneralTab+='<div id="tabFooter">';
						//alert ("tblTr="+tblTr);
						document.getElementById("divTable").innerHTML=GeneralTab;
						document.getElementById("note").innerHTML='';
						//document.getElementById("sSelectNameFamily").text=w_id;
					}else{
						var tblTr='';
						tblTr+='<table id="tbl"><tr id="trTable">';
						tblTr+='<th id="thId"></th>';
						//tblTr+='<th id="thFamily">Фамилия</th>';
						//tblTr+='<th id="thYear">Год</th>';
						//tblTr+='<th id="thWeek">Неделя</th>';
						tblTr+='<th id="thOrder">Ордер</th>';
						tblTr+='<th id="thModel">Модель</th>';
						tblTr+='<th id="thSection">Раздел</th>';
						tblTr+='<th id="thOperate">Операция</th>';
						tblTr+='<th id="thCount">Коли-<br>чество</th>';
						tblTr+='<th id="thTime">Время</th>';
						//tblTr+='<th id="thPrice">Расценка</th>';
						tblTr+='<th id="thSum">Стоимость</th>';
						tblTr+='</tr>';
						tblTr+='</table>';
						document.getElementById("note").innerHTML="Нет данных";
						document.getElementById("divTable").innerHTML=tblTr;
						
					}
			}	
				/* 
				//Обнуляем селектор ордеров и устанавливаем его "невыбрано"
				var objSel = document.getElementById("sOrder");
				objSel.options.length=0;
				objSel.selectedIndex=-1;
				 //обнуляем селектор моделей, он загрузится при выборе ордера
				var objSel = document.getElementById("sModel");
				objSel.options.length=0;
				//обнуляем список разделов, загрузится при выборе ордера
				var objSel = document.getElementById("sSection");
				objSel.options.length=0;
				//обнуляем список операций, загрузится при выборе раздела
				var objSel = document.getElementById("sOperate");
				objSel.options.length=0; 
				 */
				//очищаем строку с выбранной операцией
				//document.getElementById("sRaportOperate").innerHTML='';
				
				//очищаем селектор с количеством изделий в которых сделана эта операция
				//var objSel = document.getElementById("sCount");
				//objSel.options.length=0;
				
				//window.objSel = null;
				//window.data = null;
				//ord = -1 если выбор произошел из формы, или ord=0 если выбор произошел из функции
				clearOrd=ord;
				loadOrder(); //загружаем ордера в селектор Ордер
				
				//document.getElementById("sOrder").selectedIndex=selIndx;
				
			}catch(e){ //в случае ошибки в защищенном блоке
				alert("Что то не то с ответом selectFamily"+e);
			} 
				
		}
	}
	

//сохраняем w_id выбранной фамилии на странице
document.getElementById("w_id").value=w_id;

if (w_id != null){
	var data = new Object;
	data.w_id=w_id;
	data.week=document.getElementById("sWeek").value;
	data.month=document.getElementById("toMonth").value;
	data.year=document.getElementById("sYear").value;
	if(document.getElementById("radioPeriod1").checked)
		data.period="week";
	if(document.getElementById("radioPeriod2").checked)
		data.period="month";
	//data.count=document.getElementById("sCount").value;
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=5",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));	
// alert("data="+JSON.stringify(data));
	}else alert("w_id нет");
}


// Получаем данные из таблицы ns_admin за указанную неделю указанного года
//и записываем их в селектор Ордер
function loadOrder(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		
		var fromPHPs=xmlhttp.responseText;
		if(test==1) alert("loadOrder.fromPHPs="+fromPHPs);
		try{
		//массив со всеми ордерами за указанную неделю и год из таблицы ns_admin
		var arOrders=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			if(arOrders["status"]==1){
				// формируем список с ордерами за указанный год и неделю
				var objSel = document.getElementById("sOrder");
					objSel.options.length=0;
					var option='';
					for(var i in arOrders["data"]){
							option = document.createElement("option");
							option.text=arOrders["data"][i]['aOrder'];//дескриптор ордера
							option.value=arOrders["data"][i]['a_id'];//идентификатор
							objSel.add(option, null);
						
					}
					objSel.selectedIndex=-1;
			}
			//обнуляем селектор моделей, он загрузится при выборе ордера
		/*	 	var objSel = document.getElementById("sModel");
				objSel.options.length=0;
				//обнуляем список разделов, загрузится при выборе ордера
				var objSel = document.getElementById("sSection");
				objSel.options.length=0;
		*/		
		//выбор элементов
		if(clearOrd<0){//очищаем строки 
			document.getElementById("sOrder").selectedIndex=-1;
			document.getElementById("sModel").selectedIndex=-1;
			document.getElementById("sSection").selectedIndex=-1;
			//document.getElementById("sRaportOperate").value="";
		}else{//восстанавливаем выбранные строки
			document.getElementById("sOrder").selectedIndex=document.getElementById("selOrd").value;
			document.getElementById("sModel").selectedIndex=document.getElementById("selMod").value;
			document.getElementById("sSection").selectedIndex=document.getElementById("selSect").value;
		}
		document.getElementById("sOperate").selectedIndex=-1;
		//обнуляем список операций, загрузится при выборе раздела
		//		var objSel = document.getElementById("sOperate");
		//		objSel.options.length=0;
				 
				//очищаем строку с выбранной операцией
				//document.getElementById("sRaportOperate").innerHTML='';
				
				//очищаем селектор с количеством изделий в которых сделана эта операция
				var objSel = document.getElementById("sCount");
				objSel.options.length=0;
				window.objSel = null;

		}catch(e){
			alert("Что то не то с ответом в loadOrder :(");
		} 
				
	}
  }
  data=new Object();
  data.week=document.getElementById("sWeek").value; //указываем неделю
  data.month=document.getElementById("toMonth").value; //указываем месяц
  data.year=document.getElementById("sYear").value;// указываем год для считывания данных
//var data=new Object();
//alert("f="+data.f);
//alert(JSON.stringify(data));
	
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=2",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
		//alert("Посылаем запрос в "+new Date());
	
}

function deleteRecord(r_id){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
		
			var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("deleteRecord.fromPHPs="+fromPHPs);
			
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				if(fromPHPobj["login"] && fromPHPobj["status"]){
				selectFamily(document.getElementById("w_id").value);
				document.getElementById("sRaportOperate").innerHTML='Запись удалена';
				}else{logout()}
			
		}
	}
 data=new Object();
 data.r_id=r_id;
 data.w_id=document.getElementById("w_id").value;
	xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=6",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));			
}

//выполняется при выборе в селекторе Ордер нужного ордера
// Загружает в селектор Модель модели из таблицы ns_models
//var selIndx=-1;
function selectOrder(a_id){
document.getElementById("note").innerHTML='';
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("selectOrder.fromPHPs="+fromPHPs);
		try{
			//массив со всеми моделями, количесвтом штук и количеством уже выполненных за указанную неделю и год из таблицы ns_models 
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				//если фамилия выбрана формируем список с моделями из гл. массива arModels, 
				//который создан в loadOrder
				//alert('fromPHPobj["status"]='+fromPHPobj["status"]);
			if(fromPHPobj["status"] == 1){
				var objSel = document.getElementById("sModel");
				objSel.options.length=0; 
					var option='';								
					for(var i in fromPHPobj['val']){
						if(fromPHPobj['val'][i]['model'] !== undefined){
						
							option = document.createElement("option");
							option.text=fromPHPobj['val'][i]['model'];//название модели
							option.value=fromPHPobj['val'][i]['m_id'];//id модели
							objSel.add(option, null);
						
						}
					}
					
					
						objSel.selectedIndex=-1;
						document.getElementById("sSection").selectedIndex=-1;
					document.getElementById("sRaportOperate").innerHTML='';
			}
						
		}catch(e){
			alert("Что то не то с ответом в selectOrder");
		} 
			
	}
   }
  // selIndx=document.getElementById("sOrder").selectedIndex;
  // alert("selIndx="+document.getElementById("sOrder").selectedIndex);
  //запоминаем в скрытый инпут индекс выбранного ордера
  document.getElementById("selOrd").value=document.getElementById("sOrder").selectedIndex;
   var data={};
   data.a_id=a_id;
   //указываем идентификатор ордера, а по нему выберем все m_id, model из ns_models
   if((data.a_id!==undefined) || (data.a_id !="")){ 
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=7",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}	
		
	
}
//выбор модели и загрузка селектора разделов (sSection)
function selectModel(m_id){
document.getElementById("note").innerHTML='';
document.getElementById("m_id").value=m_id;
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("selectOrder.fromPHPs="+fromPHPs);
		try{
			//массив со всеми моделями, количесвтом штук и количеством уже выполненных за указанную неделю и год из таблицы ns_models 
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		
		var objSel = document.getElementById("sSection");
				objSel.options.length=0;
				var option = document.createElement("option");//пуастая строка
				/*	option.text="Выберите раздел";
					option.value="";
					objSel.add(option, null);
				
				*/ 
				for(var i in fromPHPobj["sections"]){
					
						option = document.createElement("option");
						option.text=fromPHPobj["sections"][i];
						option.value=fromPHPobj["sl_id"][i];
						objSel.add(option, null);
					
				}
				objSel.selectedIndex=-1;
		document.getElementById("sRaportOperate").innerHTML='';
		}catch(e){
			alert("Что то не то с ответом в selectModel");
		} 
			
	}
   }
   document.getElementById("selMod").value=document.getElementById("sModel").selectedIndex;
   var data={};
   data.m_id=m_id;
   data.a_id=document.getElementById("sOrder").value;
  //alert(data.m_id+" "+data.a_id);
  // data.a_id=a_id;"data="+JSON.stringify(data)
   //указываем идентификатор ордера, а по нему выберем все m_id, model из ns_models
   //if((data.a_id!==undefined) || (data.a_id !="")){ 
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=3",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	//}	
}

//выбор модели и загрузка селектора разделов (sSection)
function selectSection(sl_id){
document.getElementById("note").innerHTML='';
//document.getElementById("m_id").value=m_id;
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
	if(test==1) alert("selectSection.fromPHPs="+fromPHPs);
		try{
			//массив со всеми моделями, количесвтом штук и количеством уже выполненных за указанную неделю и год из таблицы ns_models 
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			if(fromPHPobj['login']){
				var objSel = document.getElementById("sOperate");
					objSel.options.length=0;
					var option = document.createElement("option");//пуастая строка
					/*	option.text="Выберите раздел";
						option.value="";
						objSel.add(option, null);
					
					*/ 
					for(var i in fromPHPobj["serials"]){
						
							option = document.createElement("option");
							option.text=fromPHPobj["serials"][i];
							option.value=fromPHPobj["t_id"][i];
							objSel.add(option, null);
						
					}
					objSel.selectedIndex=-1;
					document.getElementById("sRaportOperate").innerHTML='';
			}
		}catch(e){
			alert("Что то не то с ответом в selectSection");
		} 
			
	}
   }
   document.getElementById("selSect").value=document.getElementById("sSection").selectedIndex;
   var data={};
  data.sl_id=sl_id;
  data.m_id=document.getElementById("m_id").value;
   //указываем идентификатор ордера, а по нему выберем все m_id, model из ns_models
   //if((data.a_id!==undefined) || (data.a_id !="")){ 
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=13",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	//}	
}

//выбор операции и загрузка селектора количесвта изделий
function selectOperate(t_id){
document.getElementById("note").innerHTML='';
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

		var fromPHPs=xmlhttp.responseText;
		if(test==1) alert("selectOperate.fromPHPs="+fromPHPs);
			try{
				//Глобальный массив со всеми операциями из ns_techmap
				var operateList=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					if(operateList['login'] != false){
						//формируем список количества моделей
						var objSel = document.getElementById("sCount");
						objSel.options.length=0;//обнуляем существующий список количества изделий модели
						
						var n=1;
						var k=operateList['list']["count"];//количество изделий модели
						//alert("k="+k);
						var option='';
						while(n<=k){
							option = document.createElement("option");//заполняем цифрами список
							option.text=n;
							option.value=n;
							objSel.add(option, null);
							n++
						}
						objSel.selectedIndex=-1;
						var tblTr='<table id="tbl2">';
						tblTr +='<tr class="trTable"><th id="thId">№';//№	
									//tblTr += '</td><th id="thS">Раздел</td>';
									tblTr += '</td><th id="thD">Описание</td>';
									tblTr += '</td><th id="thT">Время';
									tblTr += '</td><th id="thP">Расценка';
									tblTr += '</td></tr>';
						tblTr +='<tr class="trTable2"><td class="tdId">'+operateList['list']["serial"];//№	
								//	tblTr += '</td><td class="tdSection">'+operateList['list']["section"]+'</td>';
									tblTr += '</td><td class="tdDescript">'+operateList['list']["descript"]+'</td>';
									tblTr += '</td><td class="tdTime">'+operateList['list']["time"];
									tblTr += '</td><td class="tdPrice">'+operateList['list']["payment"];
									tblTr += '</td></tr>';
						tblTr+='</table>';
						document.getElementById("sRaportOperate").innerHTML=tblTr;
					}				
			}catch(e){
				alert("Что то не то с ответом в selectOperate :("+e);
			} 
				
	}
  }
 // document.getElementById("selOper").value=document.getElementById("sOperate").selectedIndex;
  var data = new Object();
  data.a_id=document.getElementById("sOrder").value;
  data.t_id=t_id;
  data.w_id=document.getElementById("w_id").value;
  data.m_id=document.getElementById("m_id").value;
  data.sl_id=document.getElementById("sSection").value;
  data.year=document.getElementById("sYear").value; //new 4.08.2014
	if((data.t_id != "")){ 
//alert(t_id);
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=8",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));//"value="+JSON.stringify(data)
	}else{
		var objSel = document.getElementById("sCount");
		objSel.options.length=0;//обнуляем существующий список количества изделий модели
		var tblTr='<table id="tbl2">';
			tblTr +='<tr class="trTable"><th id="thId">ID';//ID	
						tblTr += '</td><th id="thS">Секция</td>';
						tblTr += '</td><th id="thD">Описание</td>';
						tblTr += '</td><th id="thT">Время';
						tblTr += '</td><th id="thP">Расценка';
						tblTr += '</td></tr>';
			tblTr +='<tr class="trTable"><td class="tdId">';//ID	
						tblTr += '</td><td class="tdSection"></td>';
						tblTr += '</td><td class="tdDescript"></td>';
						tblTr += '</td><td class="tdTime">';
						tblTr += '</td><td class="tdPrice">';
						tblTr += '</td></tr>';
			tblTr+='</table>';
			document.getElementById("sRaportOperate").innerHTML=tblTr;
	}
}


function btnAdd(){
document.getElementById("note").innerHTML='';
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		
		var fromPHPs=xmlhttp.responseText;
		
 //alert("btnAdd.fromPHPs="+fromPHPs);
		try{
			
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		//alert(fromPHPobj["test"]);
				if (fromPHPobj["status"]){
					selectFamily(document.getElementById("w_id").value);
					document.getElementById("sRaportOperate").innerHTML="Запись добавлена";
					//alert("Ваши данные добавлены!");
				}else{
					if (fromPHPobj["dayStop"])
						alert("Данные не добавлены!");
					else
						alert("Время внесения данных истекло! Обратитесь к руководителю");			
				}
		
		}catch(e){
			alert("Что то не то с ответом :( btnAdd "+e);
		} 
				
	}
  }

//selOrd=-1;
//считываем из инпутов значения в объект ToWorkList
var data=new Object();
data.year=document.getElementById("sYear").value;
data.week=document.getElementById("sWeek").value;
data.month=document.getElementById("toMonth").value;
data.w_id=document.getElementById("w_id").value;// id работника
data.a_id=document.getElementById("sOrder").value; //a_id ордера
data.m_id=document.getElementById("sModel").value; //ид модели
data.t_id=document.getElementById("sOperate").value; 
data.sl_id=document.getElementById("sSection").value;
data.countDid=document.getElementById("sCount").value;
	
if(data.countDid !='' && data.sl_id !='' && data.t_id!='' && data.m_id!='' && data.a_id!=''){
	
		xmlhttp.open("POST","scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=4",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
}else{alert("Не выбраны необходимые данные или недоступно количество изделий");}
//if(test==1) alert("data="+JSON.stringify(data));		
}



                            