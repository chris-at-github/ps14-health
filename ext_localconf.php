<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
	function() {

		\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
			'Health',
			'Accessibility',
			[
				\Ps14\Health\Controller\SiteController::class => 'list, show, testing'
			],
			// non-cacheable actions
			[
				\Ps14\Health\Controller\SiteController::class => 'testing'
			]
		);

		// wizards
		\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
			'mod {
                wizards.newContentElement.wizardItems.plugins {
                    elements {
                        accessibility {
                            iconIdentifier = health-plugin-accessibility
                            title = LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_accessibility.name
                            description = LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_accessibility.description
                            tt_content_defValues {
                                CType = list
                                list_type = health_accessibility
                            }
                        }
                    }
                    show = *
                }
           }'
		);
		$iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);

		$iconRegistry->registerIcon(
			'health-plugin-accessibility',
			\TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
			['source' => 'EXT:health/Resources/Public/Icons/user_plugin_accessibility.svg']
		);

	}
);
