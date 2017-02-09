<?php

namespace OCA\Zenodo\Model;

class iError {

	const TOKEN_MISSING = 1001;

	private $messages = array();
	private $code;

	function __construct() {
	}

	public function setMessage($message) {
		array_push($this->messages, $message);

		return $this;
	}

	public function getMessages() {
		return $this->messages;
	}


	public function setCode($code) {
		$this->code = $code;

		return $this;
	}

	public function getCode() {
		return $this->code;
	}


	public function toArray() {
		return array(
			'code'     => $this->getCode(),
			'messages' => $this->getMessages()
		);
	}


}