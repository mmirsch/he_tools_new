<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;
use HSE\HeTools\Service\Persons\Import\PersImport;
use HSE\HeTools\Utility\ExtensionUtility;

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

    public function importFromCsvArray($start=0, $count=10){
        $extensionConfiguration = ExtensionUtility::getExtensionConfig();
        if (isset($extensionConfiguration['sysfolder_fe_users'])) {
            $pidFeUsers = $extensionConfiguration['sysfolder_fe_users'];
        } else {
            $pidFeUsers = 0;
        }

        $csvArray = $this->createCsvArray();
        $listArray = [];
        for ($i = $start; $i < $start+$count; $i = $i + 1){
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
                $newFEUser = $this->createFrontendUser($csvArray[$i], $pidFeUsers);
                $newPerson->setFeuser($newFEUser);
                $this->add($newPerson);
                $listArray[] = $newPerson;

                // Create backend user
                $this->createBackendUser($csvArray[$i]);
            }
         }

        return $listArray;

    }


    /**
     * Create new BackendUser from importData
     *
     * @param array $importData
     *
     * return \TYPO3\CMS\Extbase\Domain\Model\BackendUser
     */
    protected function createBackendUser ($importData) {
        /** @var $backendUser \TYPO3\CMS\Extbase\Domain\Model\BackendUser  */
        $backendUser = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Model\BackendUser');
        $backendUser->setUsername($importData['login']);
        $backendUser->setRealName($importData['vorname'] . ' ' . $importData['nachname']);
        $backendUser->setEmail($importData['mailok']);
        $backendUser->setPid(0);

        /** @var $backendUsersRepository \TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository  */
        $backendUsersRepository = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository');
        $backendUsersRepository->add($backendUser);
        return $backendUser;
    }
    /**
     * Create new FrontendUser from importData
     * @param array $importData
     * @param int $pidFeUsers
     *
     * return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected function createFrontendUser($importData, $pidFeUsers) {
        /** @var $frontendUser \TYPO3\CMS\Extbase\Domain\Model\FrontendUser  */

        $frontendUser = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Model\FrontendUser');
        $frontendUser->setUsername($importData['login']);
        $frontendUser->setFirstName($importData['vorname']);
        $frontendUser->setLastName($importData['nachname']);
        $frontendUser->setEmail($importData['mailok']);

        // use storagefolder if given
        if (!empty($pidFeUsers)) {
            $frontendUser->setPid($pidFeUsers);
        }
        return $frontendUser;
    }
}

?>