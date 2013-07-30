<?php
class SanSIS_Grid_Template_Table extends Bvb_Grid_Template_Table_Table{

	const STYLE_NO_RECORD = 'listagemVazia';
	const STYLE_DIV_LIST  = 'listagem';

	public function noResults ()
	{
		return "<td colspan=\"{$this->options['colspan']}\" class=\"".self::STYLE_NO_RECORD."\">{{value}}</div>";
	}

}