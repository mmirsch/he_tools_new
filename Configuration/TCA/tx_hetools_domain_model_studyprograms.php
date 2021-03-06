<?php
return array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,
		'versioningWS' => 2,
		'versioning_followPages' => TRUE,

		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,shortcut,degree,faculty,',
		'iconfile' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extRelPath('he_tools') . 'Resources/Public/Icons/tx_hetools_domain_model_studyprograms.gif'
	),
	'interface' => array(
		'showRecordFieldList' => 'sys_language_uid, l10n_parent, l10n_diffsource, hidden, title, shortcut, degree, faculty, campus',
	),
	'types' => array(
		'1' => array('showitem' => 'sys_language_uid;;;;1-1-1, l10n_parent, l10n_diffsource, hidden;;1, title, shortcut, degree, faculty, campus, --div--;LLL:EXT:cms/locallang_ttc.xlf:tabs.access, starttime, endtime'),
	),
	'palettes' => array(
		'1' => array('showitem' => ''),
	),
	'columns' => array(
	
		'sys_language_uid' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.language',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'foreign_table' => 'sys_language',
				'foreign_table_where' => 'ORDER BY sys_language.title',
				'items' => array(
					array('LLL:EXT:lang/locallang_general.xlf:LGL.allLanguages', -1),
					array('LLL:EXT:lang/locallang_general.xlf:LGL.default_value', 0)
				),
			),
		),
		'l10n_parent' => array(
			'displayCond' => 'FIELD:sys_language_uid:>:0',
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.l18n_parent',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('', 0),
				),
				'foreign_table' => 'tx_hetools_domain_model_studyprograms',
				'foreign_table_where' => 'AND tx_hetools_domain_model_studyprograms.pid=###CURRENT_PID### AND tx_hetools_domain_model_studyprograms.sys_language_uid IN (-1,0)',
			),
		),
		'l10n_diffsource' => array(
			'config' => array(
				'type' => 'passthrough',
			),
		),

		't3ver_label' => array(
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.versionLabel',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'max' => 255,
			)
		),
	
		'hidden' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.hidden',
			'config' => array(
				'type' => 'check',
			),
		),
		'starttime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.starttime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),
		'endtime' => array(
			'exclude' => 1,
			'l10n_mode' => 'mergeIfNotBlank',
			'label' => 'LLL:EXT:lang/locallang_general.xlf:LGL.endtime',
			'config' => array(
				'type' => 'input',
				'size' => 13,
				'max' => 20,
				'eval' => 'datetime',
				'checkbox' => 0,
				'default' => 0,
				'range' => array(
					'lower' => mktime(0, 0, 0, date('m'), date('d'), date('Y'))
				),
			),
		),

		'title' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms.title',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'shortcut' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms.shortcut',
			'config' => array(
				'type' => 'input',
				'size' => 30,
				'eval' => 'trim'
			),
		),
		'degree' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms.degree',
			'config' => array(
				'type' => 'select',
				'renderType' => 'selectSingle',
				'items' => array(
					array('Bachelor of Engineering', 'B. Sc.'),
					array('Bachelor of Science', 'B. Eng.'),
					array('Master of Engineering', 'M. Eng.'),
					array('Master of Engineering', 'M. Sc.'),
				),
				'size' => 1,
				'maxitems' => 1,
				'eval' => ''
			),
		),
		'faculty' => array(
			'exclude' => 1,
			'label' => 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms.faculty',
			'config' => array(
				'type' => 'select',
				'foreign_table' => 'tx_hetools_domain_model_faculties',
				'size' => 12,
				'minitems' => 1,
				'maxitems' => 1,
			),
		),
		'campus' => array(
				'exclude' => 1,
				'label' => 'LLL:EXT:he_tools/Resources/Private/Language/locallang_db.xlf:tx_hetools_domain_model_studyprograms.campus',
				'config' => array(
					'type' => 'select',
					'foreign_table' => 'tx_hetools_domain_model_campus',
					'size' => 3,
					'minitems' => 1,
					'maxitems' => 1,
				),
		),
		
	),
);