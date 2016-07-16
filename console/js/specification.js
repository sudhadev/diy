var reqSpec = null;


function getIds(ids)
{
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("specification_body").innerHTML= "";
	document.getElementById("div_Message").style.display='none';
	document.getElementById("divAddBtn").style.display='none';
	document.getElementById("div_Mess").style.display='none';
	document.getElementById("page_body").style.display='none';
        document.getElementById("all_list_spec").style.display='none';
        
	
	var urlValue = location.search.substring(1);
	if(urlValue == "f=add")
	{
		add_spec_tpl();
	} else if(urlValue == "f=list")
	{
		getId_Spec(ids);
	} else if(urlValue == "f=plist")
	{
                resetPlist();
		getId_Spec_pending(ids,'P','specification','1');
	}
}
function getId_Spec_pending(ids,selection,orderByName,pg)
{
	createRequest();
	var url = "specification_list_pending.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getId_SpecPendingPage;
	request.send("ids="+ids+"&selec="+selection+"&orderBy="+orderByName+"&pg="+pg);
}

function getId_SpecPendingPage()
{
        var selection = "";
        //document.getElementById("all_list_active_add_spec_btn").style.display='none';
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == 3)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];

		}else if(suc_err[1] == 0)
		{
			//document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("page_body").style.display='block';

		}else if(suc_err[1] == 2)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
                        document.getElementById("all_list_spec").style.display='block';
                        document.getElementById("specification_body").innerHTML= "";
                        selection = document.getElementById("specification_status").value;
                        if(selection == "Y")
                        {
                             document.getElementById("all_list_active_add_spec_btn").style.display='block';
                        }
			//document.getElementById("div_Message").style.display='block';

		} else if(suc_err[1] == 1)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			//document.getElementById("div_Mess").style.display='block';

		} else
		{
			document.getElementById("specification_body").innerHTML= suc_err[0];
//			var id = cPath.split("_");
//			if(id[0] != 3)
//			{
//				//document.getElementById("divAddBtn").style.display='block';
//                                document.getElementById("all_list_spec").style.display='block';
//                                selection = document.getElementById("specification_status").value;
//                                if(selection == "Y")
//                                {
//                                     document.getElementById("all_list_active_add_spec_btn").style.display='block';
//                                }
//			}
		}
	}
}

function resetPlist()
{
    /*var selection = document.getElementById("specification_status").value;
    if(selection == "Y")
    {
        document.getElementById("sort").style.display='none';
    } else
    {
        document.getElementById("sort").style.display='block';

    }*/
    document.getElementById("specification_status").value = "P";
    document.getElementById("sort").style.display='block';
    document.getElementById("sort_by").value = 'specification';
    //alert("1 "+document.getElementById("specification_status").value);
    //alert("2 "+document.getElementById("sort_by").value);
}

function setAllList()
{
    document.getElementById("specification_body").innerHTML= "";
    document.getElementById("divMessage").innerHTML= "";
    var selection = document.getElementById("specification_status").value;
    if(selection == "Y")
    {
        document.getElementById("sort").style.display='none';
    } else
    {
        document.getElementById("sort").style.display='block';
      
    }
    var orderBy = document.getElementById("sort_by").value;
    getId_Spec_pending(cPath,selection,orderBy);
}

function sortBy()
{
    document.getElementById("specification_body").innerHTML= "";
    document.getElementById("divMessage").innerHTML= "";
    var selection = document.getElementById("specification_status").value;
    var orderBy = document.getElementById("sort_by").value;
   // var pg=document.getElementById("pg").value;
    getId_Spec_pending('1',selection,orderBy,'1');
}

function getId_Spec(ids)
{
	createRequest();
	var url = "specification_list.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getId_SpecPage;
	request.send("ids="+ids);
}

function getId_SpecPage()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == 3)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];

		}else if(suc_err[1] == 0)
		{
			//document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("page_body").style.display='block';
			
		}else if(suc_err[1] == 2)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("div_Message").style.display='block';
			
		} else if(suc_err[1] == 1)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("div_Mess").style.display='block';
			
		} else
		{
			document.getElementById("specification_body").innerHTML= suc_err[0];
			var id = cPath.split("_");
			if(id[0] != 3)
			{
				document.getElementById("divAddBtn").style.display='block';
			}
		}
	}
}

function edit_spec_tpl(ids,manu,pg)
{ 
    
	document.getElementById("div_Message").style.display='none';
	document.getElementById("divAddBtn").style.display='none';
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("page_body").style.display='none';
        document.getElementById("all_list_spec").style.display='none';

        var urlValue = location.search.substring(1);
	var status = "";
        if(urlValue == "f=plist")
        {
             status = "plist";
        } else
        {
             status = "";
        }
        //alert(manu);
	createRequest();
	var url = "specification_edit.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = get_edit_spec_tpl;
	request.send("ids="+ids+"&status="+status+"&manu="+manu+"&pg="+pg);
}

function get_edit_spec_tpl()
{	
	if(request.readyState == 4){	
		var message=request.responseText;
                
		var suc_err = message.split("||");
		if(suc_err[1] == 1)
		{
			document.getElementById("divMessage").innerHTML= suc_err[2];
			//document.getElementById("divAddBtn").style.display='block';
                        document.getElementById("specification_body").innerHTML= suc_err[0];
			
		} else
		{
			document.getElementById("specification_body").innerHTML= suc_err[0];
		}
	}
}

function editSpecData(ids,state)
{
	document.getElementById("divMessage").innerHTML= "";
        var specification="";
        var description="";
        var average_price="";
        var manufacturer="";
        var keywords="";
        var status = "";
        var oldManu = "";
        var imgValue = "";
        var specification_desc = "";
        
        if(state == "notAll")
        {
            
            specification=document.getElementById("specification").innerHTML;
            description=document.getElementById("description").innerHTML;
            specification_desc=document.getElementById("specification_desc").innerHTML;
            //average_price=document.getElementById("average_price").innerHTML;
            keywords=document.getElementById("keywords").value;
            imgValue=document.getElementById("keyName").value;
        } else
        {
            specification=HTMLEncode(document.getElementById("specification").value);
            description=HTMLEncode(document.getElementById("description").value);
            specification_desc=HTMLEncode(document.getElementById("specification_desc").value);
           // average_price=document.getElementById("average_price").value;
            imgValue=document.getElementById("keyName").value;
            
           
           var manufacturer_names = getManufactureNameList();
        
	    var keywords=HTMLEncode(document.getElementById("keywords").value);
            //keywords=HTMLEncode(document.getElementById("keywords").value);
        
            oldManu=document.getElementById("oldManufac").value;
            pg=document.getElementById("pg").value;
            var urlValue = location.search.substring(1);
            
            if(urlValue == "f=plist")
            {
                 status = document.getElementById("spec_status").value;
            } else
            {
                 status = "";
            }
            
        }

        manufacturer=getManufactureList();

        createRequest();
        var url = "specification.ajax.php";
        request.open("POST", url, true);
        request.setRequestHeader(
                'Content-Type',
                'application/x-www-form-urlencoded; charset=UTF-8');
        request.onreadystatechange = getEditSpecData;
        request.send("spec="+specification + "&spec_desc=" + specification_desc + "&desc=" + description + "&kWords=" + keywords + "&img=" + imgValue + "&avgpri=" + average_price + "&ids=" + ids + "&state=" + status + "&manufacturer=" + manufacturer + "&oldmanu=" + oldManu+ "&pg=" + pg +"&val=edit");
}

function getEditSpecData()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
	
		if(suc_err[1] == "SUC")
		{
                    var urlValue = location.search.substring(1);
              
                    if(urlValue == "f=plist")
                    {
                        var selection = document.getElementById("specification_status").value;
                        var orderBy = document.getElementById("sort_by").value;
                        getId_Spec_pending(cPath,selection,orderBy,pg);

                    } else
                    {
                         document.getElementById("divMessage").innerHTML= suc_err[0];
                         getId_Spec(cPath);
                    }
		} else
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			
		}
	}
}

function deleteSpecData(id)
{
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("div_Message").style.display='none';
        document.getElementById("all_list_spec").style.display='none';
        
	createRequest();
	var url = "specification.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getDeleteSpecData;
	request.send("ids="+id + "&val=delete");
}

function getDeleteSpecData()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == "SUC")
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("specification_body").innerHTML= "";
			document.getElementById("divAddBtn").style.display='none';
			document.getElementById("page_body").style.display='none';

			check_list();
			
		} else
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
		}
	}
}

function check_list()
{
	createRequest();
	var url = "specification.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getCheckListData;
	request.send("ids="+cPath + "&val=list");
}

function getCheckListData()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == "SUC")
		{
			document.getElementById("div_Message").style.display='block';
		} else
		{
			getId_Spec(cPath);
		}
	}
}

function checkLevel()
{
        var id = cPath.split("_");
        if(id.length>2)
        {
                document.getElementById("divMessage").innerHTML= "";
                add_spec_tpl();
        }
}

function add_spec_tpl(path)
{
	//alert("hi2");
	document.getElementById("div_Message").style.display='none';
	document.getElementById("divAddBtn").style.display='none';
        document.getElementById("all_list_spec").style.display='none';
	
	createRequest();
	var url = "specification_add.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getAddSpecPage;
    if(path)
        {
            request.send("ids=" + path);
        }
        else
            {
                request.send("ids=" + cPath);
            }
	
	//alert("what happen?");
}

function getAddSpecPage()
{	
	if(request.readyState == 4){	
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == 3)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
		
		}else if(suc_err[1] == 0)
		{
			//document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("page_body").style.display='block';
			//document.getElementById("specification_body_deflt").value= "Please Select a.........";
			
		} else if(suc_err[1] == 1)
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("div_Mess").style.display='block';
			
		} else
		{
			document.getElementById("specification_body").innerHTML= suc_err[0];
		}
	}
}

function findBaseName(url) {
    var fileName = url.substring(url.lastIndexOf('/') + 1);
    var dot = fileName.lastIndexOf('.');
    return dot == -1 ? fileName : fileName.substring(0, dot);
}


function addSpecData()
{

    
        var imgValue="";
	document.getElementById("divMessage").innerHTML= "";
	var specification=HTMLEncode(document.getElementById("specification").value);
        var specification_desc=HTMLEncode(document.getElementById("specification_desc").value);
        
	//var average_price=document.getElementById("average_price").value;
        var average_price='';
	var description=HTMLEncode(document.getElementById("description").value);
        var manufacturer_names = getManufactureNameList();
        imgValue=document.getElementById("keyName").value;
        //alert("spec="+specification + "&avgpri="+average_price + "&desc=" + description + "&ids="+cPath + "&manufacturer=" + manufacturer + "&kword=" + keywords +"&img=" +imgValue+"&val=add");
	var keywords=HTMLEncode(document.getElementById("keywords").value);
	var manufacturer=getManufactureList();
	//alert("spec="+specification + "&spec_desc="+specification_desc + "&avgpri="+average_price + "&desc=" + description + "&ids="+cPath + "&manufacturer=" + manufacturer + "&kword=" + keywords +"&img=" +imgValue+"&val=add");
	//exit;
        reqSpec=createAjaxRequest();

	var url = "specification.ajax.php";
	
	reqSpec.open("POST", url, true);
	reqSpec.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	reqSpec.onreadystatechange = getAddSpecData;
	reqSpec.send("spec="+specification + "&spec_desc="+specification_desc + "&avgpri="+average_price + "&desc=" + description + "&ids="+cPath + "&manufacturer=" + manufacturer + "&kword=" + keywords +"&img=" +imgValue+"&val=add");

}

function getAddSpecData()
{
	if(reqSpec.readyState == 4)
	{
		var message=reqSpec.responseText;
		var suc_err = message.split("||");

		if(suc_err[1] == "SUC")
		{
			document.getElementById("divMessage").innerHTML+= suc_err[0];
                        var urlValue = location.search.substring(1);
                        if(urlValue == "f=plist")
                        {
                            var selection = document.getElementById("specification_status").value;
                            var orderBy = document.getElementById("sort_by").value;
                            getId_Spec_pending(cPath,selection,orderBy);
                        } else 
                        {
                             getId_Spec(cPath);
                        } 
		} else
		{
			document.getElementById("divMessage").innerHTML+= suc_err[0];
		}
	}
}

function selectCategoryLevel(cPath)
{
	getIds(cPath);
}

function addCategory(url)
{
	var id = cPath.split("_");
	var level = id.length-1;
	
	//location.replace(url+"?f=add&tcat="+id[0]+"&topclist="+id[1]+"_"+level+"&plevel="+level);
	location.replace(url+"&catId="+cPath);
	//add(cPath);
}

function doSearch(fieldName,file)
{
	var options = {
			script:file+"?json=true&",
			varname:"input",
			json:true,
		};
	var as_json = new AutoSuggest(fieldName, options);

}

//---------------- Added by Saliya -------------->
function moveOver()
{
        var new_keywords = '';        
        var oldText = trim(document.getElementById('keywords').value);
        //alert(oldText);
        var keywordsArray = new Array();
        //alert(keywordsArray);
        keywordsArray = oldText.split('\n');
        for(k in keywordsArray){
            keywordsArray[k] += '\n';
        }
        var boxLength = document.adminForm.choiceBox.length;
        var availablelength = document.adminForm.available.length;
        var selectedItem = document.adminForm.available.selectedIndex;
        var selectedText = document.adminForm.available.options[selectedItem].text;
        var selectedValue = document.adminForm.available.options[selectedItem].value;
        var i,k;
        var isNew = true;

        if(selectedValue=='all'){
        var selectedItem=0;
        for(k=0;k<=availablelength-2;k++){

          var selectedText = document.adminForm.available.options[selectedItem+1].text;
          var selectedValue = document.adminForm.available.options[selectedItem+1].value;

                newoption = new Option(selectedText, selectedValue, false, false);

                document.adminForm.choiceBox.options[k] = newoption;

                selectedItem++;}

}else{
    
    keywordsArray.push(selectedText);
    
    //alert(keywordsArray);
    
    for(i=0;i<keywordsArray.length;i++){
        new_keywords += keywordsArray[i];
    }
    document.getElementById('keywords').value = new_keywords;
    
    
        if (boxLength != 0) {
                for (i = 0; i < boxLength; i++) {
                        thisitem = document.adminForm.choiceBox.options[i].text;
                        
                        if (thisitem == selectedText) {
                                isNew = false;
                                break;
                        }
                         
                }

        }
        if (isNew) {
                newoption = new Option(selectedText, selectedValue, false, false);
                document.adminForm.choiceBox.options[boxLength] = newoption;
        }
        document.adminForm.available.selectedIndex=-1;}

    document.adminForm.available.options[selectedItem] = null;
    //sortlist('available');
    //sortlist('choiceBox');
}

function moveBack()
{
        var boxLength = document.adminForm.available.length;
        var availablelength = document.adminForm.choiceBox.length;
        var selectedItem = document.adminForm.choiceBox.selectedIndex;
        var selectedText = document.adminForm.choiceBox.options[selectedItem].text;
        var selectedValue = document.adminForm.choiceBox.options[selectedItem].value;
        var i,k;
        var isNew = true;

        if(selectedValue=='all'){
        var selectedItem=0;
        for(k=0;k<=availablelength-2;k++){

          var selectedText = document.adminForm.choiceBox.options[selectedItem+1].text;
                  var selectedValue = document.adminForm.choiceBox.options[selectedItem+1].value;

                newoption = new Option(selectedText, selectedValue, false, false);

                document.adminForm.available.options[k] = newoption;

                selectedItem++;}

}else{
        if (boxLength != 0) {
                for (i = 0; i < boxLength; i++) {
                        thisitem = document.adminForm.available.options[i].text;
                        if (thisitem == selectedText) {
                                isNew = false;
                                break;
                        }
                       
                }
        }
        if (isNew) {
                newoption = new Option(selectedText, selectedValue, false, false);
                document.adminForm.available.options[boxLength] = newoption;
        }
    document.adminForm.choiceBox.selectedIndex=-1;}
    
    var old_keywords = trim(document.getElementById('keywords').value);
    
    var new_keywords = old_keywords.replace(selectedText,'');
    
    //alert(new_keywords);
    
     document.getElementById('keywords').value = new_keywords.replace('\n\n','\n');
    
    document.adminForm.choiceBox.options[selectedItem] = null;
   //sortlist('available');sortlist('choiceBox');
}

function sortlist(thisList) {
    var lb = document.getElementById(thisList);
    arrTexts = new Array();
    arrValues=new Array();

    for(i=0; i<lb.length; i++)  {
      arrTexts[i] = lb.options[i].text;
      arrValues[i] = lb.options[i].value;

    }

    arrTexts.sort();

    for(i=0; i<lb.length; i++)  {
      lb.options[i].text = arrTexts[i];
      lb.options[i].value = arrValues[i];
    }
}
function getManufactureList(){
        var strValues = "";
        var boxLength = document.adminForm.choiceBox.length;
        var count = 0;
        if (boxLength != 0) {
                for (i = 0; i < boxLength; i++) {
                        if (count == 0) {
                                strValues = document.adminForm.choiceBox.options[i].value;
                        }
                        else {
                                strValues = strValues + "-sep-" + document.adminForm.choiceBox.options[i].value;
                        }
                        count++;
                }
        }

        
        return strValues + "-sep-";



}

function getManufactureNameList(){
        var strValues = "";
        var boxLength = document.adminForm.choiceBox.length;
        var count = 0;
        if (boxLength != 0) {
                for (i = 0; i < boxLength; i++) {
                        if (count == 0) {
                                strValues = document.adminForm.choiceBox.options[i].text;
                        }
                        else {
                                strValues = strValues + "-sep-" + document.adminForm.choiceBox.options[i].text;
                        }
                        count++;
                }
        }

        
        return strValues + "-sep-";



}

function getPendingSpecifations(ids,orderBy,pg)
{
    getId_Spec_pending(ids,'P',orderBy,pg);
}

function HTMLEncode( text )
{
	if ( !text )
		return '' ;

	text = text.replace( /&/g, '-amp;' ) ;
	text = text.replace( /</g, '-lt;' ) ;
	text = text.replace( />/g, '-gt;' ) ;

	return text ;
}


function HTMLDecode( text )
{
	if ( !text )
		return '' ;

	text = text.replace( /-gt;/g, '>' ) ;
	text = text.replace( /-lt;/g, '<' ) ;
	text = text.replace( /-amp;/g, '&' ) ;

	return text ;
}


function trim(stringToTrim) {
	return stringToTrim.replace(/^\s+|\s+$/g,"");
}

function MyValue(field){
    alert(document.getElementById(field.id).innerHTML);
}