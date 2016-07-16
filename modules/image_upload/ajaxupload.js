var hiddenImgKeyField;
var formName;
var hiddenDiv;
var imageVal;
var divLoading;
var flgImgUploaded;

function $m(theVar){
	return document.getElementById(theVar)
}
function remove(theVar){
	var theParent = theVar.parentNode;
	theParent.removeChild(theVar);
}
function addEvent(obj, evType, fn){
	if(obj.addEventListener)
	    obj.addEventListener(evType, fn, true)
	if(obj.attachEvent)
	    obj.attachEvent("on"+evType, fn)
}
function removeEvent(obj, type, fn){
	if(obj.detachEvent){
		obj.detachEvent('on'+type, fn);
	}else{
		obj.removeEventListener(type, fn, false);
	}
}
function isWebKit(){
	return RegExp(" AppleWebKit/").test(navigator.userAgent);
}
/**
 * This is calling from browse file in tpl. 
 */
function ajaxUpload(form,url_action,id_element,divProcess){
    
    
        document.getElementById(id_element).innerHTML = "";
        divLoading = divProcess;flgImgUploaded=false;
	handleProcessMsg("block",divLoading);
	var detectWebKit = isWebKit();
	form = typeof(form)=="string"?$m(form):form;
	var erro="";
	if(form==null || typeof(form)=="undefined"){
		erro += "The form of 1st parameter does not exists.\n";
	}else if(form.nodeName.toLowerCase()!="form"){
		erro += "The form of 1st parameter its not a form.\n";
	}
	if($m(id_element)==null){
		erro += "The element of 3rd parameter does not exists.\n";
	}
	if(erro.length>0){
		alert("Error in call ajaxUpload:\n" + erro);
		return;
	}
	var iframe = document.createElement("iframe");
	iframe.setAttribute("id","ajax-temp");
	iframe.setAttribute("name","ajax-temp");
	iframe.setAttribute("width","0");
	iframe.setAttribute("height","0");
	iframe.setAttribute("border","0");
	iframe.setAttribute("style","width: 0; height: 0; border: none;");
	form.parentNode.appendChild(iframe);
	window.frames['ajax-temp'].name="ajax-temp";
	var doUpload = function(){
		removeEvent($m('ajax-temp'),"load", doUpload);
		var cross = "javascript: ";
		cross += "window.parent.$m('"+id_element+"').innerHTML = document.body.innerHTML; void(0);";
		$m('ajax-temp').src = cross;
                if(detectWebKit){
                    remove($m('ajax-temp'));
                }else{
                    setTimeout(function(){remove($m('ajax-temp'))}, 250);
                }
         flgImgUploaded=true;handleProcessMsg("none",divLoading);
        }
	addEvent($m('ajax-temp'),"load", doUpload);
	form.setAttribute("target","ajax-temp");
	form.setAttribute("action",url_action);
	form.setAttribute("method","post");
	form.setAttribute("enctype","multipart/form-data");
	form.setAttribute("encoding","multipart/form-data");
        /*debug(form.name);
        debug(form.action);*/
        form.submit();
        /*form.setAttribute("action","");*/
}

/**
 * This is used to keep some common fields names, in global variables.
 */
function getFieldNames(keyName,frmName,zoomDiv)
{
	hiddenImgKeyField = keyName;
	formName = frmName;
	hiddenDiv = zoomDiv;
	document.getElementById(hiddenDiv).style.display='none';
        
}

/**
 * This is called from ajaxupload.php file and this is used to pass the image key.
 */
function passImgKey(imageKey)
{
        //alert(imageKey);
        //alert(formName+hiddenImgKeyField);
	document.forms[formName][hiddenImgKeyField].value=imageKey;
	imageVal = imageKey;
	showZoom();
}

/**
 * If there is an image, this is used to display the zoom icon.
 */
function showZoom()
{
    try
    {
        flgImgUploaded=document.getElementById('imgUploaded').value;
    }
    catch(err)
    {
        flgImgUploaded=false;
    }

	if(imageVal != "" && flgImgUploaded!="y")
	{
		document.getElementById(hiddenDiv).style.display='block';	
	}
        handleProcessMsg("none",divLoading);
}


/*
 * This is calling when clicking on zoom icon.
 */
function doZoom(url,com)
{
	zoom(url,imageVal,com);
}

/**
 * Display the zoomed image. And call to zoom_prods.php.
 */
function zoom(preURL,img,com)
{
	args="width="+200+",height="+400+",resizable=no,scrollbars=no,status=0";
//	<?php echo $objCore->_SYS['CONF']['URL_IMG_UPLOAD_MODULE'];?>/ajaxupload.php
	myUrl=preURL + "?img=" + img + "&com=" + com;
	window.open(myUrl,"Zoom",args);
}

/*
 * Use this for, if there is another messages displaying in the tpl, call this to clear them before
 * display Loading box.
 */
function clearMsg(divMessage)
{
    document.getElementById(divMessage).innerHTML = "";
}

function showMsg(divMessage,message)
{
    document.getElementById(divMessage).style.display='block';
    document.getElementById(divMessage).innerHTML = message;
}

function delImage(url,section,image,sKey,use)
{ //var divLoading = divProcess;
    if(confirm("This will permanantly delete the Image from the System"))
        {   ///handleProcessMsg("block",divLoading);
            createRequest();
            request.open("POST", url, true);
            request.setRequestHeader(
                    'Content-Type',
                    'application/x-www-form-urlencoded; charset=UTF-8');
            request.onreadystatechange = function()
            {
                if(request.readyState == 4){
                    serverResponse=request.responseText;
                    serverResponse=serverResponse.split("||")
                    
                     if(serverResponse[0]=='DONE')
                        document.getElementById('uploadingImg').innerHTML = serverResponse[1];
                        document.getElementById('zooming').style.display='none';

                }
                //handleProcessMsg("none",divLoading);
            };
            
            request.send("section="+section+"&image="+image+"&use="+use+"&safeKey="+sKey);
        }


}
