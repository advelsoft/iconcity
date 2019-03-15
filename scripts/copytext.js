var tooltip, // global variables oh my! Refactor when deploying!
	hidetooltiptimer

function createtooltip(){ // call this function ONCE at the end of page to create tool tip object
	tooltip = document.createElement('div')
	tooltip.style.cssText = 
		'position:absolute; background:black; color:white; padding:4px;z-index:10000;'
		+ 'border-radius:2px; font-size:12px;box-shadow:3px 3px 3px rgba(0,0,0,.4);'
		+ 'opacity:0;transition:opacity 0.3s'
	tooltip.innerHTML = 'Copied!'
	document.body.appendChild(tooltip)
}

function showtooltip(e){
	var evt = e || event
	clearTimeout(hidetooltiptimer)
	tooltip.style.left = evt.pageX - 10 + 'px'
	tooltip.style.top = evt.pageY + 15 + 'px'
	tooltip.style.opacity = 1
	hidetooltiptimer = setTimeout(function(){
		tooltip.style.opacity = 0
	}, 500)
}

function selectElementText(el){
	var range = document.createRange() // create new range object
	range.selectNodeContents(el) // set range to encompass desired element text
	var selection = window.getSelection() // get Selection object from currently user selected text
	selection.removeAllRanges() // unselect any user selected text (if any)
	selection.addRange(range) // add range to Selection object to select it
}

function copySelectionText(){
	var copysuccess // var to check whether execCommand successfully executed
	try{
		copysuccess = document.execCommand("copy") // run command to copy selected text to clipboard
	} catch(e){
		copysuccess = false
	}
return copysuccess
}

function copyfieldvalue(e, id){
	createtooltip();
	var field = document.getElementById(id)
	field.focus()
	selectElementText(field);
	var copysuccess = copySelectionText()
	if (copysuccess){
		showtooltip(e)
	}
}
