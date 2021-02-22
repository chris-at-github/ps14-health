<?php
declare(strict_types=1);

namespace Ps14\Health\Controller;

use Ps14\Health\Domain\Model\Site;
use Ps14\Health\Domain\Model\Uri;
use Ps14\Health\Domain\Repository\SiteRepository;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class DirtyController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

	/**
	 * Initializes the view before invoking an action method.
	 *
	 * Override this method to solve assign variables common for all actions
	 * or prepare the view in another way before the action is called.
	 *
	 * @param ViewInterface $view The view to be initialized
	 */
	protected function initializeView(ViewInterface $view) {
		$this->view->assign('sites', $this->objectManager->get(SiteRepository::class)->findAll());

		if($this->request->hasArgument('site') === true) {
			$this->view->assign('site', $this->request->getArgument('site'));
		}
	}

	public function indexAction() {
	}

	/**
	 * @param Site $site
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function addUriAction(Site $site) {

		/** @var Uri $uri */
		$uri = $this->objectManager->getEmptyObject(Uri::class);
		$uri->setUri($this->request->getArgument('uri'));
		$uri->setSite($site);

		DebuggerUtility::var_dump($uri);
	}
}