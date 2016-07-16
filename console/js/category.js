var reqCate =null;

/*******************************************************************************************/
function get_Ids(ids)
{
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("page_body").innerHTML= "";
	document.getElementById("div_Message").style.display='none';
	document.getElementById("divAddBtn").style.display='none';
	document.getElementById("div_Mess").style.display='none';
        document.getElementById("all_list_spec").style.display='none';

	var url = location.search.substring(1);
	
	var urlValue = url.split("&");
	
	if(urlValue[0] == "f=add")
	{
		add(cPath);

	} else if(urlValue[0] == "f=list")
	{
		getId(ids);
	}else if(urlValue == "f=plist")
	{
                resetPlist();
		getId_Cat_pending(ids,'P','category');
	}
}

function resetPlist()
{
    document.getElementById("category_status").value = "P";
    document.getElementById("sort").style.display='block';
    document.getElementById("sort_by").value = 'category';
}

function setAllList()
{
    document.getElementById("page_body").innerHTML= "";
    document.getElementById("divMessage").innerHTML= "";
   
    var selection = document.getElementById("category_status").value;

    if(selection == "Y")
    {
        document.getElementById("sort").style.display='none';
    } else
    {
        document.getElementById("sort").style.display='block';

    }
    var orderBy = document.getElementById("sort_by").value;
    getId_Cat_pending(cPath,selection,orderBy);
}

function sortBy()
{
    document.getElementById("page_body").innerHTML= "";
    document.getElementById("divMessage").innerHTML= "";
    var selection = document.getElementById("category_status").value;
    var orderBy = document.getElementById("sort_by").value;
    getId_Cat_pending(cPath,selection,orderBy);
}

/*******************************************************************************************/
function getId_Cat_pending(ids,selection,orderByName)
{
	var idValues = ids.split("_");
	//var level = ids.length-1; //plevel
        var level = idValues.length-1; //plevel
	var lastEle = idValues[idValues.length-1]; //pcat
	var tid = idValues[0];//topclist

	createRequest();
	var url = "category_list_pending.ajax.tpl.php";
	request.open("POST", url, true);
	request.setRequestHeader(
			'Content-Type',
			'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getId_CatPendingPage;
	request.send("ids="+ids+"&plevel="+level+"&pcat="+lastEle+"&topclist="+tid+"&selec="+selection+"&orderBy="+orderByName);

}

function getId_CatPendingPage()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == 1)
		{
//			document.getElementById("divMessage").innerHTML = suc_err[0];

//                        var idValues = cPath.split("_");
//                        var level = idValues.length-1; //plevel
//                        if(level=="2")
//                        {
//                           document.getElementById("all_list_spec").style.display='none';
//                        } else
//                        {
//                            document.getElementById("all_list_spec").style.display='block';
//                        }
			//document.getElementById("divMessage").innerHTML=suc_err[0];
		}
//        else
//		{
//                        document.getElementById("all_list_spec").style.display='block';
//			document.getElementById("page_body").innerHTML= suc_err[0];
//		}
        document.getElementById("all_list_spec").style.display='block';
			document.getElementById("page_body").innerHTML= suc_err[0];
	}
}


/*******************************************************************************************/
function add(ids)
{
	if(ids != "no_id")
	{
		document.getElementById("div_Message").style.display='none';
		document.getElementById("divAddBtn").style.display='none';
                document.getElementById("all_list_spec").style.display='none';
		
		reqCate=createAjaxRequest();
		
		var url = "category_add.ajax.tpl.php?ids="+ids;
		reqCate.open("GET", url, true);
		/*reqCate.setRequestHeader(
				'Content-Type', 
				'application/x-www-form-urlencoded; charset=UTF-8');*/
		reqCate.onreadystatechange = getAddPage;
		reqCate.send(null);
	}
}

function getAddPage()
{	
	if(reqCate.readyState == 4){	
		var message=reqCate.responseText;
		
		var suc_err = message.split("||");
		if(suc_err[1] == "ERR")
		{
			document.getElementById("divMessage").innerHTML = suc_err[0];
			//document.getElementById("div_Message").style.display='block';
			
		} else
		{
			document.getElementById("page_body").innerHTML= suc_err[0];
		}
	}
}

/*******************************************************************************************/
function addData(ids)
{
	var imgValue="";
	document.getElementById("divMessage").innerHTML= "";
	var cname=document.getElementById("cname").value;
	var cdescription=document.getElementById("cdescription").value;
	var cstatus=document.getElementById("cstatus").value;
	
	var id = ids.split("_");
	if(id.length == 2)
	{	
		imgValue=document.getElementById("keyName").value;
		//imgValue = "ggg";
	}
	
	reqCate=createAjaxRequest();

	var url = "category.ajax.php";
	
	reqCate.open("POST", url, true);
	reqCate.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	reqCate.onreadystatechange = getAddDataPage;
	reqCate.send("cn="+encodeURIComponent(cname) + "&cd="+encodeURIComponent(cdescription) + "&cs=" + cstatus + "&ids="+ids +"&img=" +imgValue +"&val=add");

}

function getAddDataPage()
{
	if(reqCate.readyState == 4)
	{
		var message=reqCate.responseText;
		var suc_err = message.split("||");

		if(suc_err[1] == "SUC")
		{
			document.getElementById("divMessage").innerHTML = suc_err[0];
                       // alert("hi");
			//getId(cPath);
			//initTree("3","http://172.16.18.100/diy_v0.4/console/");
                        
			//showHideNode();
			//window.location.reload();
		} else
		{
			document.getElementById("divMessage").innerHTML = suc_err[0];
		}
	}
}

/*******************************************************************************************/
function getId(ids)
{
	var idValues = ids.split("_");
        
	//var level = ids.length-1; //plevel
        var level = idValues.length-1; //plevel
        
	var lastEle = idValues[idValues.length-1]; //pcat
	var tid = idValues[0];//topclist

	createRequest();
	var url = "category_list.ajax.tpl.php";
	request.open("POST", url, true);
	request.setRequestHeader(
			'Content-Type', 
			'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = getIdPage;
	request.send("ids="+ids+"&plevel="+level+"&pcat="+lastEle+"&topclist="+tid);


}

function getIdPage()
{
	if(request.readyState == 4){
		var message=request.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == 1)
		{
			document.getElementById("divMessage").innerHTML = suc_err[0];
			//document.getElementById("divMessage").innerHTML=suc_err[0];
		} else
		{
			document.getElementById("page_body").innerHTML= suc_err[0];
		}
	}
}

/*******************************************************************************************/
function edit(ids,extValues)
{
	document.getElementById("div_Message").style.display='none';
	document.getElementById("divAddBtn").style.display='none';
	document.getElementById("divMessage").innerHTML= "";
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
        var selection = document.getElementById("category_status").value;
	reqCate=createAjaxRequest();
	var url = "category_edit.ajax.tpl.php";
	reqCate.open("POST", url, true);
	reqCate.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	reqCate.onreadystatechange = getEditPage;
	reqCate.send("ids="+ids+"&status="+status +"&selec="+selection +"&extValues="+extValues);
}

function getEditPage()
{	
	if(reqCate.readyState == 4){	
		var message=reqCate.responseText;
		
		document.getElementById("page_body").innerHTML= message;

	}
}

/*******************************************************************************************/
function editData(category,id,parent,level)
{
	var imgValue = "";

	document.getElementById("divMessage").innerHTML= "";
	var cname=document.getElementById("cname").value;
	var cdescription=document.getElementById("cdescription").value;
	var cstatus=document.getElementById("cstatus").value;
    extValues=document.getElementById('extValues').value;
    
	if(level == 2)
	{	
		imgValue=document.getElementById("keyName").value;
	}
	
	reqCate=createAjaxRequest();
	var url = "category.ajax.php";
	reqCate.open("POST", url, true);
	reqCate.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	reqCate.onreadystatechange = getEditDataPage;
	reqCate.send("cn="+ encodeURIComponent(cname) + "&cd=" + encodeURIComponent(cdescription) + "&cs=" + cstatus + "&cat=" + category +"&id=" + id+ "&pare=" + parent+"&lvl=" + level +"&img="+imgValue+"&val=edit"+"&extValues=" + extValues);
}

function getEditDataPage()
{
	if(reqCate.readyState == 4){
		var message=reqCate.responseText;
		var suc_err = message.split("||");
		
		if(suc_err[1] == "SUC")
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
                        var urlValue = location.search.substring(1);
                        if(urlValue == "f=plist")
                        {
                           // var selection = document.getElementById("category_status").value;
                            //var  orderBy= document.getElementById("sort_by").value;
                            var orderBy='';
                            var extValSplit=extValues.split("-sep-");
                            getId_Cat_pending(extValSplit[0],extValSplit[1],orderBy);
                        } else
                        {
                             getId(cPath);
                        }
			
		} else
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
		}
	}
}

/*******************************************************************************************/
function deleteData(id)
{
	document.getElementById("divMessage").innerHTML= "";
	document.getElementById("div_Message").style.display='none';
	reqCate=createAjaxRequest();
	var url = "category.ajax.php";
	reqCate.open("POST", url, true);
	reqCate.setRequestHeader(
    		'Content-Type', 
    		'application/x-www-form-urlencoded; charset=UTF-8');
	reqCate.onreadystatechange = getDeleteDataPage;
	reqCate.send("ids="+id + "&val=delete");
}

function getDeleteDataPage()
{
	if(reqCate.readyState == 4){
		var message=reqCate.responseText;
		var suc_err = message.split("||");
		if(suc_err[1] == "SUC")
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
			document.getElementById("page_body").innerHTML= "";
			document.getElementById("divAddBtn").style.display='none';
			getId(cPath);
			//check_list();
			
		} else
		{
			document.getElementById("divMessage").innerHTML= suc_err[0];
		}
	}
}

/*******************************************************************************************/
function addSpecification(url)
{
	//location.replace(url+"specification_add.ajax.php?ids="+cPath);
	location.replace(url);
}

/*******************************************************************************************/
function selectCategoryLevel(cPath)
{
	get_Ids(cPath);
}

function checkAdd()
{
	var url = location.search.substring(1);
	
	if(url!="f=add" && url!="f=list" && url!="f=plist")
	{
		var urlCatId = url.split("&");
		var cat_id = urlCatId[1].split("="); 
		if(cat_id[1] != "")
		{
			add(cat_id[1]);
		}
	}
}

function getPendingCategories(ids,orderBy,pg)
{
    getId_Cat_pending(ids,'P',orderBy,pg)
}
function getCategoryList()
{
    var topCat=document.getElementById('cmbTopCat').value;
    var getList=document.getElementById('category_status').value;
    var orderBy=''; var pg=1;
    getId_Cat_pending(topCat,getList,orderBy,pg)
}