<?php

class SanSIS_Validate_Cpf extends Zend_Validate_Abstract
{
	const CPF_INVALIDO = "cpf_invalido";

	protected $_messageTemplates = array (
		self::CPF_INVALIDO => "CPF Inválido"
	);

	public function isValid($value)
	{
		$value = (string) $value;
		$this->_setValue($value);

		$cpf = trim($value);
		// somente números
		$cpf = preg_replace('/[^0-9]/', '', $cpf);
		$cpf = str_pad($cpf, 11, '0', STR_PAD_LEFT);

		// verificar a qtde de digitos
		if (strlen($cpf) != 11)  {
			$this->_error(self::CPF_INVALIDO);
			return false;
		}

		// verificar por dígitos iguauis
		$regex = "/^0+$|^1+$|^2+$|^3+$|^4+$|^5+$|^6+$|^7+$|^8+$|^9+$/";
		if (preg_match($regex, $cpf)) {
			$this->_error(self::CPF_INVALIDO);
			return false;
		}


		$tcpf = $cpf;
		$b = 0; $c = 11;
		for($i = 0; $i < 11; $i++) {
			if ($i < 9) {
				$b += ($tcpf[$i] * --$c);
			}
		}

		$x = $b % 11;
		$tcpf[9] = ($x < 2) ? 0 : 11 - $x;

		$b = 0; $c = 11;
		for($y = 0; $y < 10; $y++) {
			$b += ($tcpf[$y] * $c--);
		}

		$x = $b % 11;
		$tcpf[10] = ($x < 2) ? 0 : 11 - $x;


		if (($cpf[9] != $tcpf[9]) || ($cpf[10] != $tcpf[10])) {
			$this->_error(self::CPF_INVALIDO);
			return false;
		}
		return true;
	}
}