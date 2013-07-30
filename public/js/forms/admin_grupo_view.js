$(document).ready(function ()
{
    $("<div id=\"list-membros\"><p id=\"content-grupo\">Aguarde... carregando lista de anexos.</p></div>").insertAfter($("#fieldset-membros > dl"));
    $.get(
    		basephp + '/admin/grupo/carregarmembros/id_grupo/'+$("#id").val() + '/seed_id/' + $("#seed_id").val() + '/readOnly/factual',
            function(data) {
                $("#list-membros").html(data);
            }
        );
	
});