<?php 

/**
 * Exceção para formulário incompleto ou inválido
 *
 * @package		SanSIS
 * @subpackage	Exception
 * @category	Exception
 * @name		Filtro
 * @author		Pablo Santiago Sánchez <phackwer@gmail.com>
 * @version		1.0.0
 */

class SanSIS_Exception_DatabaseError extends Exception
{
	protected $message = 'Houve um erro interno da aplicação.';
	protected $code    = 'DBEMG001';
	
//	public function __construct($message, $code = null, $previous = null)
//	{
//		$headers = "From: pablo.sanchez@mirante.net.br\n" .
//	    "Reply-To: pablo.sanchez@mirante.net.br\n" .
//	    'X-Mailer: PHP/' . phpversion();
//		
//		mail('pablo.sanchez@mirante.net.br', $this->code, $this->message."\n".$message, $headers);
//	}
}

?>