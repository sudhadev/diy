

function selectOpt(flag)
{
     toggleStatus();
    switch(flag)
    {
        case "M":
            {
                document.getElementById("materials").checked=true;
            }
            break;

        default:
            {
                document.getElementById("services").checked=true;
            }
    }


}

function selectSubOpt(clicked)
{
    var selOpt='';


     switch(clicked)
    {
        case "M":
            {
                 selOpt=document.getElementById("selMOption").value;
                 switch (selOpt.substring(0,1))
                 {
                     case "b":
                         handleButtons('bronze');
                         break;
                     case "s":
                         handleButtons('silver');
                         break;
                     case "g":
                         handleButtons('gold');
                         break;



                 }

                 document.getElementById('prBox').setAttribute('class', 'active');
                 document.getElementById('clistplan').setAttribute('class', 'active');
                 document.getElementById('prCode').disabled=false;
            }
            break;
        default:
            {
                 selOpt="one_month";
                 document.getElementById('prBox').setAttribute('class', 'inactive');
                 document.getElementById('clistplan').setAttribute('class', 'inactive');
                 document.getElementById('prCode').disabled=true;
            }
    }
 toggleStatus();
 document.getElementById(selOpt).checked=true;
}


function toggleStatus() {
    if ($('#materials').is(':checked')) {
        $('#elementsToOperateOn :input').removeAttr('disabled');
		$('#elementsToOperateOn2 :input').attr('disabled', true);
		document.getElementById("subsSupplies").setAttribute("class","subs_suppEnable");
		document.getElementById("subsServices").setAttribute("class","subs_servDisable");

    } else if ($('#services').is(':checked')) {
		$('#elementsToOperateOn :input').attr('disabled', true);
		$('#elementsToOperateOn2 :input').removeAttr('disabled');

		document.getElementById("subsSupplies").setAttribute("class","subs_suppDisable");
		document.getElementById("subsServices").setAttribute("class","subs_servEnable");
		//$('#elementsToOperateOn :').attr('class', 'heading_glod_desable');

    }
    else
        {
    	$('#elementsToOperateOn2 :input').attr('disabled', true);
		if(document.getElementById("subs_servEnable")) document.getElementById("subs_servEnable").setAttribute("class","subs_servDisable");

 		$('#elementsToOperateOn :input').attr('disabled', true);
		if(document.getElementById("subs_suppEnable")) document.getElementById("subs_suppEnable").setAttribute("class","subs_suppDisable");
        }


}





function disableAll()
{
   		$('#elementsToOperateOn2 :input').attr('disabled', true);
		document.getElementById("subs_servEnable").setAttribute("id","subs_servDisable");

 		$('#elementsToOperateOn :input').attr('disabled', true);
		document.getElementById("subs_suppEnable").setAttribute("id","subs_suppDisable");
}


function handleButtons(button)
{
	   	document.getElementById("gold").style.display="none";
	   	document.getElementById("silver").style.display="none";
	   	document.getElementById("bronze").style.display="none";
		document.getElementById(button).style.display="block";



}