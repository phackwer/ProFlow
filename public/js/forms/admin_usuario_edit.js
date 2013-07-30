function getUfList()
{
	if ($("#id_pais").val() != "")
	{
		$("#id_uf_representa").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/uf/id_pais/'+$("#id_pais").val(),
            function(data) {
				$("#id_uf_representa").html(data);
            }
        );
    }
    else
    {
    	$("#id_uf_representa").html("<option value=\'\'>Selecione o País antes</option>");
    	$("#id_cidade").html("<option value=\'\'>Selecione a UF antes</option>");
    }
}

function getCidadeList()
{
	if ($("#id_uf_representa").val() != "")
	{
		$("#id_cidade_representa").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/cidade/id_uf/'+$("#id_uf_representa").val(),
            function(data) {
				$("#id_cidade_representa").html(data);
            }
        );
    }
    else
    {
    	$("#id_cidade_representa").html("<option value=\'\'>Selecione a UF antes</option>");
    }
}

$(document).ready(function (){
		$('#id_pais').change(function (){getUfList();});
		$('#id_uf_representa').change(function (){getCidadeList();});
});