var formVar    = ""
var daysofWeek = ""
var firstDate  = ""
var firstMonth = ""
var lastDate   = ""
var lastMonth  = ""
var browser    = ""

function outputMonth( currentDate )
{
	var m_des = new Array("January", "February", "March", "April", "May", "June",
                              "July", "August", "September", "October", "November", "December")
        var m_len = new Array( 31,28,31,30,31,30,31,31,30,31,30,31)
        var d_st  = new Array( 7, 1, 2, 3, 4, 5, 6 )
	var d_de  = new Array("Su","Mo","Tu","We","Th","Fr","Sa")

// ------ Use the entered date or today if blank -----

	myDate = (firstDate =="") ? new Date() : firstDate
	if ((currentDate != "dd/mm/yyyy" ) && (currentDate != ""))
	{
		splitDate = currentDate.split("/")
	        myDate = new Date( splitDate[2], splitDate[1]-1, splitDate[0])
	}

        var month = myDate.getMonth()
        var day   = myDate.getDate()
        var year  = myDate.getFullYear()
        m_len[1] = (((year % 4 == 0) && ( (!(year % 100 == 0)) || (year % 400 == 0))) ? 29 : 28 )

// ----- The title to the window -----

        document.getElementById( "cal_title" ).innerHTML = m_des[month] + " " + year

// ----- Set the move backward a month link -----

        prevDate = new Date( myDate.getFullYear(), myDate.getMonth() -1 , 1 )
	oMonth   = prevDate.getMonth() + 1
	pd = prevDate.getDate() + "/" + oMonth + "/" + prevDate.getFullYear()

	document.getElementById( "cal_left" ).innerHTML = "&nbsp;"
	if (prevDate >= firstMonth)
	{
		link = "<a href=# onClick=\"outputMonth('" + pd + "')\"><<</a>"
		document.getElementById( "cal_left" ).innerHTML = link
	}

// ----- Set the move forward a month link -----

        nextDate = new Date( myDate.getFullYear(), myDate.getMonth() + 1 , 1 ) 
	oMonth   = nextDate.getMonth() + 1
	nd = nextDate.getDate() + "/" + oMonth + "/" + nextDate.getFullYear()
	
	document.getElementById( "cal_right" ).innerHTML = "&nbsp;"
	if ((nextDate <= lastMonth) || (lastMonth == ""))
	{
		link = "<a href=# onClick=\"outputMonth('" + nd + "')\">>></a>"
		document.getElementById( "cal_right" ).innerHTML = link
	}

// ----- Find out where to start in the month -----

        stDate = new Date( year, month, 1)
        start  = d_st[stDate.getDay()]
	oMonth = month + 1
	dispmonth = (oMonth < 10) ? "0" + oMonth : oMonth

	// ----- Clear all the existing cells -----

	for (var i= 1; i <= 42 ; i++)
                document.getElementById( i ).innerHTML = "&nbsp;"

// ----- Fill in the days of the month -----

        for (var i= 1; i <= m_len[month] ; i++)
        {
		outDate    = new Date( year, month, i )
		currentDOW = d_de[outDate.getDay()]
		cell       = i

		if ( (outDate >= firstDate) && 
		     ((outDate <= lastDate) || (lastDate == "")) &&
		     (daysofWeek.indexOf(currentDOW) != -1) )
		{
			dispday = (i < 10) ? "0" + i : i
			ret  = dispday + "/"  + dispmonth + "/" +  year
                	cell = "<a href=# onClick=\"hideCalendar('" + ret + "')\">" + i + "</a>"
		}
                document.getElementById( i + start - 1).innerHTML = cell
        }
}

// ------------ Main Function to open up the DIV and display the calendar ----------

function showCalendar( entry, first, last, dow, xpos, ypos ) 
{
	formVar    = entry

// ----- get the current position & add our position offset -----

	pos = findPos( entry )
	xpos += pos.left
	ypos += pos.top

	if ( ( navigator.userAgent.indexOf("MSIE") != -1 ) &&
	     ( navigator.userAgent.indexOf("MSIE 7.0") == -1 ) )
		hideSelects( xpos, ypos )

// ----- Move the DIV to the correct position and show it -----

	document.getElementById( "calendar" ).style.left       = xpos + "px"
	document.getElementById( "calendar" ).style.top        = ypos + "px"
	document.getElementById( "calendar" ).style.visibility = "visible"

// ----- Setup the start & end dates -----

	daysofWeek = (dow != "") ? dow : "MoTuWeThFrSaSu"
        firstDate  = new Date()

        if ((first != "" ) && (first != "dd/mm/yyyy"))
        {
                splitDate = first.split("/")
                firstDate = new Date( splitDate[2], splitDate[1]-1, splitDate[0])
        }
	firstMonth = new Date( firstDate.getFullYear(), firstDate.getMonth(), 1)

	lastMonth = ""
	lastDate  = ""
        if (last != "" ) 
        {
                splitDate = last.split("/")
                lastDate  = new Date( splitDate[2], splitDate[1]-1, splitDate[0])
		lastMonth = new Date( lastDate.getFullYear(), lastDate.getMonth(), 1)
        }

// ----- Now render the month details -----

	outputMonth( entry.value )
}

// ------------ Function to close up the DIV and update the input field ----------

function hideCalendar( result )
{
        document.getElementById( "calendar" ).style.visibility = "hidden"

        if ( result.length != 0 )
                formVar.value = result

	showSelects()
}

// ------------ Find our current position ---------

function findPos(obj) 
{
        var left = obj.offsetLeft
        var top  = obj.offsetTop

	while (obj.offsetParent != null) 
	{
		obj = obj.offsetParent 
		left += obj.offsetLeft
		top += obj.offsetTop
	}
	return {left:left, top:top}
}

// --------- Hide any selects below us - IE Bug Fix ------

function hideSelects( x, y )
{
	obj = document.getElementsByTagName("select")

	for (i=0 ; i<obj.length ; i++)
	{
		pos = findPos( obj[i] )
		if (( pos.left >= x ) && ( pos.top >= y ))
			obj[i].style.display = "none"
	}
}

// --------- Show the hidden selects - IE Bug Fix ----------

function showSelects()
{
        x = document.getElementsByTagName("select")

        for (i=0 ; i<x.length ; i++)
                x[i].style.display = ""
}

