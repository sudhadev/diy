	
var request = null;
var validationArray = [];
validationArray["security_code"] = false;
 
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

	
function handleProcessMsg(change,divProcess)
{
    document.getElementById(divProcess).style.display = change;
		
}

function toggleTabs(id)
{
    if(document.getElementById(id).style.display=="block")
    {
        document.getElementById(id).style.display = 'none';
    }else
    {
        document.getElementById(id).style.display = 'block';
    }
     
		
}
    
function requestCaptcha(parameter, divId)   
{
    createRequest();
    request.open("POST", 'captcha.ajax.php', true);
    request.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
    request.onreadystatechange = function (){
        if (request.readyState == 4)
        {
            var img = document.getElementById("captcha");
            if (request.responseText != "" )
            {
                validationArray["security_code"] = false;
                document.getElementById(divId).innerHTML = request.responseText;
                document.getElementById("security_code").className = 'error';
                img.src = "captcha.php?" + Math.random();
            }
            else
            {
                validationArray["security_code"] = true;
                document.getElementById(divId).innerHTML = null;
                document.getElementById("security_code").className = '';
				
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
                    document.getElementById("validationOk").style.display = 'none';
                    document.getElementById("validationFailed").style.display = 'block';
                }
            }
        }
    }
		
    request.send("security_code="+parameter);
//alert("ggg"); 
//wait(3000);
//return captchaResponse;
}
	
	
function wait(msecs)
{
    var start = new Date().getTime();
    var cur = start
    while(cur - start < msecs)
    {
        cur = new Date().getTime();
    }
} 
	
function createAjaxRequest() {
    try{
        return new XMLHttpRequest();
    }
    catch (trymicrosoft) {
        try{
            return new ActiveXObject("Msxml12.XMLHTTP");
        }
        catch (othermicrosoft) {
            try{
                return new ActiveXObject("Microsoft.XMLHTTP");
            }
            catch (failed) {
                return null;
            }
        }
    }
}

function debug(msg)
{
    document.getElementById("debug").innerHTML+="<br/>" +msg;
}

function del(id)
{
    if(confirm("Are you sure you want to delete the selected record?"))
    {
        var str = id.split("||");
        if (str[4] == 'spec')
        {
            document.location.href="?action=delete&f="+str[4]+"&category="+str[5]+"&id="+id;
        }
        else if (str[3] == 'cat')
        {
            document.location.href="?action=delete&type="+str[3]+"&category="+str[2]+"&id="+id;
        }
        else
        {
            document.location.href="?action=&action=delete&id="+id;
        }
        
    }
}

function changeText(area,value)
{
    document.getElementById(area).innerHTML = value;
}

function printInvoice(iframeId,url)
{
    if(getBrowser()=='ie')
    {
        print_pg(url) ;
    }
    else
    {
        document.getElementById(iframeId).src=url;
    } 

}

function getBrowser() {
    var sBrowser = navigator.userAgent;
    if (sBrowser.toLowerCase().indexOf('msie') > -1) return 'ie';
    else if (sBrowser.toLowerCase().indexOf('firefox') > -1) return 'firefox';
    else return 'mozilla';
}

function enter_key_pressed(e,module)
{

    if(checkEnter(e)){

        switch(module)
        {
            case "search": // execute the same mechanism of go button in search form
                if(validToSearch()){
                    initialize();showAddress(document.search.address.value);showMap();return false;
                }
                break;
        }
    }
    return true;
}

// Get enter key stroke
function checkEnter(e){ //e is event object passed from function invocation
    var characterCode

    if(e && e.which){ //if which property of event object is supported (NN4)
        e = e
        characterCode = e.which //character code is contained in NN4's which property
    }
    else{
        e = event
        characterCode = e.keyCode //character code is contained in IE's keyCode property
    }

    if(characterCode == 13){
        return true
    }
    else{
        return false
    }

}

function handleSearchFields(optoin,eleName)
{
    var element=document.getElementById(eleName);
    var currentWord=element.value;
    var ghostWord;
    
    switch (eleName)
    {
        case "keyword":
            ghostWord='Plaster or Plasterers';
            break;
        case "address":
            ghostWord='London Regents St or W1B 1JA';
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
var replace = "no";
var desc = "";
function handleText(field,text){
    if(replace=="no"){
        desc = text;
        $('#'+field).text();
        replace = "yes";
    }
    else{
        $('#'+field).val(desc);
        replace = "no";
    }
}

function test()
{

    alert("test");
}
function updateEmailSubscriptions(cus_Id, parameter1, parameter2, parameter3, parameter4, parameter5)
	{
            //alert(cus_Id+parameter1+parameter2+parameter3+parameter4+parameter5);
                //handleProcessMsg('inline', 'preLoaderContainer');
                document.getElementById("email_subscription_result").innerHTML='';
		createRequest();
		request.open("POST", 'email_subscriptions/update_email_subscriptions.ajax.php', true);
		request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
    	request.onreadystatechange = function ()
    	{
    		if (request.readyState == 4)
    		{
    			document.getElementById("email_subscription_result").innerHTML = request.responseText; 
                        //handleProcessMsg('none', 'preLoaderContainer');
    		}
    	}; 
    	request.send("cus_Id="+cus_Id+"&"+"order="+parameter1+"&"+"password="+parameter2+"&"+"expiration="+parameter3+"&"+"renew="+parameter4+"&"+"promo="+parameter5);
	}
        

function showSpecification()
{
    document.getElementById("divDescription").style.display='none';
    document.getElementById("divSpecification").style.display='block';

    document.getElementById("tabDescription").setAttribute("class", "moredetails_tabs_desc desc_inactive cursorHand");
    document.getElementById("tabSpecification").setAttribute("class", "moredetails_tabs_spec cursorHand");
}

function showDescription()
{
    document.getElementById("divDescription").style.display='block';
    document.getElementById("divSpecification").style.display='none';

    document.getElementById("tabSpecification").setAttribute("class", "moredetails_tabs_spec spec_inactive cursorHand");
    document.getElementById("tabDescription").setAttribute("class", "moredetails_tabs_desc cursorHand");
}

