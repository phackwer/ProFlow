<?php

/**
 * Helper para apresentação de mensagens na camada View
 *
 * @package		SanSIS
 * @subpackage	View
 * @category	Helper
 * @name		Menu
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
abstract class SanSIS_View_Helper_ActionMenu extends Zend_View_Helper_Abstract
{
	//instância de configuração
	private static $config;
	
	public static function render($actionMenu, $baseUrl)
	{
		$html = '';
		$divisor = '';
		
		$auth 			= Zend_Auth::getInstance();
		
		$request 		= Zend_Controller_Front::getInstance()->getRequest();
		$baseAction 	= $request->getActionName();
		$baseController = $request->getControllerName();
		$baseModule 	= $request->getModuleName();
		
		//se usuário está autenticado, cria menu
		//if ($auth->getIdentity())
		{
			if ($actionMenu)
			{
				$html = '<div id="view-navigation">'; 
				
				foreach ($actionMenu as $key => $value)
				{
					$mod = (isset($value['module'])) ? $value['module'] : $baseModule;
					$cont = (isset($value['controller'])) ? $value['controller'] : $baseController;
					
					$path = $mod.'/'.$cont.'/'.$value['action'];
					
					if ($baseAction != $value['action'])
						$html .= $divisor.'<a href="'.$baseUrl.'/index.php/'.$path.'">'.$key.'</a>';
					else
						$html .= $divisor.'<a>'.$key.'</a>';
					
					$divisor = ' | ';
				}
				
				$html .= '</div>';
			}
		}		
		
		return $html;
	}
}





?>