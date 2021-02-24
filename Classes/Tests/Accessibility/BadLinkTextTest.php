<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class BadLinkTextTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();
		$badWords = ['hier', 'zur website', 'weiter', 'weitere infos'];
		$references = [];

		if(preg_match_all('/<a(.*?)>(.*?)<\/a>/mi', $html, $matches) !== 0) {

			// Match 0: gesamter HTML-Tag
			// Match 1: die Attribute als String
			// Match 2: der Inhalt des A-Tags
			for($i = 0; $i <= count($matches[0]); $i++) {

				// Title Attribute identifizieren
				$title = '';
				if(preg_match('/title="(.*)"/miU', $matches[1][$i], $titleMatch) !== 0) {
					if(isset($titleMatch[1]) === true) {
						$title = trim($titleMatch[1]);
					}
				}

				// Linktext identifizieren
				$text = trim(strip_tags($matches[2][$i]));

				if(empty($text) === false) {

					// unzureichende Beschriftung und nicht mit title Attribut erklaert
					if(in_array($text, $badWords) === true && empty($title) === true) {
						$references[] = $matches[0][$i];
					}

					// Title-Attribute entspricht dem Text
					if($text === $title) {
						$references[] = $matches[0][$i];
					}
				}
			}
		}

		if(empty($references) === false) {
			return new ErrorTestResult('Found ' . count($matches[0]) . ' bad link text or duplicate title-attribute: ' . implode(', ', $references));
		}

		return new SuccessTestResult();
	}
}