 $(document).ready(init);

function init(){
$('#btn4').bind('click',btn4Click);
}

function btn4Click(){
	var data=new Object();
	data.Week='23';
	data.Year='2012';
	//

	var value="value="+JSON.stringify(data);

	$('#proba').animate({'margin-top': '300px', 'margin-left': '400px'},1000);
		//alert("value="+value);
		
		
		$.ajax({
			url:'index.php?stamp='+new Date().getTime(),
			type: 'POST',
			dataType: 'JSON',
			data: value,
			success: function(response,code){
				alert("code="+code+" response="+response);
				if(code=='success'){
				var resp=$.evalJSON(response);
					alert('Данные отправлены! Сервер вернул ответ: Week='+resp.Week);
				}else{
					alert('Error!');
				}
			}
			
		})	
	
	/*var d="value="+JSON.stringify(data);
	$.post('index1.php',d,function(success,status){
		if(status=='success'){
			alert("Усе у порядке!"+success);
		}else{
			alert("Ошибочка вышла");
		}
	})*/
}
 
