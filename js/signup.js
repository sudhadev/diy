	/*--------------------------------------------------------------------------\
  '    This file is part of the DIY Project of FUSIS                          '
  '    (C) Copyright www.fusis.com                                            '
  ' ..........................................................................'
  '                                                                           '
  '    AUTHOR          :  Heshan J Peiris <j.heshan@gmail.com>      				'
  '    FILE            :  signup.js                                  			'
  '    PURPOSE         :                             									'
  '    PRE CONDITION   :                                            				'
  '    COMMENTS        :                                                      '
  '--------------------------------------------------------------------------*/
	var validationUrl = "validate.ajax.php";
	
	validationArray["fName"] = false;
	validationArray["lName"] = false;
	validationArray["email"] = false;
	validationArray["emailConfirm"] = false;
	validationArray["password"] = false;
	validationArray["confirmPassword"] = false;
        validationArray["company"] = false;
	validationArray["address"] = false;
	validationArray["street"] = false;
	validationArray["city"] = false;
	validationArray["country"] = true;
	validationArray["phone"] = false;  
        
        
	 
	function requestPackages(type, url)
	{
		createRequest();
		request.open("POST", url, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
		if (type == 'M')
		{
			request.onreadystatechange = showPackagesM;
		}
		else if (type == 'S')
		{
			request.onreadystatechange = showPackagesS;
		}
	 	request.send(null);  
               
	}
	
	function showPackagesM()
	{
		if (request.readyState == 4)
		{		
			document.getElementById("packages_m").innerHTML = request.responseText;  
		}
	}
	
	function showPackagesS()
	{
		if (request.readyState == 4)
		{		
			document.getElementById("packages_s").innerHTML = request.responseText;  
		}
	}
	
	function hidePackages(type)
	{
		 if (type == 'M')
		 {
		 	document.getElementById("packages_s").innerHTML = null; 
		 }
		 else if (type == 'S')
		 {
		 	document.getElementById("packages_m").innerHTML = null; 
		 }	
		 else if (type == 'C')
		 {
		 	document.getElementById("packages_m").innerHTML = null;
		 	document.getElementById("packages_s").innerHTML = null; 
		 }
	}

    function onLoadValidate()
    {
        for(i=0; i<document.forms[0].elements.length; i++)
        {
            if (document.forms[0].elements[i].id != 'title' && document.forms[0].elements[i].id != 'company' && document.forms[0].elements[i].id != 'postcode' && document.forms[0].elements[i].id != 'country' && document.forms[0].elements[i].id != 'fax' && document.forms[0].elements[i].id != 'mobile')
             {
                if (document.forms[0].elements[i].value != '' && document.forms[0].elements[i].id != 'security_code') validationArray[document.forms[0].elements[i].id] = true;
                //validate(document.forms[0].elements[i].id, document.forms[0].elements[i].value);
             }
        }
    }
    
    function requestCaptchaThis(parameter)   
        {
    
    createRequest();
    request.open("POST", 'captcha.ajax.php', true);
    request.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
    request.onreadystatechange = function (){
        if (request.readyState == 4)
        {
            
            if (request.responseText != "" )
            {
                    //img.src = "captcha.php?" + Math.random();
                    document.getElementById('session_captcha').value = 'no';
                    //alert(request.responseText);
                    //return false;
            }
            else{
                
                    //alert('yes');
                    //return true;
                      document.getElementById('session_captcha').value = 'yes';
                      
            }
                
        }
    }
		
    request.send("security_code="+parameter);

}


    function resetVerificationCode(value) 
	{ 
             
         handleProcessMsg('block','preLoaderContainer');
         handleProcessMsg('none','resetted');
          handleProcessMsg('none','validate');
		createRequest();
		request.open("POST", 'reset_verification.ajax.php', true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
		request.onreadystatechange = showMessage;
	 	request.send("uid="+value);  
      
        
}

function showMessage()
	{
		if (request.readyState == 4)
		{

                        handleProcessMsg('none','preLoaderContainer');
                        handleProcessMsg('block','reset_code');
                         handleProcessMsg('block','resetted');
                        //document.getElementById("result").innerHTML = request.responseText;
		}
	}

	
function handleProcessMsg(change,divProcess)
{
    document.getElementById(divProcess).style.display = change;
		
}
//----------------------Validation start----------------------------------------------	
	function validate(value) 
	{        
          
        createRequest();
		request.open("POST", validationUrl, false);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');

    	request.send('fields='+value);
        
        
    	var validationResponse = request.responseText;   
        
        
        

             var cusType = document.reg.cusType.value;
             
             if(cusType=='B'){
                 validationFields = ['fName','lName','email','emailConfirm','password','confirmPassword','security_code'];
             }
             if(cusType=='S'){
                 
                   validationFields = ['fName','lName','email','emailConfirm','password','confirmPassword','company','address','street','city','postcode','country','phone','mobile','fax','security_code'];
             
             }
              
//             capitalFields = ['address','street','city']; 
//             
//             $('#security_code').focus(function(){
//                for(s in capitalFields){
//                // $('#'+capitalFields[s]).capitalize();
//                $('#'+capitalFields[s]).attr('style','text-transform:capitalize');
//             } 
//             });
             
              
                    var pieces = validationResponse.split('||');
                    
                    if(pieces[0]!='suceess'){
                        document.getElementById("validate").innerHTML = pieces[0];
                    }
                    else  if(pieces[0]=='suceess'){
                        document.getElementById("validate").innerHTML = '';
                    }
                    
                     for(i in validationFields){
                      $('#'+validationFields[i]).attr('style','border-color:#CCCCCC !important');
                  } 
                    
                    //alert(pieces[1]);
                    
                    if(pieces[1]!='nothing'){
                        //alert(pieces);
                       
                        var fields = pieces[1].split('|*|');
                                      
                        for(j in fields){
                      
                                 $('#'+fields[j]).attr('style','border-color:red');
                                 
                        }
                         $( 'html, body' ).animate( {scrollTop: 0}, 'medium' );
                         //alert(fields[1]);
                         if(fields[1]!='security_code'){
                             $('#'+fields[1]).focus();
                         }
                         //$('#terms').addAttr("disabled");
                         handleProcessMsg('none', 'checkbox_en');
                         handleProcessMsg('block', 'checkbox');
                        $('#validationFailed').attr('style','display:inline');
                        $('#validationOk').attr('style','display:none;');
                        $('input[name=terms]').attr('style','outline:none');
                         //document.getElementById('checkbox').innerHTML = '<input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatus(this);"/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>';
                        reloadCaptcha();
                         
                    }
                    else if(pieces[2]=='no'){
//                        $('#validationFailed').attr('style','display:none');
//                        $('#button').attr('style','display:inline;cursor:pointer;');
                        //$('input:security_code').focus();
                        //$('#terms').removeAttr("disabled");
                        handleProcessMsg('none', 'checkbox');
                        handleProcessMsg('block', 'checkbox_en');
                        $('input[name=terms]').attr('style','border:none;');
                        if($('#checkbox_status').val()=='yes'){
                         $('#validationOk').attr('style','display:inline');
                        $('#validationFailed').attr('style','display:none;');
                        $('input[name=terms]').attr('style','outline:none');
                        }
                        else{
                         $('#validationFailed').attr('style','display:inline');
                        $('#validationOk').attr('style','display:none;');
                        $('input[name=terms]').attr('style','outline:1px solid red');
                        }
                        return false;
                   }
                              
                    else{
            initialize(); 
            showAddress(document.reg.address.value+' '+document.reg.street.value+' '+document.reg.city.value+' '+document.reg.postcode.value+' '+document.reg.country.value); 
            showMap(); 
            return false;
                    }
                    return false;
	}      

       

        function validateBuyer(value) 
	{        
        
        createRequest();
		request.open("POST", 'validatebuyer.ajax.php', false);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');

    	request.send('fields='+value);
        
        
    	var validationResponse = request.responseText;   
             
             var cusType = document.reg.cusType.value;
             
             if(cusType=='B'){
                 validationFields = ['fName','lName','email','emailConfirm','password','confirmPassword','security_code'];
             }
             if(cusType=='S'){
                 
                   validationFields = ['fName','lName','email','emailConfirm','password','confirmPassword','company','address','street','city','country','phone','mobile','fax','security_code'];
             
             }
             
                   
                    var pieces = validationResponse.split('||');
                    
                    if(pieces[0]!='suceess'){
                        document.getElementById("validate").innerHTML = pieces[0];
                    }
                    else  if(pieces[0]=='suceess'){
                        document.getElementById("validate").innerHTML = '';
                    }
                    
                     for(i in validationFields){
                      $('#'+validationFields[i]).attr('style','border-color:#CCCCCC !important');
                  } 
                    
                    //alert(pieces);
                    
                    
                    
                    if(pieces[1]!='nothing'){
                       // alert(pieces[1]);
                        var fields = pieces[1].split('|*|');
                        
                        for(j in fields){
                      
                                 $('#'+fields[j]).attr('style','border-color:red');
                                 
                        }
                        $( 'html, body' ).animate( {scrollTop: 0}, 'medium' );
                        //document.getElementById('security_code').value = '';
                         if(fields[1]!='security_code'){
                             $('#'+fields[1]).focus();
                         }
                         //$('#terms').addAttr("disabled");
                         $('#validationFailed').attr('style','display:inline');
                        $('#button').attr('style','display:none;');
                         handleProcessMsg('none', 'checkbox_en');
                         handleProcessMsg('block', 'checkbox');
                         $('input[name=terms]').attr('style','outline:none');
                         //document.getElementById('checkbox').innerHTML = '<input type="checkbox" id="terms" name="terms" value="agree" onclick="checkStatus(this);"/> &nbsp; I agree to the <a href="/registration_terms.php" target="_blank">DIY Registration Terms & Conditions</a>';
                        reloadCaptcha();
                        return false;
                    }
                                      
                    
                  else if(pieces[2]=='no'){
//                        $('#validationFailed').attr('style','display:none');
//                        $('#button').attr('style','display:inline;cursor:pointer;');
                        //$('input:security_code').focus();
                        //$('#terms').removeAttr("disabled");
                        handleProcessMsg('none', 'checkbox');
                        handleProcessMsg('block', 'checkbox_en');
                        
                        if($('#checkbox_status').val()=='yes'){
                         $('#button').attr('style','display:inline');
                        $('#validationFailed').attr('style','display:none;');
                        $('input[name=terms]').attr('checked',true);
                        $('input[name=terms]').attr('style','outline:none;');
                        }
                        else{
                         $('#validationFailed').attr('style','display:inline');
                        $('#button').attr('style','display:none;');
                        $('input[name=terms]').attr('checked',false);
                        $('input[name=terms]').attr('style','outline:1px solid red');
                        }
                        return false;
                   }
                              
                    else{
                        document.reg.submit();
                    }   
                        
                  
                    return false;
                       
                  }

        function checkStatus(status){
            //alert($(status).attr("checked"));
            if($(status).is(':checked')){
                $('#validationFailed').attr('style','display:none;');
                $('#validationOk').attr('style','display:inline;cursor:pointer;');
                $('input[name=terms]').attr('style','outline:none');
                $('#checkbox_status').val('yes');
            }
            else {
                $('#validationFailed').attr('style','display:inline;');
                $('#validationOk').attr('style','display:none;');
                $('input[name=terms]').attr('style','outline:1px solid red');
                $('#checkbox_status').val('no');
            }
        }
        
        function checkStatusBuyer(status){
            //alert($(status).is(':checked'));
            if($(status).is(':checked')){
                
                $('#validationFailed').attr('style','display:none;');
                $('#button').attr('style','display:inline;cursor:pointer;');
                $('input[name=terms]').attr('style','outline:none');
                $('#checkbox_status').val('yes');
            }
            else {
                
                $('#validationFailed').attr('style','display:inline;');
                $('#button').attr('style','display:none;');
                $('input[name=terms]').attr('style','outline:1px solid red');
                $('#checkbox_status').val('no');
            }
        }
        
        function validateall(){
            createRequest();
		request.open("POST", validationUrl, false);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
//    	request.onreadystatechange = validatedField;
    	request.send(field + "=" + parameter);
    	var validationResponse = request.responseText;
        
	var str = validationResponse.split("||");
			if (str[0] != "") 
			{ 
				document.getElementById("validate").innerHTML = str[0];
				validationArray[str[1]] = false;
				if(str[2]) validationArray[str[2]] = false; 
				document.getElementById(str[1]).className = 'error';
				if(str[2]) document.getElementById(str[2]).className = 'error';
				return false; 
			}
			else
			{
				document.getElementById("validate").innerHTML = null ;
				validationArray[str[1]] = true; 
				if(str[2]) validationArray[str[2]] = true;
				document.getElementById(str[1]).className = '';
				if(str[2]) document.getElementById(str[2]).className = ''; 
				
				validated=true;
				for (i in validationArray)  
				{
					if(validationArray[i]==false) validated=false; 
				}
					if (validated == true )
					{
						document.getElementById("validationFailed").style.display = 'none';
						document.getElementById("validationOk").style.display = 'block'; 
					}
					else  
					{
						document.getElementById("validationOk").style.display = 'block';
						//document.getElementById("validationFailed").style.display = 'block';
					}
				return true; 	 	  
			} 
          
        }
        
	function validateEmail(parameter1, parameter2)  
	{  		
		createRequest();
		request.open("POST", validationUrl, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = validatedField; 
    	request.send("email="+parameter1+"&"+"emailConfirm="+parameter2);
	}   
	 
	function validatePassword(parameter1, parameter2) 
	{
		createRequest();
		request.open("POST", validationUrl, true);
		request.setRequestHeader( 
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = validatedField;
    	request.send("password="+parameter1+"&"+"confirmPassword="+parameter2);
	} 
	
	function validatedField()  
	{
		if (request.readyState == 4)
		{
			var validationResponse = request.responseText;
			var str = validationResponse.split("||");
			document.getElementById("validate").innerHTML = str[0];
			if (str[0] != "") 
			{ 
				validationArray[str[1]] = false;
				if(str[2]) validationArray[str[2]] = false; 
				document.getElementById(str[1]).className = 'error';
				if(str[2]) document.getElementById(str[2]).className = 'error'; 
			}
			else
			{
				validationArray[str[1]] = true; 
				if(str[2]) validationArray[str[2]] = true;
				document.getElementById(str[1]).className = '';
				if(str[2]) document.getElementById(str[2]).className = ''; 
				
				validated=true;
				for (i in validationArray)  
				{
					if(validationArray[i]==false) validated=false; 
				}
					if (validated == true )
					{
						document.getElementById("validationFailed").style.display = 'none';
						document.getElementById("validationOk").style.display = 'block'; 
					}
					else  
					{
						document.getElementById("validationOk").style.display = 'block';
						//document.getElementById("validationFailed").style.display = 'block';
					} 	  
			}  
		}
	}
//-----------------------Validation end------------------------------------ 	
	
	//Function for ajax form submission 
/*	function requestConfirmation(url) 
	{
		createRequest();
		alert(url); 		
		request.open("POST", url, true);
		request.setRequestHeader( 
			'Content-Type', 
			'application/x-www-form-urlencoded; charset=UTF-8');
		request.onreadystatechange = showConfirmation;
	 	request.send(null); 
	 	return false; 
	}
	
	function showConfirmation()
	{
		document.getElementById("middle_right_bar").innerHTML = request.responseText;
	 
	}*/
	
	function reloadCaptcha()
	{
    	var img = document.getElementById("captcha");
        img.src = "captcha.php?"+Math.random();
    	document.getElementById('security_code').value = '';
	}
	
	function showLoadingImage()
	{
		document.getElementById("loading").innerHTML="<image src='../images/icons/ajax-loader.gif'></image>";
	}

	function hideLoadingImage()
	{
		document.getElementById("loading").innerHTML="";
	}  
        
        function removeMyClass(val){
            
            document.getElementById(val.id).setAttribute('style', 'border-color:none');
        }
        
        function controlCheckbox(checkbox){
            
            if($('input[name=terms]').attr('checked')==true){
                $(checkbox).attr('style','border:none');
            }
            else{
                $(checkbox).attr('style','outline:1px solid red');
            }
            
            
        }
        
$(document).ready(function($) {
if ($.browser.mozilla) {
$("#security_code").keypress(checkForEnter);
} else {
$("#security_code").keydown(checkForEnter);
}
function checkForEnter(event) {
if (event.keyCode == 13) {
$("#validation_button").click();
}
}
});