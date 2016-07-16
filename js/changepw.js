	function changePassword(customerId, parameter1, parameter2, parameter3)  
	{  		 
		createRequest();
		request.open("POST", 'changepw.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{ 
    			document.getElementById("result_pw").innerHTML = request.responseText;
    		}
    	}; 
    	request.send("customerId="+customerId+"&"+"password="+parameter1+"&"+"newPassword="+parameter2+"&"+"confirmNewPassword="+parameter3); 
	}