<?php


class SanSIS_Validate_Cnpj extends Zend_Validate_Abstract
{
	const CNPJ_INVALIDO = "cnpj_invalido";
	
	protected $_messageTemplates = array (
		self::CNPJ_INVALIDO => "CNPJ Inválido"
	);

	public function isValid($value)
	{
		
		$value = (string) $value; 
		$this->_setValue($value);

		$cnpj = trim($value);
		// somente números
		$cnpj = preg_replace('/[^0-9]/', '', $cnpj);
		$cnpj = str_pad($cnpj, 14, '0', STR_PAD_LEFT);
		
		// verificar qtde de digitos
		if (strlen($cnpj) != 14) {
			$this->_error(self::CNPJ_INVALIDO);
			return false;
		}
	
		// verificar por digitos iguais
		$regex = "/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/";
		if (preg_match($regex, $cnpj)) {
			$this->_error(self::CNPJ_INVALIDO);
			return false;
		} 
	
		$tamanho = strlen($cnpj) - 2;
		$numeros = substr($cnpj, 0, $tamanho);
		$digitos = substr($cnpj, $tamanho);	
		$pos = $tamanho - 7;
		
	
		$soma = 0;
		for($i = $tamanho; $i >= 1; $i--) {
			$soma += $numeros[$tamanho - $i] * $pos--;
			if ($pos < 2) {
				$pos = 9;
			}
		}
	
		$resultado = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));
 		if($resultado != $digitos[0]) {
 			$this->_error(self::CNPJ_INVALIDO);
			return false;
 		}
 			
		$tamanho++;
		$numeros = substr($cnpj, 0, $tamanho);
		$soma = 0;
		$pos = $tamanho - 7;
		
		for($i = $tamanho; $i >= 1; $i--) {
			$soma += $numeros[$tamanho - $i] * $pos--;
			if ($pos < 2) {
				$pos = 9;
			}
		}
		
		$resultado = (($soma % 11) < 2) ? 0 : (11 - ($soma % 11));
 		if($resultado != $digitos[1]) {
 			$this->_error(self::CNPJ_INVALIDO);
			return false;
 		}
		
	  	return true;		
	}
}