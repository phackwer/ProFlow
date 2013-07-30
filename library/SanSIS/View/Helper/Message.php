<?php

/**
 * Helper para apresentação de mensagens na camada View
 *
 * @package		SanSIS
 * @subpackage	View
 * @category	Helper
 * @name		Message
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */
abstract class SanSIS_View_Helper_Message extends Zend_View_Helper_Abstract
{
	public static function render($show, $baseurl)
	{
		$html = '';

		if ($show && isset($_SESSION['systemMessages']) && count($_SESSION['systemMessages']))
		{
			$displayed = array();
			foreach ($_SESSION['systemMessages'] as $target => $sysMessages)
			{
				$cur_uri = str_replace(array($baseurl,'/index.php'),'',$_SERVER['REQUEST_URI']);
				$cur_uri = explode('/',$cur_uri);
				$cur_tar = explode('/', $target);
				
				if (!isset($cur_uri[2]))
					$cur_uri[2] = '';
				if (!isset($cur_uri[3]))
					$cur_uri[3] = '';
				if (!isset($cur_tar[2]))
					$cur_tar[2] = '';
				if (!isset($cur_tar[3]))
					$cur_tar[3] = '';
				if ($cur_tar[3] == 'index')
					$cur_uri[3] = 'index';
				
				if (
						$cur_uri[1] == $cur_tar[1] //module
						&&
						$cur_uri[2] == $cur_tar[2] //controller
						&&
						$cur_uri[3] == $cur_tar[3] //action
					)
				{
					foreach ($sysMessages as $namespace => $messages)
					{
						
						$html .= '<div class="' . $namespace . '">';
						foreach ($messages as $message)
						{
							if (!isset($displayed[$namespace][$message]))
							{
								$displayed[$namespace][$message] = $message;
								$html .= '<p>' . $message . '</p>';
							}
								
						}
						$html .= "</div>";
					}
					
					unset($_SESSION['systemMessages'][$target]);
				}
			}
			//mantive aqui a depuração caso tudo exploda e eu precise dos pedaços ainda...
// 			echo $_SERVER['REQUEST_URI'].'<br>';
// 			echo $baseurl.'/index.php'.$target;
// 			var_dump($_SESSION['systemMessages']);die;
// 			unset($_SESSION['systemMessages']);
		}
		
		return $html;
	}
}





?>