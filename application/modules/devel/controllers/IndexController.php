
<?php

class Devel_IndexController extends SanSIS_Controller_Action
{
	protected $bizClassName 				= 'SanSIS_Business';
	protected $title						= 'Área Desenvolvimento';
	protected $crudgenSubTitle				= 'Gerar Crud';
	protected $resetdatabaseSubTitle		= 'Reiniciar banco';
	protected $reverseengineeerSubTitle		= 'Gerar Modelo';
	
	public function init()
	{
		parent::init();
		
		if (APPLICATION_ENV != 'development')
			throw new Exception ('Tentativa de acesso ao módulo de desenvolvimento fora de ambiente de desenvolvimento registrada');
	}
	
	public function indexAction()
	{
	}
	
	public function crudgenAction()
	{
		$params = $this->getRequest()->getParams();
		
		$db = Zend_Db_Table::getDefaultAdapter();		
		$tables = $db->listTables();
		$result = '';
		
		if (!isset($params['confirmar']))
		{
			$this->addInstantMessage(SanSIS_Message::TYPE_ALERT,'ATENÇÃO! Todos os arquivos pré-existentes referentes ao CRUD selecionado serão sobrescritos.<br><br>
			Caso já tenha codificado regras, execute o backup manualmente ou tenha certeza de utilizar um repositório versionado de código.<br>
			A responsabilidade por qualquer dano ao código é do desenvolvedor ou administrador que disparar esta ação, e não da ferramenta fornecida.<br><br>
			COM GRANDE PODER, VEM GRANDE RESPONSABILIDADE.');
			
			$this->view->form = new Devel_Form_CrudGen();
		}
		else
		{
			if ($params['modulo_novo'] && $params['controlador_novo'])
			{
				$params['mod'] = str_replace(' ','',strtolower($params['modulo_novo']));
				$params['ctl'] = str_replace(' ','',strtolower($params['controlador_novo']));
				$params['modulo_novo'] = ucfirst($params['mod']);
				$params['controlador_novo'] = ucfirst($params['ctl']);
				
				#Cria estrutura de diretórios do módulo
				$mod_path = $this->createModule($params, $result);

				#Cria controlador
				$this->createController($params, $mod_path, $result);

				#Cria negócio
				$this->createBusiness($params, $mod_path, $result);
				
				#Cria apresentação
				$this->createView($params, $mod_path, $result);
				
				#Cria forms
				$this->createForm($params, $mod_path, $result);
			}
		}
	
		$this->view->result = $result;
	} 
	
	public function createModule(&$params, &$result)
	{
		$mod_path = APPLICATION_PATH.DIRECTORY_SEPARATOR
					.'modules'.DIRECTORY_SEPARATOR
					.strtolower(str_replace(' ','',$params['modulo_novo']));
	
		if (!file_exists($mod_path)) {
			mkdir($mod_path);
	
// 			chmod($mod_path, 0777);
	
			$bts_file = $mod_path.DIRECTORY_SEPARATOR.'Bootstrap.php';
	
			$class  = "<?php\n";
			$class .= "/**\n";
			$class .= " * Classe para Bootstrap de ".$params['modulo_novo']."\n";
			$class .= " *\n";
			$class .= " * @package	 ".$params['modulo_novo']."\n";
			$class .= " * @category	Bootstrap\n";
			$class .= " * @name		Bootstrap\n";
			$class .= " * @version	 1.0.0\n";
			$class .= " */\n";
			$class .= "class ".$params['modulo_novo']."_Bootstrap extends Zend_Application_Module_Bootstrap\n";
			$class .= "{\n";
			$class .= "	public function _initAutoload()\n";
			$class .= "	{\n";
			$class .= "		\$autoloader = new Zend_Application_Module_Autoloader(array(\n";
			$class .= "			'basePath'		  => dirname(__FILE__),\n";
			$class .= "			'namespace'		 => '".$params['modulo_novo']."')\n";
			$class .= "		);\n";
			$class .= "\n";
			$class .= "		\$autoloader->addResourceType('form',	 	'forms/',		'Form');\n";
			$class .= "		\$autoloader->addResourceType('business',	'business/',	'Business');\n";
			$class .= "\n";
			$class .= "		return \$autoloader;\n";
			$class .= "	}\n";
			$class .= "}\n";
	
			if (!file_exists($bts_file))
				file_put_contents($bts_file, $class);
	
// 			chmod($bts_file, 0777);
		}
	
		return $mod_path;
	}
	
	public function createController(&$params, $mod_path, &$result)
	{
		$ctl_path = $mod_path.DIRECTORY_SEPARATOR.'controllers';
		$ctl_file = $ctl_path.DIRECTORY_SEPARATOR.$params['controlador_novo'].'Controller.php';
		
		$extends = 'SanSIS_Controller_'.$params['tipo'];
	
		if (!file_exists($ctl_path))
			mkdir($ctl_path);
	
// 		chmod($ctl_path, 0777);
	
		if (!file_exists($ctl_file))
		{
			$class  = "<?php\n";
			$class .= "/**\n";
			$class .= " * Classe para Controller de ".$params['controlador_novo']."\n";
			$class .= " *\n";
			$class .= " * @package	 ".ucfirst($params['modulo_novo'])."\n";
			$class .= " * @category	Controller\n";
			$class .= " * @name		".$params['controlador_novo']."Controller\n";
			$class .= " * @version	 1.0.0\n";
			$class .= " */\n";
			$class .= "class ".$params['modulo_novo']."_".$params['controlador_novo']."Controller extends ".$extends."\n";
			$class .= "{\n";
			$class .= "	protected \$title 					= '".$params['titulo']."';\n";
			$class .= "	protected \$bizClassName 			= '".$params['modulo_novo']."_Business_".$params['controlador_novo']."';\n";
			$class .= "\n";	
			$class .= "	protected \$listSubTitle 			= 'Listar ".$params['nome_plural']."';\n";
			$class .= "	protected \$listFormClassName 		= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_List';\n";
			$class .= "	protected \$listSucessTarget 		= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$listCancelTarget 		= '".$params['mod']."/';\n";
			$class .= "	protected \$listInfoMessage			= '';\n";
			$class .= "	protected \$listContextMenu			= '';\n";
			$class .= "	protected \$listRowAction 			= array(\n";
			$class .= "			array('Visualizar',	'/".$params['mod']."/".$params['ctl']."/view/id/{{id}}',	array('class' => 'icoVisualizar')),\n";
			$class .= "			array('Editar',		'/".$params['mod']."/".$params['ctl']."/edit/id/{{id}}',	array('class' => 'icoEditar')),\n";
			$class .= "			array('Excluir',	'/".$params['mod']."/".$params['ctl']."/delete/id/{{id}}',	array('class' => 'icoExcluir'))\n";
			$class .= "	);\n";
			$class .= "	protected \$listMainAction 			= array(\n";
			$class .= "			array('Excluir registros selecionados', '/".$params['mod']."/".$params['ctl']."/deleteall')\n";
			$class .= "	);\n";
			$class .= "\n";
			if ($params['tipo'] == 'CrudHTML')
			{
				$class .= "	protected \$createSubTitle			= 'Criar Cadastro de ".$params['nome_singular']."';\n";
				$class .= "	protected \$createFormClassName		= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_Edit';\n";
				$class .= "	protected \$createSucessTarget		= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$createCancelTarget		= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$createInfoMessage		= '';\n";
				$class .= "	protected \$createContextMenu		= '';\n";
				$class .= "\n";
				$class .= "	protected \$editSubTitle				= 'Editar Cadastro de ".$params['nome_singular']."';\n";
				$class .= "	protected \$editFormClassName		= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_Edit';\n";
				$class .= "	protected \$editSucessTarget			= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$editCancelTarget			= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$editFailureTarget		= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$editInfoMessage			= '';\n";
				$class .= "	protected \$editContextMenu			= '';\n";
				$class .= "	protected \$editSubGrid				= '';\n";
				$class .= "\n";
				$class .= "	protected \$viewSubTitle				= 'Visualizar Cadastro de ".$params['nome_singular']."';\n";
				$class .= "	protected \$viewFormClassName		= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_View';\n";
				$class .= "	protected \$viewSucessTarget			= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$viewCancelTarget			= '".$params['mod']."/".$params['ctl']."';\n";
				$class .= "	protected \$viewInfoMessage			= '';\n";
				$class .= "	protected \$viewContextMenu			= '';\n";
				$class .= "	protected \$viewGridRadio			= '';\n";
				$class .= "\n";
			}
			$class .= "	protected \$deleteSubTitle			= 'Remover Cadastro de ".$params['nome_singular']."';\n";
			$class .= "	protected \$deleteFormClassName		= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_Delete';\n";
			$class .= "	protected \$deleteSucessTarget		= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteFailureTarget		= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteCancelTarget		= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteInfoMessage		= '';\n";
			$class .= "	protected \$deleteContextMenu		= '';\n";
			$class .= "\n";
			$class .= "	protected \$deleteAllSubTitle		= 'Remover Cadastro de ".$params['nome_plural']."';\n";
			$class .= "	protected \$deleteAllFormClassName	= '".$params['modulo_novo']."_Form_".$params['controlador_novo']."_Deleteall';\n";
			$class .= "	protected \$deleteAllSucessTarget	= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteAllFailureTarget	= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteAllCancelTarget	= '".$params['mod']."/".$params['ctl']."';\n";
			$class .= "	protected \$deleteAllInfoMessage		= '';\n";
			$class .= "	protected \$deleteAllContextMenu		= '';\n";
			$class .= "}\n";
	
			file_put_contents($ctl_file, $class);
	
// 			chmod($ctl_file, 0777);
		}
	}
	
	public function createBusiness($params, $mod_path, &$result)
	{
		$biz_path = $mod_path.DIRECTORY_SEPARATOR.'business';
	
		if (!file_exists($biz_path))
			mkdir($biz_path);
	
// 		chmod($biz_path, 0777);
	
		$biz_file = $biz_path.DIRECTORY_SEPARATOR.$params['controlador_novo'].'.php';
	
		if (!file_exists($biz_file))
		{
			$class  = "<?php\n";
			$class .= "/**\n";
			$class .= " * Classe para Business de ".$params['controlador_novo']."\n";
			$class .= " *\n";
			$class .= " * @package	 ".ucfirst($params['modulo_novo'])."\n";
			$class .= " * @category	Business\n";
			$class .= " * @name		".$params['controlador_novo']."\n";
			$class .= " * @version	 1.0.0\n";
			$class .= " */\n";
			$class .= "class ".$params['modulo_novo']."_Business_".$params['controlador_novo']." extends SanSIS_Business\n";
			$class .= "{\n";
			$class .= "	/**\n";
			$class .= "	 * @var string\n";
			$class .= "	 */\n";
			$class .= "	public \$crudClass = '".$this->_config->appnamespace.'_Model_'.$params['controlador_novo']."';\n";
			$class .= "}\n";
	
			file_put_contents($biz_file, $class);
	
// 			chmod($biz_file, 0777);
		}
	}
	
	public function createView($params, $mod_path, &$result)
	{
		$vwm_path = $mod_path.DIRECTORY_SEPARATOR.'views';
		$vw1_path = $vwm_path.DIRECTORY_SEPARATOR.'scripts';
		$vw2_path = $vw1_path.DIRECTORY_SEPARATOR.strtolower($params['controlador_novo']);
	
		if (!file_exists($vwm_path))
			mkdir($vwm_path);
		if (!file_exists($vw1_path))
			mkdir($vw1_path);
		if (!file_exists($vw2_path))
			mkdir($vw2_path);
	
		if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'index.phtml'))
			file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'index.phtml',		"<?php\nrequire('list.phtml');?>");
		if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'list.phtml'))
		    file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'list.phtml',		"<?php\necho \$this->form;\necho \$this->grid;\n?>");
		if ($params['tipo'] == 'CrudHTML')
		{
			if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'create.phtml'))
				file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'create.phtml',		"<?php\necho \$this->form;\n?>");
			if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'edit.phtml'))
				file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'edit.phtml',		"<?php\necho \$this->form;\n?>");
			if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'view.phtml'))
				file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'view.phtml',		"<?php\necho \$this->form;\n?>");
		}
		if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'delete.phtml'))
			file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'delete.phtml',		"<?php\necho 'Deseja excluir o item selecionado?';\necho \$this->form;\n?>");
		if (!file_exists($vw2_path.DIRECTORY_SEPARATOR.'deleteall.phtml'))
		    file_put_contents($vw2_path.DIRECTORY_SEPARATOR.'deleteall.phtml',	"<?php\necho 'Deseja excluir o(s) item(ns) selecionado(s)?';\necho \$this->form;\n?>");
	
// 		chmod($vwm_path, 0777);
// 		chmod($vw1_path, 0777);
// 		chmod($vw2_path, 0777);
	
// 		chmod($vw2_path.DIRECTORY_SEPARATOR.'index.phtml', 0777);
// 		chmod($vw2_path.DIRECTORY_SEPARATOR.'list.phtml', 0777);
// 		if ($params['tipo'] == 'CrudHTML')
// 		{
// 			chmod($vw2_path.DIRECTORY_SEPARATOR.'create.phtml', 0777);
// 			chmod($vw2_path.DIRECTORY_SEPARATOR.'edit.phtml', 0777);
// 			chmod($vw2_path.DIRECTORY_SEPARATOR.'view.phtml', 0777);
// 		}
// 		chmod($vw2_path.DIRECTORY_SEPARATOR.'delete.phtml', 0777);
// 		chmod($vw2_path.DIRECTORY_SEPARATOR.'deleteall.phtml', 0777);
	}
	
	public function createForm($params, $mod_path, &$result)
	{
		$frm_path = $mod_path.DIRECTORY_SEPARATOR.'forms';
		$fr1_path = $frm_path.DIRECTORY_SEPARATOR.$params['controlador_novo'];
		
		if (!file_exists($frm_path))
		    mkdir($frm_path);
		if (!file_exists($fr1_path))
		    mkdir($fr1_path);
		
		if ($params['tipo'] == 'CrudHTML')
		{
			if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'List.php'))
			    file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'List.php',		'<?php
			
/**
 * Formulário para listagem de '.$params['nome_plural'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_List extends SanSIS_Form
{

	/**
	* Inicializa a criação do formulário
	*/
	public function init()
	{
		$nome = $this->createElement(\'Select\', \'nome\', array(\'label\' => \'Status:\', \'style\' => \'width:300px\', \'required\' => true));
		
		$status_tupla = $this->createElement(\'Select\', \'status_tupla\', array(\'label\' => \'Status:\', \'style\' => \'width:300px\'));
		
		$pesquisar = $this->createElement ( \'submit\', \'pesquisar\', array (\'class\' => \'button\' ) );
		$limpar = $this->createElement ( \'reset\', \'limpar\', array (\'class\' => \'button\') );
		
		$this->addElements ( array ($nome, $status_tupla, $pesquisar, $limpar) );
		
		$this->addDisplayGroup(
			array(
				\'nome\',
				\'status_tupla\',
			),
			\'filtro\',
			array(
				\'legend\' => \'Filtro\'
			) );
		
		$this->addDisplayGroup(
			array(
				\'pesquisar\',
				\'limpar\'
			),
			\'ActionBar\'
		);
		
		parent::init ();
	}
	
	public function populateFromModel($data)
	{
		$this->getElement(\'status_tupla\')->addMultiOptions(array(\'1\' => \'Ativo\', \'0\' => \'Inativo\'));
	}
}');
		    if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'Edit.php'))
		        file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'Edit.php',		'<?php

/**
 * Formulário para edição de '.$params['nome_plural'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_Edit extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
    	$adicionar = $this->createElement(\'submit\', \'adicionar\', array(\'class\' => \'button\'));
		$cancelar = $this->createElement(\'submit\', \'cancelar\', array(\'class\' => \'button\'));
		 
		$this->addElements(
			array(
				$adicionar,
				$cancelar
			)
		);
		
		$this->addDisplayGroup(
			array(
				\'adicionar\',
				\'cancelar\'
			),
			\'ActionBar\'
		);

        parent::init ();
	}
}');
		    if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'View.php'))
		        file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'View.php',		'<?php

/**
 * Formulário para Visualização de '.$params['nome_plural'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		Edit
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_View extends SanSIS_Form
{

	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$cancelar = $this->createElement(\'submit\', \'cancelar\', array(\'class\' => \'button\'));
		 
		$this->addElements(
			array(
				$cancelar
			)
		);
		
		$this->addDisplayGroup(
			array(
				\'cancelar\'
			),
			\'ActionBar\'
		);

        parent::init();
	}
}');
		}
		else 
		{
			if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'List.php'))
			    file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'List.php',		'<?php

/**
 * Formulário para listagem e edição (Crud simples) de '.$params['nome_plural'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		List
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_List extends SanSIS_Form
{
			
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
    {
        $id = $this->createElement(\'Hidden\', \'id\', array(\'value\' => \'\'));

		$nome = $this->createElement(\'Text\', \'nome\', array(\'label\' => \'Nome:\', \'required\' => true, \'maxLength\' => 100, \'style\' => \'width:300px\'));
		$nome->addValidator(\'StringLength\', false, array(1, 100));
		
		$status_tupla = $this->createElement(\'Select\', \'status_tupla\', array(\'label\' => \'Status\', \'required\' => true, \'style\' => \'width:300px\'));

		$adicionar = $this->createElement ( \'submit\', \'adicionar\' , array(\'class\' => \'button\'));			
		$pesquisar = $this->createElement ( \'submit\', \'pesquisar\' , array(\'class\' => \'button\'));

		$this->addElements ( array ($id,$nome, $status_tupla, $adicionar, $pesquisar) );
		
		$this->addDisplayGroup(
			array(
				\'nome\',
				\'status_tupla\'
			),
			\'simples\',
			array(
				\'legend\' => \'Participante\'
			));
			
		$this->addDisplayGroup(
			array(
				\'adicionar\',
				\'pesquisar\'
			),
			\'ActionBar\');

		parent::init ();
			
	}
			
    public function populateFromModel($data)
    {
		$this->getElement(\'status_tupla\')->addMultiOptions(array(\'1\' => \'Ativo\', \'0\' => \'Inativo\'));
	}
}');
		}
		
		if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'Delete.php'))
		    file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'Delete.php',		'<?php

/**
 * Formulário para confirmação de remoção de '.$params['nome_singular'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		Delete
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_Delete extends SanSIS_Form {
	
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement ( \'Hidden\', \'id\', array (\'value\' => \'\' ) );
		
		$nome = $this->createElement(\'Text\', \'nome\', array(\'label\' => \'Nome:\', \'required\' => true, \'maxLength\' => 100, \'style\' => \'width:300px\'));
		$nome->addValidator(\'StringLength\', false, array(2, 100));
		
		$Confirmar = $this->createElement ( \'submit\', \'confirmar\', array (\'class\' => \'button\' ) );
		$Cancelar = $this->createElement ( \'submit\', \'cancelar\', array (\'class\' => \'button\') );
		
		$arElements = $this->addElements ( array ($id, $nome ) );
		
		$this->addDisplayGroup ( array (\'nome\' ), \'idParticipante\', array (\'legend\' => \'Participante\' ) );
		
		$arElements = $this->addElements ( array ($Confirmar, $Cancelar ) );
		
		$this->addDisplayGroup(array(\'confirmar\', \'cancelar\'), \'ActionBar\');
		
		parent::init ();
	}
}');
		if (!file_exists($fr1_path.DIRECTORY_SEPARATOR.'Deleteall.php'))
		    file_put_contents($fr1_path.DIRECTORY_SEPARATOR.'Deleteall.php',	'<?php

/**
 * Formulário para confirmação de remoção múltipla de '.$params['nome_plural'].'
 *
 * @package		'.$params['modulo_novo'].'
 * @subpackage	'.$params['controlador_novo'].'
 * @category	Form
 * @name		Deleteall
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class '.$params['modulo_novo'].'_Form_'.$params['controlador_novo'].'_Deleteall extends SanSIS_Form {
	
	/**
	 * Inicializa a criação do formulário
	 */
	public function init()
	{
		$id = $this->createElement ( \'Hidden\', \'id\', array (\'value\' => \'\' ) );
		
		$flag = $this->createElement ( \'Hidden\', \'flag\', array (\'value\' => \'1\' ) );
		
		$Confirmar = $this->createElement ( \'submit\', \'confirmar\', array (\'class\' => \'button\' ) );
		$Cancelar = $this->createElement ( \'submit\', \'cancelar\', array (\'class\' => \'button\') );
		
		$arElements = $this->addElements ( array ($id, $flag, $Confirmar, $Cancelar ) );
		
		$this->addDisplayGroup(array(\'confirmar\', \'cancelar\'), \'ActionBar\');
		
		parent::init ();
	}
}');
		
// 		chmod($frm_path, 0777);
// 		chmod($fr1_path, 0777);
		
// 		chmod($fr1_path.DIRECTORY_SEPARATOR.'List.php', 0777);
// 		if ($params['tipo'] == 'CrudHTML')
// 		{
// 		    chmod($fr1_path.DIRECTORY_SEPARATOR.'Edit.php', 0777);
// 		    chmod($fr1_path.DIRECTORY_SEPARATOR.'View.php', 0777);
// 		}
// 		chmod($fr1_path.DIRECTORY_SEPARATOR.'Delete.php', 0777);
// 		chmod($fr1_path.DIRECTORY_SEPARATOR.'Deleteall.php', 0777);
	}
	
	public function resetdatabaseAction()
	{
		$params = $this->getRequest()->getParams();
		
		$db = Zend_Db_Table::getDefaultAdapter();
				
		if (!isset($params['confirmar']))
		{
			$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, 
				'ATENÇÃO! Todos os dados do banco de dados, com excessão dos logins, serão removidos.<br><br>
				Caso já tenha codificado regras, execute o backup manualmente ou tenha certeza de utilizar um repositório versionado de código.<br>
				A responsabilidade por qualquer dano aos dados é do desenvolvedor ou administrador que disparar esta ação, e não da ferramenta fornecida.<br><br>
				COM GRANDE PODER, VEM GRANDE RESPONSABILIDADE.');
			$this->view->form = new Devel_Form_ReverseEngineer();
			$this->view->result = '';
		}
		else
		{
			$this->view->form = '';
			$this->view->result = '';
		}
	}
	
	public function reverseengineerAction()
	{
		$params = $this->getRequest()->getParams();
		
		$db = Zend_Db_Table::getDefaultAdapter();
		
		if (!isset($params['confirmar']))
		{
			$this->addInstantMessage(SanSIS_Message::TYPE_ALERT, 
				'ATENÇÃO! Tenha certeza de não ter codificado regras de negócio dentro da Model_DbTable, pois estes objetos serão reescritos.<br><br>
				Caso já tenha codificado regras, execute o backup manualmente ou tenha certeza de utilizar um repositório versionado de código.<br>
				A responsabilidade por qualquer dano ao código é do desenvolvedor ou administrador que disparar esta ação, e não da ferramenta fornecida.<br><br>
				COM GRANDE PODER, VEM GRANDE RESPONSABILIDADE.');
			$this->view->form = new Devel_Form_ReverseEngineer();
			$this->view->result = '';
		}
		else 
		{
			$this->view->form = '';
			$this->view->result = '';
			
			$schemas = $this->getSchemas($db);

			foreach ($schemas as $schema)
			{
				$tables = $this->getSchemaTables($db, $schema);
				
				foreach ($tables as $table)
					$this->createDatabase($db, $table);
			}
		}
	}
	
	/**
	 * Recupera a lista de schemas do postgres para reversa
	 *
	 * @param Zend_Db_Adapter_Abstract $database
	 */
	public function getSchemas($database)
	{
		$query = "SELECT
		n.nspname AS schema_name
		FROM pg_attribute AS a
		JOIN pg_class AS c ON a.attrelid = c.oid
		JOIN pg_namespace AS n ON c.relnamespace = n.oid
		JOIN pg_type AS t ON a.atttypid = t.oid
		LEFT OUTER JOIN pg_constraint AS co ON (co.conrelid = c.oid
		AND a.attnum = ANY(co.conkey) AND co.contype = 'p')
		LEFT OUTER JOIN pg_attrdef AS d ON d.adrelid = c.oid AND d.adnum = a.attnum
		WHERE a.attnum > 0
		AND NOT EXISTS (SELECT 1 FROM pg_views WHERE viewname = c.relname)
		AND c.relname !~ '^pg_'
		AND  c.relkind = 'r'
		GROUP BY schema_name
		ORDER BY schema_name";
	
		$resultset = $database->getConnection()->query($query);
	
		$arr = array();
		foreach ($resultset as $row)
			$arr[] = $row['schema_name'];
	
		return $arr;
	}
	
	/**
	 * Obtém as tabelas de um determinado schema
	 *
	 * @param Zend_Db_Adapter_Abstract $database
	 * @param string $schema_name
	 */
	public function getSchemaTables($database, $schema_name)
	{
		$query = "SELECT
		n.nspname AS schema_name,
		c.relname as table_name
		FROM pg_attribute AS a
		JOIN pg_class AS c ON a.attrelid = c.oid
		JOIN pg_namespace AS n ON c.relnamespace = n.oid
		JOIN pg_type AS t ON a.atttypid = t.oid
		LEFT OUTER JOIN pg_constraint AS co ON (co.conrelid = c.oid
		AND a.attnum = ANY(co.conkey) AND co.contype = 'p')
		LEFT OUTER JOIN pg_attrdef AS d ON d.adrelid = c.oid AND d.adnum = a.attnum
		WHERE a.attnum > 0
		AND n.nspname = '".$schema_name."'
		AND NOT EXISTS (SELECT 1 FROM pg_views WHERE viewname = c.relname)
		AND c.relname !~ '^pg_'
		AND  c.relkind = 'r'
		GROUP BY schema_name, table_name
		ORDER BY schema_name, table_name";
	
		$resultset = $database->getConnection()->query($query);
	
		$arr = array();
		foreach ($resultset as $row)
			$arr[] = $row['table_name'];
	
		return $arr;
	}
		
	public function createDatabase($db, $table, $overwrite = false)
	{
		$desc = $db->describeTable($table);
		
		$_class = str_replace(' ','',ucwords(str_replace('_', ' ', $table)));
		
		$_schema = '';
		$_name = '';
		$_sequence = '';
		$_metadata = array();
		$_primary = array();
		$_cols = array();
		
		$extends = 'SanSIS_Model_Database_Abstract';
		
		foreach ($desc as $col => $desc)
		{
			$_metadata[$col]	= $desc;
			$_cols[]			= $col;
			$_schema			= $desc["SCHEMA_NAME"];
			$_name			  = $desc["TABLE_NAME"];
			
			if (strstr($desc["DEFAULT"], 'nextval(\'') && !strstr($desc["DEFAULT"], $_schema.'.')) {
				$_metadata[$col]["DEFAULT"] = str_replace('nextval(\'','nextval(\''.$_schema.'.',$desc["DEFAULT"]);
			}

			if ($desc['PRIMARY'])  {
				$_primary[] = $col;
				if (!$_sequence) {
					$_sequence = str_replace('nextval(\'', '', str_replace('\'::regclass)','',$_metadata[$col]["DEFAULT"]));
				}
			}
		}
		
		$class  = "<?php\n";
		$class .= 'class '.$this->_config->appnamespace.'_Model_DbTable_'.$_class.' extends '.$extends."\n";
		$class .= "{\n";
		$class .= 'protected $_schema = '.var_export($_schema, true).";\n";
		$class .= 'protected $_name = '.var_export($_name, true).";\n";
		$class .= 'protected $_sequence = '.var_export($_sequence, true).";\n\n";
		$class .= 'protected $_primary = '.var_export($_primary, true).";\n\n";
		$class .= 'protected $_cols = '.var_export($_cols, true).";\n\n";
		$class .= 'protected $_metadata = '.var_export($_metadata, true).";\n\n";
		$class .= "}\n";
		$class .= '?>';
		
		$filename = APPLICATION_PATH.DIRECTORY_SEPARATOR.
									'models'.DIRECTORY_SEPARATOR.
									'DbTable'.DIRECTORY_SEPARATOR.
		$_class.'.php';
		
		if (!file_exists($filename))
			$this->view->result .= '<font color="#006600">Gerada a classe '.$this->_config->appnamespace.'_Model_DbTable_'.$_class.'.</font><br>';
		else
			$this->view->result .= '<font color="#000099">Sobrescrita a definição da classe '.$this->_config->appnamespace.'_Model_DbTable_'.$_class.'.</font><br>';
		
		file_put_contents($filename, $class);
		
		$class  = "<?php\n";
		$class .= 'class '.$this->_config->appnamespace.'_Model_'.$_class.' extends '.$this->_config->appnamespace.'_Model_DbTable_'.$_class."\n";
		$class .= "{\n";
		$class .= "}\n";
		$class .= '?>';
		
		$filename = APPLICATION_PATH.DIRECTORY_SEPARATOR.
									'models'.DIRECTORY_SEPARATOR.
		$_class.'.php';
		
		if (!file_exists($filename) && !$overwrite)
		{
			file_put_contents($filename, $class);
			$this->view->result .= '<font color="#006600">Gerada a classe '.$this->_config->appnamespace.'_Model_'.$_class.'.</font><br><br>';
		}
		else
			$this->view->result .= '<font color="#FF0000">Não foi possível gerar a classe '.$this->_config->appnamespace.'_Model_'.$_class.'! Já há um arquivo para esta classe.</font><br><br>';
	}


}

