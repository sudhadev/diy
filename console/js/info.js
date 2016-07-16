
	Xoffset = 10;    
	Yoffset = -10;
    
	var popInfo, yIndex = -1000;   

	if (document.layers)
	{
		popInfo=document.info;
	}	 
	else if (document.getElementById && !document.all)
	{
		popInfo=document.getElementById("info").style;
	}	 
	else if (document.all)
	{
		popInfo=document.all.info.style;
	}	 
	if(document.layers)
	{
		document.captureEvents(Event.mousemove);
	}	
	else
	{
		popInfo.display="none"; 
	}
	document.onmousemove=getMouse;

	function showPopup(msg,bgcol) 
	{
		var content="<table width=150 border=1 bordercolor=black cellpadding=2 cellspacing=0 "+
"bgcolor="+bgcol+"><td align=center><font color=black size=2>"+msg+"</font></td></table>";
		yIndex=Yoffset;
 		if(document.layers)
 		{
 			popInfo.document.write(content);
 			popInfo.document.close();
 			popInfo.visibility="visible";
 		}
 		if(document.getElementById && !document.all)
 		{
 			document.getElementById("info").innerHTML=content;
 			popInfo.display='block';
 		}
 		if(document.all)
 		{
 			document.all("info").innerHTML=content;
 			popInfo.display='block';
 		}
	}

	function getMouse(e)
	{
		var x=(document.layers||document.getElementById && !document.all)?e.pageX:event.x+document.body.scrollLeft;
		var y=(document.layers||document.getElementById && !document.all)?e.pageY:event.y+document.body.scrollTop;
		popInfo.left = (x + Xoffset)+"px"; 
		popInfo.top = (y + yIndex)+"px";
		popInfo.opacity = '0.7';
		popInfo.filter = 'alpha(opacity=70)';
	}

	function hidePopup()
	{
		yIndex = -1000; 
		if(document.layers)
		{
			popInfo.visibility="hidden";
		}
		else if (document.getElementById && !document.all||document.all)
		{
			popInfo.display="none";
		} 
	}
