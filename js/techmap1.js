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

///////////////////////////////////////////////////

//исполняется при загрузке страницы
function loadList(){
//hiddenInsert()
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	//alert("Сейчас будет ответ");
	var fromPHPs=xmlhttp.responseText;
	alert("fromPHPs="+fromPHPs);
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	var tblTr='';
		tblTr+='<table id="tbl"><tr id="trTable">';
		tblTr+='<td id="tdNomer">№</td>';
		tblTr+='<td id="tdDescript">Описание</td>';
		tblTr+='<td id="tdDimension">Пояснения</td>';
		tblTr+='<td id="tdEek">Стоимость<br /> в EEK</td>';
		tblTr+='<td id="tdEur">Стоимость<br /> в EUR</td>';
		tblTr+='<td id="tdSection">Раздел</td>';
		tblTr+='</tr>';
	for(var i in fromPHPobj){
		tblTr +='<tr class="trTable"><td class="tdNomer">'+fromPHPobj[i]["num"];
		tblTr += '</td><td class="tdDescript">'+fromPHPobj[i]["descript"];
		tblTr += '</td><td class="tdDimension">'+fromPHPobj[i]["dimension"];
		tblTr += '</td><td class="tdEek">'+fromPHPobj[i]["eek"];
		tblTr += '</td><td class="tdEur>'+fromPHPobj[i]["eur"];
		tblTr += '</td><td class="tdSection">'+fromPHPobj[i]["section"]+'</td></tr>';
	}
	tblTr+='</table>';
	document.getElementById("spanTable").innerHTML=tblTr;
	//alert("fromPHPobj.length="+fromPHPobj.length);
	//alert("fromPHPobj.descript="+fromPHPobj.descript);
	//document.getElementById("note").innerHTML='<div id="note">'+fromPHPobj.text+'</div>';
	var objSel = document.getElementById("tList");
	objSel.options.length=0;
			for(var i in fromPHPobj){
				var option = document.createElement("option");
				option.text=fromPHPobj[i]['num']+'. '+fromPHPobj[i]['descript']+'; '
				+fromPHPobj[i]['dimension']+'; '+fromPHPobj[i]['eek']+'; '+fromPHPobj[i]['eur']+'; '
				+fromPHPobj[i]['section'];
				option.value=fromPHPobj[i]['t_id'];
				objSel.add(option, null);
			}
	//document.getElementById("tList").innerHTML=fromPHPobj.aList;

	}
  }
//var data=new Object();
//alert("f="+data.f);
//alert(JSON.stringify(data));
	
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=1",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send();
		//alert("Посылаем запрос в "+new Date());
	
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
	//alert("fromPHPs="+fromPHPs);
	//alert("Сейчас запустим loadList");
	
	try{
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
	//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
	document.getElementById("note").innerHTML='<span id=\"spanNote\">'+fromPHPobj.text+'</span>';
	//document.getElementById("aList").innerHTML=fromPHPobj.aList;
	loadList();
	}catch(e){alert("Что то не так с возвратом");}
  }
 }
var data=new Object();
data.num=document.getElementById("nomer").value; 
data.descript=document.getElementById("descript").value;
data.dimension=document.getElementById("dimension").value;
data.eek=document.getElementById("eek").value;
data.eur=document.getElementById("eur").value;
data.section=document.getElementById("section").value;
data.f='2';
//alert("f="+data.f);
//alert("value="+JSON.stringify(data));
	if(data.num=="" || data.descript=="" || data.dimension=="" || data.eur=="" || data.section==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=2",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("value="+JSON.stringify(data));
		//alert("Посылаем запрос в scr_techmap.php");
	}
}

// обрабатывает выбор строки в списке 
function listClick(){
var xmlhttp=ajaxConnect();  
xmlhttp.onreadystatechange=function()
{
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
  {
	var fromPHPs=xmlhttp.responseText;
	//alert("Получено от сервера: "+fromPHPs);
	var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	//var fromPHPobj = JSON.parse(fromPHPs);
	//var s=formPHPobj.aOrder;
	//alert("Ответ от сервера получен");
	//alert("aOrder="+ fromPHPobj["aOrder"]);
	document.getElementById("t_id").value=fromPHPobj["t_id"];
    document.getElementById("nomer").value=fromPHPobj["num"];
	document.getElementById("descript").value=fromPHPobj["descript"]; 
	document.getElementById("dimension").value=fromPHPobj["dimension"];
	document.getElementById("eek").value=fromPHPobj["eek"]; 
	document.getElementById("eur").value=fromPHPobj["eur"];
	document.getElementById("section").value=fromPHPobj["section"]; 
  }
}

var t_idList=document.getElementById("tList").value;

//alert(Week+Year+str);
xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=5",true);
xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
//alert("scr_admin.php?aList="+str+"&aWeek="+Week+"&aYear="+Year+"&f=2");
//document.getElementById("aOrder").value=str;
xmlhttp.send("t_idList="+t_idList);
//alert("запрос отправлен! ");		
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
	//alert("fromPHPs="+fromPHPs);
	//alert("Сейчас запустим loadList");
	try{
		var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
	
		//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
		document.getElementById("note").innerHTML='<span id=\"spanNote\">'+fromPHPobj.text+'</span>';
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		loadList();
		document.getElementById("t_id").value="";
		document.getElementById("nomer").value="";
		document.getElementById("descript").value="";
		document.getElementById("dimension").value="";
		document.getElementById("eek").value="";
		document.getElementById("eur").value="";
		document.getElementById("section").value="";
	}catch(e){
		alert("Что то не так с возвратом");
	}
  }
 }
var data=new Object();
data.t_id=document.getElementById("t_id").value;
data.num=document.getElementById("nomer").value; 
data.descript=document.getElementById("descript").value;
data.dimension=document.getElementById("dimension").value;
data.eek=document.getElementById("eek").value;
data.eur=document.getElementById("eur").value;
data.section=document.getElementById("section").value;

//alert("f="+data.f);
//alert("value="+JSON.stringify(data));
	if(data.num=="" || data.descript=="" || data.dimension=="" || data.eur=="" || data.section==""){
		alert("Вы не заполнили необходимые поля");
	}else{
		xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=3",true);
		xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		xmlhttp.send("value="+JSON.stringify(data));
		//alert("Посылаем запрос в scr_techmap.php");
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
		//var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
		//alert(fromPHPobj.text+" : "+fromPHPobj.aList);
		document.getElementById("note").innerHTML='<span>'+fromPHPs+'</span>';
		loadList();
		document.getElementById("t_id").value="";
		document.getElementById("nomer").value="";
		document.getElementById("descript").value="";
		document.getElementById("dimension").value="";
		document.getElementById("eek").value="";
		document.getElementById("eur").value="";
		document.getElementById("section").value="";
		//document.getElementById("aList").innerHTML=fromPHPobj.aList;
		// clearInput();
	}
  }

var t_id=document.getElementById("t_id").value; 
//alert("t_id="+t_id);
//alert("f="+data.f+"aList="+data.a_id);
//alert("value="+JSON.stringify(data));
if(t_id==""){
	alert("Вы не выбрали строду для удаления");	
}else {xmlhttp.open("POST","scr_techmap.php?timeStamp="+new Date().getTime()+"&f=4",true);
	xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
	xmlhttp.send("t_id="+t_id);
}
}