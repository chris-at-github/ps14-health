<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class TableThTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();
		$references = [];

		if(preg_match_all('/<table(.*?)>(.*?)<\/table>/mi', $html, $matches) !== 0) {
			foreach($matches[0] as $table) {

				// keine TH in der Tabelle enthalten
				if(preg_match('/<th(.*?)>(.*?)<\/th>/mi', $table) === 0) {
					$references[] = $table;
				}
			}
		}

		if(empty($references) === false) {
			return new ErrorTestResult('Found ' . count($references) . ' tables without th tags: ' . implode(', ', $references));
		}

		return new SuccessTestResult();
	}
}