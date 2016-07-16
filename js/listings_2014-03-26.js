var reqListing =null; //the request object name.

var displayTr = ''; //need to get the name of the div that currently displaying. with in the code give values to this.
var suc_err =''; //need to get the value of the error message and need to hide it.
var checkItems = new Array(); //need to add spec Ids when tick on the check box.
var values = new Array(); // need to keep the values of manufacturers.
var checkedData=0;
var checkedListings = 0;
var values_of_rows = new Array();

var subcatRowId_gbl = "";

var editList = 0;

function resetData()
{
    idArrayValue='';
    suc_err ='';
    imgChangeId = new Array();
    chngId=0;
    document.getElementById("displayMsg").innerHTML="";
    clearItems = new Array();
    clearData=0;
}

/*****************************************************************/
function checkValue(ids,elementId,div_id)
{ 
   
    editList = 1;
    document.getElementById("displayMsg").innerHTML="";
    document.getElementById("delivery_"+elementId).value = document.getElementById("delivery_show_"+elementId).value;
    var unitCost = document.getElementById("unit_cost_" + elementId).value;
    var bulkDiscount = document.getElementById("select_bulk_discount_"+elementId).value;
    var bulkPrice=document.getElementById("bulk_price_"+elementId).value;
    var delivery=document.getElementById("delivery_"+elementId).value;
    var listingActive=document.getElementById("listing_active_"+elementId).value;
    
   // alert(bulkDiscount+'--'+bulkPrice);
    
    if(listingActive=='Y'){
    	
    	if(bulkPrice!=0 && bulkPrice!='0.00' && bulkPrice!='' && bulkPrice!=null){
    		if(bulkDiscount==0){
    			$('#'+"select_bulk_discount_"+elementId).attr("style", 'border: 1px solid red;');
    		}else{
    			$('#'+"select_bulk_discount_"+elementId).attr("style", 'border: 1px solid #CBCBCB;');
    		}
    	}else{
    		if(bulkDiscount==0){
    			$('#'+"select_bulk_discount_"+elementId).attr("style", 'border: 1px solid #CBCBCB;');
    			$('#'+"bulk_price_"+elementId).attr("style", 'border: 1px solid #CBCBCB;');
    		}else{
    			$('#'+"select_bulk_discount_"+elementId).attr("style", 'border: 1px solid red;');
    		}
    	}
	}	
    	reqListing = createAjaxRequest();
	    var url = "listing.ajax.process.php";
	    reqListing.open("POST", url, true);
	    reqListing.setRequestHeader(
	        'Content-Type',
	        'application/x-www-form-urlencoded; charset=UTF-8');
	    reqListing.onreadystatechange =  function ()
	    {
	        fieldsCheck(ids,elementId,unitCost,delivery);
	    };
	    
	    reqListing.send("val=checkValue" + "&uc="+ unitCost + "&bd=" + bulkDiscount + "&bp=" + bulkPrice + "&deliv=" + delivery + "&la=" + listingActive + "&rowId=" + elementId);
    
   // }
    
	    
    if(div_id){
        change_div_color(div_id);// for color change - edit by maduranga
    }
    
}

function fieldsCheck(ids,elementId,unitCost,delivery)
{
    if(reqListing.readyState == 4)
    {
        var message=reqListing.responseText;
        var err = message.split("||");

        if(err[0] != "")
        {
            document.getElementById(err[2]).className = 'error';
            if(err[3])
            {
                document.getElementById(err[3]).className = 'error';
            }
            handleProcessMsg("none","displayMsg");
            document.getElementById("displayMsg").innerHTML="";
            document.getElementById("displayMsg").style.display='block';
            document.getElementById("displayMsg").innerHTML= err[0];
			
        }
        else

        {
            document.getElementById("unit_cost_" + elementId).className = 'numeric_txtfield';
            document.getElementById("select_bulk_discount_"+elementId).className = 'mng_mylistings_short';
            document.getElementById("bulk_price_"+elementId).className = 'numeric_txtfield';
            document.getElementById("delivery_"+elementId).className = 'numeric_txtfield';

            handleProcessMsg("none","displayMsg");
            document.getElementById("displayMsg").innerHTML="";
        }
    }
}

function add_edit_before(){
    var rowCount = document.getElementById("rowCount").value;
   
    if(rowCount){
       $('#list_submit_button-BT').hide(); 
       $('#list_submit_button-hover-BT').hide();
       $('#list_submit_button-BT-2').hide(); 
       $('#list_submit_button-hover-BT-2').hide();
        add_edit(rowCount);
    }
    
}

function add_edit(rowCount)
{ 
    
       // var rowCount = document.getElementById("rowCount").value;

        for(var i=0; i<rowCount; i++)
        {

            var ids = document.getElementById("ids["+i+"]").value;
            var elementId = document.getElementById("eleId["+i+"]").value;

            document.getElementById("displayMsg").innerHTML="";
            document.getElementById("displayMsg").style.display='none';

            handleProcessMsg("block","displayMsg");

            var unitCost = document.getElementById("unit_cost_" + elementId).value;
            var bulkDiscount = document.getElementById("select_bulk_discount_"+elementId).value;
            var bulkPrice=document.getElementById("bulk_price_"+elementId).value;
            var delivery=document.getElementById("delivery_"+elementId).value;
            var listingActive=document.getElementById("listing_active_"+elementId).value;
            var img=document.getElementById("list_img_"+elementId).value;
            var img2=document.getElementById("list_img2_"+elementId).value;
            var img3=document.getElementById("list_img3_"+elementId).value;
            var img4=document.getElementById("list_img4_"+elementId).value;
            var desc=document.getElementById("list_des_"+elementId).value;
            desc=replace_coma(desc);
            var sup_code=document.getElementById("list_sup_"+elementId).value;
            var curStatus=document.getElementById("curstatus_"+elementId).value;
            var spec=document.getElementById("list_spec_"+elementId).value;
            spec=replace_coma(spec);
            var del=document.getElementById("list_del_"+elementId).value;
            var rate=document.getElementById("actual_list_rate_"+elementId).value;
            var header=document.getElementById("list_head_"+elementId).value;
            header=replace_coma(header);
            var url=document.getElementById("list_url_"+elementId).value;
            
            ///alert(unitCost+"||"+bulkDiscount+"||"+bulkPrice+"||"+delivery+"||"+"||"+ids+"||"+img+"||"+desc+"||"+ curStatus+"||"+sup_code+"||"+ spec+"||"+ del+"||"+rate+"||"+header+"||"+url);
            //if(listingActive=='Y'){
                 values_of_rows[i] =  unitCost+"||"+bulkDiscount+"||"+bulkPrice+"||"+delivery+"||"+listingActive+"||"+ids+"||"+img+"||"+desc+"||"+ curStatus+"||"+sup_code+"||"+ spec+"||"+ del+"||"+rate+"||"+header+"||"+url+"||"+img2+"||"+img3+"||"+img4;
           // }
        
        }
       // alert(values_of_rows);
        addEditValues(values_of_rows);
     
}

function replace_coma(str){ /* add by maduranga - for replace  "," to specify symbles*/
    var descript_array = str.split(",");
    var descript='';
    for (var i=0;i<descript_array.length;i++){
        if(i==0){
            descript=descript_array[i];
        }else{
            descript=descript+"<#**#>"+descript_array[i];
        }
    }
    return descript;
}


function addEditValues(values_of_rows)
{ 
   // alert(values_of_rows);
    reqListing = createAjaxRequest();
    var url = "listing.ajax.process.php";
    reqListing.open("POST", url, true);
    reqListing.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
    reqListing.onreadystatechange = function()
    {
        //alert(reqListing.readyState);
        //var h = 0;
        if(reqListing.readyState == 4)
        {

            //alert("msg =========> "+msg);
            if(reqListing.status==200)
            {
                var msg=reqListing.responseText;
                //alert(msg);
                suc_err = msg.split("||");
                handleProcessMsg("none","displayMsg");
                document.getElementById("displayMsg").innerHTML="";
                document.getElementById("displayMsg").style.display='block';
                //alert(suc_err[0]);
                document.getElementById("displayMsg").innerHTML= suc_err[0];
                document.getElementById("credit").innerHTML= suc_err[2];
                document.getElementById("credit1").innerHTML= suc_err[2];
                
                
                if(suc_err[1] == "SUC" || suc_err[1] == "1")
                {
                    document.getElementById(displayTr).style.display='none';
                    document.getElementById(displayDiv).innerHTML="";
                    displayTr = "";
                    editList = 0;
                } else
                {
                    //alert("came1");
                    if(suc_err[4] == "yes")
                    {
                        var currentPath=document.getElementById("currentPath").value;
                        //alert("came2 = "+currentPath);
                        location.replace(currentPath+"?selections=M&listing=L");
                    }else
                    {
                    //alert("came3");
                      /*  document.getElementById(displayTr).style.display='none';
                        document.getElementById(displayDiv).innerHTML="";
                        displayTr = "";*/
                    }
                    editList = 1;
                }
                
                   $('#list_submit_button-BT').show(); 
                   $('#list_submit_button-hover-BT').hide();
                   $('#list_submit_button-BT-2').show(); 
                   $('#list_submit_button-hover-BT-2').hide();
            }
        }
    };
    //alert("val=add_edit" + "&rowValues="+ values_of_rows+"&");
    reqListing.send("val=add_edit" + "&rowValues="+ values_of_rows+"&");
      
}

function display_listings(ids,subcatRowId)
{
    //alert("hi");
    var lastClicked=document.getElementById('lastClicked').value;
    if(lastClicked!="" && (lastClicked==subcatRowId)){
        document.getElementById("listing_add_list_"+subcatRowId).style.display="none";
        document.getElementById("listing_add_list_tr_"+subcatRowId).style.display="none";
        document.getElementById('lastClicked').value='';
    }
    else
    {
            if(document.getElementById("traceInfoBox").value=='y')
                {
                    document.getElementById("msgWrapper").innerHTML="";
                 
                }
                else
                    {
                        document.getElementById("displayMsg").innerHTML=""; 
                    }
            

            var cancel = "";

            if(editList==0)
            {
               // if(confirm("You will lose the modified values, if you proceed."))
                {
                    
                    
                    //add_edit();
                    //cancel = "yes";
                    //editList = 0;
                    //editList = 0;
                    //alert("hi1");
                    cancel = "yes";
                    editList = 1;
                    loadData(ids,subcatRowId,cancel);

                } //else
        {
            //alert("hi2");

            }

            } else
        {
                loadData(ids,subcatRowId,cancel);
            }

    }
}

function loadData(ids,subcatRowId,cancel)
{
    //alert("suc_err = "+suc_err);
    //alert("suc_err 1 = "+suc_err[1]);
    //alert("display div = "+displayTr);
    if(displayTr != '' && (suc_err[1] == "SUC" ||  suc_err == '' || suc_err[1]==1 || cancel=="yes"))
    {
        //alert("came1");
        document.getElementById(displayTr).style.display='none';
        document.getElementById(displayDiv).innerHTML="";
    }
	
    if(suc_err[1] == "SUC" || suc_err == '' || suc_err[1]==1  || cancel=="yes")
    {
        //alert("came2");
        reqListing = createAjaxRequest();
        var url = "listing_add.ajax.tpl.php";
        reqListing.open("POST", url, true);
        reqListing.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded; charset=UTF-8');
        reqListing.onreadystatechange = function()
        {
            if(reqListing.readyState == 4)
            {
                var tbl=reqListing.responseText;
                document.getElementById('lastClicked').value = subcatRowId;
                //alert(tbl);
                suc_err = tbl.split("||");
										
                if(suc_err == '')
                {
                    document.getElementById("displayMsg").innerHTML = "";
                }
                if(suc_err[1]==1)
                {
                    document.getElementById("displayMsg").style.display = 'block';
                    document.getElementById("displayMsg").innerHTML = suc_err[0];
                    document.getElementById("listing_add_list_tr_"+subcatRowId).style.display = 'block';
                    document.getElementById("listing_add_list_"+subcatRowId).style.display = 'block';
                    displayTr = "listing_add_list_tr_"+subcatRowId;
                    displayDiv = "listing_add_list_"+subcatRowId;
                    document.getElementById("listing_add_list_"+subcatRowId).innerHTML = suc_err[2];
                    
                } else {
                    // alert("came3");
                    document.getElementById("listing_add_list_tr_"+subcatRowId).style.display = 'block';
                    document.getElementById("listing_add_list_"+subcatRowId).style.display = 'block';
                    displayTr = "listing_add_list_tr_"+subcatRowId;
                    displayDiv= "listing_add_list_"+subcatRowId;
                    document.getElementById("listing_add_list_"+subcatRowId).innerHTML = suc_err[0];
                    suc_err = '';
                    checkItems = new Array();
                    values = new Array();
                    checkedData = 0;
                }
            }
        }
        reqListing.send("ids=" + ids);
    }
}



function changeColor(ids,elementId,div_id){

    var listingActive=document.getElementById("listing_active_"+elementId).value;
    
    if(listingActive=="Y"){
      document.getElementById("listing_active_"+elementId).setAttribute('style','border-color:#006633');
    }

    else{
          document.getElementById("listing_active_"+elementId).setAttribute('style','border-color:#FF0000');
    }
    /**
     *Submit button color change
     **/
    $('#list_submit_button-BT').hide(); 
    $('#list_submit_button-hover-BT').show();
    $('#list_submit_button-BT-2').hide(); 
    $('#list_submit_button-hover-BT-2').show();
    
    change_div_color(div_id); // add by maduranga
    checkValue(ids,elementId,div_id);
}

function select_items(ids,elementId)
{
    var choose_item = document.getElementById("checkItem_" + elementId).checked;
    var listings = 0;
    if(choose_item == true)
    {
        var s = 0;
        for(var j=0;j<checkItems.length;j++)
        {
            if(checkItems[j] == ids)
            {
                s = 1;
                break;
            }
        }
        if(s == 0)
        {
            checkItems[checkedData] = ids;
            checkedData++;
        }
    } else
{
        for(var i=0;i<checkItems.length;i++)
        {
            if(checkItems[i] == ids)
            {
                Array.prototype.remove=function(ids)
                {
                    var index = this.indexOf(ids);
                    if(this.indexOf(ids) != -1)this.splice(i, 1);
                }
                checkItems.remove(ids);
                checkedData = checkItems.length;
                break;
            }
        }
    }
    listings = countListings();
    document.getElementById("list_summery2").innerHTML="You are about to use "+listings+" Listings";
}

function countListings()
{
    var count = 0;
    for(var j=0;j<checkItems.length;j++)
    {
        var id = checkItems[j].split("_");
        var specId = id[id.length-1];
        var clearItem = document.getElementById("checkItem_" + specId).checked;
        if(clearItem == true)
        {
            count++;
        }
    }
    return count;
}

function clear_items()
{
    for(var j=0;j<checkItems.length;j++)
    {
        var id = checkItems[j].split("_");
        var specId = id[id.length-1];
        var manufacturer = document.getElementById("manufacturer_" + specId).value;
        var clearItem = document.getElementById("checkItem_" + specId).checked;

        if(clearItem == true)
        {
            document.getElementById("manufacturer_" + specId).value = "";
            document.getElementById("checkItem_" + specId).checked = false;
            var ids = checkItems[j] ;
            var listings = countListings();

            document.getElementById("list_summery2").innerHTML="You are about to use "+listings+" Listings";
			
            reqListing = createAjaxRequest();
            var url = "listing.ajax.process.php";
            reqListing.open("POST", url, true);
            reqListing.setRequestHeader(
                'Content-Type',
                'application/x-www-form-urlencoded; charset=UTF-8');
            reqListing.onreadystatechange = function()
            {
                if(reqListing.readyState == 4)
                {
                    var msg=reqListing.responseText;
													
                    document.getElementById("displayMsg").innerHTML="";
                    document.getElementById("displayMsg").style.display='block';
                    document.getElementById("displayMsg").innerHTML= msg;
                }
            }
            reqListing.send("&val=clear");
			
        }
    }
}

function submitData()
{
    values = new Array();
    for(var j=0;j<checkItems.length;j++)
    {
        var id = checkItems[j].split("_");
        var specId = id[id.length-1];
        var manufacturer = document.getElementById("manufacturer_" + specId).value;
        var clearItem = document.getElementById("checkItem_" + specId).checked;
		
        if(clearItem == true)
        {
            values[j] = manufacturer + "||" + checkItems[j];
        }
    }
	
    reqListing = createAjaxRequest();
    var url = "listing.ajax.process.php" ;
    reqListing.open("POST", url, true);
    reqListing.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
    reqListing.onreadystatechange = function()
    {
        addDataPage();
    }
    reqListing.send("arry=" + values + "&val=add");
}

function addDataPage()
{
    if(reqListing.readyState == 4)
    {
        var msg=reqListing.responseText;
        document.getElementById("displayMsg").innerHTML="";
        document.getElementById("displayMsg").style.display='block';
        document.getElementById("displayMsg").innerHTML= msg;
    }
}

function doSearch(fieldName,file)
{
    var options = {
        script:file+"?json=true&",
        varname:"input",
        json: true
    };
    var as_json = new AutoSuggest(fieldName, options);

}

function newPopup(url) {
    popupWindow = window.open(
        url,'popUpWindow','height=458,width=700,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
}


var preDiv=false;
function change_div_color(div_id){ // for change color - add by maduranga 
   if(preDiv){
       $('#'+preDiv).attr("style", 'background-color:#FFF7C6 !important; background: none;');
   }
    $('#'+div_id).attr("style", 'background-color:#FFEC72 !important; background: none;');
   preDiv=div_id;
   
   $('#list_submit_button-BT').hide(); 
   $('#list_submit_button-hover-BT').show();
   $('#list_submit_button-BT-2').hide(); 
   $('#list_submit_button-hover-BT-2').show();
}

function addExtraDetails(control,id,div_id)
{
    // $('.tr-class').attr("style", 'background-color:#FFF7C6;');
    /*
   if(preDiv){
       $('#'+preDiv).attr("style", 'background-color:#FFF7C6 !important; background: none;');
   }
    $('#'+div_id).attr("style", 'background-color:#FFEC72 !important; background: none;');
   preDiv=div_id;*/
   change_div_color(div_id);
    /**
     *Submit button color change
     **/
    /*
   $('#list_submit_button-BT').hide(); 
   $('#list_submit_button-hover-BT').show();
   $('#list_submit_button-BT-2').hide(); 
   $('#list_submit_button-hover-BT-2').show();*/
    
    var title=document.getElementById('list_title_' + control).value;
    document.getElementById('divListName').innerHTML=title;
    var images_list = '';
    for(var i = 1;i<5;i++){
        if(i==1){
            images_list += document.getElementById('list_img_' + control).value+'|*|';
        }
        else{
            images_list += document.getElementById('list_img'+i+'_' + control).value+'|*|';
        }
    }
    
    var pass_details = 
        //alert();
    pass_details+=document.getElementById('list_img_'+control).value+'-dlm-';//0
    pass_details+=document.getElementById('list_img2_'+control).value+'-dlm-';//1
    pass_details+=document.getElementById('list_img3_'+control).value+'-dlm-';//2
    pass_details+=document.getElementById('list_img4_'+control).value+'-dlm-';//3
    pass_details+=document.getElementById('list_des_'+control).value+'-dlm-';//4
    pass_details+=document.getElementById('list_sup_'+control).value+'-dlm-';//5
    pass_details+=document.getElementById('list_spec_'+control).value+'-dlm-';//6
    pass_details+=document.getElementById('list_head_'+control).value+'-dlm-';//7
    //pass_details+=document.getElementById('list_del_'+control).value+'-dlm-';//8
    pass_details+=document.getElementById('delivery_'+control).value+'-dlm-';//8
    pass_details+=document.getElementById('list_rate_'+control).value+'-dlm-';//9
    pass_details+=document.getElementById('list_url_'+control).value+'-dlm-';//10
    
    handleInputBox('block');
    getListingExtra(control,id,images_list,pass_details);
}

function cancelExtraDetails()
{
    handleInputBox('none');
    document.getElementById('divContainer').innerHTML="";
}

function commitExtraDetails(control)
{ 
   
    var descript=document.getElementById('listED').value;
    var spec=document.getElementById('listSPEC').value;
    var listheader=document.getElementById('listheader').value;
    var delivery=document.getElementById('select_delivery').value;
    var delrate=document.getElementById('select_rate').value;
    var url=document.getElementById('product_url').value;
    var supplier_code=document.getElementById('supplier_code').value;
    var image=document.getElementById('keyName_'+control).value;
    var image2=document.getElementById('keyName1_'+control).value;
    var image3=document.getElementById('keyName2_'+control).value;
    var image4=document.getElementById('keyName3_'+control).value;
    var imagePath=document.getElementById('imagePath').value;
    var blankimagePath = document.getElementById('blankimagePath').value;
    var images_list = new Array();
    //alert(image+'>>list_img_'+control);
   
    if(image==""){
        image = "no_image.jpg";
        //imagePath=document.getElementById('blankimagePath').value;
    }
    else{
        images_list[0] = image;
    }
    if(image2==""){
        image2 = "no_image.jpg";
        //imagePath=document.getElementById('blankimagePath').value;
    }
     else{
        images_list[1] = image2;
    }
    if(image3==""){
        image3 = "no_image.jpg";
        //imagePath=document.getElementById('blankimagePath').value;
    }
     else{
        images_list[2] = image3;
    }
    if(image4==""){
        image4 = "no_image.jpg";
        //imagePath=document.getElementById('blankimagePath').value;
    }
     else{
        images_list[3] = image4;
    }
    //alert(delrate);
   // document.getElementById('already_image2').value = image2;
   
    document.getElementById('list_img_'+control).value=image;
    document.getElementById('list_img2_'+control).value=image2;
    document.getElementById('list_img3_'+control).value=image3;
    document.getElementById('list_img4_'+control).value=image4;
    document.getElementById('list_des_'+control).value=descript;
    document.getElementById('list_sup_'+control).value=supplier_code;
    document.getElementById('list_spec_'+control).value=spec;
    document.getElementById('list_head_'+control).value=listheader;
    document.getElementById('list_del_'+control).value=delivery;
    document.getElementById('list_rate_'+control).value=delrate;
    document.getElementById('list_url_'+control).value=url;
    document.getElementById('actual_list_rate_'+control).value=delrate;
   //document.getElementById('delivery_'+control).value=delrate;
    //$('#delivery_'+control).val(delrate);
    //alert(image.indexOf("no_image.jpg"));
    
    
    if(delivery==0){ // Free UK
    	document.getElementById('delivery_'+control).value='Free';
        document.getElementById('actual_list_rate_'+control).value='Free';
        document.getElementById('delivery_show_'+control).value='Free';
        document.getElementById('delivery_show_'+control+'_div').innerHTML='Free';
    }else if(delivery==1){ // ring for details
    	document.getElementById('delivery_'+control).value='Ring';
        document.getElementById('actual_list_rate_'+control).value='Ring';
        document.getElementById('delivery_show_'+control).value='Ring';
        document.getElementById('delivery_show_'+control+'_div').innerHTML='Ring';
    }else{
    	if(isNaN(delrate)){ delrate ='Free'; }
    	document.getElementById('delivery_'+control).value=delrate;
        document.getElementById('actual_list_rate_'+control).value=delrate;
        document.getElementById('delivery_show_'+control).value=delrate;
        document.getElementById('delivery_show_'+control+'_div').innerHTML=delrate;
    }
   /* if(delivery>0){
        if(delivery==1 && delrate==0){
            document.getElementById('delivery_'+control).value=delrate;
            document.getElementById('actual_list_rate_'+control).value='0';
            document.getElementById('delivery_show_'+control).value='Ring';
            document.getElementById('delivery_show_'+control+'_div').innerHTML='Ring';
        }
        else{
            document.getElementById('delivery_'+control).value=delrate;
            document.getElementById('actual_list_rate_'+control).value=delrate;
            document.getElementById('delivery_show_'+control).value=delrate;
            document.getElementById('delivery_show_'+control+'_div').innerHTML=delrate;
        }
        
    }
    else if(delivery==0){
        document.getElementById('delivery_'+control).value="0";
        document.getElementById('actual_list_rate_'+control).value='0';
        document.getElementById('delivery_show_'+control).value='Ring';
        document.getElementById('delivery_show_'+control+'_div').innerHTML='Ring';
    }
    else{
     
    }*/
    if(image.indexOf("no_image.jpg")>=0||image=="0"){    	
         document.getElementById('thumb_'+control).setAttribute("src", blankimagePath + 'no_image.jpg');
    }
    else{
         document.getElementById('thumb_'+control).setAttribute("src", imagePath+ image);
    }
    
    
    handleInputBox('none');

}

function handleInputBox(action)
{
    document.getElementById('divInputBox').style.display=action;
    document.getElementById('divInputFader').style.display=action;
}

function getListingExtra(control,id,images_list,pass_details)
{
   handleProcessMsg('block','divLoader');
//    handleProcessMsg('none','etbcMsg');
//    handleProcessMsg('none','closeExpandTotalBillCycle');
    var string ="&control=" + control  + "&id=" + id + "&image_list="+ images_list + "&pass_details=" + pass_details  ;
    reqCdrop = createAjaxRequest();
    reqCdrop.open("POST", "listing_ext_details.ajax.tpl.php", true);
    reqCdrop.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
    reqCdrop.onreadystatechange = gotListingExtra;
    reqCdrop.send(string);
}

function gotListingExtra()
{
    if (reqCdrop.readyState == 4)
    {
        handleProcessMsg('none','divLoader');
        //document.getElementById('divContainer').innerHTML=reqCdrop.responseText;
        $('#divContainer').html(reqCdrop.responseText);
    }

}

function changeText(element,evnt){
    var event = evnt;
    var id = element.id;
    if(event=="focus"){
        document.getElementById(id).value = "";
    }
    else{
        if(document.getElementById(id).value==""||document.getElementById(id).value==document.getElementById('specdesc').value){
            document.getElementById(id).value = document.getElementById('specdesc').value;
        }
        else{
            
        }
    }
    
}

// added by sudharshan
function toggleselection2(divselect,target){
	var del = $('#'+divselect).val();
	if(del=='0'||del=='1'){
		$('#'+target).attr("disabled", "disabled");
	}else{
		var val_t= $('#'+target).val();
		
		if(val_t=="Ring" || val_t=="ring" || val_t=="Free" || val_t=="free"){
			//document.getElementById('#'+target).value="";
			$('#'+target).val("");
		}
		
		$('#'+target).attr("disabled", "");
	}
}

function toggleselection(divselect,target){
    var del = $('#'+divselect).val();   
    //alert(del);
    if(del=='0'||del=='-'){
        
        $('#'+target).val('0');
        $('#'+target).attr("disabled", "disabled");
    }
    else{
        $('#'+target).attr("disabled", "");
    }
}

function setSelectedIndex(s, v) {
                        for ( var i = 0; i < s.options.length; i++ ) {
                            if ( s.options[i].value == v ) {
                            s.options[i].selected = true;
                            //alert(s.options[i].selected);
                        }
                       }
                    }