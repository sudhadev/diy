function resetSubmit(formName,url)
{
    
    //formName.setAttribute("action",url);
    //formName.submit();
    document.forms[formName].setAttribute("target","_top");
    document.forms[formName].setAttribute("action",url);
    document.forms[formName].setAttribute("method","post");
    document.forms[formName].submit();
}