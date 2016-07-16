var reqWishList = null;
var checkItems = new Array(); //need to add listing Ids when tick on the check box.
var checkData = 0;

function add(count)
{ 

    var checkVal = new Array();
    var listing_id = new Array();
    var quantity = new Array();
    var subscription = document.getElementById("subscription").value;
    for(var i=0;i<count;i++)
    {
        var choose_item = document.getElementById("checkVal["+i+"]").checked;
        if(choose_item == true)
        {
             checkVal[i] = document.getElementById("checkVal["+i+"]").value+"||"+i;
        }
        
        if(subscription == "M")
        {
            var listing = document.getElementById("listing_id["+i+"]").value;
            listing_id[i] = listing;
            var qty = document.getElementById("quantity["+i+"]").value;
            quantity[i] = qty;
            
        } else
        {
            listing_id[i] = "no_val"
            quantity[i] = "no_qty";
        }
    }

    createRequest();
    var url = "../bin/ajax/wish_list.ajax.php";
    request.open("POST", url, true);
    request.setRequestHeader(
            'Content-Type',
            'application/x-www-form-urlencoded; charset=UTF-8');
    request.onreadystatechange = getAdd;
    request.send("subscri="+subscription+"&check="+checkVal+"&listingId="+listing_id+"&qty="+quantity);
    
        $('#hover-BT').hide(); 
        $('#not-hover-BT').show();
        $('#hover-BT-2').hide(); 
        $('#not-hover-BT-2').show();
}


function getAdd()
{
	if(request.readyState == 4)
        {
		var message=request.responseText;
		var suc_err = message.split("||");
                if(suc_err[1] == "ERR")
		{
                    document.getElementById("error_msg").innerHTML= suc_err[0];
                    
                } else 
		{
                    document.getElementById("error_msg").innerHTML= suc_err[0];
                    document.getElementById("header_wishlist_count").innerHTML = suc_err[2];
		}
	}
}
  
function clearItems(tpl,count)
{
    for(var i=0;i<count;i++)
    {
        var choose_item = document.getElementById("checkVal["+i+"]").checked;
        if(choose_item == true)
        {
             document.getElementById("checkVal["+i+"]").checked = false;
             if(tpl == "M")
             {
                 document.getElementById("quantity["+i+"]").value = "";
             }
        }
    }
}

function selectcheck(checkId,tot){
    //var id = checkId;
   
     //$("INPUT[name=" + checkId + "][type='checkbox']").attr('checked', true);
     document.getElementById(checkId).checked=true
     selectItems(checkId,tot);
     
}

function selectItems(checkId,tot){
    
    //alert(checkId+'**'+tot);
    var setOK=false;
    for(var i=0;i<tot;i++)
    {
        if(document.getElementById("checkVal["+i+"]").checked){
            setOK=true;
        }
    }
    
    if(setOK){
       $('#hover-BT').show(); 
        $('#not-hover-BT').hide();
        $('#hover-BT-2').show(); 
        $('#not-hover-BT-2').hide(); 
    }else{
         $('#hover-BT').hide(); 
        $('#not-hover-BT').show();
        $('#hover-BT-2').hide(); 
        $('#not-hover-BT-2').show();
    }
}