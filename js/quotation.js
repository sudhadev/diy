function showItems()
{
document.getElementById("quotation_formmain_ginfo").style.display = "none";
document.getElementById("quotation_formmain_items").style.display = "block";
document.getElementById("configure_quot_tabs_items").setAttribute("class", "configure_quot_tabs_items cursorHand");
document.getElementById("configure_quot_tabs_ginfo").setAttribute("class", "configure_quot_tabs_ginfo ginfoinactive cursorHand");
}

function showGeneral()
{
document.getElementById("quotation_formmain_items").style.display = "none";
document.getElementById("quotation_formmain_ginfo").style.display = "block";
document.getElementById("configure_quot_tabs_ginfo").setAttribute("class",  "configure_quot_tabs_ginfo cursorHand");
document.getElementById("configure_quot_tabs_items").setAttribute("class",  "configure_quot_tabs_items itemsinactive cursorHand");
}

function delQuot(e)
{
    if(confirm("Selected Quotation will be deleted from the System!")){
        windows.location = "e.href";
    }else{
         return false;
    }

}

function rectreate(e)
{
	if(confirm('Current wish list will be empty and reloaded with selected quotation items. Do you need to continue?')){
		 windows.location = "e.href";
	}else{
        return false;
    }

}

function editItems(obj,id){

var input = obj.getElementsByTagName( "input" );
 var getstr = "";
      for (i=0; i<input.length; i++) {
         if (input[i].name) {
               getstr += input[i].name + "=" + input[i].value + "&";
         }   
      }
 
 		reqeditItem = createAjaxRequest();
		var url = "item_list_edit.ajax.tpl.php";
      	reqeditItem.open("POST", url, true);
		reqeditItem.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
		reqeditItem.onreadystatechange =function(){
            if(reqeditItem.readyState == '4')
                {
                 var itemContent=reqeditItem.responseText;
				 document.getElementById('quotation_formmain_items').innerHTML = itemContent;
                }
        }
        reqeditItem.send(getstr+"&action=edit&qid="+id);

}


function delItem(id,qid)
{
    if(confirm("Selected Item will be deleted from the Quotation!")){
        reqdelItem = createAjaxRequest();
		var url = "item_list_edit.ajax.tpl.php";
      	reqdelItem.open("POST", url, true);
		reqdelItem.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
		reqdelItem.onreadystatechange =function(){
            if(reqdelItem.readyState == '4')
                {
                 var itemContent=reqdelItem.responseText;
				 document.getElementById('quotation_formmain_items').innerHTML = itemContent;
                }
        }
        reqdelItem.send("id=" + id + "&qid="+qid+"&action=del");   
       
    }



}

function moveUp(id,qid)
{
	        reqdelItem = createAjaxRequest();
		var url = "item_list_edit.ajax.tpl.php";
      	reqdelItem.open("POST", url, true);
		reqdelItem.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
		reqdelItem.onreadystatechange =function(){
            if(reqdelItem.readyState == '4')
                {
                 var itemContent=reqdelItem.responseText;
				 document.getElementById('quotation_formmain_items').innerHTML = itemContent;
                }
        }
        reqdelItem.send("id=" + id + "&qid="+qid + "&action=moveup");
}

function moveDown(id,qid)
{
	        reqdelItem = createAjaxRequest();
		var url = "item_list_edit.ajax.tpl.php";
      	reqdelItem.open("POST", url, true);
		reqdelItem.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
		reqdelItem.onreadystatechange =function(){
            if(reqdelItem.readyState == '4')
                {
                 var itemContent=reqdelItem.responseText;
				 document.getElementById('quotation_formmain_items').innerHTML = itemContent;
                }
        }
        reqdelItem.send("id=" + id + "&qid="+qid + "&action=movedown");
}

function editGenInfo(qid)
{
    $('.msgBox').hide();
    title = document.getElementById('title').value;
        imagename = document.getElementById('keyName').value;
     
        cusdetails = document.getElementById('cusdetails').value;
        vfrom = document.getElementById('vfrom').value;
        vto = document.getElementById('vto').value;
        othertext = document.getElementById('othertext').value;
        paymethod = document.getElementById('payMethod').value;
        status = document.getElementById('status').value;
	quotationid = document.getElementById('quotationid').value;
   
    reqdelItem = createAjaxRequest();
		var url = "item_list_edit.ajax.tpl.php";
      	reqdelItem.open("POST", url, true);
		reqdelItem.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
		reqdelItem.onreadystatechange =function(){
            if(reqdelItem.readyState == '4')
                {
                 var itemContent=reqdelItem.responseText;
		  //document.getElementById('quotation_formmain_ginfo').innerHTML = itemContent;
                  //$('#quotation_formmain_ginfo').show();       
                  document.getElementById('quotation_formmain_ginfo').innerHTML = itemContent;
                  //$('#divProcess').show();
                 changeText('quoteId',quotationid);// update the quotation id - added by saliya
                }
        }
        
        
        reqdelItem.send("qid="+qid+"&action=editgeninfo&title="+title+"&imagename="+imagename+"&cusdetails="+cusdetails+"&vfrom="+vfrom+"&vto="+vto+"&othertext="+othertext+"&paymethod="+paymethod+"&status="+status+"&quotationid="+quotationid);
    
}

 function print_pg(URL)
   {
               args="width="+710+",height="+900+",resizable=no,scrollbars=yes,status=0";
               window.open(URL,"Print",args);
   }

function clearMessage(resultArea)
	{
		document.getElementById(resultArea).innerHTML = "";
	}

