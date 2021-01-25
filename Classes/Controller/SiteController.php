<?php
declare(strict_types=1);

namespace Ps14\Health\Controller;


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
}
