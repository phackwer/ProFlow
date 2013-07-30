function getUfList()
{
	if ($("#localizacao-id_pais").val() != "")
	{
		$("#localizacao-id_uf").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/uf/id_pais/'+$("#localizacao-id_pais").val(),
            function(data) {
				$("#localizacao-id_uf").html(data);
				$("#localizacao-id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
            }
        );
    }
    else
    {
    	$("#localizacao-id_uf").html("<option value=\'\'>Selecione o País antes</option>");
    	$("#localizacao-id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
    }
}

function getCidadeList()
{
	if ($("#localizacao-id_uf").val() != "")
	{
		$("#localizacao-id_cidade").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/cidade/id_uf/'+$("#localizacao-id_uf").val(),
            function(data) {
				$("#localizacao-id_cidade").html(data);
            }
        );
    }
    else
    {
    	$("#localizacao-id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
    }
}


function getUfListCidade()
{
	if ($("#id_pais").val() != "")
	{
		$("#id_uf").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/uf/id_pais/'+$("#id_pais").val(),
            function(data) {
				$("#id_uf").html(data);
				$("#id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
            }
        );
    }
    else
    {
    	$("#id_uf").html("<option value=\'\'>Selecione o País antes</option>");
    	$("#id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
    }
}

$(document).ready(function (){
	if($('#localizacao-id_pais'))
		$('#localizacao-id_pais').change(function (){getUfList();});
	if ($('#localizacao-id_uf'))
		$('#localizacao-id_uf').change(function (){getCidadeList();});
	if($('#id_pais'))
		$('#id_pais').change(function (){getUfListCidade();});
});



