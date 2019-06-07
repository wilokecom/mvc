<?php

namespace MVC\Database;


class MysqlGrammar implements DBInterface {
	/*
	 * @param Array
	 */
	private $aDBConfiguration;
	/*
	 * @param instanceof \mysqli
	 */
	private $oConnect = null;
	private $oSTMT = null;

	public function __construct($aDBConfiguration) {
		$this->aDBConfiguration = $aDBConfiguration;
	}
	/*
	 * Prepare before querying
	 *
	 * @return array
	 */
	public function queryPrepared($query, array $aArgs){
		$aParams = array();
		$this->oSTMT = $this->oConnect->prepare($query);
		$types = array_reduce($aArgs, function($carry, $args) use (&$aParams){
			$aParams[] = $args;
			switch ($args){
				case is_float($args):
					$carry .= 'd';
					break;
				case is_integer($args):
					$carry .= 'i';
					break;
				case is_string($args):
					$carry .= 's';
					break;
				default:
					$carry .= 'b';
					break;
			}
			return $carry;
		}, '');

		$this->oSTMT->bind_param($types, ...$aParams);
		$oResult = $this->oSTMT->execute() ? $this->oSTMT->get_result() : false;
		$this->oSTMT->close();

		if ( !$oResult ){
			return false;
		}

		$aRows = [];
		if (isset($oResult) && $oResult instanceof \mysqli_result) {
			while (null !== ($aRow = $oResult->fetch_assoc())) {
				$aRows[] = $aRow;
			}
		}
		return $aRows;
	}

	/*
	 * Connecting to database
	 */
	public function connect() {
		if ( $this->oConnect === null ){
			$this->oConnect = new\mysqli($this->aDBConfiguration['host'], $this->aDBConfiguration['username'], $this->aDBConfiguration['password'], $this->aDBConfiguration['db']);
			/* check connection */
			if ($this->oConnect->connect_errno) {
				throw new \RuntimeException("Connect failed: %s\n", $this->oConnect ->connect_error);
			}
		}
		return $this;
	}
	/**
	 * Get Result
	 *
	 * @return array | bool
	 */
	public function select($string) {
		if ( $oResult = $this->oConnect->query($string) ){
			$aValue = array();
			while ($aResulta = $oResult->fetch_array(MYSQLI_ASSOC))
			{
				$aValue[] = $aResulta;
			}
			$oResult->close();
			return $aValue;
		}
		return false;
	}
	public function insert($string) {
		// TODO: Implement insert() method.
	}

	public function delete($string) {
		// TODO: Implement delete() method.
	}
}