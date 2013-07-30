function excluir(id, id_usuario, id_participante)
{
	$.get(
    		basephp + '/admin/grupo/excluirmembro/seed_id/' + $("#seed_id").val() + '/id_grupo/'+$("#id").val()+'/id_usuario/'+id_usuario+'/id_participante/'+id_participante+'/id/'+id,
            function(data) {
                $("#list-membros").html(data);
            }
        );
}

function usuarioCallback( par )
{
	if (par[0] && par[1])
	{
	}
}

$(document).ready(function ()
{
	if ($('#incluir'))
	{
		$('#incluir').click(function ()
		{
			if ($("#usuario").val() && $("#id_participante").val())
			{
				$.get(
			    		basephp + '/admin/grupo/incluirmembro/id_grupo/'+$("#id").val()+'/usuario/'+$("#usuario").val()+'/id_participante/'+$("#id_participante").val() + '/seed_id/' + $("#seed_id").val(),
			            function(data) {
			                $("#list-membros").html(data);
			            }
			        );
				
				$("#usuario").val('');
				$("#id_participante").val('');
			}
			else
			{
				alert('Você deve informar o usuário e o papel com o qual ele participa.');
			}
		});
	}
	
	if ($('#usuario'))
	{
		$('#usuario').simpleAutoComplete
	    (
	    		basephp + '/services/supportdata/pesquisausuarios/',
			{
				autoCompleteClassName: 'autocomplete',
				selectedClassName: 'sel',
				attrCallBack: 'rel',
				identifier: 'usuario'
			},
			usuarioCallback
	    );
	}
	
    $("<div id=\"list-membros\"><p id=\"content-grupo\">Aguarde... carregando lista de anexos.</p></div>").insertAfter($("#fieldset-membros > dl"));
    $.get(
    		basephp + '/admin/grupo/carregarmembros/id_grupo/'+$("#id").val() + '/seed_id/' + $("#seed_id").val(),
            function(data) {
                $("#list-membros").html(data);
            }
        );
	
});