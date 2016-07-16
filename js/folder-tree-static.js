/************************************************************************************************************
Static folder tree
Copyright (C) October 2005  DTHMLGoodies.com, Alf Magne Kalleland

This library is free software; you can redistribute it and/or
modify it under the terms of the GNU Lesser General Public
License as published by the Free Software Foundation; either
version 2.1 of the License, or (at your option) any later version.

This library is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABIliTY or FITNESS FOR A PARTICulAR PURPOSE.  See the GNU
Lesser General Public License for more details.

You should have received a copy of the GNU Lesser General Public
License along with this library; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA

Dhtmlgoodies.com., hereby disclaims all copyright interest in this script
written by Alf Magne Kalleland.

Alf Magne Kalleland, 2006
Owner of DHTMLgoodies.com
	
************************************************************************************************************/	
	
/*
	Update log:
	December, 19th, 2005 - Version 1.1: Added support for several trees on a page(Alf Magne Kalleland)
	January,  25th, 2006 - Version 1.2: Added onclick event to text nodes.(Alf Magne Kalleland)
	February, 3rd 2006 - Dynamic load nodes by use of Ajax(Alf Magne Kalleland)
*/
		
	var idOfFolderTrees = ['dhtmlgoodies_tree'];
	
	var imageFolder = '';	// Path to images
	var folderImage = 'dhtmlgoodies_folder.gif';
	var plusImage = 'up-arrow.jpg';
	var minusImage = 'down-arrow.jpg';
	var initExpandedNodes = '';	// Cookie - initially expanded nodes;
	var useAjaxToLoadNodesDynamically = true;
	var ajaxRequestFile = '';
	var contextMenuActive = false;	// Set to false if you don't want to be able to delete and add new nodes dynamically
	
	var ajaxObjectArray = new Array();
	var topList = new Array();
	var topListId = new Array();
	var treeUlCounter = 0;
	var nodeId = 1;
	var treeLevels = 1;
	var cPath = 0;

	/*
	These cookie functions are downloaded from 
	http://www.mach5.com/support/analyzer/manual/html/General/CookiesJavaScript.htm
	*/
	function Get_Cookie(name) { 
	   var start = document.cookie.indexOf(name+"="); 
	   var len = start+name.length+1; 
	   if ((!start) && (name != document.cookie.substring(0,name.length))) return null; 
	   if (start == -1) return null; 
	   var end = document.cookie.indexOf(";",len); 
	   if (end == -1) end = document.cookie.length; 
	   return unescape(document.cookie.substring(len,end)); 
	} 
	// This function has been slightly modified
	function Set_Cookie(name,value,expires,path,domain,secure) { 
		expires = expires * 60*60*24*1000;
		var today = new Date();
		var expires_date = new Date( today.getTime() + (expires) );
	    var cookieString = name + "=" +escape(value) + 
	       ( (expires) ? ";expires=" + expires_date.toGMTString() : "") + 
	       ( (path) ? ";path=" + path : "") + 
	       ( (domain) ? ";domain=" + domain : "") + 
	       ( (secure) ? ";secure" : ""); 
	    document.cookie = cookieString; 
	} 
	
	function expandAll(treeId)
	{
		var menuItems = document.getElementById(treeId).getElementsByTagName('li');
		for(var no=0;no<menuItems.length;no++){
			var subItems = menuItems[no].getElementsByTagName('ul');
			if(subItems.length>0 && subItems[0].style.display!='block'){
				showHideNode(false,menuItems[no].id.replace(/[^0-9]/g,''));
			}			
		}
	}
	
	function collapseAll(treeId)
	{
		var menuItems = document.getElementById(treeId).getElementsByTagName('li');
		for(var no=0;no<menuItems.length;no++){
			var subItems = menuItems[no].getElementsByTagName('ul');
			if(subItems.length>0 && subItems[0].style.display=='block'){
				showHideNode(false,menuItems[no].id.replace(/[^0-9]/g,''));
			}			
		}		
	}
	
	function getNodeDataFromServer(ajaxIndex,ulId,parentId)
	{
		document.getElementById(ulId).innerHTML = ajaxObjectArray[ajaxIndex].response;
		ajaxObjectArray[ajaxIndex] = false;
		parseSubItems(ulId,parentId);
	}

	
	function parseSubItems(ulId,parentId)
	{
		
		if(initExpandedNodes){
			var nodes = initExpandedNodes.split(',');
		}
		
		var branchObj = document.getElementById(ulId);
		var menuItems = branchObj.getElementsByTagName('li');	// Get an array of all menu items
		for(var no=0;no<menuItems.length;no++){
			var imgs = menuItems[no].getElementsByTagName('IMG');
			if(imgs.length>0)continue;
			nodeId++;
			var subItems = menuItems[no].getElementsByTagName('ul');
			var img = document.createElement('IMG');
			img.src = imageFolder + plusImage;
			img.onclick = showHideNode;
			if(subItems.length==0)img.style.display='none';else{
				subItems[0].id = 'tree_ul_' + treeUlCounter;
				treeUlCounter++;
			}
			var aTag = menuItems[no].getElementsByTagName('A')[0];
			aTag.onclick = showHideNode;
			if(contextMenuActive)aTag.oncontextmenu = showContextMenu;

            /*
             *EDITED by saliya
             *hidden image is created alignment issue and commented following
             *line in order to overcome it.
             *2010-08-30
             **/
							
			//menuItems[no].insertBefore(img,aTag);
			menuItems[no].id = 'dhtmlgoodies_treeNode' + nodeId;


			/*var folderImg = document.createElement('IMG');
			if(menuItems[no].className){
				folderImg.src = imageFolder + menuItems[no].className;
			}else{
				folderImg.src = imageFolder + folderImage;
			}
			menuItems[no].insertBefore(folderImg,aTag);
			*/
			var tmpParentId = menuItems[no].getAttribute('parentId');
			if(!tmpParentId)tmpParentId = menuItems[no].tmpParentId;
			if(tmpParentId && nodes[tmpParentId])showHideNode(false,nodes[no]);	
		}		
	}
		
	
	function showHideNode(e,inputId)
	{ 
		
		

		if(inputId){
			if(!document.getElementById('dhtmlgoodies_treeNode'+inputId))return;
			thisNode = document.getElementById('dhtmlgoodies_treeNode'+inputId).getElementsByTagName('IMG')[0];

		}else {

			thisNode = this;
			if(this.tagName=='A')thisNode = this.parentNode.getElementsByTagName('IMG')[0];	
			cPath = this.getAttribute('cPath');
		}
	

		if(thisNode.style.visibility=='hidden')return;
		var parentNode = thisNode.parentNode;
		var ul = parentNode.getElementsByTagName('ul')[0];

		/*--------   collapse All ul and change the Img --------------------*/

			for(var z=0;z<topList.length;z++){
			if(topListId.indexOf(ul.id)>=0)
			{
				if(ul.id != topList[z][0].id){
				topList[z][0].style.display='none';
				topImg =  topList[z][0].parentNode.getElementsByTagName('IMG')[0];	
				topImg.src = topImg.src.replace(minusImage,plusImage);
				}
			}
			}
		/*--------   END collapse All ul and change the Img --------------------*/

		inputId = parentNode.id.replace(/[^0-9]/g,'');

		if(thisNode.src.indexOf(plusImage)>=0){
		thisNode.src = thisNode.src.replace(plusImage,minusImage);
		
		ul.style.display='block';
		
		/* ------ Set the Id to Cookie -----------*/
		if (initExpandedNodes)
		{
		initExpandedNodes = initExpandedNodes.replace(',' + inputId,'');
		}


			if(!initExpandedNodes)initExpandedNodes = ',';
			if(initExpandedNodes.indexOf(',' + inputId + ',')<0) initExpandedNodes = initExpandedNodes + inputId + ',';
			
			if(useAjaxToLoadNodesDynamically){	// Using AJAX/XMLHTTP to get data from the server
				var firstLi = ul.getElementsByTagName('li')[0];
				var parentId = firstLi.getAttribute('parentId');
				if(!parentId)parentId = firstLi.parentId;
				if(parentId){
					ajaxObjectArray[ajaxObjectArray.length] = new sack();
					var ajaxIndex = ajaxObjectArray.length-1;
					ajaxObjectArray[ajaxIndex].requestFile = ajaxRequestFile + '?parentId=' + parentId + '&treeLevels=' + treeLevels+ '&spId=' + spId;
					ajaxObjectArray[ajaxIndex].onCompletion = function() { getNodeDataFromServer(ajaxIndex,ul.id,parentId); };	// Specify function that will be executed after file has been found					
					ajaxObjectArray[ajaxIndex].runAJAX();		// Execute AJAX function
				}			
			}
			
		}else{
			thisNode.src = thisNode.src.replace(minusImage,plusImage);
			parentNode.getElementsByTagName('ul')[0].style.display='none';
			initExpandedNodes = initExpandedNodes.replace(',' + inputId,'');
		}	

		Set_Cookie('dhtmlgoodies_expandedNodes',initExpandedNodes,500);
		
		return false;
	}
	
	var okToCreateSubNode = true;
	function addNewNode(e)
	{
		if(!okToCreateSubNode)return;
		setTimeout('okToCreateSubNode=true',200);
		contextMenuObj.style.display='none';
		okToCreateSubNode = false;
		source = contextMenuSource;
		while(source.tagName.toLowerCase()!='li')source = source.parentNode;
		
	
		/*
		if (e.target) source = e.target;
			else if (e.srcElement) source = e.srcElement;
			if (source.nodeType == 3) // defeat Safari bug
				source = source.parentNode; */
		//while(source.tagName.toLowerCase()!='li')source = source.parentNode;
		var nameOfNewNode = prompt('Name of new node');
		if(!nameOfNewNode)return;

		uls = source.getElementsByTagName('ul');
		if(uls.length==0){
			var ul = document.createElement('ul');
			source.appendChild(ul);
			
		}else{
			ul = uls[0];
			ul.style.display='block';
		}
		var img = source.getElementsByTagName('IMG');
		img[0].style.visibility='visible';
		var li = document.createElement('li');
		li.className='dhtmlgoodies_sheet.gif';
		var a = document.createElement('A');
		a.href = '#';
		a.innerHTML = nameOfNewNode;
		li.appendChild(a);
		ul.id = 'newNode' + Math.round(Math.random()*1000000);
		ul.appendChild(li);
		parseSubItems(ul.id);
		saveNewNode(nameOfNewNode,source.getElementsByTagName('A')[0].id);
		
	}
	
	/* Save a new node */
	function saveNewNode(nodeText,parentId)
	{
		self.status = 'Ready to save node ' + nodeText + ' which is a sub item of ' + parentId;
		// Use an ajax method here to save this new node. example below:
		/*
		ajaxObjectArray[ajaxObjectArray.length] = new sack();
		var ajaxIndex = ajaxObjectArray.length-1;
		ajaxObjectArray[ajaxIndex].requestFile = ajaxRequestFile + '?newNode=' + nodeText + '&parendId=' + parentId					
		ajaxObjectArray[ajaxIndex].onCompletion = function() { self.status = 'New node has been saved'; };	// Specify function that will be executed after file has been found					
		ajaxObjectArray[ajaxIndex].runAJAX();		// Execute AJAX function
		*/		
	}
	
	function deleteNode()
	{
		if(!okToCreateSubNode)return;		
		setTimeout('okToCreateSubNode=true',200);		
		contextMenuObj.style.display='none';
		source = contextMenuSource;
		
		if(!confirm('Click OK to delete the node ' + source.innerHTML))return;
		okToCreateSubNode = false;
		
		var parentLi = source.parentNode.parentNode.parentNode;
		while(source.tagName.toLowerCase()!='li')source = source.parentNode;		

		var lis = source.parentNode.getElementsByTagName('li');
		source.parentNode.removeChild(source);
		if(lis.length==0)parentLi.getElementsByTagName('IMG')[0].style.visibility='hidden';
		deleteNodeOnServer(source.id);
	}
	
	function deleteNodeOnServer(nodeId)
	{
		self.status = 'Ready to delete node' + nodeId;
		// Use an ajax method here to save this new node. example below:
		/*
		ajaxObjectArray[ajaxObjectArray.length] = new sack();
		var ajaxIndex = ajaxObjectArray.length-1;
		ajaxObjectArray[ajaxIndex].requestFile = ajaxRequestFile + '?deleteNodeId=' + nodeId					
		ajaxObjectArray[ajaxIndex].onCompletion = function() { self.status = 'Node has been deleted successfully'; };	// Specify function that will be executed after file has been found					
		ajaxObjectArray[ajaxIndex].runAJAX();		// Execute AJAX function
		*/				
		
	}
	
	function initTree(level,RequestFile,csId)
	{
		treeLevels = level;
		ajaxRequestFile = RequestFile +'bin/ajax/get_category.php';
		imageFolder = RequestFile +'images/';
        spId=csId;

		for(var treeCounter=0;treeCounter<idOfFolderTrees.length;treeCounter++){
			var dhtmlgoodies_tree = document.getElementById(idOfFolderTrees[treeCounter]);
			var menuItems = dhtmlgoodies_tree.getElementsByTagName('li');	// Get an array of all menu items
			
			for(var no=0;no<menuItems.length;no++){					
				nodeId++;
				var subItems = menuItems[no].getElementsByTagName('ul');
				
				var img = document.createElement('IMG');
				img.src = imageFolder + plusImage;
				img.onclick = showHideNode;
				if(subItems.length==0)img.style.visibility='hidden';else{
					subItems[0].id = 'tree_ul_' + treeUlCounter;
					treeUlCounter++;
					topList[treeUlCounter-1]=subItems;
					topListId[treeUlCounter-1]= subItems[0].id;
				}
			
				var aTag = menuItems[no].getElementsByTagName('A')[0];
				if(contextMenuActive)aTag.oncontextmenu = showContextMenu;
				aTag.onclick = showHideNode;
				menuItems[no].insertBefore(img,aTag);
				if(!menuItems[no].id)menuItems[no].id = 'dhtmlgoodies_treeNode' + nodeId;
				//var folderImg = document.createElement('IMG');
				//if(menuItems[no].className){
				//	folderImg.src = imageFolder + menuItems[no].className;
				///}else{
				//	folderImg.src = imageFolder + folderImage;
				//}
				//menuItems[no].insertBefore(folderImg,aTag);
                
			}	
			
		}
		initExpandedNodes = Get_Cookie('dhtmlgoodies_expandedNodes');
		if(initExpandedNodes){
			var nodes = initExpandedNodes.split(',');
			for(var no=0;no<nodes.length;no++){
				if(nodes[no])showHideNode(false,nodes[no]);	
			}			
		}	
	}

	
