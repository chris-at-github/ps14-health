<?php

namespace Ps14\Health\Tests\Accessibility;

use Ps14\Health\Tests\AbstractTest;
use Ps14\Health\Tests\PageTestInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class EmptyParagraphTest extends AbstractTest implements PageTestInterface {

	/**
	 * @return \Ps14\Health\Tests\TestResultInterface|void
	 */
	public function perform() {
		DebuggerUtility::var_dump($this->getUriResponse()->getBody());
	}
}