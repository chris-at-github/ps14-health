<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EmptyAltAttributeTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();
		$references = [];

		if(preg_match_all('/<img.*? alt="\s*"[^>]*?\/?>/mi', $html, $matches) !== 0) {
			for($i = 0; $i < count($matches[0]); $i++) {
				$references[] = $matches[0][$i];
			}

			return new ErrorTestResult('Found ' . count($matches[0]) . ' images with empty alt-attribute: ' . implode(', ', $references));
		}

		return new SuccessTestResult();
	}
}