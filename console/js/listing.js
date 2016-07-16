
function selectCategoryLevel(cPath)
{
    document.getElementById("divMessage").innerHTML= "";
    var urlValue = location.search.substring(1);
    var str = urlValue.split('=');
    getListings(str[1], cPath);
}

function getListings(cusId, ids, pg)
{
    
    var time="";
    document.getElementById("divMessage").innerHTML= "";
    createRequest();
	var url = "listing.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = showListings;
    if(document.getElementById("time")!=null)
    {time = document.getElementById("time").value;}
	request.send("cusId="+cusId+"&ids="+ids+"&pg="+pg+"&time="+time);
}

function showListings()
{
    if (request.readyState == 4)
    {
        var listingData = request.responseText;
        document.getElementById('page_body').innerHTML = listingData;
    }
}

function getEditListing(cusId, ids)
{   
	createRequest();
	var url = "listing_edit.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = showeditListing;
	request.send("cusId="+cusId+"&ids="+ids);
}

function showeditListing()
{
    if (request.readyState == 4)
    {
        var editData = request.responseText;
        document.getElementById('page_body').innerHTML = editData;
    }
}

function deleteListing(deleteId)
{
    createRequest();
	var url = "listing.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = showDeleteListing;
	request.send("deleteId="+deleteId);
}

function showDeleteListing()
{
    if (request.readyState == 4)
    {
        var deleteData = request.responseText;
        document.getElementById('divMessage').innerHTML = deleteData;
        document.getElementById('spanStatus').innerHTML="Inactive";
        document.getElementById("faButton").setAttribute("onClick","javascript:activate();");
        document.getElementById("faButton").setAttribute("value","     Activate     ");
        showReason('Y');

    }
}

function restoreListing(restoreId)
{   
	
    createRequest();
	var url = "listing.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = showRestoreListing;
	request.send("restoreId="+restoreId);
}


function showRestoreListing()
{
    if (request.readyState == 4)
    {
        var restoreData = request.responseText;
        document.getElementById('divMessage').innerHTML = restoreData;
        document.getElementById('spanStatus').innerHTML="Active";
        document.getElementById("faButton").setAttribute("onClick","javascript:deactivate();");
        document.getElementById("faButton").setAttribute("value"," Deactivate ");
        showReason('');
    }
}

function editListing(cusId, data, id)
{
    createRequest();
	var url = "listing_edit.ajax.php";
	request.open("POST", url, true);
	request.setRequestHeader(
    		'Content-Type',
    		'application/x-www-form-urlencoded; charset=UTF-8');
	request.onreadystatechange = showRestoreListing;
	request.send("cusId="+cusId+"data="+data+"id="+id);
}

function showReason(parameter)
{   
    if (parameter != 'Y')
    {
       document.getElementById('reason').style.display = 'block';
       document.getElementById('reasonD').style.display = 'none';

    }
    else
    {
        document.getElementById('reason').style.display = 'none';
        document.getElementById('reasonD').style.display = 'block';
    }
}

function deactivate(){
    if(document.getElementById('reason_text').value=="")
    {
        document.getElementById("reason_text").setAttribute("style","border-color:#FF0000;");
    }
    else
    {
        var id =document.getElementById('faId').value + "_" + document.getElementById('reason_text').value;
        var ajax =document.getElementById('faAjax').value;
        var page =document.getElementById('faPage').value;

          if(confirm("Are you sure you want to Deactivate"))
          {
              if (ajax !="" && page == "listing")
              {
                 deleteListing(id);
              }else
			  {
				  document.location.href="?action=&action=restore&id="+id;
			  }
          }
    }
   }

function activate(){
	var id =document.getElementById('faId').value;
	var ajax =document.getElementById('faAjax').value;
	var page =document.getElementById('faPage').value;
	
      if(confirm("Are you sure you want to Activate")){
          if (ajax !="" && page == "listing")
          {
             restoreListing(id);
          }else
          {
              document.location.href="?action=&action=restore&id="+id;
          }
      }
}

function Popup(url) {
  popupWindow = window.open(
   url,'popUpWindow',  'height=560,width=536,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
 }
