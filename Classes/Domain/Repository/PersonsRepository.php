<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;
use HSE\HeTools\Service\Persons\Import\PersImport;

class PersonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    /**
     * ignore storagePid
     *
     * @return void
     */
    public function setIgnorePid() {
        $querySettings = $this->objectManager->get('TYPO3\\CMS\\Extbase\\Persistence\\Generic\\Typo3QuerySettings');
        // don't add the pid constraint
        $querySettings->setRespectStoragePage(FALSE);
        $this->setDefaultQuerySettings($querySettings);
    }


    /**
     * Gets single fe_user by username
     *
     * @param string $username
     * @return \HSE\HeTools\Domain\Model\Persons
     */
    public function findByUsername($username)	{
        $this->setIgnorePid();
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
          $query->equals('feuser.username', $username)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }

    /**
     * Gets single fe_user by email
     *
     * @param string $email
     * @return \HSE\HeTools\Domain\Model\Persons
     */
    public function findByEmail($email)	{
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
          $query->equals('feuser.username', $email)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }


    public function createCsvArray(){

        $extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('he_tools');
        $csvPath = $extPath . '/Resources/Public/csv/persdb.csv';
        return PersImport::importCvsData($csvPath);

    }

    public function importFromCsvArray(){

        $csvArray = $this->createCsvArray();
        $listArray = [];
        for($i = 0; $i < 2; $i = $i + 1){
            /**@var $existingPerson \HSE\HeTools\Domain\Model\Persons */
            $existingPerson = $this->findByUsername($csvArray[$i]['login']);

            if (!empty($existingPerson)) {
                // Update

                $existingPerson->setFirstName($csvArray[$i]['vorname']);
                $existingPerson->setLastName($csvArray[$i]['nachname']);
                $existingPerson->setEmail($csvArray[$i]['mailok']);
                $this->update($existingPerson);
                $listArray[] = $existingPerson;

            } else {
                // New
                /**@var $newPerson \HSE\HeTools\Domain\Model\Persons */
                $newPerson = $this->objectManager->get('HSE\HeTools\Domain\Model\Persons');

                /**@var $newFEUser \TYPO3\CMS\Extbase\Domain\Model\FrontendUser */
                $newFEUser = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Model\FrontendUser');

                $newFEUser->setUsername($csvArray[$i]['login']);
                $newFEUser->setFirstName($csvArray[$i]['vorname']);
                $newFEUser->setLastName($csvArray[$i]['nachname']);
                $newFEUser->setEmail($csvArray[$i]['mailok']);
                $newPerson->setFeuser($newFEUser);
                $this->add($newPerson);
                $listArray[] = $newPerson;

            }
         }

        return $listArray;

    }

}

?>