function addTXT(textValue, textArea) {
	// Get the textarea we're looking for.
	var txtArea = document.getElementById(textArea);
	
	// If statement for Internet Explorer.
	if (document.selection) {
		txtArea.focus();
		var sel = document.selection.createRange();
		sel.text = textValue;
		return;
	} else if (txtArea.selectionStart || txtArea.selectionStart == '0') {
		// Statement for Firefox, Chrome, etc...
		var startPos = txtArea.selectionStart;
		var endPos = txtArea.selectionEnd;
		var scrollTop = txtArea.scrollTop;
		var before = txtArea.value.substr(0, startPos);
		var selected = txtArea.value.substr(txtArea.selectionStart, (txtArea.selectionEnd - txtArea.selectionStart));
		var after = txtArea.value.substr(txtArea.selectionEnd, (txtArea.value.length - txtArea.selectionEnd));
		
		txtArea.value = before + "[" + textValue + "]" + selected + "[/" + textValue + "]" + after;
		txtArea.focus();
		var openTag = before + "[" + textValue + "]";
		var closeTag = selected + "[/" + textValue + "]" + after;
		txtArea.selectionStart = startPos + openTag.length;
		txtArea.selectionEnd = startPos + closeTag.length;
	} else {
		txtArea.value += textArea.value;
		txtArea.focus();
	}
}