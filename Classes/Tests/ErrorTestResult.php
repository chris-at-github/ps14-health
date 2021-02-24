<?php
namespace Ps14\Health\Tests;

class ErrorTestResult implements TestResultInterface {

	/**
	 * @var string
	 */
	protected $message = '';

	/**
	 * @param string $message
	 */
	public function __construct($message = '') {
		$this->setMessage($message);
	}

	/**
	 * @return string
	 */
	public function getMessage(): string {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage(string $message): void {
		$this->message = $message;
	}
}