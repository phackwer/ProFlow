$(document).ready(function (){
	mascaras()
})


function mascaras() {
	$('.phone').mask('(99) 9999-9999');
	$('.cpf').mask('999.999.999-99');
	$('.cnpj').mask('99.999.999/9999-99');
	$('.cep').mask('99.999-999');
	$('.percentage').maskMoney({symbol:"",decimal:",",thousands:"."});
	$('.money').live("keydown", function (e) 
	{
		if (e.ctrlKey)
			return false;
	});
	$('.money').maskMoney({symbol:"R$",decimal:",",thousands:"."});
	$('.integer').live("keydown", function (e) 
	{
		if (e.ctrlKey)
			return false;
	     var key = e.charCode || e.keyCode || 0;
	     // allow backspace, tab, delete, arrows, numbers and keypad numbers ONLY
	     return (
	     key == 8 || 
	     key == 9 ||
	     key == 46 ||
	     (key >= 37 && key <= 40) ||
	     (key >= 48 && key <= 57) ||
	     (key >= 96 && key <= 105));
	 });
	
	var editors = $(".htmleditor");
	
	for (var i = 0; i < editors.length; i++)
	{
		if (editors[i].disabled)
		{
			editors[i].parentNode.innerHTML = '<div class="view-textarea">' + editors[i].innerHTML.replace(/\&lt\;/g,'<').replace(/\&gt\;/g, '>').replace(/\&amp\;/g, '&') + '</div>';
		}
		else
		{
			$('#' + editors[i].id).cleditor({
				width:        650,
				height:       250,
				controls:     "bold italic underline strikethrough subscript superscript | " +
				              "removeformat | bullets numbering | outdent " +
				              "indent | alignleft center alignright justify | undo redo | " +
				              "link unlink | cut copy paste pastetext ",
				sizes:        "1,2,3,4,5,6,7",
				styles:       [["Paragraph", "<p>"], ["Header 1", "<h1>"], ["Header 2", "<h2>"],
				              ["Header 3", "<h3>"],  ["Header 4","<h4>"],  ["Header 5","<h5>"],
				              ["Header 6","<h6>"]],
				useCSS:       false,
				docType:      '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">',
				docCSSFile:   "", 
				bodyStyle:    "margin:4px; font-family: Verdana, Sans-Serif, Arial, Helvetica; font-size: 12px; cursor:text",
				maxLength:	  $(".htmleditor")[i].maxLength > 0 ? $(".htmleditor")[i].maxLength : 0
			});
		}
	}
}