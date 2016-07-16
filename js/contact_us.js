var filter=/^.+@.+\..{2,3}$/;
var value;

/**
* call this function after click on the submit button in the contact us page.
*/
function getData()
{
	document.getElementById("error_msg").style.display='none';
	handleProcessMsg("block","divProcess");
	var subject=document.getElementById("subject").value;
	var firstName=document.getElementById("fname").value;
	var lastName=document.getElementById("lname").value;
	var contactNo=document.getElementById("cno").value;
	var email=document.getElementById("email").value;
	var organisation=document.getElementById("organisation").value;
	var selection=document.getElementById("select").value;
	var otherVal=document.getElementById("textArea").value;
	var comment=document.getElementById("comment").value;
	
	if(subject == "" || firstName == "" || lastName == "" || contactNo == "" || email == "" || selection == ""){
		value=1 ;
		return checkFields(value);
		
	} else if (!isNumeric(contactNo)){
		value=2 ;
		return checkFields(value);
		
	} else if (contactNo.length<8){
		value=3 ;
		return checkFields(value);
	
	} else if( !(filter.test(email)) ){
		value=4 ;
		return checkFields(value);
	
	} else if (selection == 'other' ){
		if(otherVal == ""){
			value=1;
			return checkFields(value);
			
		} else{
			return submitData(subject, firstName, lastName, contactNo, email, organisation, selection, otherVal, comment);	
		}
	} else{
			return submitData(subject, firstName, lastName, contactNo, email, organisation, selection, otherVal, comment);
	}
	handleProcessMsg("none","divProcess");
}

/**
* check	numeric, spaces and dashes have or not in the telephone number
*/
function isNumeric(contactNo) 
{
	var ValidChars = "01234567 89-+";
   	var IsNumber=true;
   	var Char;

	for (i = 0; i < contactNo.length && IsNumber == true; i++) 
	{ 
		Char = contactNo.charAt(i); 
		if (ValidChars.indexOf(Char) == -1) 
		{
			IsNumber = false;
		}
	}
   return IsNumber;
}

/**
* Call this function to get the messages of success or error.
*/
function checkFields(value)
{
	createRequest();
	var url = "bin/ajax/contact_us.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = updateDataPage;
	request.send("val=" + value);
}

function updateDataPage()
{
	if(request.readyState == 4){
		handleProcessMsg("none","divProcess");
		var blankMessage=request.responseText;
		document.getElementById("error_msg").style.display='block';
		document.getElementById("error_msg").innerHTML= blankMessage;
	}
}

/** 
* Call this, after client side validation and call to php page and do server side validation and print success or error message
*/
function submitData(subject, firstName, lastName, contactNo, email, organisation, selection, otherVal, comment)
{
	document.getElementById("error_msg").style.display='none';
	
	createRequest();
	var url = "bin/ajax/contact_us.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = submitDataPage;
	request.send("subj=" + subject + "&fn=" + firstName + "&ln=" + lastName +"&cn=" + contactNo +"&email=" + email +"&orga=" + organisation +"&sele=" + selection +"&comme=" + comment +"&other=" + otherVal);
}

function submitDataPage()
{
	if(request.readyState == 4){
		handleProcessMsg("none","divProcess");
		var displayData=request.responseText;
		var suc_err = displayData.split("||");
		
		document.getElementById("error_msg").style.display='block';
		document.getElementById("error_msg").innerHTML = suc_err[0];
		
		if(suc_err[1]=="SUC")
		{
			document.getElementById("subject").value="";
			document.getElementById("fname").value="";
			document.getElementById("lname").value="";
			document.getElementById("cno").value="";
			document.getElementById("email").value="";
			document.getElementById("organisation").value="";
			document.getElementById("select").value="";
			document.getElementById("otherWay").style.display='none';
			document.getElementById("textArea").value="";
			document.getElementById("comment").value="";
		}
	}
}

/**
* Call this at the onchage event in dropdown list in the contact us form and if selected option is "Other", display the textarea.
*/
function displayTextBox()
{	
	document.getElementById("otherWay").style.display='none';
	document.getElementById("textArea").value="";
	var selection=document.getElementById("select").value;
	if (selection == 'other' ){
		handleProcessMsg("block","divProcess");
		document.getElementById("otherWay").style.display='block';
		handleProcessMsg("none","divProcess");
	}
}

/**
* call this, at the onload funtion in body tag and reset the page when click on refresh button in the browser window. 
*/
function resetDropdown()
{
	document.getElementById("otherWay").style.display='none';
	document.getElementById("select").value="";
	document.getElementById("textArea").value="";
}