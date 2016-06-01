<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
	'HSE.' . $_EXTKEY,
	'Hepersonen',
	array(
		'Persons' => 'list, show, edit',
		
	),
	// non-cacheable actions
	array(
		'Persons' => 'edit',
		
	)
);
