<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class HeaderOrderTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();
		$references = [];

		if(preg_match_all('/<h([1-6]).*?>.*?<\/h[1-6]>/msi', $html, $matches) !== 0) {

			// Speicherung der vorherigen Ueberschriften-Stufe
			$prev = 0;

			for($i = 0; $i < count($matches[0]); $i++) {
				$current = (int) $matches[1][$i];

				if($current > $prev) {

					// Abstand berechnen
					$distance = $current - $prev;

					// Bei einem Abstand mehr eins ist ein Sprung enthalten
					if($distance > 1) {
						$references[] = $matches[0][$i];
					}
				}

				$prev = $current;
			}
		}

		if(empty($references) === false) {
			return new ErrorTestResult('Incorrect ' . count($references) . ' headline orderings found ' . implode(', ', $references));
		}

		return new SuccessTestResult();
	}
}