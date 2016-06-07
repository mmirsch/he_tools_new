<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Service\Persons\Import\PersImport;

class BackendRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function createCsvArray(){

        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('he_tools');
        $csvPath = $extPath . '/Resources/Public/csv/persdb.csv';
        return PersImport::importCvsData($csvPath);

    }

}

?>