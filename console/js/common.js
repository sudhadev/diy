//-----------------------------------------------------------------
//  Written by Saliya Wijesinghe @FUSIS IT
//  Email: saliyasoft@gmail.com
//  Phone: +94773505072
//-----------------------------------------------------------------
   function zoom(preURL,img,com)
   {
               args="width="+100+",height="+100+",resizable=no,scrollbars=no,status=0";
               myUrl=preURL + "/modules/misc/zoom_prods.php?img=" + img + "&com=" + com;
               window.open(myUrl,"Zoom",args);
   }
   
   function print_pg(URL)
   {
               args="width="+700+",height="+400+",resizable=no,scrollbars=no,status=0";
               window.open(URL,"Print",args);
   }
   function  pop_help()
   {
               args="width="+750+",height="+495+",resizable=no,scrollbars=no,status=0";
               window.open("../help/" ,"Help",args);
   }


 

   function conf(com,act)
   {

        /*switch (com){
                 //  case "0007":  var valid=validate_com_0007(act);  break;
        } */
           valid='yes';

           if(valid=='yes')
           {
             switch (act){
                     case 'edit':document.frmSetupCart.submit();break;

             }

           }
           else if(valid)
           {
                   alert(valid);
           }

   }


   function del(id,ajax,page){
          if(confirm("The Selected Record will be Deleted")){
			  if(ajax == true && page == "cat")
			  {
				  deleteData(id);
			  } else if(ajax == true && page == "spec")
			  {
				  deleteSpecData(id);
			  } else if (ajax == true && page == "listing")
              {
                 deleteListing(id);
              }else
			  {
				  document.location.href="?action=&action=delete&id="+id;
			  }
          }
   }

      function restore(id,ajax,page){
          if(confirm("The Selected Record will be Restored")){
              if (ajax == true && page == "listing")
              {
                 restoreListing(id);
              }else
			  {
				  document.location.href="?action=&action=restore&id="+id;
			  }
          }
   }


  function call_url(url){
		document.location.href=url;
  }  
  
   
     
function logout(msg,url){
	  
	    if(confirm(msg)){
             // document.frmLg.submit();
			 document.location.href=url;
          }
}
  
function cancel(){
	history.back();

}



/*AJAX INCLUTION

*/

var request = null;

function create_request(){
		try {
			 request= new XMLHttpRequest();
		} catch (microsoft){
			try {
				request= new ActiveXObject("Msx12.XMLHTTP");
			} catch (othermicrosoft){
				try {
					request= new ActiveXObject("Microsoft.XMLHTTP");
				}catch (fail){
					request =null;
				}
			}
		}
		
		if(request==null){
				alert ("Error Creating Request Object");
		}
}


function printURL(url){
	create_request();
	request.open("GET", url, true);
	//request.onreadystatechange=updateLPane;
	request.send(null);
}


function qString( form )
{
    var qStr="";var length = form.elements.length
    for( var i = 0; i < length; i++ )
    {
        element = form.elements[i]
		//alert("===>"+element.tagName.toLowerCase());
        switch (element.tagName.toLowerCase())
        {
            case 'textarea':
                qStr+="&"+ element.name + "=" + element.value;
            break;

            case 'input':
				//alert(element.type);
                if( element.type == 'text' || element.type == 'hidden' || element.type == 'password')
                {
                       qStr+="&"+ element.name + "=" + element.value;
                }
                else if( element.type == 'radio' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on"
                        else
                                qStr+="&"+ element.name + "=" + element.value;

                }
                else if( element.type == 'checkbox' && element.checked )
                {
                        if( !element.value )
                                params[element.name] = "on"
                        else
                                qStr+="&"+ element.name + "=" + element.value;
                }
             break;
			 
			   case 'select':
				//alert("<<<<<<<< "+element.type);
				 //alert("came here........... "+ element.selected);
                if( element.type == 'select-one')
                {
                      // alert("came here "+ element);
					   if( !element.value )
                                params[element.name] = "on"
                        else
                                qStr+="&"+ element.name + "=" + element.value;
                }
             break;
        }
    }
	//alert(qStr);
    return qStr;

}


function printInvoice(iframeId,url)
{
    if(getBrowser()=='ie')
    {
            print_pg(url) ;
    }
    else
    {
            document.getElementById(iframeId).src=url;
    }

}

function getBrowser() {
  var sBrowser = navigator.userAgent;
  if (sBrowser.toLowerCase().indexOf('msie') > -1) return 'ie';
  else if (sBrowser.toLowerCase().indexOf('firefox') > -1) return 'firefox';
  else return 'mozilla';
}