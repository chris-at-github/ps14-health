<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class DoubleSpaceEntityTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();

		if(preg_match_all('/(&nbsp;){2,}/mi', $html, $matches) !== 0) {
			return new ErrorTestResult('Found ' . count($matches[0]) . ' double space entities');
		}

		return new SuccessTestResult();
	}
}