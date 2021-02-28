<?php
declare(strict_types=1);

namespace Ps14\Health\Controller;

use GuzzleHttp\Client;
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
		$this->addUri($site, $this->request->getArgument('uri'));

//		/** @var QueryBuilder $queryBuilder */
//		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_uri');
//		$statement = $queryBuilder
//			->select('uid')
//			->from('tx_health_domain_model_uri')
//			->where(
//				$queryBuilder->expr()->eq('site', $queryBuilder->createNamedParameter($site->getUid(), \PDO::PARAM_INT)),
//				$queryBuilder->expr()->eq('uri', $queryBuilder->createNamedParameter($this->request->getArgument('uri'), \PDO::PARAM_STR))
//			)
//			->execute();
//
//		$uri = $statement->fetch();
//		$now = new \DateTime();
//
//		if($uri === false) {
//
//			/** @var Connection $connection */
//			$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_health_domain_model_uri');
//			$connection->insert('tx_health_domain_model_uri', [
//				'uri' => $this->request->getArgument('uri'),
//				'site' => 	$site->getUid(),
//				'pid' => $site->getPid(),
//				'tstamp' => $now->getTimestamp(),
//				'crdate' => $now->getTimestamp()
//			]);
//
//			$uri = [
//				'uid' => (int) $connection->lastInsertId('tx_health_domain_model_uri')
//			];
//		}
//
//		if(empty($uri['uid']) === false) {
//			$identifier = sha1(UriHandler::class . '.' . $site->getUid() . '.' . $uri['uid']);
//			$arguments = [
//				'uri' => $uri['uid']
//			];
//
//			/** @var QueryBuilder $queryBuilder */
//			$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_queue');
//			$statement = $queryBuilder
//				->select('uid')
//				->from('tx_health_domain_model_queue')
//				->where(
//					$queryBuilder->expr()->eq('identifier', $queryBuilder->createNamedParameter($identifier, \PDO::PARAM_STR))
//				)
//				->execute();
//
//			if($statement->fetch() === false) {
//
//				/** @var Connection $connection */
//				$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_health_domain_model_queue');
//				$connection->insert('tx_health_domain_model_queue', [
//					'pid' => $site->getPid(),
//					'tstamp' => $now->getTimestamp(),
//					'crdate' => $now->getTimestamp(),
//					'identifier' => $identifier,
//					'site' => 	$site->getUid(),
//					'handler' => UriHandler::class,
//					'execute_at' => $now->format('Y-m-d H:i:s'),
//					'arguments' => json_encode($arguments)
//				]);
//			}
//		}
	}

	/**
	 * @param Site $site
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function processQueueAction(Site $site) {

		$runtime = 1;
		$this->processQueueListing(time() + $runtime);

		return true;
	}

	protected function processQueueListing($runtime) {

		$now = new \DateTime();

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_queue');
		$statement = $queryBuilder
			->select('*')
			->from('tx_health_domain_model_queue')
			->where(
				$queryBuilder->expr()->lte('execute_at', $queryBuilder->createNamedParameter($now->format('Y-m-d H:i:s'), \PDO::PARAM_STR))
			)
			->orderBy('execute_at')
			->setMaxResults(1)
			->execute();

		if(empty($data = $statement->fetch()) === false) {
			$this->processQueueItem($data);

			if(time() < $runtime) {
				$this->processQueueListing($runtime);
			}
		}
	}

	protected function processQueueItem($data) {

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_queue');

		/** @var Site $site */
		$site = $this->objectManager->get(SiteRepository::class)->findByUid((int) $data['site']);

		/** @var UriHandler $handler */
		$handler = GeneralUtility::makeInstance($data['handler'], $site, json_decode($data['arguments'], true));
		$handler->handle();

		$executeAt = new \DateTime();
		$executeAt->add(new \DateInterval('P7D'));

//		$queryBuilder
//			->update('tx_health_domain_model_queue')
//			->where(
//				$queryBuilder->expr()->eq('uid', $queryBuilder->createNamedParameter($data['uid'], \PDO::PARAM_INT))
//			)
//			->set('execute_at', $executeAt->format('Y-m-d H:i:s'))
//			->execute();
//
		usleep((int) (1 * 1000 * 1000));
	}

	/**
	 * @param Site $site
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	public function readSitemapXmlAction(Site $site) {
		$client = new Client();
		$response = $client->request('GET', $this->request->getArgument('sitemap'));
		$xml = $response->getBody()->getContents();

		if(empty($xml) === false) {
			$sitemap = new \SimpleXMLElement($xml);
			foreach($sitemap->url as $url) {
				$uri = str_replace($site->getDomain()->getUri(), '', (string) $url->loc);

				if(empty($uri) === false) {
					$this->addUri($site, $uri);
				}
			}
		}

		return true;
	}

	/**
	 * @param Site $site
	 * @param string $uri
	 * @throws \TYPO3\CMS\Extbase\Mvc\Exception\NoSuchArgumentException
	 */
	protected function addUri(Site $site, string $uri) {

		/** @var QueryBuilder $queryBuilder */
		$queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tx_health_domain_model_uri');
		$statement = $queryBuilder
			->select('uid')
			->from('tx_health_domain_model_uri')
			->where(
				$queryBuilder->expr()->eq('site', $queryBuilder->createNamedParameter($site->getUid(), \PDO::PARAM_INT)),
				$queryBuilder->expr()->eq('uri', $queryBuilder->createNamedParameter($uri, \PDO::PARAM_STR))
			)
			->execute();

		$uid = $statement->fetch();
		$now = new \DateTime();

		if($uid === false) {

			/** @var Connection $connection */
			$connection = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_health_domain_model_uri');
			$connection->insert('tx_health_domain_model_uri', [
				'uri' => $uri,
				'site' => $site->getUid(),
				'pid' => $site->getPid(),
				'tstamp' => $now->getTimestamp(),
				'crdate' => $now->getTimestamp()
			]);

			$uid = [
				'uid' => (int) $connection->lastInsertId('tx_health_domain_model_uri')
			];
		}

		if(empty($uid['uid']) === false) {
			$identifier = sha1(UriHandler::class . '.' . $site->getUid() . '.' . $uid['uid']);
			$arguments = [
				'uri' => $uid['uid']
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
					'execute_at' => $now->format('Y-m-d H:i:s'),
					'arguments' => json_encode($arguments)
				]);
			}
		}
	}
}