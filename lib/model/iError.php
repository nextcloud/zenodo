<?php

namespace OCA\Zenodo\Model;

class iError {

	const FIELD_ISSUE = 1001;

	private $message;
	private $code;

	function __construct() {
	}

	public function setMessage($message) {
		$this->message = $message;

		return $this;
	}

	public function getMessage() {
		return $this->message;
	}


	public function setCode($code) {
		$this->code = $code;
		return $this;
	}

	public function getCode() {
		return $this->code;
	}

}