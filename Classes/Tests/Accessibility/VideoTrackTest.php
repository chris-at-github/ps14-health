<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\ErrorTestResult;
use Ps14\Health\Tests\SuccessTestResult;
use Ps14\Health\Tests\UriTest;
use Ps14\Health\Tests\UriTestInterface;
use Ps14\Health\Tests\TestResultInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class VideoTrackTest extends UriTest implements UriTestInterface {

	/**
	 * @return TestResultInterface|void
	 */
	public function perform() {
		$html = $this->getUriResponse()->getBody();
		$references = [];

		if(preg_match_all('/<video(.*?)>(.*?)<\/video>/mi', $html, $matches) !== 0) {
			foreach($matches[0] as $video) {

				// kein Track-Tag (Captions) im Video-Tag enthalten
				if(preg_match('/<track(.*?)\/>/mi', $video) === 0) {
					$references[] = $video;
				}
			}
		}

		if(empty($references) === false) {
			return new ErrorTestResult('Found ' . count($references) . ' videos without track tags: ' . implode(', ', $references));
		}

		return new SuccessTestResult();
	}
}