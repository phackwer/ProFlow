<?php
/**
 * Controller base para todos os outros baseados em HTML
 *
 * @package		SanSIS
 * @subpackage	Controller
 * @category	Controller
 * @name		Action
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
abstract class SanSIS_Controller_Action extends Zend_Controller_Action
{
	/**
	 * As variáveis abaixo devem ser setadas na classe que estende a Action,
	 * caso contrário, não funcionará 
	 */
	protected $title 					= '';
	protected $bizClassName 			= 'SanSIS_Business';
	protected $biz 						= null;
	protected $loginFormClassName		= 'SanSIS_Form_Login';
	protected $actionMenu				= null;
	public $_config;
	
	public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        
        if (Zend_Db_Table::getDefaultAdapter() && !Zend_Db_Table::getDefaultAdapter()->getConnection()->inTransaction())
        	Zend_Db_Table::getDefaultAdapter()->beginTransaction();
    }
    
    public function __destruct()
    {
	    if (Zend_Db_Table::getDefaultAdapter() && Zend_Db_Table::getDefaultAdapter()->getConnection()->inTransaction())
	    	Zend_Db_Table::getDefaultAdapter()->commit();
    }
	
	/**
	 * Inicializa a action, checando itens como segurança e preparando o ambiente
	 */
	public function init()
	{
		$this->_config = new Zend_Config_Ini(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini', APPLICATION_ENV);
		$this->baseurl = $this->getRequest()->getBaseUrl();
		$this->checkInstall();
		
		if($this->bizClassName)
		{
			$this->biz = new $this->bizClassName();
			$this->biz->baseurl = $this->baseurl;
			$this->biz->controller = $this;
		}
		
		$this->view->baseurl = $this->baseurl;
		$this->view->controller = $this;
		$this->view->displaySystemMessages = true;
		$this->view->actionMenu = $this->actionMenu;
		$this->getRealPost();
			
		$this->setTitle($this->title);
		
		$this->checkAuth();
		
		
		parent::init();
	}
	/**
	 * Método para evitar uso indevido dos recursos do Sistema
	 */
	public function checkReferer()
	{
		if (
				(
					!isset($_SERVER['HTTP_REFERER'])
					||
					!strstr($_SERVER['HTTP_REFERER'], 'http://'.$_SERVER['SERVER_NAME'])
				)
				&&
				(
					APPLICATION_ENV != 'development'
				)
		)
			die('Busted! IP: '.$_SERVER['REMOTE_ADDR'].' log time: '.date('Y-m-d H:i:s'));
	}

	public function checkInstall()
	{
		//checa se configuração da aplicação foi realizada
		if (
				!Zend_Db_Table::getDefaultAdapter()
				&&
					file_exists(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'configuration.ini')
// 				&&
// 					APPLICATION_ENV == 'production' //descomentar depois
				&& 
				(
					$this->getRequest()->getModuleName() != 'default'
					||
					$this->getRequest()->getControllerName() != 'installation'
				)
		)
		{
			$auth = Zend_Auth::getInstance();
			$auth->clearIdentity();
			
			$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INSTALLATION, '/default/installation/index/');
		}
	}
	
	
	/**
	 * Action para login, comum a todas as controllers
	 */
	public function loginAction()
	{
		$this->setSubTitle($this->loginSubTitle);
		
		$this->view->form = new $this->loginFormClassName();
		
		$this->checkAuth();
	}
	
	/**
	 * Action de logout, comum a todas as controllers
	 */
	public function logoutAction()
	{
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
		
		$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, '/');
	}
	
	/**
	 * Checa se o module e controller requerem autenticação. Se requerer, redireciona para
	 * formulário de login caso não tenha ninguém autenticado.
	 */
	public function checkAuth()
	{
		if (Zend_Db_Table::getDefaultAdapter())
		{
			//verificamos se modulo/controller requerem ACL
			$params = $this->getRequest()->getParams();
			$values = $this->getRequest()->getPost();
			
			//cancelamento da ação
			if(isset($values["cancelar"]))
			{
				header('Location: '.$this->baseurl);
				return;
			}
			
			if($this->bizClassName)
			{		
				//se receber usuário e senha, ou se a página requerer autenticação, inicia o processo
				if (
						$this->biz->checkACL($params['module'], $params['controller'])
						||
						(
							isset($values['username']) && isset($values['password'])
						)
					)
				{
					//Vars para redirecionar à página que seria acessada antes de pedir autenticação
					if (isset($params['target']) && $params['target'])
					{
						$arr = explode('|',$params['target']);
						$params['prevmodule'] = $params['module'];
						$params['prevcontroller'] = $params['controller'];
						$params['module'] = $arr[0];
						$params['controller'] = $arr[1];
					}
					
					//verificamos autenticação			
					$auth = Zend_Auth::getInstance();
					
					//Se recebeu usuário e senha tenta autenticar
					if(isset($values['username']) && isset($values['password']))
					{
						$adapter = new SanSIS_Auth_Adapter($values['username'],$values['password']);
						$adapter->setAuthBiz($this->biz);
						$result = $auth->authenticate($adapter);
						
						if ($result->getIdentity()->user->id)
							if ($params['controller'] == 'login')
								$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $params['module']);
							else
								$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $params['module'].'/'.$params['controller']);
						else
							$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID, '/login/index/target/'.$params['module'].'|'.$params['controller']);
					}
					//se tiver alguém autenticado, checa se tem permissão para acessar o que foi solicitado
					else if ($auth->getIdentity())
					{
						$user = $auth->getIdentity()->user;
						if ($user && !$user->checkPerfil($params['module'], $params['controller'], $params['action']))
							$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_ACL, '/');
					}
					//se não tem ninguém autenticado, pede autenticação
					else if (
							!$auth->getIdentity() && 
								$params['module'] !='default' && 
								$params['controller'] !='login' &&
								$params['prevmodule'] !='default' && 
								$params['prevcontroller'] !='login'
							)
						$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_RESTRICTACCESS, '/login/index/target/'.$params['module'].'|'.$params['controller']);
				}
				else if (isset($params['target']))
					$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_RESTRICTACCESS);
			}
		}
	}
	
	public static function getAuth()
	{
		$auth = Zend_Auth::getInstance();
		$authStorage = new Zend_Auth_Storage_Session('Admin');
		$auth->setStorage($authStorage);
	
		return $auth;
	}

	/**
	 * Pega o Post independente da configuração do post_max_size no php.ini
	 */
	public function getRealPost()
	{
		if(count($_POST) == 0)
		{
			$fp = fopen('php://input', 'r');
			if($fp)
			{
				$data = '';
				while(!feof($fp))
				{
					$read = fread($fp, 100);
					if(!strstr($read, 'filename'))
						$data .= $read;
					else
					{
						$data .= $read;
						break;
					}						
				}
				
				$boundary = substr($data, 0, strpos($data, "\n") - 1);
				$data = substr($data, strpos($data, "\n"));
					
				while(strstr($data, $boundary))
				{
				   	$content = substr($data, 0, strpos($data, $boundary));
				   	$data = substr($data, strpos($data, $boundary));
				   	$data = substr($data, strpos($data, "\n"));

				   	//ignoramos o que for arquivo, pois provavelmente
				   	//é a causa de ter excedido o post_max_size
				  	if(!strstr($content, 'filename'))
					   $this->setRealPostData($content);
						
					$counter++;
				}
			}
		}
		
		//filtra os HTMLs para impedir inserção maliciosa
		foreach($_GET as $key => $value)
		{
			$_GET[$key] = $this->limpa_tags($value);
			$_REQUEST[$key] = $this->limpa_tags($value);
		}
		foreach($_POST as $key => $value)
		{
			$_POST[$key] = $this->limpa_tags($value);
			$_REQUEST[$key] = $this->limpa_tags($value);
		}
	}
	
	public function limpa_tags($value)
	{
		if(is_array($value))
		{
			foreach($value as $key2 => $value2)
			{
				$return[$key2] = $this->limpa_tags($value2);
			}
		}
		else
			$return = $value;
			//$return = strip_tags($value);
			
		return $return;
	}
	
	/**
	 * Função auxiliar da getRealPost que dá carga no $_POST
	 * @param $content
	 */
	public function setRealPostData($content)
	{
		$content = explode("\n", $content);
		
		//remove linha separadora que ficou de sujeira
		array_shift($content);
		
		//pegamos a linha com o nome da variável
		$varline = array_shift($content);
		$var = substr($varline, strpos($varline, '"'));
		$var = str_replace(array('"', "\n", "\r"), '', $var);
		
		//remove linha separadora definida pela RFC
		array_shift($content);
		
		//resgata o valor submetido
		$value = '';
		$total = count($content) - 1;
		for($i = 0; $i < $total; $i++)
		{
			if($i ==($total - 1))
			  $content[$i] = str_replace(array('"', "\n", "\r"), '', $content[$i]);
			$value .= $content[$i];
		}
		   
		//coloca o valor no $_POST
		if(!strstr($var, '['))
		{
			$_POST[$var] = $value;
			$_REQUEST[$var] = $value;
		}
		else
		{
			$var1 = substr($var , 0, strpos($var , '['));
			$var2 = substr($var , strpos($var , '['));
			eval('$_POST["'.$var1.'"]'.$var2.' = $value;');
			eval('$_REQUEST["'.$var1.'"]'.$var2.' = $value;');
		}	
	}
	
	/**
	 * Este método é para limpar o submit do form, eliminando os botões de submit
	 * Isso permite que você coloque o nome dos campos iguais aos atributos necessários
	 * Atualmente é usado apenas na listAction.
	 * @return array
	 */
	public function getFormDataOnly(Zend_Form $form, $data = null)
	{		
		if (!$data)
			$data = $this->getRequest()->getParams();
		
		$filteredData = array();
		
		foreach ($data as $key => $value)
		{
			if (is_array($value))
			{
				$sub = $form->getSubForm($key);
				if ($sub)
				{
					$tmparr = $this->getFormDataOnly($sub, $value);
					$filteredData = array_merge($filteredData, $tmparr);
				}
				else 
					$filteredData[$key] = $value;
			}
			else
			{
				$content = $form->getElement($key);
				
				if(!($content instanceof Zend_Form_Element_Submit))
				{
					$class = '';
					if ($content instanceof Zend_Form_Element)
						$class = $content->getAttrib('class');
					
					if (strstr($class, 'money') && $value && strstr($value, ','))
						$filteredData[$key] = str_replace(',','.',str_replace('.','',$value));
					else
						$filteredData[$key] = $value;
				}
			}
		}
		
		return $filteredData;
	}
	
	/**
	 * Métodos referentes à tratativas visuais
	 */
	public function setTitle($title)
	{
		$this->view->title = $title;
	}
	
	public function setSubTitle($subtitle)
	{
		$this->view->subtitle = $subtitle;
	}
	
	public function addMessage($type, $msg, $target)
	{
		if ($target{0}!= '/')
			$target = '/'.$target;
			
		$this->addSystemMessage($type, $msg, $target);
		
		$this->view->displaySystemMessages = false;
		
		header('Location: '.$this->baseurl.$target);
		
		die;
	}
	
	/**
	 * 
	 * Enter description here ...
	 * @param CONST $type
	 * @param CONST $msg
	 */
	public function addInstantMessage($type, $msg)
	{
		$request = $this->getRequest();
		
		$module = $request->getParam('module');
		$controller = $request->getParam('controller');
		$action = $request->getParam('action');
		
		$target = '/'.$module.'/'.$controller;
		
		if ($action)
			$target .= '/'.$action;
		
		$this->addSystemMessage($type, $msg, $target);
	}
	
	protected function addSystemMessage($type, $msg, $target)
	{
		if (!isset($_SESSION['systemMessages']))
			$_SESSION['systemMessages'] = array();
		if (!isset($_SESSION['systemMessages'][$target]))
			$_SESSION['systemMessages'][$target] = array();
		if (!isset($_SESSION['systemMessages'][$target][$type]))
			$_SESSION['systemMessages'][$target][$type] = array();
		$_SESSION['systemMessages'][$target][$type][$msg] = $msg;
	}
}