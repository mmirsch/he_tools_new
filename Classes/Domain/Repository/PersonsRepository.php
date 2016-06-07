<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;
use HSE\HeTools\Service\Persons\Import\PersImport;

class PersonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    /**
     * Gets single fe_user by username
     *
     * @param string $username
     * @return QueryResultInterface|array
     */
    public function findByUsername($username)	{
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $query->equals('feuser.username', $username);
        $queryResult = $query->execute();
        return $queryResult;
    }

    /**
     * Gets single fe_user by email
     *
     * @param string $email
     * @return QueryResultInterface|array
     */
    public function findByEmail($email)	{
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $query->equals('feuser.email', $email);
        $queryResult = $query->execute();
        return $queryResult;
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
            /**@var $existingUser \HSE\HeTools\Domain\Model\Persons */
            $existingUser = $this->findByUsername($csvArray[$i]['login']);

            if (!empty($existingUser)) {
                // Update
                $feUser = $existingUser->getFeuser();
                $feUser->setFirstName($csvArray[$i]['vorname']);
                $feUser->setLastName($csvArray[$i]['nachname']);
                $feUser->setEmail($csvArray[$i]['mailok']);
                $existingUser->setFeuser($feUser);
                $this->update($existingUser);
                
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