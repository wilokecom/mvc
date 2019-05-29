<?php

namespace MVC\Database;


class MysqlGrammar implements DBInterface {
	/*
	 * @param Array
	 */
	private $aDBConfiguration;

	/*
	 * @param Closure
	 */
	private $oConnect = null;

	public function __construct($aDBConfiguration) {
		$this->aDBConfiguration = $aDBConfiguration;
	}

	/*
	 * Connecting to database
	 */
	public function connect() {
		if ( $this->oConnect === null ){
			$this->oConnect = new \mysqli($this->aDBConfiguration['host'], $this->aDBConfiguration['username'], $this->aDBConfiguration['password'], $this->aDBConfiguration['db']);

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