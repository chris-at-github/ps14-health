<?php

namespace Ps14\Health\QueueHandler;

use Ps14\Health\Domain\Model\Site;
use Ps14\Health\Domain\Model\Uri;
use Ps14\Health\Domain\Model\UriResponse;
use Ps14\Health\Domain\Repository\UriRepository;
use Ps14\Health\Domain\Repository\UriResponseRepository;
use Ps14\Health\Tests\AbstractTest;
use Ps14\Health\Tests\Accessibility\DoubleSpaceEntityTest;
use Ps14\Health\Tests\Accessibility\EmptyParagraphTest;
use Ps14\Health\Tests\ErrorTestResult;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use GuzzleHttp\Client;

class UriHandler {

	/**
	 * 1 Woche
	 * @var int
	 */
	protected $interval = 604800;

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
		$logFile = Environment::getPublicPath() . '/fileadmin/documents/a11y.csv';
		$tests = [
			EmptyParagraphTest::class,
			DoubleSpaceEntityTest::class
		];
		$error = false;
		$log = [
			$this->uri->getUri()
		];

		if(is_file($logFile) === false) {
			$fp = fopen($logFile, 'a+');
			fputcsv($fp, array_merge(['Uri'], $tests));

		} else {
			$fp = fopen($logFile, 'a+');
		}

		foreach($tests as $test) {

			/** @var AbstractTest $testInstance */
			$testInstance = GeneralUtility::makeInstance($test);
			$testInstance->setUriResponse($response);

			$result = $testInstance->perform();

			if($result instanceof ErrorTestResult) {
				$error = true;
				$log[$test] = 1;

			} else {
				$log[$test] = 0;
			}
		}

		if($error === true) {
			fputcsv($fp, $log);
		}

		fclose($fp);
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

	/**
	 * @return int
	 */
	public function getInterval(): int {
		return $this->interval;
	}
}