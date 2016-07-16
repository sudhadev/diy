	
	var request = null;
 
	function createRequest() {
		try{
			request = new XMLHttpRequest(); 
		}
		catch (trymicrosoft) {
			try{
				request = new ActiveXObject("Msxml12.XMLHTTP");
			}
			catch (othermicrosoft) {
				try{
					request = new ActiveXObject("Microsoft.XMLHTTP"); 
				}
				catch (failed) {
					request = null;
				}
			}
		}
		if (request==null)
			alert("Error creating request object");
	}


    function createAjaxRequest() {
		try{
			return new XMLHttpRequest();
		}
		catch (trymicrosoft) {
			try{
				return new ActiveXObject("Msxml12.XMLHTTP");
			}
			catch (othermicrosoft) {
				try{
					return new ActiveXObject("Microsoft.XMLHTTP");
				}
				catch (failed) {
					return null;
				}
			}
		}

	}

function debug(msg)
{
    document.getElementById("debug").innerHTML+="<br/>" +msg;
}

function handleProcessMsg(change,divProcess)
{
	document.getElementById(divProcess).style.display = change;
}

