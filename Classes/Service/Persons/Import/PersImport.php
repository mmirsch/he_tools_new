<?php
namespace  HSE\HeTools\Service\Persons\Import;

use TYPO3\CMS\Backend\Form\Wizard\SuggestWizardDefaultReceiver;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;


/**
 * Class for importing Persdata from different sources
 *
 * @package	TYPO3
 * @subpackage	hfwu_redirects
 */
class PersImport  {

	/**
	 * csv import for testing
	 *
	 * @param string $csvPath
	 * @return array
	 * @static
	 */
	public static function importCvsData($csvPath)
	{
		$persData = array();
		$handle = fopen($csvPath, "r");
		if ($handle) {
			while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
				$persData[] = $data;
			}
			fclose($handle);
		}
		return $persData;
	}

}