function Popup(url) {
  popupWindow = window.open(
   url,'popUpWindow',  'height=560,width=536,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
 }
 
 function PopupWhereAreThey(url) {
  popupWindow = window.open(
   url,'popUpWindow',  'height=550,width=600,left=10,top=10,resizable=no,scrollbars=yes,toolbar=no,menubar=no,location=no,directories=no,status=yes')
 }

function selectcheck(checkId){
    //var id = checkId;
    //alert(checkId);
     $("INPUT[name=" + checkId + "][type='checkbox']").attr('checked', true);
}