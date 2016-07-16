	
	function updateContact(customerId, parameter1, parameter2, parameter3)  
	{  		
            //alert("customerId="+customerId+"&"+"phone="+parameter1+"&"+"fax="+parameter2+"&"+"mobile="+parameter3);
		createRequest();
		request.open("POST", 'update_contact.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{ 
    			document.getElementById("contact_result").innerHTML = request.responseText; 
    		}
    	}; 
    	request.send("customerId="+customerId+"&"+"phone="+parameter1+"&"+"fax="+parameter2+"&"+"mobile="+parameter3);
	}
        
        function updateBusiness(customerId, parameter1, parameter2, parameter3, parameter4, parameter5)  
	{  
            
		createRequest();
		request.open("POST", 'update_business.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{ 
    			document.getElementById("business_result").innerHTML = request.responseText; 
    		}
    	}; 
    	request.send("customerId="+customerId+"&"+"mon="+parameter1+"&"+"sat="+parameter2+"&"+"sun="+parameter3+"&"+"website="+parameter4+"&"+"show_website="+parameter5);
	}
	
	
	function updatePersonal(customerId, parameter1, parameter2, parameter3, parameter4, parameter5)  
	{  	
            
		createRequest();
		request.open("POST", 'update_personal.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{
    			var message=request.responseText;
                var suc_err = message.split("||");
                if(suc_err[1] == "ERR")
                    {
                    document.getElementById("personal_result").innerHTML= suc_err[0];

                } else
                {
                    document.getElementById("personal_result").innerHTML= suc_err[0];
                    //document.getElementById("header_user_name").innerHTML = suc_err[2];
                }
            }
    	}; 
    	request.send("customerId="+customerId+"&"+"title="+parameter1+"&"+"fName="+parameter2+"&"+"lName="+parameter3+"&"+"email="+parameter4+"&"+"emailConfirm="+parameter5);
	}
	
	function updateAddress(customerId, parameter1, parameter2, parameter3, parameter4, parameter5,parameter6, parameter7, parameter8)
	{
                parameter1 = encodeURIComponent(parameter1);
		createRequest();
		request.open("POST", 'update_address.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{
    			document.getElementById("address_result").innerHTML = request.responseText; 
    		}
    	}; 
        document.getElementById("header_user_name").innerHTML = parameter1;
    	request.send("customerId="+customerId+"&"+"company="+parameter1+"&"+"address="+parameter2+"&"+"street="+parameter3+"&"+"city="+parameter4+"&"+"postcode="+parameter5+"&"+"country="+parameter6+"&"+"latitude="+parameter7+"&"+"longitude="+parameter8);
	}
	
	function callAjax()
	{ 
		//updateAddress(document.address_details.customerId.value, document.address_details.company.value, document.address_details.address.value, document.address_details.street.value, document.address_details.city.value, document.address_details.postcode.value, document.address_details.country.value, document.address_details.confirmedLatitude.value, document.address_details.confirmedLongitude.value);
	}
	
	function clearMessage(resultArea)
	{
		document.getElementById(resultArea).innerHTML = ""; 
	}

/*
 *Tab control to the profile editng section
 **/

function showProfilePersonal()
{
    document.getElementById("divProfileAddress").style.display='none';
    document.getElementById("divProfileContact").style.display='none';
    document.getElementById("divProfilePersonal").style.display='block';
    document.getElementById("divProfileBusiness").style.display='none';

    document.getElementById("tabProfileAddress").setAttribute("class", "myprofile_tabs_address address_inactive cursorHand");
    document.getElementById("tabProfileContact").setAttribute("class", "myprofile_tabs_contacts contacts_inactive cursorHand");
    document.getElementById("tabProfilePersonal").setAttribute("class", "myprofile_tabs_personal_details  cursorHand");
    document.getElementById("tabProfileBusiness").setAttribute("class", "myprofile_tabs_business business_inactive cursorHand");
    clearProfileMessages();
}

function showProfileAddress()
{
    document.getElementById("divProfileContact").style.display='none';
    document.getElementById("divProfilePersonal").style.display='none';
    document.getElementById("divProfileAddress").style.display='block';
    document.getElementById("divProfileBusiness").style.display='none';

    document.getElementById("tabProfilePersonal").setAttribute("class", "myprofile_tabs_personal_details personal_details_inactive cursorHand");
    document.getElementById("tabProfileAddress").setAttribute("class", "myprofile_tabs_address cursorHand");
    document.getElementById("tabProfileContact").setAttribute("class", "myprofile_tabs_contacts contacts_inactive cursorHand");
    document.getElementById("tabProfileBusiness").setAttribute("class", "myprofile_tabs_business business_inactive cursorHand");

   // To rectifiy the issue found in the address text field 
   document.getElementById("address").style.display='block';
    clearProfileMessages();
}

function showProfileContact()
{
    document.getElementById("divProfilePersonal").style.display='none';
    document.getElementById("divProfileAddress").style.display='none';
    document.getElementById("divProfileContact").style.display='block';
    document.getElementById("divProfileBusiness").style.display='none';
    
    document.getElementById("tabProfilePersonal").setAttribute("class", "myprofile_tabs_personal_details personal_details_inactive cursorHand");
    document.getElementById("tabProfileAddress").setAttribute("class", "myprofile_tabs_address address_inactive cursorHand");
    document.getElementById("tabProfileContact").setAttribute("class", "myprofile_tabs_contacts cursorHand");
    document.getElementById("tabProfileBusiness").setAttribute("class", "myprofile_tabs_business business_inactive cursorHand");
    clearProfileMessages();
}

function showProfileBusiness()
{
    
    document.getElementById("divProfilePersonal").style.display='none';
    document.getElementById("divProfileAddress").style.display='none';
    document.getElementById("divProfileContact").style.display='none';
    document.getElementById("divProfileBusiness").style.display='block';

    document.getElementById("tabProfilePersonal").setAttribute("class", "myprofile_tabs_personal_details personal_details_inactive cursorHand");
    document.getElementById("tabProfileAddress").setAttribute("class", "myprofile_tabs_address address_inactive cursorHand");
    document.getElementById("tabProfileContact").setAttribute("class", "myprofile_tabs_contacts contacts_inactive cursorHand");
    document.getElementById("tabProfileBusiness").setAttribute("class", "myprofile_tabs_business cursorHand");
    clearProfileMessages();
}

function clearProfileMessages()
{
    document.getElementById("personal_result").innerHTML='';
    document.getElementById("contact_result").innerHTML='';
    document.getElementById("address_result").innerHTML='';
}
function changestatus(divId,divTrgt){
    alert(divId);
    if(document.getElementById(divId).checked)
        document.getElementById(divTrgt).value = '1';
        else
             document.getElementById(divTrgt).value = '0';
        
    
}