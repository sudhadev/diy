	var request = null;

	function createRequest() {
		try{
			request = new XMLHttpRequest(); 
		}
		catch (trymicrosoft) {
			try{
				request = new ActiveXObject("Msxml12.XMLHTTP");
			}
			catch (othermicrosoft) {
				try{
					request = new ActiveXObject("Microsoft.XMLHTTP"); 
				}
				catch (failed) {
					request = null;
				}
			}
		}
		if (request==null)
			alert("Error creating request object");
	}

	function doRequest(parameter)  
	{
		createRequest();
		var url = "http://localhost/diy_v0.1/signup/getCaptcha.php"; 
		request.open("POST", url, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
		request.onreadystatechange = changeCaptcha;
	 	request.send("security_code="+parameter);  
	}
	
	function changeCaptcha()
	{
		if (request.readyState == 4)
		{		
			var img = document.getElementById("captcha");
			alert(request.responseText);
			if (request.responseText == "Error")
			{
				img.src = "http://localhost/diy_v0.1/signup/captcha.php?" + Math.random();
			}
			else 
			{
				exit(); 
			} 
		}
	}


