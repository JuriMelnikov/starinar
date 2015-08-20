$(document).ready(function(){
setCurrentWeek(); loadFamily(); loadOrder();
 });	
function setCurrentWeek(){
	var cd=new Date();
		//alert(cd);
		var Year=cd.getFullYear();//alert(Year);
		var Month=cd.getMonth()+1;//
		//alert("Месяц "+Month);
				d0 = new Date(Year,0,1); 
				d1 = new Date(); 
				dt = (d0.getTime() - d1.getTime()) / (1000*60*60*24*7); 
				

		var n=Math.round(dt);
			n=Math.abs(n);
		var objSelW = document.getElementById("sWeek");
		for(var i=0;i<53;i++){
			objSelW.options[i]=new Option(i,i);
			}
		objSelW.selectedIndex = n; // устанавливаем текущий номер недели
		
		//////////////////////	
		var obj=document.getElementById("sYear");
		
		obj.options.length=0;
		for(var j=Year-2;j<Year+1;j++){
			var option = document.createElement("option");
			option.text=j;
			option.value=j;
			obj.add(option,null);
		}
		document.getElementById("sYear").value = Year;
	
}



//создание объекта XMLHttpRequest
/*function ajaxConnect() {
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
*/
//////////////////////////////////////////////////////////

//исполняется при загрузке страницы
function loadFamily(){

	var url="scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=1";

	$.ajax({
			url:	url,
			type: 'POST',
			dataType: 'JSON',
			
			success: function(response,code){
				var fromPHPs=response;
				alert("loadFamily.fromPHPs="+fromPHPs);
				try{
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					var objSel = document.getElementById("sSelectNameFamily");
						option = document.createElement("option");
							option.text="";
							option.value="";
							objSel.add(option, null);
						for(var i in fromPHPobj){
							option = document.createElement("option");
							option.text=fromPHPobj[i]['family']+' '+fromPHPobj[i]['name'];
							option.value=fromPHPobj[i]['w_id'];
							objSel.add(option, null);
						}
						
				arrToWork=[]; //создаем глобальный пустой массив для хранения выбранных ордеров, чтобы послать их в базу в функции btnAdd
				//Всякий раз при выборе фамилии этот массив переписывается.
						
				}catch(e){
					alert("Что то не то с ответом :( loadFamily");
				} 
			}
			
		})	
}


// Получаем данные из таблицы ns_admin за указанную неделю указанного года
function loadOrder(){
	data=new Object();
	data.sWeek=document.getElementById("sWeek").value; //указываем неделю
	data.sYear=document.getElementById("sYear").value;// указываем год для считывания данных
	var url="scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=2";
	var value="value="+JSON.stringify(data);
	alert("value="+value);
	$.ajax({
			url:	url,
			type: 'POST',
			dataType: 'JSON',
			data: value,
			success: function(response,code){
			var fromPHPs=response;
				alert("fromPHPs="+fromPHPs);
				try{
				//Глобальный массив со всеми ордерами за указанную неделю и год
				arOrders=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					var objSel = document.getElementById("sOrder");
						objSel.options.length=0;
						option = document.createElement("option");
								option.text="";
								option.value="";
								objSel.add(option, null);
						for(var i in arOrders){
								option = document.createElement("option");
								option.text=arOrders[i]['aOrder'];
								option.value=arOrders[i]['a_id'];
								objSel.add(option, null);
						}
						
				}catch(e){
					alert("Что то не то с ответом в loadOrder :(");
				} 
			}
			
			
		})	
}


function selectOrder(){
	var objSel = document.getElementById("sModel");
				objSel.options.length=0;
				option = document.createElement("option");
						option.text="";
						option.value="";
						objSel.add(option, null);
				for(var i in arOrders){
					if (arOrders[i]["a_id"]==document.getElementById("sOrder").value){
					
					for(var n=1;n<5;n++){
						option = document.createElement("option");
						option.text=arOrders[i]['aModel'+n];
						option.value=arOrders[i]['aCount'+n];
						objSel.add(option, null);
					}
					}
				}
				
		
	
}

function selectModel(){
var objSel = document.getElementById("sCount");
	objSel.options.length=0;
	
	var n=1;
	var k=document.getElementById("sModel").value;
	//alert("k="+k);
	while(n<=k){
		option = document.createElement("option");
		option.text=n;
		option.value=n;
		objSel.add(option, null);
		n++
	}

		var url="scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=3";
		
		$.ajax({
			url:	url,
			type: 'POST',
			dataType: 'JSON',
			
			success: function(response,code){
				var fromPHPs=response;
			//alert("fromPHPs="+fromPHPs);
				try{
					//Глобальный массив со всеми ордерами за указанную неделю и год
					operateList=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					var objSel = document.getElementById("sOperate");
					objSel.options.length=0;
					option = document.createElement("option");
					option.text="";
					option.value="";
					objSel.add(option, null);
					for(var i in operateList){
						option = document.createElement("option");
						option.text=operateList[i]["t_id"];
						option.value=operateList[i]["t_id"];
						objSel.add(option, null);
					
					}
				}catch(e){
				alert("Что то не то с ответом в selectModel :(");
				} 
			}
			
		})		
	
}	

function selectOperate(t_id){
	for(var i in operateList){
		if(operateList[i]["t_id"]==t_id)document.getElementById("sRaportOperate").value=operateList[i]["descript"];
		
	}
}

function addOperateToList(){

ToWorkList=new Object();
ToWorkList.family=document.getElementById("sSelectNameFamily").value;
ToWorkList.Year=document.getElementById("sYear").value;
ToWorkList.week=document.getElementById("sWeek").value;
ToWorkList.order=document.getElementById("sOrder").value;

ToWorkList.model=document.getElementById("sModel").value;
ToWorkList.operate=document.getElementById("sOperate").value;
	for(var i in operateList){
		if(operateList[i]["t_id"]==ToWorkList.operate){
		ToWorkList.order=operateList[i]["order"];
		ToWorkList.year=operateList[i]["year"];
		ToWorkList.week=operateList[i]["week"];
			ToWorkList.price=operateList[i]["eur"];
			ToWorkList.time="0";
		}
	}
ToWorkList.cost=document.getElementById("sCount").value;

	var objSel = document.getElementById("sList");
		option = document.createElement("option");
		option.text="Модель: "+ToWorkList.model+". Количество: "+ToWorkList.cost+". Стоимость (EEK="+ToWorkList.price/16,6+", EUR="+ToWorkList.price+")";
		option.value=document.getElementById("sList").options.length+1;
		objSel.add(option, null);
	arrToWork[arrToWork.length]=ToWorkList;
}



function btnAdd(){


	var url="scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=4";
	var value="data="+JSON.stringify(arrToWork);//
	$.ajax({
		url:	url,
		type: 'POST',
		dataType: 'JSON',
		data: value,
		success: function(response,code){
			var fromPHPs=response;
				alert("fromPHPs="+fromPHPs);
				try{
				//Глобальный массив со всеми ордерами за указанную неделю и год
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
					if (fromPHPobj=="ok"){
						arrToWork.length=0;
						ToWorkList.length=0;
						document.getElementById("sList").options.length=0;
						
						alert("Ваши данные добавлены!");
					}
				
				}catch(e){
					alert("Что то не то с ответом :( btnAdd");
				} 
		
		}
		
	})		
}

function selectFamily(w_id){

var url="scr_seamstress.php?timeStamp="+new Date().getTime()+"&f=5";
var value="data="+JSON.stringify(w_id);//
	$.ajax({
		url:	url,
		type: 'POST',
		dataType: 'JSON',
		data: value,
		success: function(response,code){
			var fromPHPs=response;
			alert("fromPHPs="+fromPHPs);
			try{
				//Глобальный массив со всеми ордерами за указанную неделю и год
				var fromPHPobj=!(/[^,:{}[]0-9.-+Eaeflnr-u nrt]/.test(fromPHPs.replace(/"(.|[^"])*"/g, ''))) && eval("(" + fromPHPs + ")");
				var tblTr='';
				tblTr+='<table id="tbl"><tr id="trTable">';
				tblTr+='<td id="tdId">ID</td>';
				tblTr+='<td id="tdFamily">Фамилия</td>';
				tblTr+='<td id="tdOrder">Ордер</td>';
				tblTr+='<td id="tdOperate">Операция</td>';
				tblTr+='<td id="tdCost">Количество</td>';
				tblTr+='<td id="tdPrice">Расценка</td>';
				tblTr+='<td id="tdAll">Стоимость</td>';
				tblTr+='</tr>';
				var i=0;
				
				for(i in fromPHPobj){
					
					tblTr +='<tr class="trTable"><td class="tdId">'+fromPHPobj[i]["num"];
					tblTr += '</td><td class="tdFamily">'+fromPHPobj[i]["descript"]+'</td>';
					tblTr += '<td class="tdOrder">'+fromPHPobj[i]["dimension"];
					tblTr += '</td><td class="tdOperate">'+fromPHPobj[i]["eek"];
					tblTr += '</td><td class="tdCost">'+fromPHPobj[i]["eur"];
					tblTr += '</td><td class="tdPrice">'+fromPHPobj[i]["eur"];
					tblTr += '</td><td class="tdAll">'+fromPHPobj[i]["eur"];
					tblTr += '</td></tr>';
				}
				tblTr+='</table>';
				//alert ("tblTr="+tblTr);
				document.getElementById("spanTable").innerHTML=tblTr;
			
			
			}catch(e){
				alert("Что то не то с ответом :( btnAdd");
			} 
		
		}
	})
}






