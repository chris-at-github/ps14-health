<?php
declare(strict_types=1);

namespace Ps14\Health\Controller;

use Ps14\Health\Domain\Model\Site;
use Ps14\Health\Domain\Model\Uri;
use Ps14\Health\Domain\Repository\SiteRepository;
use Ps14\Health\QueueHandler\UriHandler;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
use TYPO3\CMS\Extbase\Persistence\Generic\PersistenceManager;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Database\Connection;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;

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

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_uri');
		$statement = $queryBuilder
			->select('uid')
			->from('tx_health_domain_model_uri')
			->where(
				$queryBuilder->expr()->eq('site', $queryBuilder->createNamedParameter($site->getUid(), \PDO::PARAM_INT)),
				$queryBuilder->expr()->eq('uri', $queryBuilder->createNamedParameter($this->request->getArgument('uri'), \PDO::PARAM_STR))
			)
			->execute();

		$uri = $statement->fetch();
		$now = new \DateTime();

		if($uri === false) {

			/** @var Connection $connection */
			$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_health_domain_model_uri');
			$connection->insert('tx_health_domain_model_uri', [
				'uri' => $this->request->getArgument('uri'),
				'site' => 	$site->getUid(),
				'pid' => $site->getPid(),
				'tstamp' => $now->getTimestamp(),
				'crdate' => $now->getTimestamp()
			]);

			$uri = [
				'uid' => (int) $connection->lastInsertId('tx_health_domain_model_uri')
			];
		}

		if(empty($uri['uid']) === false) {
			$identifier = sha1(UriHandler::class . '.' . $site->getUid() . '.' . $uri['uid']);
			$arguments = [
				'uri' => $uri['uid']
			];

			/** @var QueryBuilder $queryBuilder */
			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_queue');
			$statement = $queryBuilder
				->select('uid')
				->from('tx_health_domain_model_queue')
				->where(
					$queryBuilder->expr()->eq('identifier', $queryBuilder->createNamedParameter($identifier, \PDO::PARAM_STR))
				)
				->execute();

			if($statement->fetch() === false) {

				/** @var Connection $connection */
				$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_health_domain_model_queue');
				$connection->insert('tx_health_domain_model_queue', [
					'pid' => $site->getPid(),
					'tstamp' => $now->getTimestamp(),
					'crdate' => $now->getTimestamp(),
					'identifier' => $identifier,
					'site' => 	$site->getUid(),
					'handler' => UriHandler::class,
					'next_execution' => $now->format('Y-m-d H:i:s'),
					'arguments' => json_encode($arguments)
				]);
			}
		}
	}

	/**
	 * @param Site $site
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function processQueueAction(Site $site) {

		$now = new \DateTime();

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_queue');
		$statement = $queryBuilder
			->select('*')
			->from('tx_health_domain_model_queue')
			->where(
				$queryBuilder->expr()->lte('next_execution', $queryBuilder->createNamedParameter($now->format('Y-m-d H:i:s'), \PDO::PARAM_STR))

			)
			->orderBy('next_execution')
			->execute();

		if(($queue = $statement->fetch()) !== false) {

			/** @var Site $site */
			$site = $this->objectManager->get(SiteRepository::class)->findByUid((int) $queue['site']);

			/** @var UriHandler $handler */
			$handler = GeneralUtility::makeInstance($queue['handler'], $site, json_decode($queue['arguments'], true));
			$handler->handle();
		}
	}
}