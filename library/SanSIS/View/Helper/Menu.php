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
abstract class SanSIS_View_Helper_Menu extends Zend_View_Helper_Abstract
{
	//instância de configuração
	private static $config;
	
	public static function render($baseurl)
	{
		$html = '';
		
		$auth = Zend_Auth::getInstance();
		
		//se usuário está autenticado, cria menu
		if ($auth->getIdentity())
		{
			if (!self::$config)
				self::$config = new Zend_Config_Ini(APPLICATION_PATH.'/configs/menu.ini', 'menu');
			
			foreach (self::$config as $menu)
			{
				if (isset($menu->environment) && $menu->environment != APPLICATION_ENV)
					continue;
				
				$subhtml = '';
				
				if (isset($menu->type) && $menu->type == 'system')
					$css = 'header-navigation-system-links';
				else
					$css = 'header-navigation-links';
				
				if (isset($menu->itens))
				{
					foreach ($menu->itens as $item)
					{
						//checa se usuário tem permissão para o item
 						$user = $auth->getIdentity()->user;
 						if ($user && $user->checkPerfil($item->module, $item->controller, $item->action))
						{
							if (!$subhtml)
								$subhtml .= '<div class="header-navigation-menu">';
							
							if (isset($item->url))
								$href = $item->url;
							else
								$href = $baseurl.'/index.php/'.$item->module.'/'.$item->controller.'/'.$item->action;
							
							$subhtml .= 	'<div class="header-navigation-menu-item">'.
											'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.$href.'">'.
											$item->label.
											'</a>'.
											'</div>';
						}
					}
					
					//se usuário tem permissão para qualquer um dos subitens do menu, lista aqui
					if ($subhtml)
					{
						$html .= 	'<div class="'.$css.'">&nbsp;&nbsp;&nbsp;&nbsp;'.
									$menu->label.
									$subhtml.
									'</div>'.
									'</div>';
					}
				}
				else
				{
					$html .= 	'<div class="'.$css.'">'.
								$menu->label.
								'</div>';
				}
			}
			
		}		
		
		return $html;
	}
}

?>