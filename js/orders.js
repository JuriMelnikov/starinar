function _getDate() {
	var month_names = new Array("Января", "Февраля", "Марта", "Апреля", "Мая", "Июня", "Июля", "Августа", "Сентября", "Октоября", "Ноября", "Декабря");	
	var d = new Date();
	var current_date = d.getDate();
	var current_month = d.getMonth();
	var current_year = d.getFullYear();
	
	var date_now = "Сегодня: <b>"+current_date + " " + month_names[current_month] 	+ " " + current_year + " г.</b>";
	document.getElementById("currentDate").innerHTML=date_now;
	//alert(date_now);
}
function setCurrentWeek(){

	var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				
				var fromPHPs=xmlhttp.responseText;
				//alert("setCurrntWeek.fromPHPs="+fromPHPs);
				try{
				//var fromPHPobj=JSON.parse(fromPHPs);
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					
					var cd=new Date();
					//alert(cd);
					var Year=cd.getFullYear();//alert(Year);
				
					var objSelW = document.getElementById("selWeek");
						for(var i=0;i<53;i++){	
							objSelW.options[i] = new Option(i+1,i+1);
						}
					objSelW.selectedIndex = fromPHPobj["week"]-1; // устанавливаем текущий номер недели
					
					//////////////////////	
						var obj=document.getElementById("selMonth");
					
					obj.options.length=0;
					var n="0";
					for(var j=1;j<=12;j++){
					if(j<10){
								n="0"+j;
							}else{n=j};
						var option = document.createElement("option");
						option.text=n;
						option.value=n;
						obj.add(option,null);
					}
					document.getElementById("selMonth").value = fromPHPobj["month"];
					
					var obj=document.getElementById("selYear");
					
					obj.options.length=0;
					for(var j=Year-2;j<=Year+1;j++){
						var option = document.createElement("option");
						option.text=j;
						option.value=j;
						obj.add(option,null);
					}
					document.getElementById("selYear").value = fromPHPobj["year"];
					document.getElementById("divCalendar").innerHTML = fromPHPobj["calendar"];
					loadOrders();
				}catch(e){
					alert("Что то не то с ответом setCurrentWeek: "+e);
				} 		
				
				
				
			}
			
	}			
		xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=11",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
	
	document.getElementById("abtnChange").disabled=true;
	document.getElementById("abtnDeleteOrder").disabled=true;
	document.getElementById("abtnCanselChange").disabled=true;

	
}

//Проверяем номер
function onliNumer(num){
//alert("Blur");
num = num.toString().replace(/\,/g, '.');//замена запятой на точку
if (isNaN(num)) num = "0";// определяем переменную 



return Math.floor(num);
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

//////////////////////////////////////////////////////////

//Показать кнопку Вставить
function showPlusMinus(){
 	document.getElementById("countInputs").style.display="block";
	document.getElementById("plus").style.display="block";
	document.getElementById("minus").style.display="block";
	document.getElementById("abtnAdd").disabled=false;
	document.getElementById("abtnChange").disabled=true;
	document.getElementById("abtnDeleteOrder").disabled=true;
	document.getElementById("abtnCanselChange").disabled=true;
}


///////////////////////////////////////////////////////

//Скрыть кнопку Вставить
function hiddenPlusMinus(){
	document.getElementById("countInputs").style.display="none";
	document.getElementById("plus").style.display="none";
	document.getElementById("minus").style.display="none";

	if(document.getElementById("check").checked){
	document.getElementById("abtnAdd").disabled=true;
	document.getElementById("abtnChange").disabled=true;
	document.getElementById("abtnDeleteOrder").disabled=true;
	document.getElementById("abtnCanselChange").disabled=true;	
	}else{
	document.getElementById("abtnAdd").disabled=false;
	document.getElementById("abtnChange").disabled=false;
	document.getElementById("abtnDeleteOrder").disabled=false;
	document.getElementById("abtnCanselChange").disabled=false;
	}
}
function logout(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
			//alert("logout.fromPHPs="+fromPHPs);
			try{
				loginCheck();
			}catch(e){
				alert("logout: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=10",false);
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
		clearInterval(setIntervalID);
	}
}

function loginCheck(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			//alert("loginCheck.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["loginCheck"]){
					showLoginWindow(fromPHPobj["count"]);
				}else{
				if(fromPHPobj["levelM"]==-2)document.getElementById("nextPage").style.display="none"
				setCurrentWeek();
				document.getElementById("check").checked=false;
					 // Отключаем окно
					$('#account').hide();
					// Выключаем задник
					if(document.getElementById("bgOverlay").style.display="block")
					$('#bgOverlay').empty();
					second=0;
					clearInterval(setIntervalID);
					
				}
			}catch(e){
				alert("loginCheck: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=0",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
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
	 // Отключаем окно
    $('#account').hide();
    // Выключаем задник
	if(document.getElementById("bgOverlay").style.display="block")
    $('#bgOverlay').empty();
	clearInterval(setIntervalID);
}
function clickLoginButton(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			//alert("clickLoginButton.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(!fromPHPobj["login"]){
					loginCheck();
					document.getElementById("delay_txt").innerHTML='<h3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</h3>';
					second=1;
					clearInterval(setIntervalID);
					setIntervalID=setInterval('display()',1000);
				}else{
				if(fromPHPobj["levelM"]==-2)document.getElementById("nextPage").style.display="none"
					closeLoginWindow();
					setCurrentWeek();
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
		xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=0",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}
function addInput(){	

var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
//alert("addInput.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
					
				var parentDiv=document.getElementById("models");
				var newDiv=document.createElement('div');
				
				
				var k=parentDiv.getElementsByTagName('div').length;
				
				k++;
				if(k<11){
					newDiv.id="line"+k;
					newDiv.innerHTML='<span id="span_m_id'+k+'"><input type="hidden" id="m_id'+k+'"></span>';
					var sel='<span id="span_m'+k+'"><select id="aModel'+k+'">';
						var opt='';
						if(fromPHPobj["status"]==1){
							for(var i in fromPHPobj["models"]){
									opt+='<option value="'+fromPHPobj["models"][i]+'">'+fromPHPobj["models"][i]+'</option>';
							}
						}
						sel+=opt;	
						sel+='</select></span>';
					newDiv.innerHTML+=sel;
					
					newDiv.innerHTML+='<span id="span_c'+k+'"><input type="text" id="aCount'+k+'" onBlur="this.value=onliNumer(this.value)"></span>';
					parentDiv.appendChild(newDiv);
					document.getElementById("aModel"+k).selectedIndex=-1;
				}
				 document.getElementById("countInputs").selectedIndex=parentDiv.getElementsByTagName('div').length-1;
			}catch(e){
				alert("addInput: "+e);
			}
		
		}
	}
	var data={};
	data.check=false;
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=7",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
 

}
//создание проверочной панели
function addInputCheck(){	
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
			
//alert("addInputCheck.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");			
				if(fromPHPobj["status"]==1){
					var parentDiv=document.getElementById("models");
					//parentDiv=innerHTML='';
					var newDiv=document.createElement('div');
									
					var k=parentDiv.getElementsByTagName('div').length;
					
					k++;
					if(k<11){
						newDiv.id="line"+k;
						newDiv.innerHTML='<input type="hidden" id="m_id'+k+'">';
						newDiv.innerHTML='<input type="text" id="sel'+k+'">';
							
						
						
						sel='<select id="section'+k+'" onChange="checkOrder(this.value,document.getElementById(\'sel'+k+'\').value)">';
						var opt='';
							var j=0;
								for( j in fromPHPobj["sections"]){
										opt+='<option value="'+fromPHPobj["sl_id"][j]+'">'+fromPHPobj["sections"][j]+'</option>';
										
								}
								
							sel+=opt;
							sel+='</select>';
						newDiv.innerHTML+=sel;
						
						//alert(newDiv.innerHTML);
						parentDiv.appendChild(newDiv);
						//document.getElementById("sel"+k).selectedIndex=-1;
						document.getElementById("section"+k).selectedIndex=-1;
					}
					 document.getElementById("countInputs").selectedIndex=parentDiv.getElementsByTagName('div').length-1;
				}
			}catch(e){
				alert("addInputCheck: "+e);
			}
		
		}
	}
	var data={};
	data.check=true;
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=7",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
 

}

function removeInput(){
	var parentDiv=document.getElementById("models");
	var q=parentDiv.getElementsByTagName('div');
	if(q.length>1){
		q[q.length - 1].parentNode.removeChild(q[q.length - 1]);
	}
	document.getElementById("countInputs").selectedIndex=q.length-1;
	
}

//количество редакторов для модели и количества изделий
function countInputs(n){
	var parentDiv=document.getElementById("models");
	if(parentDiv.getElementsByTagName('div')===undefined)
		var k=0;
	else
		var k=parentDiv.getElementsByTagName('div').length;
	
		if(n===undefined){
			
			if (k==0){n=1;
				for(var i=0;i<n;i++){
					addInput();
					
				}
			}
		}else{
			if(k>n){
				for(var i=n;i<k;i++) 
				removeInput();
			}
			if(k<n){
				for(var i=k;i<n;i++) 
				addInput();
			}
		}
	


}



////////////////////////////////////////////////////

//вывод таблицы со списком ордеров для указанной недели
function loadOrders(){
//alert("loadWeek is runing");
var xmlhttp=ajaxConnect();

		xmlhttp.onreadystatechange=function(){
			if (xmlhttp.readyState==4 && xmlhttp.status==200){
			fromPHPs=xmlhttp.responseText;
//alert("loadOrders.fromPHPs="+fromPHPs);

				try{
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					if(fromPHPobj["status"]){
						var aList='<table id="tblList" cellpadding="0">';
							aList+='<tr id="trList"><th id="thNo">No</th><th id="thOrder">СПИСОК ОРДЕРОВ</th></tr>';
						var n=1;
						for(var i=0;i<fromPHPobj["data"].length;i++){
							aList += '<tr class="trList">';
							 
							aList += '<td class="tdId">'+n+'.</td>'; 
							aList += '<td class="tdOrder" onclick="selectOrder('+fromPHPobj["data"][i]["a_id"]+');">';
							aList += '<a href="#">'+fromPHPobj["data"][i]["order"]+'</a></td></tr>';
							n++;
						}
						aList += '<tr class="trList"><td>&nbsp;</td><td>&nbsp;</td></tr></table>';
						document.getElementById("table_div").innerHTML=aList;
						document.getElementById("note").innerHTML="";
					}else{
						document.getElementById("table_div").innerHTML='';
						document.getElementById("note").innerHTML="Ордеров нет";
					}
				}catch(e){
					document.getElementById("note").innerHTML="Ордеров нет";
				}

			}
		}
if(!document.getElementById("check").checked)
	countInputs(1); //прорисовываем поля модели-количества
//alert("check="+document.getElementById("check").checked);
  
  var data=new Object();
  data.aWeek=document.getElementById("selWeek").value;
  data.month=document.getElementById("selMonth").value;
  data.aYear=document.getElementById("selYear").value;
  
xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=1",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("data="+JSON.stringify(data));
//alert("value="+JSON.stringify(data));
}


//////////////////////////////////////////////////////
	var selWeek=0;
	var selMonth=0;
	var selYear=0;
function updateVisible(){
selWeek=document.getElementById("selWeek").value;
selMonth=document.getElementById("selMonth").value;
selYear=document.getElementById("selYear").value;
	document.getElementById("weekMonthYear").style.display="none";
	document.getElementById("abtnAdd").style.display="none";
	document.getElementById("UweekMonthYear").style.display="block";
	document.getElementById("txtUpdateDate").style.display="block";
	document.getElementById("abtnDubl").style.display="block";
	/*document.getElementById("selWeek").style.display="none";
	document.getElementById("selMonth").style.display="none";
	document.getElementById("selYear").style.display="none";
	document.getElementById("UselWeek").style.display="blok";
	document.getElementById("UselMonth").style.display="blok";
	document.getElementById("UselYear").style.display="blok";
*/
	}
function check(){

if(document.getElementById("check").checked){
aCanselClick();
hiddenPlusMinus();
loadOrders();
document.getElementById("abtnAdd").desabled=true;
document.getElementById("models").innerHTML="";
document.getElementById("textCheck").style.color='#FF3300';
document.getElementById("txtModel").innerHTML="МОДЕЛЬ - РАЗДЕЛ";
}
if(!document.getElementById("check").checked){
document.getElementById("models").innerHTML="";
loadOrders();
aCanselClick();
document.getElementById("textCheck").style.color='#000';
document.getElementById("raport").style.display="none";	
document.getElementById("right").style.display="block";
document.getElementById("txtModel").innerHTML="МОДЕЛЬ - КОЛИЧЕСТВО";
}
}	
	
function checkOrder(sl_id,mName){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var fromPHPs=xmlhttp.responseText;
alert("checkOrder.fromPHPs: "+fromPHPs);			
		try{
				fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				if(fromPHPobj["login"]){
				var str='<div id="OrderModel">Ордер: "<span id="tblROrder">'+data.order+'</span>"<br>Model: "<span id="tblRModel">'+data.mName+'</span>"</div>';
					str+='<table id="tblR">';
					str+='<tbody id="tblRBody">';
					str+='<tr>';
					str+='<th id="tblRBodyF">Фамилия, Имя</th>';
					str+='<th id="tblRBodyS">№</th>';
					str+='<th id="tblRBodyC">Количе-<br>ство</th>';
					str+='</tr>';
					for(var i in fromPHPobj["List"]){
						str+='<tr>';
						str+='<td class="tdRF">'+fromPHPobj["List"][i]["family"]+' '+fromPHPobj["List"][i]["name"]+'</td>';
						str+='<td class="tdRS">'+fromPHPobj["List"][i]["serial"]+'</td>';
						str+='<td class="tdRС">'+fromPHPobj["List"][i]["countDid"]+'</td>';
						str+='</tr>';
					}
					str+='</tbody>';
					str+='</table>';
					//alert("str="+str);
					document.getElementById("raport").innerHTML=str;
					document.getElementById("raport").style.display="block";	
					document.getElementById("right").style.display="none";
				}
			
			
			}catch(e){
				alert("Что то не то с ответом checkOrder "+e);
					
			} 
		}
	}
	//alert("data="+data);
data={};
data.order=document.getElementById("aOrder").value;
//alert(data.order);
data.sl_id=sl_id;
data.mName=mName;
data.week=document.getElementById("selWeek").value;
data.month=document.getElementById("selMonth").value;
data.year=document.getElementById("selYear").value;
xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=9",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("data="+JSON.stringify(data));	
//alert("data="+JSON.stringify(data));

}

//выбор строки из списка ордеров
function selectOrder(a_id){

document.getElementById("valueSelectOrderId").value=a_id;
//document.getElementById("valueSelectOrder").value=order;
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var fromPHPs=xmlhttp.responseText;
//alert("selectOrder.fromPHPs: "+fromPHPs);
			try{
				fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				//панеть проверки активирована
				if(document.getElementById("check").checked){
					hiddenPlusMinus();
					document.getElementById("aOrder").value=fromPHPobj["order"];
					var parentDiv=document.getElementById("models");
					var n=parentDiv.getElementsByTagName('div').length;
					if(fromPHPobj["n"]>n){
						for(var i=n;i<fromPHPobj["n"];i++){
							addInputCheck();
						}
					}else if(fromPHPobj["n"]<n){
						for(var i=fromPHPobj["n"];i<n;i++){
							removeInput();
						}
					}
					var k=1;
					for(var i=0;i<fromPHPobj["n"];i++){
						document.getElementById("sel"+k).value=fromPHPobj["models"][i]["model"];
					// for(var i in fromPHPobj["models"]){
						// document.getElementById("m_id"+k).value=fromPHPobj["models"][i]["m_id"]; 
						// for(var j=0;j<document.getElementById("sel"+k).options.length;j++){
							// if(fromPHPobj["models"][i]["model"]==document.getElementById("sel"+k).options[j].text){
								// document.getElementById("sel"+k).selectedIndex=j; 
								
							// }
						// }
						
						 k++;
					}
				}else{//Панель проверки не видна
					updateVisible();	
					//селектор недели		
					var objSelW = document.getElementById("UselWeek");
						for(var i=0;i<53;i++){	
							objSelW.options[i] = new Option(i+1,i+1);
						}
						//alert(fromPHPobj["aWeek"]);
					objSelW.selectedIndex = fromPHPobj["aWeek"]-1; // устанавливаем текущий номер недели
						
					//селектор месяца
					var obj=document.getElementById("UselMonth");
						obj.options.length=0;
						var n="0";
						for(var j=1;j<=12;j++){
						if(j<10){
									n="0"+j;
								}else{n=j};
							var option = document.createElement("option");
							option.text=n;
							option.value=n;
							obj.add(option,null);
						}
						var m=fromPHPobj["month"];
						if(m<10)m="0"+m;
					document.getElementById("UselMonth").value=m;	
					//селектор года
					var cd=new Date();
					var Year=cd.getFullYear();//alert(Year);
					var obj=document.getElementById("UselYear");
						obj.options.length=0;
						for(var j=Year-2;j<=Year+1;j++){
							var option = document.createElement("option");
							option.text=j;
							option.value=j;
							obj.add(option,null);
						}
						document.getElementById("UselYear").value = fromPHPobj["aYear"];	
					hiddenPlusMinus();
					//инпут с именем ордера
					document.getElementById("aOrder").value=fromPHPobj["order"];
					//устанавливаем количество импутов в соответствии с 
					// количеством моделей.
					var parentDiv=document.getElementById("models");
					var n=parentDiv.getElementsByTagName('div').length;
					if(fromPHPobj["n"]>n){
						for(var i=n;i<fromPHPobj["n"];i++){
							addInput();
						}
					}else if(fromPHPobj["n"]<n){
						for(var i=fromPHPobj["n"];i<n;i++){
							removeInput();
						}
					}
					if(fromPHPobj["n"]==0){//если моделей у ордера нет (n==0) ставим пустые импуты
						document.getElementById("aModel1").selectedIndex=-1;
						document.getElementById("aCount1").value='';
					}else{ //устанавливаем индексы моделей для ордера
						var k=1;
						for(var i in fromPHPobj["models"]){//пройдемся по моделям
							document.getElementById("m_id"+k).value=fromPHPobj["models"][i]["m_id"]; 
							for(var j=0;j<document.getElementById("aModel"+k).options.length;j++){
							//alert(fromPHPobj["models"][i]["model"]+"=="+document.getElementById("aModel"+k).options[j].text);
								if(fromPHPobj["models"][i]["model"]==document.getElementById("aModel"+k).options[j].text){
									document.getElementById("aModel"+k).selectedIndex=j; 
									//alert("selectedIndex="+document.getElementById("aModel"+k).selectedIndex);
								}
							}
							document.getElementById("aCount"+k).value=fromPHPobj["models"][i]["count"];
							k++;
						}
					}
				}
			}catch(e){
				alert("Что то не то с ответом selectOrder "+e);
					
			} 
		}
	}
	//alert("data="+data);
data={};
//состояние панели проверки
data.check=document.getElementById("check").checked;
data.a_id=a_id;
xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=2",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
xmlhttp.send("data="+JSON.stringify(data));
}
		


///////////////////////////////////////////////////

//Нажатие на кнопку ДОбавить
function aAddClick(){
//hiddenInsert()
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

	var fromPHPs=xmlhttp.responseText;
	
//alert("aAddClick.fromPHPs="+fromPHPs);
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	//alert("fromPHPs="+fromPHPs);
	//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
	document.getElementById("note").innerHTML='<div id="note">'+fromPHPobj.text+'</div>';
	//document.getElementById("aList").innerHTML=fromPHPobj.aList;
	updateHide();
		countInputs(1);
		document.getElementById("aModel1").selectedIndex=-1;
		document.getElementById("aCount1").value="";
		document.getElementById("aOrder").value="";
	loadOrders();
	
	}
  }
var data=new Object();
data.aWeek=document.getElementById("selWeek").value; 
data.month=document.getElementById("selMonth").value;
data.aYear=document.getElementById("selYear").value;
data.aOrder=document.getElementById("aOrder").value;//название ордера
//alert("order "+data.aOrder);
var n=document.getElementById("countInputs").value;
var models=[];
var counts=[];
for(var i=1;i<=n;i++){
	if(document.getElementById("aModel"+i).value !== undefined){
	
		models[i-1]=document.getElementById("aModel"+i).value;
		counts[i-1]=document.getElementById("aCount"+i).value;
	//alert("array.models="+models[i-1]+" array.counts="+counts[i-1]);
	}
}

	if(data.aOrder==""){
		alert("Вы не заполнили поле \"Ордер\"");
	}else{
		xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=3",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("order="+JSON.stringify(data)+"&models="+JSON.stringify(models)+"&counts="+JSON.stringify(counts));
		//alert("order="+JSON.stringify(data)+"&model="+JSON.stringify(model)+"&count="+JSON.stringify(count) );
	}
}
///////////////////////////////////////////////////

//Нажатие на кнопку Дубль
function aDublClick(){
//hiddenInsert()
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

	var fromPHPs=xmlhttp.responseText;
	
//alert("aDublClick.fromPHPs="+fromPHPs);
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");

	if(fromPHPobj['status']){
		document.getElementById("note").innerHTML='<div id="note">Дубль ордера добавлен</div>';
		aCanselClick();
	}else
		alert("aDublClick: "+e);
	}
  }
var data=new Object();
data.a_id=document.getElementById("valueSelectOrderId").value; 
data.week=document.getElementById("UselWeek").value;
data.month=document.getElementById("UselMonth").value;
data.year=document.getElementById("UselYear").value;
	if(data.a_id==""){
		alert("Вы не выбрали ордер?");
	}else{
		xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=8",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	//alert("order="+JSON.stringify(data));
	}
}



function aCanselClick(){
	updateHide();
	document.getElementById("valueSelectOrderId").value='';
	document.getElementById("aOrder").value='';
	for(var i=1;i<=document.getElementById("countInputs").value;i++){
		document.getElementById("aModel"+i).value='';
		document.getElementById("aCount"+i).value='';
	}
	showPlusMinus();
	countInputs(1);
}

////////////////////////////////////////////////////////

//скрывает панель update
function updateHide(){
selWeek=0;
selMonth=0;
selYear=0;
	document.getElementById("weekMonthYear").style.display="block";
	document.getElementById("UweekMonthYear").style.display="none";
	document.getElementById("txtUpdateDate").style.display="none";
	document.getElementById("abtnDubl").style.display="none";
	document.getElementById("abtnAdd").style.display="block";

	}
//Нажатие на кнопку Вставить
function aUpdateClick(){
//hiddenInsert()
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {

	var fromPHPs=xmlhttp.responseText;
//alert("aUpdateClick.fromPHPs="+fromPHPs);
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
		if (fromPHPobj["status"]==1)document.getElementById("note").innerHTML="Данные изменены!";
		if (fromPHPobj["status"]==0)document.getElementById("note").innerHTML="Данные изменить не удалось!";
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		updateHide();
		loadOrders();
		showPlusMinus();
		countInputs(1);
		document.getElementById("aModel1").selectedIndex=-1;
		document.getElementById("aCount1").value="";
		document.getElementById("aOrder").value="";
	}
  }
var data ={};
data.a_id=document.getElementById("valueSelectOrderId").value; 
data.week=document.getElementById("UselWeek").value;
data.month=document.getElementById("UselMonth").value;
data.year=document.getElementById("UselYear").value;
data.order=document.getElementById("aOrder").value;
data.m_id=[];
data.model=[];
data.count_=[];
var n=document.getElementById("countInputs").value;
for(var i=1;i<=n;i++){
	if(document.getElementById("aModel"+i).value !== undefined){
		data.m_id[i-1]=document.getElementById("m_id"+i).value;
		data.model[i-1]=document.getElementById("aModel"+i).value;
		data.count_[i-1]=document.getElementById("aCount"+i).value;
	// //alert("model="+document.getElementById("aModel"+i).value
	// 	+" m_id="+document.getElementById("m_id"+i).value+" count="+
	// 	document.getElementById("aCount"+i).value);
	}
}


if(data.a_id==""){alert("Вы не выбрали строку для изменения!")}
else{
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=4",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
	//alert("data="+JSON.stringify(data));
}

}


///////////////////////////////////////////////////

//Нажатие на кнопку Удалить
function aDeleteClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	var fromPHPs=xmlhttp.responseText;
//alert("aDeleteClick.fromPHPs="+fromPHPs);
		try{	
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			updateHide();
			loadOrders();
			showPlusMinus();
			if(fromPHPobj["status"])
				document.getElementById("note").innerHTML='<span>Ордер удален!</span>';
			else
				document.getElementById("note").innerHTML='<span>Ордер удалить не удалось!</span>';
		}catch(e){
			   alert("DeleteClick "+e);
		}
	}
  }
  
var data=new Object();
data.a_id=document.getElementById("valueSelectOrderId").value;
if(document.getElementById("UselWeek").value==selWeek && document.getElementById("UselMonth").value==selMonth && document.getElementById("UselYear").value==selYear){
	if(data.a_id==""){
		alert("Вы не выбрали строку для удаления!");	
	}else {xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=5",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}else{
	aDeleteDublClick();

}	//alert("Посылаем запрос в "+new Date());
}

//Нажатие на кнопку Удалить Dubl
function aDeleteDublClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
		var fromPHPs=xmlhttp.responseText;
	//	alert("aDeleteClick.fromPHPs="+fromPHPs);
		try{
			var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
			if(fromPHPobj["login"]){
				updateHide();
				loadOrders();
				showPlusMinus();
				if(fromPHPobj["status"])
					document.getElementById("note").innerHTML='<span>Дубль ордера удален!</span>';
				else
					document.getElementById("note").innerHTML='<span>Дубль ордера удалить не удалось!</span>';
			}else{
				logout();
			}
		}catch(e){
		   alert("DeleteDublClick "+e);
		}
	}
  }
  var data=new Object();
data.a_id=document.getElementById("valueSelectOrderId").value; 
data.week=selWeek;
data.month=selMonth;
data.year=selYear;
	if(data.a_id==""){
		alert("Вы не выбрали ордер?");
	}else{
	xmlhttp.open("POST","scr_orders.php?timeStamp="+new Date().getTime()+"&f=12",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("data="+JSON.stringify(data));
	}
	//alert("Посылаем запрос в "+new Date());
}
///////////////////////////////////////////////




//////////////////////////////////////////////

// очистка полей ордера, моделей и количества
function clearInput(){
	document.getElementById("aOrder").value="";
	
	for(var i=0;i<5;i++){
		document.getElementById("aModel[i]").value='';
		document.getElementById("aCount[i]").value='';
	}
}

