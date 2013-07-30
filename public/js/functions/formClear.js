$(document).ready(function ()
{
	$("#limpar").click (function(){
		var form ;
		if(document.getElementById('form_list') != null){
			form = document.getElementById('form_list');
		}else{
			form = document.getElementById('form_edit');
		}
		
		for(var i=0 ; i<form.elements.length ; i++){
			if (form.elements[i].type != "submit" && form.elements[i].type != "button"){
				if (form.elements[i].value!="") {
					if(form.elements[i].id == "status_tupla"){
						form.elements[i].value  = 1;
					}
					
					form.elements[i].value  = "";
				}
			}
			
		}
	
	});
	
	
});