<?php
declare(strict_types=1);

namespace Ps14\Health\Controller;


use Ps14\Health\Domain\Model\UriResponse;
use Ps14\Health\Domain\Repository\UriRepository;
use Ps14\Health\Tests\AbstractTest;
use Ps14\Health\Tests\Accessibility\EmptyParagraphTest;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

/***
 *
 * This file is part of the "Health" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2021 Christian Pschorr <pschorr.christian@gmail.com>
 *
 ***/

/**
 * SiteController
 */
class SiteController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * siteRepository
	 *
	 * @var \Ps14\Health\Domain\Repository\SiteRepository
	 */
	protected $siteRepository = null;

	/**
	 * @param \Ps14\Health\Domain\Repository\SiteRepository $siteRepository
	 */
	public function injectSiteRepository(\Ps14\Health\Domain\Repository\SiteRepository $siteRepository) {
		$this->siteRepository = $siteRepository;
	}

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$sites = $this->siteRepository->findAll();
		$this->view->assign('sites', $sites);
	}

	/**
	 * action show
	 *
	 * @param \Ps14\Health\Domain\Model\Site $site
	 * @return void
	 */
	public function showAction(\Ps14\Health\Domain\Model\Site $site) {
		$this->view->assign('site', $site);
	}

	/**
	 * @return UriResponse
	 */
	protected function getMock() {
		$uri = $this->objectManager->get(UriRepository::class)->findByUid(1);

		/** @var UriResponse $response */
		$response = $this->objectManager->getEmptyObject(UriResponse::class);
		$response->setLastRequestTime(new \DateTime());
		$response->setUri($uri);
		$response->setBody('<body><p>&bnsp;</p>');

		return $response;
	}



	/**
	 * @param \Ps14\Health\Domain\Model\Uri $uri
	 * @return boolean
	 */
	public function testingAction(\Ps14\Health\Domain\Model\Uri $uri = null) {
		$response = $this->getMock();
		$tests = [
			EmptyParagraphTest::class
		];

		foreach($tests as $test) {

			/** @var AbstractTest $testInstance */
			$testInstance = $this->objectManager->get($test);
			$testInstance->setUriResponse($response);

			$result = $testInstance->perform();
		}

		return true;
	}
}
