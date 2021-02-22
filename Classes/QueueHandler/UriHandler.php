<?php

namespace Ps14\Health\QueueHandler;

use Ps14\Health\Domain\Model\Site;
use Ps14\Health\Domain\Model\Uri;
use Ps14\Health\Domain\Model\UriResponse;
use Ps14\Health\Domain\Repository\UriRepository;
use Ps14\Health\Domain\Repository\UriResponseRepository;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use GuzzleHttp\Client;

class UriHandler {

	/**
	 * @var Site
	 */
	protected $site;

	/**
	 * @var Uri
	 */
	protected $uri;

	/**
	 * UriHandler constructor.
	 * @param Site $site
	 * @param array $arguments
	 */
	public function __construct(Site $site, $arguments = []) {
		$this->site = $site;
		$this->resolveArguments($arguments);
	}

	protected function resolveArguments($arguments) {
		$this->uri = GeneralUtility::makeInstance(UriRepository::class)->findByUid((int) $arguments['uri']);
	}

	public function handle() {
		$response = $this->getResponse();
	}

	/**
	 * @return UriResponse
	 * @throws \GuzzleHttp\Exception\GuzzleException
	 * @throws \TYPO3\CMS\Extbase\Persistence\Exception\IllegalObjectTypeException
	 */
	protected function getResponse() {

		/** @var UriResponseRepository $uriResponseRepository */
		$uriResponseRepository = GeneralUtility::makeInstance(UriResponseRepository::class);
		$uriResponse = $uriResponseRepository->findBy(['uri' => $this->uri]);

		if($uriResponse === null) {
			$uri = $this->site->getDomain()->getUri() . $this->uri->getUri();
			$client = new Client();
			$response = $client->request('GET', $uri);

			/** @var UriResponse $uriResponse */
			$uriResponse = GeneralUtility::makeInstance(UriResponse::class);
			$uriResponse->setPid($this->site->getPid());
			$uriResponse->setUri($this->uri);
			$uriResponse->setLastRequestTime(new \DateTime());
			$uriResponse->setBody($response->getBody()->getContents());

			$uriResponseRepository->add($uriResponse);
		}

		return $uriResponse;
	}
}