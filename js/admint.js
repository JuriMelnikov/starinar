function getXmlHttp(){
  var xmlhttp;
  try {
    xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
  } catch (e) {
    try {
      xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    } catch (E) {
      xmlhttp = false;
    }
  }
  if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
    xmlhttp = new XMLHttpRequest();
  }
  return xmlhttp;
}

function loadWeekOrders(){
	var aWeek=document.getElementById("aWeek").value;
	alert(aWeek);
	var xmlHTTP=getXmlHttp();
		xmlHTTP.open('GET', 'localhost/svei/admin.php?aWeek='+aWeek, true);
		xmlHTTP.onreadystatechange = function() {
			if (xmlHTTPp.readyState == 4) {
				if(xmlHTTP.status == 200) {
					alert(xmlHTTP.responseText);
				}
			}
		}	
		xmlHTTP.send(null);
		
	
}

	
