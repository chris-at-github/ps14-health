<?php
return [
	'ctrl' => [
		'title' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_site',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'sortby' => 'sorting',
		'versioningWS' => true,
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => [
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		],
		'searchFields' => 'title,identifier',
		'iconfile' => 'EXT:health/Resources/Public/Icons/tx_health_domain_model_site.gif'
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, identifier, domain, uris',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, identifier, domain, uris, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
	],
	'columns' => [
		'sys_language_uid' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.language',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'special' => 'languages',
				'items' => [
					[
						'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.allLanguages',
						-1,
						'flags-multiple'
					]
				],
				'default' => 0,
			],
		],
		'l10n_parent' => [
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.l18n_parent',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'default' => 0,
				'items' => [
					['', 0],
				],
				'foreign_table' => 'tx_health_domain_model_site',
				'foreign_table_where' => 'AND {#tx_health_domain_model_site}.{#pid}=###CURRENT_PID### AND {#tx_health_domain_model_site}.{#sys_language_uid} IN (-1,0)',
			],
		],
		'l10n_diffsource' => [
			'config' => [
				'type' => 'passthrough',
			],
		],
		't3ver_label' => [
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.versionLabel',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			],
		],
		'hidden' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.visible',
			'config' => [
				'type' => 'check',
				'renderType' => 'checkboxToggle',
				'items' => [
					[
						0 => '',
						1 => '',
						'invertStateDisplay' => true
					]
				],
			],
		],
		'starttime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.starttime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
				'behaviour' => [
					'allowLanguageSynchronization' => true
				]
			],
		],
		'endtime' => [
			'exclude' => true,
			'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.endtime',
			'config' => [
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'eval' => 'datetime,int',
				'default' => 0,
				'range' => [
					'upper' => mktime(0, 0, 0, 1, 1, 2038)
				],
				'behaviour' => [
					'allowLanguageSynchronization' => true
				]
			],
		],


		'title' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_site.title',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'identifier' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_site.identifier',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			],
		],
		'domain' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_site.domain',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_health_domain_model_domain',
				'default' => 0,
				'minitems' => 0,
				'maxitems' => 1,
			],
		],
		'uris' => [
			'exclude' => 1,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_site.uris',
			'config' => [
				'type' => 'inline',
				'foreign_table' => 'tx_health_domain_model_uri',
				'foreign_field' => 'site',
				'maxitems' => 9999,
				'appearance' => [
					'collapseAll' => 1,
					'expandSingle' => 1,
				],
			],
		],
	],
];
