var reqRequestListing = null; //the request object name.

function editCat(category,id,parent,level,mainCat)
{
    var imgValue = "";

    var cname = document.getElementById("category_name").value;
    if(level == "2")
    {
       imgValue = document.getElementById("keyName").value;
    }
    reqRequestListing = createAjaxRequest();
    var url = "request_listing.ajax.php";
    reqRequestListing.open("POST", url, true);
    reqRequestListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqRequestListing.onreadystatechange = function()
    {
        if(reqRequestListing.readyState == 4)
        {
            var msg = reqRequestListing.responseText;
            var suc_err = msg.split("||");
            document.getElementById("error_msg").innerHTML = suc_err[0];
            
            if(suc_err[1]=="SUC")
            {
                location.replace("?category="+mainCat);
            } 
        }
    }
    reqRequestListing.send("cn="+cname + "&cat=" + category + "&id=" + id + "&pare=" + parent + "&lvl=" + level + "&img=" + imgValue + "&val=editCat");
}

function refreshDropDown(type,newAddedValue,specId)
{
    if(type == 'manufac')
    {
        var subcategory = document.getElementById("cat_spec_select").value;
        newAddedValue = subcategory;
        //alert("2 = " + newAddedValue);
    }
    
    reqRequestListing = createAjaxRequest();
    var url = "new_listing.ajax.php";
    reqRequestListing.open("POST", url, true);
    reqRequestListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqRequestListing.onreadystatechange = function()
    {
        if(reqRequestListing.readyState == 4)
        {
            var msg = reqRequestListing.responseText;
            //alert("msg = " + msg);
            var suc_err = msg.split("||");
            
            switch(type)
            {
                case 'cate':
                {
                    if(suc_err[1]=="SUC")
                    {
                        location.replace("?req=cate&ids="+suc_err[2]);
                    }
                } break;

                case 'manufac':
                {
                    if(suc_err[1]=="ERR")
                    {
                        document.getElementById("spec_drop_down").innerHTML = suc_err[2];
                        document.getElementById("error_msg").innerHTML = suc_err[0];
                    } else if(suc_err[1]=="SUC")
                    {
                        document.getElementById("error_msg").innerHTML = "";
                        document.getElementById("spec_drop_down").innerHTML = suc_err[0];
                    }
                } break;
            }
        }
    }
    reqRequestListing.send("val=refreshDropDown" + "&type="+ type + "&addedVal=" + newAddedValue + "&specId=" + specId);
}

function selectCat(id_lvl)
{
    var id_level = id_lvl.split("||");
    //var id = id_level[0];
    var level = id_level[1];
   
   if(level == 2)
   {
       document.getElementById('catDiv').style.height = "260px";
   } else
   {
       document.getElementById('catDiv').style.height = "130px";
   }
}

function editSpec(ids)
{
    var specification = document.getElementById("specification").value;
    var keywords = document.getElementById("keywords").value;
    var keyName = document.getElementById("keyName").value;
    reqRequestListing = createAjaxRequest();
    var url = "request_listing.ajax.php" ;
    reqRequestListing.open("POST", url, true);
    reqRequestListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqRequestListing.onreadystatechange = function()
    {
        if(reqRequestListing.readyState == 4)
        {
            var msg = reqRequestListing.responseText;
            var suc_err = msg.split("||");

            document.getElementById("error_msg").innerHTML = suc_err[0];
            if(suc_err[1]=="SUC")
            {
                location.replace("?f=spec&category=1");
            } 
        }
    }
    reqRequestListing.send("val=editSpec" + "&spec=" + specification + "&kWords=" + keywords+ "&ids=" + ids + "&keyName=" + keyName);
}
