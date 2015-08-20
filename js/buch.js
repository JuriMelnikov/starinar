
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

function printIt(){ 
	document.getElementById("toPrint").style.display="none";
	document.getElementById("btnLogout").style.display="none";
	document.getElementById("back").style.display="none";
	
	//document.getElementById("addvPer").style.display="none";
	
		window.print(); 
	
}

function selMonth(){
document.getElementById("selFamily").selectedIndex=-1;
document.getElementById("divTable").innerHTML='';
}
function selYear(){
document.getElementById("selFamily").selectedIndex=-1;
document.getElementById("divTable").innerHTML='';
}
function logout(){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function(){
		if (xmlhttp.readyState==4 && xmlhttp.status==200){
			 var fromPHPs=xmlhttp.responseText;
				
			//alert("logout.fromPHPs="+fromPHPs);
			try{
				location.reload();
			}catch(e){
				alert("logout: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=4",false);
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
					//alert("loginCheck="+fromPHPobj["loginCheck"]);
				}else{
					if(fromPHPobj["levelM"]<0)document.getElementById("back").style.display="block";
				//alert("loginCheck="+fromPHPobj["loginCheck"]);
					 // Отключаем окно
					$('#loginWindow').hide();
					// Выключаем задник
					//if(document.getElementById("bgOverlay").style.display="block") 
					$('#bgOverlay').empty();
					second=0;
					clearInterval(setIntervalID);
					loadAppointments();
					//btnDisabled(true);
				}
			}catch(e){
				alert("loginCheck: "+e);
			}
		
		}
	}
	xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=0",false);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send();
}	
function showLoginWindow($count){
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
    $('#loginWindow').hide();
    // Выключаем задник
    $('#bgOverlay').empty();
	clearInterval(setIntervalID);
	loadAppointments();
	//loginCheck();
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
					/* document.getElementById("delay_txt").innerHTML='<H3><font color="red">У Вас нет прав на вход!</font><br>Начать авторизацию можно через <span id="sec">'+delay+'</span>&nbsp;секунд.</H3>';
					second=1;
					clearInterval(setIntervalID);
					setIntervalID=setInterval('display()',1000); */
				}else{
					if(fromPHPobj["levelM"]<0)document.getElementById("back").style.display="block";
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
		xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=0",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
}	

function loadAppointments(){
var xmlhttp=ajaxConnect();  
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				
				var fromPHPs=xmlhttp.responseText;
	//alert("loadAppolointments.fromPHPs="+fromPHPs);
				try{
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					var objSel = document.getElementById("selAppointment");
					objSel.options.length=0;
					var index=0;
//alert("filtr="+fromPHPobj['filtr']);
					for( var i in fromPHPobj["appointments"]){
						option = document.createElement("option");
							option.text=fromPHPobj['appointments'][i];
							option.value=fromPHPobj['wa_id'][i];
							objSel.add(option, null);
							if(fromPHPobj['wa_id'][i]==fromPHPobj['filtr']){
								//alert("index="+i);
								index=i;
							}

					}
					objSel.selectedIndex=index-1;
					
			setSelected();	
				}catch(e){
					alert("Что то не то с ответом setSelected: "+e);
				} 		
			}
			
	}			
		xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=3",false);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
		
}
function setSelected(){

	var xmlhttp=ajaxConnect();  
	
	xmlhttp.onreadystatechange=function()
	{
		if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				
				var fromPHPs=xmlhttp.responseText;
		//alert("setSelected.fromPHPs="+fromPHPs);
				try{
					var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					
					var cd=new Date();
					//alert(cd);
					var Year=cd.getFullYear();//alert(Year);
				
					var objSel2 = document.getElementById("selFamily");
					objSel2.options.length=0;
					option2 = document.createElement("option");
							option2.text="ВСЕ РАБОТНИКИ";
							option2.value='0';
							objSel2.add(option2, null);
					var i=0;
					for( i in fromPHPobj["family"]){
						option2 = document.createElement("option");
							option2.text=fromPHPobj['family'][i]+' '+fromPHPobj['name'][i];
							option2.value=fromPHPobj['w_id'][i];
							objSel2.add(option2, null);
							//alert(option2.text);
					}
					objSel2.selectedIndex=-1;
					
					var obj = document.getElementById("selMonth");
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
					//document.getElementById("divCalendar").innerHTML = fromPHPobj["calendar"];
					//loadOrders();
				}catch(e){
					alert("Что то не то с ответом setSelected: "+e);
				} 		
			
			}
			
	}	
var data={};
data.wa_id=document.getElementById("selAppointment").value;
		xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=1",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
		//alert("Посылаем запрос в "+new Date());
	
	
}
function loadPalk(w_id){
var xmlhttp=ajaxConnect();  
	xmlhttp.onreadystatechange=function()
	{
	  if (xmlhttp.readyState==4 && xmlhttp.status==200)
		{		
			var fromPHPs=xmlhttp.responseText;
		//alert("loadPalk.fromPHPs="+fromPHPs);
			try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				if(fromPHPobj["login"]!=0){
					if(fromPHPobj["f"]==0){
						var tbBuch='<table id="tbBuch"><tr><th id="thN">№</th><th id="thFamily">Имя Фамилия</th><th id="thTime">Время</th><th id="thSum">Сумма</th></tr>';
						var n=1;
						for(var i in fromPHPobj["data"]){
							
								tbBuch+='<tr><td class="tdN">'+n+'</td><td class="tdFamily">'+fromPHPobj["data"][i]["family"]+' '+fromPHPobj["data"][i]["name"]+'</td>';
								tbBuch+='<td class="tdTime">'+fromPHPobj["data"][i]["sumTime"]+'</td>';
								tbBuch+='<td class="tdSum">'+fromPHPobj["data"][i]["sumPrice"]+'</td></tr>';
							n++;
						}
						tbBuch+='<tr><td id="tdKokku" colspan="3">Всего: </td><td id="tdKokkuRez">'+fromPHPobj["kokku"]+'</td></tr>';
						tbBuch+='</table>';
						document.getElementById("divTable").innerHTML=tbBuch;
					}else if(fromPHPobj["f"]==1){
						var tbBuch='<table id="tbBuch"><tr><th id="thFamily">Фамилия Имя </th><th id="thTime">Время</th><th id="thSum">Сумма</th></tr>';
						tbBuch+='<tr><td class="tdFamily">'+fromPHPobj["family"]+' '+fromPHPobj["name"]+'</td><td class="tdTime">'+fromPHPobj["sumTime"]+'</td><td class="tdSum">'+fromPHPobj["sumPrice"]+'</tr>';
						
						tbBuch+='</table>';
						document.getElementById("divTable").innerHTML=tbBuch;
					}
					document.getElementById("toPrint").style.display="block";
					document.getElementById("btnLogout").style.display="block";
										
					if(fromPHPobj["login"]<0)document.getElementById("back").style.display="block";
				}
			}catch(e){
				alert("Что то не то с ответом loadPalk: "+e);
			} 		
		
		}
	}	
	
	var data={};
	
	data.w_id=w_id;
	data.wa_id=document.getElementById("selAppointment").value;
	data.month=document.getElementById("selMonth").value;
	data.year=document.getElementById("selYear").value;
	// var parentDiv=document.getElementById("fList");
	// var k=parentDiv.getElementsByTagName('input').length;
	
	if( data.wa_id=='' && data.month=='' && data.year==''){
		alert("Вы не корректно ввели данные!");
	}else{
		xmlhttp.open("POST","scr_buch.php?timeStamp="+new Date().getTime()+"&f=2",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("data="+JSON.stringify(data));
	}
//alert("data="+JSON.stringify(data)+" add1="+JSON.stringify(add1)+" add2="+JSON.stringify(add2));	
}
