// Jeff Gordon

// ============= DisableKeys.js =============//

// Keys to be disabled can be added to the lists below.
// The number is the key code for the particular key
// and the text is the description displayed in the
// status window if the key [combination] is pressed.

// var t1 = 'Backspace outside text fields';
// var	t2 = 'Enter outside text fields';

var badKeys = new Object();
badKeys.single = new Object();
badKeys.single['8'] = 'Backspace en dehors dun champs texte';
badKeys.single['13'] = 'Enter en dehors dun champs texte';
badKeys.single['116'] = 'F5 (Refraichissement)';
badKeys.single['122'] = 'F11 (Plein Écran)';

badKeys.alt = new Object();
badKeys.alt['37'] = 'Alt+Left Cursor';
badKeys.alt['39'] = 'Alt+Right Cursor';

badKeys.ctrl = new Object();
badKeys.ctrl['43'] = 'Ctrl++';
badKeys.ctrl['78'] = 'Ctrl+N';
badKeys.ctrl['79'] = 'Ctrl+O';
badKeys.ctrl['80'] = 'Ctrl+P';
badKeys.ctrl['85'] = 'Ctrl+U';
badKeys.ctrl['107'] = 'Ctrl + +';

function checkKeyCode(type, code) {
  if( badKeys[type][code] ) 
    return true;
  else 
   return false;
} // checkKeyCode

function getKeyText(type, code) {
		 return badKeys[type][code];
}

var ie=document.all;
var w3c=document.getElementById && !document.all;

function keyEventHandler(evt) {
 var badKeyType = "single";
  this.target = evt.target || evt.srcElement;
  this.keyCode = evt.keyCode || evt.which;
  var targtype = this.target.type;
  
  if (w3c) {
    if (document.layers) {
      this.altKey = ((evt.modifiers & Event.ALT_MASK) > 0);
      this.ctrlKey = ((evt.modifiers & Event.CONTROL_MASK) > 0);
      this.shiftKey = ((evt.modifiers & Event.SHIFT_MASK) > 0);
    } 
		else {
		  this.altKey = evt.altKey;
		  this.ctrlKey = evt.ctrlKey;
		}
	// Internet Explorer
  } 
  else {
    this.altKey = evt.altKey;
	this.ctrlKey = evt.ctrlKey;
  }

 

// Find out if we need to disable this key combination

  if (this.ctrlKey) {
    badKeyType = "ctrl";
  } 
  else if (this.altKey) {
    badKeyType = "alt";
  }
  if( checkKeyCode(badKeyType, this.keyCode) ) 
    return cancelKey(evt, this.keyCode, this.target, getKeyText(badKeyType, this.keyCode) );
}


function cancelKey(evt, keyCode, target, keyText) {
  if (keyCode==8 || keyCode==13) {
  	 // Don't want to disable Backspace or Enter in text fields
     if ( target.type == "text" || target.type == "textarea" || target.type == "password" )  {
       window.status = "";
       return true;
     } // Si texte
  } // Si backspace ou enter

  if (evt.preventDefault) {
    evt.preventDefault();
	evt.stopPropagation();
  } 
  else {
    evt.keyCode = 0;
    evt.returnValue = false;
  }
  window.status = keyText + " est désactivé";
  return false;
}

function addEvent(obj, evType, fn, useCapture) {
var r;
		 // General function for adding an event listener
		 if (obj.addEventListener) {
		 	obj.addEventListener(evType, fn, useCapture);
			return true;
		 } 
		 else 
		   if (obj.attachEvent) {
		     r = obj.attachEvent("on" + evType, fn);
		     return r;
		   } 
		   else 
		   	 alert( evType+" handler ne peut être attaché" );
			 
} // addEvent

<!-- /* */-->
function addKeyEvent()
{
		 // Specific function for this particular browser
var e = 'keydown';
	addEvent(document,e,keyEventHandler,false);
}

// ============= DisableKeys.js =============//

