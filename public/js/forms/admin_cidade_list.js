function getUfList()
{
	if ($("#id_pais").val() != "")
	{
		$("#id_uf").html("<option value=\'\'>Aguarde, carregando...</option>");
		$.get(
			basephp + '/services/supportdata/uf/id_pais/'+$("#id_pais").val(),
            function(data) {
				$("#id_uf").html(data);
            }
        );
    }
    else
    {
    	$("#id_uf").html("<option value=\'\'>Selecione o País antes</option>");
    }
}

$(document).ready(function (){
		$('#id_pais').change(function (){getUfList();});
});