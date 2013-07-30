<?php
/**
 * Contém o registro de mensagens sistêmicas básicas da parte administrativa do site
 *
 * @package	 SanSIS
 * @category	Message
 * @name		Message
 * @author	  Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version	 1.0.0
 */
abstract class SanSIS_Message
{	
	/**
	 * Estilos
	 */
	const TYPE_SUCCESS			= 'msgSucesso';
	const TYPE_ALERT			= 'msgAlerta';
	const TYPE_ERROR			= 'msgErro';
	const TYPE_INFO				= 'msgOrientacao';
	
    /**
     * Mensagens
     */
	const MSG_INSTALLATION		= 'É necessário configurar a instalação antes de prosseguir.';
	const MSG_DBINSTALLERROR	= 'Não foi possível conectar ao banco com as informações fornecidas. Verifique se os dados estão corretos. Caso o erro persista, execute esta ação manualmente.';
	const MSG_CONFWRITEPERM		= 'É necessário dar permissão de escrita no arquivo de configuração para prosseguir com a instalação.';
	const MSG_SUCCESS 			= 'Operação realizada com sucesso.';
	const MSG_CONFIRM 			= 'Confirme a ação.';
	const MSG_EDIT_DENIED		= 'A situação deste item impede sua edição.';
	const MSG_DELETE_DENIED		= 'A situação deste item impede sua exclusão.';
	const MSG_INVALID			= 'Dados inválidos.';
	const MSG_RESTRICTACCESS	= 'Área de acesso restrito. Favor identificar-se.';
	const MSG_NO_ACL 			= 'Você não tem esta permissão de acesso ao item solicitado.';
	const MSG_LIST_EMPTY 		= 'Nenhum registro encontrado.';
	const MSG_NO_CRITERIA 		= 'Por favor informe um critério para pesquisa';
	const MSG_NO_ACTION 		= 'Nenhuma ação adicional foi selecionada.';
	const MSG_NO_SELECTION	 	= 'Por favor selecione pelo menos um registro para executar a ação desejada.';
	const MSG_SAMEUSER			= 'Este usuário já foi inserido com este papel neste grupo.';
}