<?php
return [
	'ctrl' => [
		'title' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue',
		'label' => 'identifier',
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
		'searchFields' => 'identifier,handler,arguments',
		'iconfile' => 'EXT:health/Resources/Public/Icons/tx_health_domain_model_queue.gif',
		'hideTable' => true
	],
	'interface' => [
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, identifier, handler, execute_at, arguments, site',
	],
	'types' => [
		'1' => ['showitem' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, identifier, handler, execute_at, arguments, site, --div--;LLL:EXT:frontend/Resources/Private/Language/locallang_ttc.xlf:tabs.access, starttime, endtime'],
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
				'foreign_table' => 'tx_health_domain_model_queue',
				'foreign_table_where' => 'AND {#tx_health_domain_model_queue}.{#pid}=###CURRENT_PID### AND {#tx_health_domain_model_queue}.{#sys_language_uid} IN (-1,0)',
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


		'identifier' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue.identifier',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'handler' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue.handler',
			'config' => [
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim,required'
			],
		],
		'execute_at' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue.execute_at',
			'config' => [
				'dbType' => 'datetime',
				'type' => 'input',
				'renderType' => 'inputDateTime',
				'size' => 12,
				'eval' => 'datetime',
				'default' => null,
			],
		],
		'arguments' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue.arguments',
			'config' => [
				'type' => 'text',
				'cols' => 40,
				'rows' => 15,
				'eval' => 'trim'
			]
		],
		'site' => [
			'exclude' => true,
			'label' => 'LLL:EXT:health/Resources/Private/Language/locallang_db.xlf:tx_health_domain_model_queue.site',
			'config' => [
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'tx_health_domain_model_site',
				'default' => 0,
				'minitems' => 0,
				'maxitems' => 1,
			],

		],

	],
];
