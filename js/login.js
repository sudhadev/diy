	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  login.js                                  				'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/

	function requestForgotPassword(url, parameter)
	{
               
		createRequest();
		request.open("POST", url, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
		request.onreadystatechange = showForgotPassword;
	 	request.send('uid='+parameter);  
	}
	
	function showForgotPassword()
	{
                
		if (request.readyState == 4)
		{
                        
			document.getElementById("middle_right_bar").innerHTML = request.responseText;  
		}
	}
	
	function doReset(url, parameter)
	{

                
                handleProcessMsg('block','preLoaderContainer');
		createRequest();
		request.open("POST", url, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
		request.onreadystatechange = showResult;
	 	request.send("uid="+parameter);  
	}
	
		function showResult()
	{
		if (request.readyState == 4)
		{

                        handleProcessMsg('none','preLoaderContainer');
                        handleProcessMsg('block','password_reset_form');
                        document.getElementById("result").innerHTML = request.responseText;
		}
	}


    function handleLoginFields(optoin,eleName,e)
    {
        var element=document.getElementById(eleName);
        var currentWord=element.value;
        var ghostWord;

        switch (eleName)
        {
            case "uid":
                 ghostWord='Email';
                 break;
            case "pass":
                 ghostWord='';
                 break;
        }


        switch(optoin)
        {
            case "none":
                if(currentWord==ghostWord)
                {
                    element.value="";

                }

                break;
            case "block":

                if(!currentWord)
                {
                    element.value=ghostWord;
                    element.setAttribute("style", "color:#BBB;border:default;")

                }

                break;

            case "change":
                element.setAttribute("style", "color:#333;border:default;")
                break;
        }

    }
    
function eventTrace(e){
        var unicode=e.keyCode? e.keyCode : e.charCode;
        if(unicode=='13'){
            $("#submit_password_reset").click();

        }
    }

		