function merg(id){
  if(confirm("Are you sure you want to merge the data with selected manufacturer?"))
  {
	// document.location.href="?f=merge&id="+id;
	 document.location.href="?action=&action=merge&id="+id;
	 //alert(document.location.href="?f=merge&id="+id);
  }
}