<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function()
    {

        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
            'Health',
            'Accessibility',
            'Health Accessibility'
        );



        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile('health', 'Configuration/TypoScript', 'Health');


        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_health_domain_model_site', 'EXT:health/Resources/Private/Language/locallang_csh_tx_health_domain_model_site.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_site');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_health_domain_model_uri', 'EXT:health/Resources/Private/Language/locallang_csh_tx_health_domain_model_uri.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_uri');

        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_health_domain_model_urirequest', 'EXT:health/Resources/Private/Language/locallang_csh_tx_health_domain_model_urirequest.xlf');
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_health_domain_model_urirequest');

    }
);
