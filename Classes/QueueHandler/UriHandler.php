<?php

namespace Ps14\Health\QueueHandler;

use Ps14\Health\Domain\Model\Site;
use Ps14\Health\Domain\Model\Uri;
use Ps14\Health\Domain\Model\UriResponse;
use Ps14\Health\Domain\Repository\UriRepository;
use Ps14\Health\Domain\Repository\UriResponseRepository;
use Ps14\Health\Tests\AbstractTest;
use Ps14\Health\Tests\Accessibility\BadLinkTextTest;
use Ps14\Health\Tests\Accessibility\DoubleBreakTest;
use Ps14\Health\Tests\Accessibility\DoubleSpaceEntityTest;
use Ps14\Health\Tests\Accessibility\EmptyAltAttributeTest;
use Ps14\Health\Tests\Accessibility\EmptyParagraphTest;
use Ps14\Health\Tests\Accessibility\ExistingHeader1Test;
use Ps14\Health\Tests\Accessibility\HeaderOrderTest;
use Ps14\Health\Tests\Accessibility\TableThTest;
use Ps14\Health\Tests\ErrorTestResult;
use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use GuzzleHttp\Client;

class UriHandler {

	/**
	 * @var string
	 */
	protected $interval = 'P7D';

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
		$logFile = Environment::getPublicPath() . '/fileadmin/documents/a11y.log';
		$logEntries = [];
		$tests = [
			EmptyParagraphTest::class,
			DoubleSpaceEntityTest::class,
			DoubleBreakTest::class,
			EmptyAltAttributeTest::class,
			BadLinkTextTest::class,
			TableThTest::class,
			ExistingHeader1Test::class,
			HeaderOrderTest::class,
		];

		$fp = fopen($logFile, 'a+');

		foreach($tests as $test) {

			/** @var AbstractTest $testInstance */
			$testInstance = GeneralUtility::makeInstance($test);
			$testInstance->setUriResponse($response);

			$result = $testInstance->perform();

			if($result instanceof ErrorTestResult) {
				$logEntries[] = $result->getMessage();
			}
		}

		if(empty($logEntries) === false) {
			fwrite($fp, '---------------------------------------------------------' . PHP_EOL);
			fwrite($fp, $this->uri->getUri() . PHP_EOL);

			foreach($logEntries as $logEntry) {
				fwrite($fp, $logEntry . PHP_EOL);
			}

			fwrite($fp, PHP_EOL);
			DebuggerUtility::var_dump($logEntries, $this->uri->getUri());
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
	 * @return string
	 */
	public function getInterval(): string {
		return $this->interval;
	}
}