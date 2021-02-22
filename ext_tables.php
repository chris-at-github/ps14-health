<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function() {
		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'Health',
			'Accessibility',
			'Health Accessibility'
		);

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
			'Health',
			'Dirty',
			'Health Dirty'
		);

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('health', 'Configuration/TypoScript', 'Health');

		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_site');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_uri');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_uriresponse');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_domain');
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_queue');
	}
);
