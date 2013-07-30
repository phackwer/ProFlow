<?php
/**
 * Adapter para autenticação na área administrativa
 *
 * @package		SanSIS
 * @subpackage	Auth
 * @category	Adapter
 * @name		Admin
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com> 
 * @version		1.0.0
 */
class SanSIS_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
	private $username;
	private $password;
	private $user;
	private $biz;
	
	/**
	 * Construtor padrão
	 * @param unknown_type $username
	 * @param unknown_type $password
	 */
	public function __construct($username, $password)
	{
		$this->username = $username;
		$this->password = hash('whirlpool', $password);;
	}
	
	public function setAuthBiz(SanSIS_Business $biz)
	{
		$this->biz = $biz;
	}
	
	public function authenticate()
	{
		$response = $this->biz->authenticate($this->username, $this->password);
		$this->user = $this->biz->user;
		
		if ($response)
		{
			return $this->result(Zend_Auth_Result::SUCCESS);
		}
		else
		{
			$message = array(SanSIS_Message::MSG_INVALID);
			return $this->result(Zend_Auth_Result::FAILURE, $message);
		}
	}
	
	public function updateUser($id)
	{
		$response = $this->biz->user->load($id);
		$this->user = $this->biz->user;
		
		if ($response)
		{
			return $this->result(Zend_Auth_Result::SUCCESS);
		}
		else
		{
			$message = array(SanSIS_Message::MSG_INVALID);
			return $this->result(Zend_Auth_Result::FAILURE, $message);
		}
	}
	
	/**
	 * @param int $code
	 * @param array $messages
	 * @return Zend_Auth_Result
	 */
	public function result($code, $messages = array())
	{
		return new Zend_Auth_Result(
			$code,
			$this->getUserInfo(),
			$messages
		);
	}
	
    /**
     * @return stdClass
     */
    public function getUserInfo()
    {
        $info = array();
        $info['username'] 		= $this->username;
        $info['user']			= $this->user;
        $info['perfil'] 		= $this->user->perfil;
        return (object) $info;
    }
}