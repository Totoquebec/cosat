// Denis Léveillé

function tableruler() {
  if (document.getElementById && document.createTextNode) {
    var tables=document.getElementsByTagName('table');
    for (var i=0;i<tables.length;i++){
      if(tables[i].className=='ruler') {
        var trs=tables[i].getElementsByTagName('tr');
        for(var j=0;j<trs.length;j++) {
          if(trs[j].parentNode.nodeName=='TBODY') {
            trs[j].onmouseover=function(){this.className='ruled';return false}
            trs[j].onmouseout=function(){this.className='';return false}
          } // Si TBODY
        } // for j
      } // Si ruler
    } // for i
  } // si document
} // tableruler

function montre(object)
  {
  if (document.layers && document.layers[object])
    { 
    document.layers[object].visibility = 'visible';
    } 
  else if (document.all)
    {
    document.all[object].style.visibility = 'visible';
    document.all[object].style.zIndex = 100;
    }
  else if (document.getElementById) 
    {
    document.getElementById(object).style.visibility = 'visible';     document.getElementById(object).style.zIndex = 100; 
    } 
  }

function cache(object)
  {
  if (document.layers && document.layers[object])
    { 
    document.layers[object].visibility = 'hidden';
    } 
  else if (document.all)
    { 
    document.all[object].style.visibility = 'hidden';
    }
  else if (document.getElementById) 
    {
    document.getElementById(object).style.visibility = 'hidden'; 
    } 
  }
  
function CheckCleDown(e){ //e is event object passed from function invocation
var characterCode //literal character code will be stored in this variable

  if( e && e.which ){ //if which property of event object is supported (NN4)
	 e = e
	 characterCode = e.which //code contained in NN4's which property
  }
  else{
	 e = event
	 characterCode = e.keyCode //code contained in IE's keyCode property
  }

//  document.ClientForm.Refere.value = characterCode;
 document.ClientForm.CleShift.value = 0;
 document.ClientForm.CleCtrl.value = 0;
 document.ClientForm.CleAlt.value = 0;

  switch( characterCode ) {
  		  // Si clé égal 16 alors un shift
    case 16 : document.ClientForm.CleShift.value = 1; 
		 	  return false
			  break;
  		  // Si clé égal 17 alors un Ctrl
    case 17 : document.ClientForm.CleCtrl.value = 1; 
		 	  return false
			  break;
  		  // Si clé égal 18 alors un Alt
    case 18 : document.ClientForm.CleAlt.value = 1; 
		 	  return false
			  break;
	default : return true
  } // switch code

} // CheckCleDown

function CheckCleUp(e){ //e is event object passed from function invocation
  var characterCode //literal character code will be stored in this variable

  if( e && e.which ){ //if which property of event object is supported (NN4)
	 e = e
	 characterCode = e.which //code contained in NN4's which property
  }
  else{
	 e = event
	 characterCode = e.keyCode //code contained in IE's keyCode property
  }

  switch( characterCode ) {
  		  // Si clé égal 16 alors un shift
    case 16 : document.ClientForm.CleShift.value = 0; 
		 	  return false
			  break;
  		  // Si clé égal 17 alors un Ctrl
    case 17 : document.ClientForm.CleCtrl.value = 0; 
		 	  return false
			  break;
  		  // Si clé égal 18 alors un Alt
    case 18 : document.ClientForm.CleAlt.value = 0; 
		 	  return false
			  break;
	default : return true
  } // switch code
} // CheckCleUp

function MMshowMenuInFrame(menuLabel, x, y, imgLabel) {

//	   alert("Dedans foncton");
        if (!top.window.frames[1]) {
                return;
        }
		
		// pageXOffset -Gets the amount of content that has been hidden by scrolling to the right. 
        if (window.pageXOffset > -1) {
//		   alert("Dans page x offset");	   						   
		   		x = x || top.window.frames[1].pageXOffset;
				// pageYOffset -Gets the amount of content that has been hidden by scrolling down. 
				// window.pageY -Returns the vertical coordinate of the event relative to the visible page
                y = y || top.window.frames[1].pageYOffset;
        } else if (document.body) {
                x = x || top.window.frames[1].document.body.scrollLeft;
                y = y || top.window.frames[1].document.body.scrollTop;
        }
		
        if (top.window.frames[1].MM_showMenu) {
		   top.window.frames[1].MM_showMenu(menuLabel,x,y, null,imgLabel);
        }
}

function MM_startTimeoutInFrame(menuLabel, x, y, imgLabel) {
        if (!top.window.frames[1]) {
                return;
        }
        if (top.window.frames[1].MM_showMenu) {
		   top.window.frames[1].MM_startTimeout();	   						   
        }
}

function mouseTracker(e) {
        e = e || window.Event || window.event;
        window.pageX = e.pageX || e.clientX;
        window.pageY = e.pageY || e.clientY;
}

function img_on(imgName)  {
   	  imgDown = eval(imgName + "on.src");
   	  document [imgName].src = imgDown;
}

function img_off(imgName)  {
   	  imgUp = eval(imgName + "off.src");
   	  document [imgName].src = imgUp;
}

// ============= denislib.js =============//

