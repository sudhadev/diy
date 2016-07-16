var IFrameObj; // our IFrame object
function callToServer(URL) {
  if (!document.createElement) {return true};
  var IFrameDoc;
  //var URL = 'server.html';
  if (!IFrameObj && document.createElement) {
    // create the IFrame and assign a reference to the
    // object to our global variable IFrameObj.
    // this will only happen the first time
    // callToServer() is called
    var tempIFrame=document.createElement('iframe');
    tempIFrame.setAttribute('id','RSIFrame');
    tempIFrame.style.border='0px';
    tempIFrame.style.width='0px';
    tempIFrame.style.height='0px';
    IFrameObj = document.body.appendChild(tempIFrame);

    if (document.frames) {
      // this is for IE5 Mac, because it will only
      // allow access to the document object
      // of the IFrame if we access it through
      // the document.frames array
      IFrameObj = document.frames['RSIFrame'];
    }
  }

  if (navigator.userAgent.indexOf('Gecko') !=-1 && !IFrameObj.contentDocument) {
    // we have to give NS6 a fraction of a second
    // to recognize the new IFrame
    setTimeout('callToServer()',10);
    return false;
  }

  if (IFrameObj.contentDocument) {
    // For NS6
    IFrameDoc = IFrameObj.contentDocument;
  } else if (IFrameObj.contentWindow) {
    // For IE5.5 and IE6
    IFrameDoc = IFrameObj.contentWindow.document;
  } else if (IFrameObj.document) {
    // For IE5
    IFrameDoc = IFrameObj.document;
  } else {
    return true;
  }

  IFrameDoc.location.replace(URL);
  return false;
}


// Get enter key stroke
function checkEnter(e){ //e is event object passed from function invocation
         var characterCode

         if(e && e.which){ //if which property of event object is supported (NN4)
            e = e
            characterCode = e.which //character code is contained in NN4's which property
         }
         else{
              e = event
              characterCode = e.keyCode //character code is contained in IE's keyCode property
         }

         if(characterCode == 13){
               return true
         }
         else{
              return false
         }

}
