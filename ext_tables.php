<?php
if (!defined('TYPO3_MODE')) {
	die('Access denied.');
}

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
	'HSE.' . $_EXTKEY,
	'Hepersonen',
	'HE Personen'
);

$pluginSignature = str_replace('_','',$_EXTKEY) . '_hepersonen';
$GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$pluginSignature] = 'pi_flexform';
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue($pluginSignature, 'FILE:EXT:' . $_EXTKEY . '/Configuration/FlexForms/flexform_hepersonen.xml');

if (TYPO3_MODE === 'BE') {

	/**
	 * Registers a Backend Module
	 */
	\TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerModule(
		'HSE.' . $_EXTKEY,
		'web',	 // Make module a submodule of 'web'
		'hetools',	// Submodule key
		'',						// Position
		array(
			'Backend' => 'managePersons, import, test, testAdd',
			'BeUsers' => 'list, listAjax',
			'FeUsers' => 'list, listAjax',
			'Persons' => 'list',
		),
		array(
			'access' => 'user,group',
			'icon'   => 'EXT:' . $_EXTKEY . '/Ressources/Public/Icons/he_tools.svg',
			'labels' => 'LLL:EXT:' . $_EXTKEY . '/Resources/Private/Language/locallang_hetools.xlf',
		)
	);

}

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'HE-Tools');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_faculties', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_faculties.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_faculties');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_studyprograms', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_studyprograms.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_studyprograms');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_institutions', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_institutions.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_institutions');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_persons', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_persons.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_persons');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_persdata', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_persdata.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_persdata');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_persfunc', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_persfunc.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_persfunc');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_persdatalist', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_persdatalist.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_persdatalist');

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addLLrefForTCAdescr('tx_hetools_domain_model_persfunclist', 'EXT:he_tools/Resources/Private/Language/locallang_csh_tx_hetools_domain_model_persfunclist.xlf');
\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_hetools_domain_model_persfunclist');
