<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Service\Persons\Import\PersImport;


class FrontendUserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository{

    public function createCsvArray(){

        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('he_tools');
        $csvPath = $extPath . '/Resources/Public/csv/persdb.csv';
        return PersImport::importCvsData($csvPath);

    }

    public function addFrontendUser($user){
        $query = $this->createQuery();
        $query->add($user);
        $query->execute();
    }

    public function findAllByFilter($value){
        $query = $this->createQuery();
        $query->matching(
            $query->like('name', '%'.$value.'%')
        );
        return $query->execute();

    }

}

?>