// cv list
// AUTHOR: Priya Saliya Wijesinghe <saliyasoft@yahoo.com>
// (C) Copyright 2006 www.fusis.com

function login_response(errNo,uid,lfrom,imgPath){
 // error messages array
   var errMsg ;
   if(errNo==428)
   {
       alert('Missing Email or Password');
   }else if(errNo==422)
   {
       alert('Password Incorrect');
   }else if(errNo==426)
   {
        alert('User not Found');
   }else{
        alert("Error Connecting to Server. Please Try again ");
   }

   loading('hidden');
}


function login_redirect(URL) {
   document.location.href=URL;
}


function login() {
 loading('visible');
         var uid=document.getElementById('uid').value;
         var pass=document.getElementById('pass').value;
         URL='process.php?uid=' + uid +'&pass=' + pass;
         callToServer(URL) ;
}

function logout() {
   loading('visible');
    if(confirm("This will end your current session")){
         URL='../login/logout.php';
         callToServer(URL) ;
    }
}

function logout_response(msg,URL) {
   //if(msg){alert ("You are already Logged out")} ;
   document.location.href=URL;
}

function enter_key_pressed(e)
{
  if(checkEnter(e)){
      login() ;
  }

}