var reqNewListing = null; //the request object name.
var count = 0; // used to identify whether some filed change or not in the perticular section.
var newOpenDivision = ""; //to get the open div name when page loading
var lastDivision = "";
var divArry = new Array(); // to keep the clicking div names
var m = 0; // to keep the count of clicking div names array
var msgState = "PENDING";
var saveChangesAlert = false;
var change = "no_changes";

function resetData()
{
    count = 0;
    change = "no_changes";
    m = 0;
    divArry = new Array(); 
    setOpenDivToArry();
    msgState = "PENDING";
    saveChangesAlert = false;
}

function setOpenDivToArry()
{
    divArry[m++] = document.getElementById("displayDiv").value;
}

function addCatData()
{
    var category = document.getElementById("category_selection").value;
    var subcategory = document.getElementById("category_name").value;
    var image = document.getElementById("keyName").value;

    reqNewListing = createAjaxRequest();
    var url = "new_listing.ajax.php";
    reqNewListing.open("POST", url, true);
    reqNewListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqNewListing.onreadystatechange = function()
    {
        if(reqNewListing.readyState == 4)
        {
            var msg = reqNewListing.responseText;
            var suc_err = msg.split("||");
            document.getElementById("error_msg").innerHTML = suc_err[0];
            
            if(suc_err[1]=="SUC")
            {
                var topCatId = document.getElementById("topCatId").value;
                document.getElementById("category_name").value='';
                document.getElementById("keyName").value='';
                document.getElementById("uploadingImg").innerHTML='';
                if(topCatId == 1)
                {
                    displaySpec(category,subcategory);
                } else
                {
                    var ids = category.split("_");
                    catId = ids[0];
                    level = ids[1];
                  
                    if(saveChangesAlert == false)
                    {
                        msgState = "PENDING";
                        if(level == 0)
                        {
                            refreshDropDown('cate',subcategory,'');
                        }
                        
                    } else
                    {
                        msgState = "SUC";
                        count = 1;
                        change = "no_changes";

                        if(level == 0)
                        {
                            refreshDropDown('cate',subcategory,'');
                        }
                        collapse_expand(newOpenDivision,lastDivision);
                        msgState = "PENDING";
                    }
                }
            } else
            {
                if(saveChangesAlert == false)
                {
                    msgState = "PENDING";
                } else
                {
                    msgState = "ERR";
                    collapse_expand(newOpenDivision,lastDivision);
                    msgState = "PENDING";
                }
            }
            //alert("0 = "+msgState);
        }
    }
    reqNewListing.send("val=addCat" + "&cat="+ category + "&subcat=" + subcategory + "&img=" + image);  
}

function refreshDropDown(type,newAddedValue,specId)
{
    if(type == 'manufac')
    {
        var subcategory = document.getElementById("cat_spec_select").value;
        newAddedValue = subcategory;
        //alert("2 = " + newAddedValue);
    }
    
    reqNewListing = createAjaxRequest();
    var url = "new_listing.ajax.php";
    reqNewListing.open("POST", url, true);
    reqNewListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqNewListing.onreadystatechange = function()
    {
        if(reqNewListing.readyState == 4)
        {
            var msg = reqNewListing.responseText;
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
    reqNewListing.send("val=refreshDropDown" + "&type="+ type + "&addedVal=" + newAddedValue + "&specId=" + specId);
}

function displaySpec(category, subcategory)
{
    var ids = category.split("_");
    catId = ids[0];
    level = ids[1];
    if(level == 1)
    { 
        reqNewListing = createAjaxRequest();
        var url = "new_listing.ajax.php" ;
        reqNewListing.open("POST", url, true);
        reqNewListing.setRequestHeader(
        'Content-Type',
        'application/x-www-form-urlencoded; charset=UTF-8');
        reqNewListing.onreadystatechange = function()
        {
            if(reqNewListing.readyState == 4)
            {
                var msg = reqNewListing.responseText;
                var suc_err = msg.split("||");
                if(suc_err[1] == "ERR")
                {
                    document.getElementById("error_msg").innerHTML = suc_err[0];
                    location.replace("?req=spec&ids="+suc_err[2]);
                }
                location.replace("?req=spec&ids="+suc_err[2]);
            }
        }
        
    reqNewListing.send("val=showSpec" + "&cat="+ category + "&subcat=" + subcategory);

    } else
    {
        if(saveChangesAlert == false)
        {
            msgState = "PENDING";
            refreshDropDown('cate',subcategory,'');

        } else
        {
            msgState = "SUC";
            count = 1;
            change = "no_changes";
           // alert("new div = " + newOpenDivision);
           // alert("last div = " + lastDivision);
            refreshDropDown('cate',subcategory,'');
            collapse_expand(newOpenDivision,lastDivision);
            msgState = "PENDING";
        }
    }
}

function changeHeight()
{
    //alert("image1");
    
    var image = document.getElementById("keyName").value;
    
    if(image)
    {
        //alert(image);
       // document.getElementById('catDiv').style.height = "250px";
    }else
        {
             //alert("image2");
        }
   
}

function selectCat()
{
   var category = document.getElementById("category_selection").value;
   var cat = category.split("_");
   var level =  cat[1];
   document.getElementById("specialInfo").style.display='block'; // Added By saliya
   if(level == 1)
   {
       //document.getElementById('catDiv').style.height = "240px";
       document.getElementById("divImage").style.display='block';

       document.getElementById("addSecCat").style.display='none';// Added By saliya
       document.getElementById("addThirdCat").style.display='block';// Added By saliya

   } else
   {
       //document.getElementById('catDiv').style.height = "130px";
       document.getElementById("divImage").style.display='none';
       document.getElementById("addSecCat").style.display='block';// Added By saliya
       document.getElementById("addThirdCat").style.display='none';// Added By saliya
   }
   
   var topCatId = document.getElementById("topCatId").value;

   if(topCatId == 1)
   {
        document.getElementById("specAndManu").style.display='block';
   } else
   {
        document.getElementById("specAndManu").style.display='none';
   }
}

function addSpecData()
{
    var subcategory = document.getElementById("cat_spec_selection").value;
    var specification = document.getElementById("specification").value;
    var manufacturer = document.getElementById("manufacturer").value;
    var keywords = document.getElementById("keywords").value;
    //var supplier_code = document.getElementById("supplier_code").value;
    var imgValue = document.forms['frmSpecification']['keyName'].value;
    
    reqNewListing = createAjaxRequest();
    var url = "new_listing.ajax.php" ;
    reqNewListing.open("POST", url, true);
    reqNewListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqNewListing.onreadystatechange = function()
    {
        if(reqNewListing.readyState == 4)
        {
            var msg = reqNewListing.responseText;
            var suc_err = msg.split("||");

            document.getElementById("error_msg").innerHTML = suc_err[0];
            if(suc_err[1]=="SUC")
            {
               count = 1;
               change = "no_changes";
               if(saveChangesAlert == false)
               {
                    //animatedcollapse.toggle('spec');
                    //animatedcollapse.toggle('manufac');
                   // collapse_expand('manufac','spec');
                    count = 0;
               } else
               {
                    collapse_expand(newOpenDivision,lastDivision);
               }
               msgState = "SUC";
               
               $('#specification').val('');
               $('#manufacturer').val('');
               $("#cat_spec_selection").val('');
               //location.replace("?req=manufac&ids="+suc_err[2]+"&specId="+suc_err[3]);
            } else
            {
                if(saveChangesAlert == false)
                {
                    msgState = "PENDING";
                } else
                {
                    msgState = "ERR";
                    collapse_expand(newOpenDivision,lastDivision);
                    msgState = "PENDING";
                }
            }
           //alert("1 = "+msgState);
        }
    }
    reqNewListing.send("val=addSpec" + "&subcat="+ subcategory + "&spec=" + specification + "&manu=" + manufacturer + "&kWords=" + keywords + "&img=" + imgValue);
}

function addManufacData()
{
    // msgState = "SUC";

    var subcategory = document.getElementById("cat_spec_select").value;
    var specification = document.getElementById("spec_selection").value;
    
    var manu = document.getElementById("manu_name").value;
    //alert("manufacturer = "+manu);

    reqNewListing = createAjaxRequest();
    var url = "new_listing.ajax.php" ;
    reqNewListing.open("POST", url, true);
    reqNewListing.setRequestHeader(
    'Content-Type',
    'application/x-www-form-urlencoded; charset=UTF-8');
    reqNewListing.onreadystatechange = function()
    {
        if(reqNewListing.readyState == 4)
        {
            var msg = reqNewListing.responseText;
            //alert("msg = " + msg);
            var suc_err = msg.split("||");
            document.getElementById("error_msg").innerHTML = suc_err[0];
            
            if(suc_err[1]=="SUC")
            {
              msgState = "SUC";
              count = 1;
              change = "no_changes";
              if(saveChangesAlert == true)
               {
                    collapse_expand(newOpenDivision,lastDivision);
               } 
               
               $('#cat_spec_select').val('');
               $('#spec_selection').val('');
               $('#manu_name').val('');
            } else
            {
                //msgState = "ERR";
                if(saveChangesAlert == false)
                {
                    msgState = "PENDING";
                } else
                {
                    msgState = "ERR";
                    collapse_expand(newOpenDivision,lastDivision);
                    msgState = "PENDING";
                }
            }
        }
    }
    reqNewListing.send("val=addManufac" + "&subcat="+ subcategory + "&spec=" + specification + "&manu=" + manu);

}

function clickSave()
{
    count = 1;
}

function doChanges()
{
    change = "do_changes";
}

function saveChanges(openDiv)
{
    newOpenDivision = openDiv;
    lastDivision = divArry[divArry.length-1];
   // alert("count = " + count);
    if(count == 0 && change == "do_changes")
    {
        if(confirm("Do you want to save the changes?"))
        {
            saveChangesAlert = true;
            switch(lastDivision)
            {
                case "cate":
                {
                    addCatData();
                } break;

                case "spec":
                {
                    addSpecData();
                } break;

                case "manufac":
                {
                    addManufacData();
                } break;
            }
            
            //collapse_expand(openDiv,lastDiv);
            //msgState = "PENDING";
        } else
        {
            msgState = "PENDING";
            if(newOpenDivision == 'manufac')
            {
                refreshDropDown('manufac','','');
            }
            collapse_expand(newOpenDivision,lastDivision);
            count = 0;
            change = "no_changes";
            saveChangesAlert = false;
        }
    } else
    {
        if(newOpenDivision == 'manufac')
        {
            refreshDropDown('manufac','','');
        }
        //alert("open div = "+newOpenDivision);
        //alert("old div = "+lastDivision);
        collapse_expand(newOpenDivision,lastDivision);
        count = 0;
        change = "no_changes";
        msgState = "PENDING";
        saveChangesAlert = false;
    }
}

 function collapse_expand(openDiv,lastDiv)
 {
    /* alert("2 = "+msgState);
     alert("open div = "+openDiv);
     alert("old div = "+lastDiv);*/

     if(msgState != "ERR")
     {
         //document.getElementById("error_msg").innerHTML = "";
         if(lastDiv == openDiv)
         {
             //animatedcollapse.toggle(lastDiv);
             divArry[m++] = openDiv;
         
         } else
         {
            
             animatedcollapse.toggle(lastDiv);
             animatedcollapse.toggle(openDiv);
             divArry[m++] = openDiv;
         }
     } 
     
 }

function doSearch(fieldName,file)
{
	var options = {
			script:file+"?json=true&",
			varname:"input",
			json:true
		};
	var as_json = new AutoSuggest(fieldName, options);

}