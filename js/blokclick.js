// ============= blokclick.js =============//
//* Auteur : Denis Léveillé 	 		  Date : 2006-01-01

var message='Désolé, fonction désactivé !!!' ;
var ie=document.all;
var w3c=document.getElementById && !document.all;

function clickIE()
{
     return false;
}

function clickNS(e) 
{
	if( e.which == 2 || e.which==3 ) 
		return false;
} // clickNS

function disableselect(e)
{
	return false
} // disableselect

function reEnable()
{
	return true
} // reEnable

// Initialisation

	if( w3c ){
		document.captureEvents( Event.MOUSEDOWN );
		document.onmousedown=clickNS;
	}
	else{
		document.onmouseup=clickNS;
		document.onmouseup=clickIE;
		document.oncontextmenu=clickIE;
		if( window.sidebar ){
			document.onmousedown=disableselect
			document.onclick=reEnable
		}	
	}
	
	document.oncontextmenu = new Function('alert(message);return false')
	
	document.onselectstart = new Function ('return false')