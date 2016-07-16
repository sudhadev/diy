var reqGlConf =null;

function update(url)
{	
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("page_body").innerHTML= "";
	
	reqGlConf=createAjaxRequest();
	reqGlConf.open("POST", url, true);
			reqGlConf.setRequestHeader(
				'Content-Type', 
				'application/x-www-form-urlencoded; charset=UTF-8');
			reqGlConf.onreadystatechange = getUpdatePage;
	reqGlConf.send(null);
}

function getUpdatePage()
{	
	if(reqGlConf.readyState == 4){	
		var message=reqGlConf.responseText;
		document.getElementById("page_body").innerHTML= message;
	}
}

function getValues(values)
{
	//alert(values);
	var field_and_value = values.split("&");
	
	var arrValues = new Array();
	var arrKeys = new Array();
	var j=0;
	for(var i=1; i<field_and_value.length; i++)
	{
			var val =  field_and_value[i].split("=");	
			var field = val[0];
			var value = val[1];
			
			if(field != "type")
			{
				arrValues[j] = value;
				arrKeys[j] = field;
			}
			j++;
	}
	var type=document.getElementById("type").value;
	
	reqGlConf=createAjaxRequest();
	var url = "global_config.ajax.process.php?arryValues=" + arrValues + "&arryKeys=" + arrKeys + "&val=" + type; 
	reqGlConf.open("GET", url, true);
	reqGlConf.onreadystatechange = getEditDataPage;
	reqGlConf.send(null);
}

function getEditDataPage()
{
	if(reqGlConf.readyState == 4){
		var message=reqGlConf.responseText;
		document.getElementById("divMessage").innerHTML= message;	
	}
}

