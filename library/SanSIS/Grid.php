<?php

/**
 * Extens�o do Bvb_Grid
 *
 * @package		SanSIS
 * @category	Visual
 * @name		Grid
 * @author		Pablo Santiago S�nchez <phackwer@gmail.com> 
 * @version		1.0.0
 */

class SanSIS_Grid {

	private $title;
	private $header;
	private $rowAction = array();
	private $rowId;
	private $mainAction;
	private $hiddenColumn = array();
	private $data;
	protected $_output;
	protected $_rowCallback;
	protected $_flagRowInput = false;
	protected $_actionColumn = 'A&ccedil;&otilde;es';
	protected $_paginationDisplay = null;
	/**
	 * @var int
	 */
	protected $_pagination = 15;


	const INPUT_TYPE_CHECKBOX = 'checkbox';
	const INPUT_TYPE_RADIO = 'radio';

	const DEFAULT_MESSAGE_NO_RECORD = 'Nenhum registro encontrado';
	const MESSAGE_NO_RECORD = SanSIS_Grid_Table::MESSAGE_NO_RECORD;

	const CLASS_ICONS = 'icons';

	/**
	 *
	 * @var array
	 */
	protected $_message = array();
	/**
	 * @var string
	 */
	protected $_rowInput = self::INPUT_TYPE_CHECKBOX;

	/**
	 * @return string
	 */
	public function getActionColumn() {
		return $this->_actionColumn;
	}

	/**
	 * @param string $class
	 * @return SanSIS_Grid 
	 */
	public function setActionColumn($column) {
		$this->_actionColumn = $column;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function hasInput() {
		return $this->_hasInput;
	}

	/**
	 *
	 * @var SanSIS_Grid_Table
	 */
	protected $dataGridInstance;

	/**
	 * Cria uma inst�ncia do SanSIS Grid
	 * @return SanSIS_Grid
	 */
	public static function create() {
		return new SanSIS_Grid();
	}

	/**
	 * @param string $type
	 * @return SanSIS_Grid 
	 */
	public function setRowInput($type) {
		$this->_flagRowInput = true;
		$this->_rowInput = $type;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getRowInput() {
		return $this->_rowInput;
	}

	/**
	 * Retorna o t�tulo da tabela
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Recebe o t�tulo da tabela
	 * @param string $title
	 * @return SanSIS_Grid 
	 */
	public function setTitle($title) {
		$this->title = $title;
		return $this;
	}

	/**
	 * Recebe o cabe�alho do Grid
	 * @param array $header
	 * @return SanSIS_Grid 
	 */
	public function setHeader(array $header) {
		if (!empty($header)) {
			$this->header = $header;
		}
		return $this;
	}

	/**
	 * Retorna as colunas de cabe�alho
	 * @return array
	 */
	public function getHeader() {
		return $this->header;
	}

	/**
	 * Adiciona a��o para a linha
	 * @param string $href
	 * @return SanSIS_Grid
	 */
	public function addRowAction($href) {
		$this->rowAction[] = $href;
		return $this;
	}

	/**
	 * Adicionar a��es para as linhas
	 * @param string $href
	 * @return SanSIS_Grid
	 */
	public function setRowAction($href) {
		$this->rowAction = $href;
		return $this;
	}

	/**
	 * Seta a coluna identificadora da linha
	 * @param string $column
	 * @return SanSIS_Grid
	 */
	public function setRowId($column) {
		$this->rowId = $column;
		return $this;
	}

	/**
	 * Retorna a coluna chave da linha
	 * @return string
	 */
	public function getRowId() {
		return $this->rowId;
	}

	/**
	 * Adiciona as principais a��es 
	 * @param string $label
	 * @param string $url
	 * @return SanSIS_Grid
	 */
	public function addMainAction($label, $url) {
		$this->mainAction[$label] = $url;
		return $this;
	}

	/**
	 * @param array $mains
	 * @return SanSIS_Grid 
	 */
	public function setMainAction(array $mains) {
		foreach ($mains as $label => $url)
			$this->mainAction[$label] = $url;
		return $this;
	}

	/**
	 * Seta as colunas que n�o devem ser mostradas
	 * @param array $column
	 * @return SanSIS_Grid
	 */
	public function setColumnsHidden(array $column) {
		$this->hiddenColumn = $column;
		return $this;
	}

	/**
	 * Seta dos dados na Grid
	 * @param array $data
	 * @return SanSIS_Grid
	 */
	public function setData($data) {
		if (is_array($data)) {
			$this->data = $data;
		} else {
			throw new Zend_Exception('Tipo de dados inv�lidos, deve ser um Zend_Db_Table_Select ou um array');
		}
		return $this;
	}

	/**
	 * Retorna os dados do Grid
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * @return SanSIS_Grid_Table
	 */
	protected function getBvbInstance() {
		if (is_null($this->dataGridInstance)) {
			$this->dataGridInstance = Bvb_Grid::factory('SanSIS_Grid_Table', array(), 'list');
		}
		return $this->dataGridInstance;
	}

	protected function getMainAction() {
		$mainActions = array();
		if (!is_null($this->mainAction)) {
			foreach ($this->mainAction as $label => $url) {
				$mainActions[$label] = array('url' => $url);
			}
		}
		return $mainActions;
	}

	/**
	 * @return string
	 */
	protected function getRowAction() {
		$sthtml = implode('', $this->rowAction);
		return $sthtml;
	}

	/**
	 * @return array
	 */
	protected function getOptions() {
		$arOptions = array('acao' =>
			$this->getMainAction(),
			'idRow' => $this->rowId,
		);

		$arOptions['class'] = 'listagem';
		$arOptions['titulo'] = $this->title;
		return $arOptions;
	}

	/**
	 * @return int
	 */
	public function getPagination() {
		return $this->_pagination;
	}

	/**
	 * @param int $number
	 * @return SanSIS_Grid 
	 */
	public function setPagination($number) {
		$this->_pagination = $number;
		$this->getBvbInstance()->setPagination($number);
		return $this;
	}

	/**
	 * Retona a inst�ncia do Grid Table
	 * @return SanSIS_Grid_Table
	 */
	protected function setPreferences($options, $data, $header = null, $rowAction = null) {
		$obGrid = $this->getBvbInstance();
		$obGrid->setPagination($this->getPagination());
		$obGrid->setPaginationDisplay($this->getPaginationDisplay());

		if (!empty($rowAction)) {
			$this->addColumnsGrid($rowAction);
		}

		$obGrid->setClassCellCondition($this->_actionColumn, true, self::CLASS_ICONS, '');

		$data = new SanSIS_Grid_Source_Array($data, $header);

		$obGrid->noFilters = 1;
		$obGrid->noOrder = 1;

		$obGrid->setOptions($options);

		$obGrid->setSource($data);

		if (($this->_flagRowInput || !empty($options['acao'])) && $options['idRow']) {
			$obGrid->setRowAltClasses("listagemItem", "listagemItem");
			$name = ($this->_rowInput == self::INPUT_TYPE_CHECKBOX) ? 'id[]' : 'id';
			$left = new Bvb_Grid_Extra_Column();
			$left->position('left')->name('')
					->decorator("<input type='" . $this->_rowInput . "' name='{$name}' value='{{" . $options['idRow'] . "}}' />");
			$obGrid->addExtraColumns($left);
		}
		$obGrid->setColumnsHidden($this->hiddenColumn);
	}

	/**
	 * Adiciona campos da grid
	 *
	 * @access protected
	 * @param object $obGrid - Objeto da grid
	 */
	protected function addColumnsGrid($sthtml) {
		$right = new Bvb_Grid_Extra_Column();
		$right->position('right')->name($this->getActionColumn())->class(self::CLASS_ICONS)->title('Right')->decorator($sthtml);
		$this->getBvbInstance()->addExtraColumns($right);
	}

	protected function render() {
		$this->setPreferences($this->getOptions(), $this->getData(), $this->getHeader(), $this->getRowAction());
		$this->_output = self::getBvbInstance()->__toString();
		return $this->_output;
	}

	public function addMessage($key, $message) {
		$this->getBvbInstance()->addMessage($key, $message);
		return $this;
	}

	public function getMessage($key) {
		return $this->getBvbInstance()->getMessage($key);
	}

	/**
	 * @param boolean $flag
	 * @return SanSIS_Grid 
	 */
	public function setPaginationDisplay($flag){
		$this->_paginationDisplay = $flag;
		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getPaginationDisplay(){
		if(count($this->getData()) > $this->getPagination()){
			$this->_paginationDisplay = true;
		}
		return $this->_paginationDisplay;
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$data = $this->getData();
		$header = $this->getHeader();
		if (empty($data) && empty($header)) {
			$this->_output = '<div class="' . SanSIS_Grid_Template_Table::STYLE_DIV_LIST . '">';
			$this->_output .= '<p class="' . SanSIS_Grid_Template_Table::STYLE_NO_RECORD . '">';
			$this->_output .= $this->getMessage(SanSIS_Grid_Table::MESSAGE_NO_RECORD);
			$this->_output .= '</p></div>';
		} elseif (empty($this->_output)) {
			$this->_output = $this->render();
		}
		return $this->_output;
	}

}