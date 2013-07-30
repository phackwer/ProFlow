<?php

class SanSIS_Grid_Source_Array extends Bvb_Grid_Source_Array {

	function __construct(array $array, $titles = null) {
		if (!empty($array) && $titles) {
			if (count(array_keys($array[0])) == count($titles)) {
				$fields = $titles;
				foreach ($array as $key => $value) {
					$array[$key] = array_combine($titles, $value);
				}
			} else {
				$fields = array_keys($array[0]);
			}
		} elseif (empty($array) && $titles) {
			$fields = $titles;
			$array = array();
		} elseif (!empty($array) && is_null($titles)) {
			$fields = array_keys($array[0]);
		} else {
			$array = array();
			$fields = array();
		}

		$this->_fields = $fields;
		$this->_rawResult = $array;
		$this->_sourceName = 'array';
	}

	function execute() {
		$this->_totalRecords = count($this->_rawResult);

		if (!empty($this->_rawResult)) {
			if ($this->_offset == 0) {
				return array_slice($this->_rawResult, $this->_start);
			}
			return array_slice($this->_rawResult, $this->_start, $this->_offset);
		} else {
			return array();
		}
	}

}