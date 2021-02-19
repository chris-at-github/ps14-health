<?php
namespace Ps14\Health\Tests;

use Ps14\Health\Domain\Model\UriResponse;

interface UriTestInterface {

	/**
	 * @param UriResponse $uriResponse
	 * @return void
	 */
	public function setUriResponse(UriResponse $uriResponse);

	/**
	 * @return TestResultInterface
	 */
	public function perform();
}