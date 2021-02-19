<?php
namespace Ps14\Health\Tests;

use Ps14\Health\Domain\Model\UriResponse;

class UriTest extends AbstractTest {

	/**
	 * @var UriResponse $uriResponse
	 */
	protected $uriResponse;

	/**
	 * @return UriResponse
	 */
	public function getUriResponse(): UriResponse {
		return $this->uriResponse;
	}

	/**
	 * @param UriResponse $uriResponse
	 * @return void
	 */
	public function setUriResponse(UriResponse $uriResponse): void {
		$this->uriResponse = $uriResponse;
	}

}