<?php

class InstallationController extends SanSIS_Controller_Action
{
	protected $bizClassName 			= null;
	protected $title 					= 'Assistente de configuração de instalação do ProFlow';
	
	protected $actionOrder				= array(
				0 => 'index',
				1 => 'dbcreation',
				2 => 'dbconfig',
				3 => 'rootusercreation',
				4 => 'end'
	);
	
	protected $indexSubTitle 			= 'Iniciar Instalação';	
	protected $dbcreationSubTitle		= 'Criação do Banco de Dados';
	protected $dbconfigSubTitle			= 'Configuração para acesso ao Banco de Dados';
	protected $importbasedataSubTitle	= 'Importação dos dados básicos';
	protected $rootusercreationSubTitle	= 'Criação do super-usuário';
	protected $endSubTitle				= 'Instalação finalizada';
	
	protected $currAction				= '';
	
	protected $currActionKey			= null;
	protected $prevActionKey			= null;
	protected $nextActionKey			= null;
	
	protected $successTarget			= '';
	protected $previousTarget			= '';
	
	protected $actionMenu				= array();
	
	public function init()
	{		
		parent::init();
		
		//se não existir um arquivo de configuração modelo, não executar nenhuma etapa da instalação
		if (
			!file_exists(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'configuration.ini')
			&& APPLICATION_ENV == 'production'
			)
		{
			$this->addMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_NO_ACL, '/');
			return;
		}
		
		$req = $this->getRequest();
		
		$this->currAction = $req->getActionName();
		
		$this->currActionKey = array_search($this->currAction, $this->actionOrder);
		//Botão "Anterior" do Wizard removido temporariamente - código mantido apenas para exemplo de como criar a navegação de um wizard
		//$this->prevActionKey = ($this->currActionKey > 0) ? ($this->currActionKey -1) : null;
		$this->nextActionKey = ($this->currActionKey < (count($this->actionOrder) - 1)) ? ($this->currActionKey  + 1) : null;
		
		$form = 'SanSIS_Form_Installation_'.ucfirst($this->currAction);
		
		$this->view->form = new $form();
		$this->view->form->setActionButtons($this->prevActionKey, $this->nextActionKey);
		
		if (!is_null($this->nextActionKey))
			$this->successTarget  = '/default/installation/'.$this->actionOrder[$this->nextActionKey];
		if (!is_null($this->prevActionKey))
			$this->previousTarget = '/default/installation/'.$this->actionOrder[$this->prevActionKey];
		
		$values = $this->getRequest()->getParams();
		
		if (isset($values['anterior']))
			$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->previousTarget);
	}
	
	public function indexAction()
	{
		$this->setSubTitle($this->indexSubTitle);
		
		//processa os dados submetidos e então vai para a próxima action em caso de sucesso
		try
		{
			if($this->getRequest()->getPost())
			{
				if ($this->view->form->isValid($this->getRequest()->getPost()))
					$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->successTarget);
				else
				{
					$this->view->form->populate($this->getRequest()->getParams());
					$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->form->populate($this->getRequest()->getParams());			
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());
		}
		
		//Pega os dados da licença
		$license = file_get_contents(APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'LICENSE.txt');
		$this->view->form->getElement('contrato')->setValue($license);
	}
	
	public function dbcreationAction()
	{
		$this->setSubTitle($this->dbcreationSubTitle);
		
		//se já existir um banco de dados criado, não deve prosseguir com a instalação
		try
		{
			if (!isset($_SESSION['server']))
			{
				$_SESSION['server'] 	= '';
				$_SESSION['dbname'] 	= '';
				$_SESSION['superuser'] 	= '';
				$_SESSION['passwd'] 	= '';
			}
			
			$this->view->form->populate(
				array(
					'server' 	=> $_SESSION['server'],
					'dbname' 	=> $_SESSION['dbname'],
					'superuser' => $_SESSION['superuser'],
					'passwd'	=> '',
				)
			);
			
			if($this->getRequest()->getPost())
			{
				$values = $this->getRequest()->getParams();
				
				if ($this->view->form->isValid($this->getRequest()->getPost()))
				{
					$_SESSION['server'] 	= strtolower($values['server']);
					$_SESSION['dbname'] 	= strtolower($values['dbname']);
					$_SESSION['superuser'] 	= strtolower($values['superuser']);
					$_SESSION['passwd'] 	= $values['passwd'];
					
// 					var_dump($_SESSION);die;
					
					if (!$values['manual'])
					{					
						$conn = new PDO('pgsql:host='.$values['server'].';dbname=postgres', $values['superuser'], $values['passwd']);
						$conn->exec('CREATE DATABASE '.$values['dbname'].'
										WITH OWNER = postgres
										ENCODING = \'UTF8\'
										TABLESPACE = pg_default
										CONNECTION LIMIT = -1;');
						
						$script = file_get_contents(APPLICATION_PATH.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'ProFlow.sql');
						
						$conn = new PDO('pgsql:host='.$values['server'].';dbname='.$values['dbname'], $values['superuser'], $values['passwd']);
						$conn->exec($script);
					}
					
					$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->successTarget);
				}
				else
				{
					$this->view->form->populate($this->getRequest()->getParams());
					$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->form->populate($this->getRequest()->getParams());
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_DBINSTALLERROR);
		}
	}
	
	public function dbconfigAction()
	{
		$this->setSubTitle($this->dbconfigSubTitle);
		
		//se já existir uma configuração para o banco de dados, não deve prosseguir com a instalação
		//se já existir um banco de dados criado, não deve prosseguir com a instalação
		try
		{
			if (!isset($_SESSION['user']))
			{
				$_SESSION['user'] = '';
				$_SESSION['pass'] = '';
			}
			
			$this->getRequest()->setParams(
				array(
					'server' 	=> $_SESSION['server'],
					'dbname' 	=> $_SESSION['dbname'],
				)
			);
			
			$this->view->form->populate(
				array(
					'server' 	=> $_SESSION['server'],
					'dbname' 	=> $_SESSION['dbname'],
					'user' 		=> $_SESSION['user'],
					'pass' 		=> $_SESSION['pass'],
				)
			);
			
			$appini_path = APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'application.ini';

			if (!(fileperms($appini_path) & 0x0080))
			{
				$this->view->form->populate($this->getRequest()->getParams());
				$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_CONFWRITEPERM);
				return;
			}
			
			if($this->getRequest()->getPost())
			{
				$values = $this->getRequest()->getParams();
				
				if ($this->view->form->isValid($this->getRequest()->getPost()))
				{
					$_SESSION['user'] 	= $values['user'];
					$_SESSION['pass'] 	= $values['pass'];

					$adp = new Zend_Db_Adapter_Pdo_Pgsql(array(
							'host' 		=> $_SESSION['server'],
							'username' 	=> $_SESSION['superuser'],
							'password' 	=> $_SESSION['passwd'],
							'dbname' 	=> $_SESSION['dbname']
					));
					
					try
					{
						$conn = $adp->getConnection();
					
						//cria usuário automaticamente
						if (!$values['manual'])
						{
							$conn->exec('CREATE USER '.$values['user'].' WITH PASSWORD \''.$values['pass'].'\'');
						}
						
						//grants necessários para utilizar o banco de dados
						Zend_Db_Table::setDefaultAdapter($adp);
						
						$tables = Zend_Db_Table::getDefaultAdapter()->listTables();
						
						foreach ($tables as $table)
						{
							try
							{
								$conn->exec('GRANT SELECT, INSERT, UPDATE on '.$table.' TO '.$values['user']);
							}
							catch(Exception $e)
							{
								throw new Exception();
							}
							try
							{
								$conn->exec('GRANT SELECT, INSERT, UPDATE on '.$table.'_id_seq TO '.$values['user']);
							}
							catch(Exception $e){}
						}
					}
					catch(Exception $e)
					{
						$this->view->form->populate($this->getRequest()->getParams());
						$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_DBINSTALLERROR);
						return;
					}
					
					//testa conexão
					$conn = new PDO('pgsql:host='.$_SESSION['server'].';dbname='.$_SESSION['dbname'], $values['user'], $values['pass']);
					
					$config = new Zend_Config_Ini(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'configuration.ini',null, true);
					
					$config->{APPLICATION_ENV}->resources->db->params->host 		= $_SESSION['server'];
					$config->{APPLICATION_ENV}->resources->db->params->username 	= $_SESSION['user'];
					$config->{APPLICATION_ENV}->resources->db->params->password 	= $_SESSION['pass'];
					$config->{APPLICATION_ENV}->resources->db->params->dbname 		= $_SESSION['dbname'];
										
					// Write the config file
					$writer = new Zend_Config_Writer_Ini(array ('config'   => $config,
										                        'filename' => $appini_path
																)
														);
					$writer->write();
										
					$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->successTarget);
				}
				else
				{
					$this->view->form->populate($this->getRequest()->getParams());
					$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->form->populate($this->getRequest()->getParams());
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());
		}
	}
	
	public function rootusercreationAction()
	{
		$this->setSubTitle($this->rootusercreationSubTitle);
		
		//se já existir um ou mais roots no sistema, não deve prosseguir com a instalação
		try
		{
			if($this->getRequest()->getPost())
			{
				
				$values = $this->getRequest()->getParams();
				
				if ($this->view->form->isValid($this->getRequest()->getPost()))
				{
					$biz = new Admin_Business_Usuario();
					$biz->saveInstall($this->getRequest()->getParams());
					$this->addMessage(SanSIS_Message::TYPE_SUCCESS, SanSIS_Message::MSG_SUCCESS, $this->successTarget);
				}
				else
				{
					$this->view->form->populate($this->getRequest()->getParams());
					$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, SanSIS_Message::MSG_INVALID);
				}
			}
		}
		catch(Exception $e)
		{
			$this->view->form->populate($this->getRequest()->getParams());
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());
		}
	}
	
	public function endAction()
	{
		$this->setSubTitle($this->endSubTitle);
		
		try
		{
			if($this->getRequest()->getPost())
			{
				unset(
					$_SESSION['server'],
					$_SESSION['dbname'],
					$_SESSION['user'],
					$_SESSION['pass'],
					$_SESSION['superuser'],
					$_SESSION['passwd']
				);
				
				$values = $this->getRequest()->getParams();				
				
				//se não existir um arquivo de configuração modelo, interrompe a instalação
				if (APPLICATION_ENV == 'production')
					unlink(APPLICATION_PATH.DIRECTORY_SEPARATOR.'configs'.DIRECTORY_SEPARATOR.'configuration.ini');
				
				//só é possível agora ir para a tela de login
				if (isset($values['próximo']))
					header('Location: '.$this->baseurl.'/login/index/');
			}
		}
		catch(Exception $e)
		{
			$this->view->form->populate($this->getRequest()->getParams());
			$this->addInstantMessage(SanSIS_Message::TYPE_ERROR, $e->getMessage());
		}
	}
}

