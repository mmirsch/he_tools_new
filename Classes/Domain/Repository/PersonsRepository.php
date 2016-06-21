<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;
use HSE\HeTools\Service\Persons\Import\PersImport;
use HSE\HeTools\Utility\ExtensionUtility;

class PersonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    /**
     * persDataListRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersDataListRepository
     * @inject
     */
    protected $persDataListRepository = null;

    /**
     * persDataRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersDataRepository
     * @inject
     */
    protected $persDataRepository = null;

    /**
     * persFuncListRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersFuncListRepository
     * @inject
     */
    protected $persFuncListRepository = null;

    /**
     * persFuncRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersFuncRepository
     * @inject
     */
    protected $persFuncRepository = null;

    /**
     * FacultiesRepository
     *
     * @var \HSE\HeTools\Domain\Repository\FacultiesRepository
     * @inject
     */
    protected $facultiesRepository = null;

    /**
     * InstitutionsRepository
     *
     * @var \HSE\HeTools\Domain\Repository\InstitutionsRepository
     * @inject
     */
    protected $institutionsRepository = null;

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
    public function findOneByUsername($username)	{
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
    public function findOneByEmail($email)	{
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

    public function importFromCsvArray($start=0, $count=100){
        $extensionConfiguration = ExtensionUtility::getExtensionConfig();
        if (isset($extensionConfiguration['sysfolder_fe_users'])) {
            $pidFeUsers = $extensionConfiguration['sysfolder_fe_users'];
        } else {
            $pidFeUsers = 0;
        }

        $csvArray = $this->createCsvArray();
        $listArray = [];
        $end = $start+$count;
        if (count($csvArray)<$end) {
            $end = count($csvArray);
        }
        for ($i = $start; $i < $end; $i = $i + 1){
            /**@var $existingPerson \HSE\HeTools\Domain\Model\Persons */
            $existingPerson = $this->findOneByUsername($csvArray[$i]['login']);

            if (!empty($existingPerson)) {
                // Update
                $existingPerson->setFirstName($csvArray[$i]['vorname']);
                $existingPerson->setLastName($csvArray[$i]['nachname']);
                $existingPerson->setEmail($csvArray[$i]['mailok']);

                /**@var $newPersFuncList \HSE\HeTools\Domain\Model\PersFuncList */
                $newPersFuncList = $this->persFuncListRepository->findByTitle($csvArray[$i]['fkt_sva']);

                if(!empty($newPersFuncList)){

                    if($this->isFunctionInPerson($existingPerson, $csvArray[$i]['fkt_sva']) == FALSE){
                        /**@var $newPersFunc \HSE\HeTools\Domain\Model\PersFunc */
                        $newPersFunc = $this->objectManager->get('HSE\HeTools\Domain\Model\PersFunc');
                        $newPersFunc->setType($newPersFuncList);

                        /**@var $faculties \HSE\HeTools\Domain\Model\Faculties */
                        $faculties = $this->facultiesRepository->findByShortcut($csvArray[$i]['hb_sva']);
                        if(!empty($faculties)) {
                            $newPersFunc->setFaculty($faculties);
                        } else{
                        }

                        /**@var $institutions \HSE\HeTools\Domain\Model\Institutions */
                        $institutions = $this->institutionsRepository->findByTitle($csvArray[$i]['hb_sva']);
                        if(!empty($institutions)) {
                            $newPersFunc->setInstitution($institutions);
                        } else {
                        }

                        $existingPerson->addPersFunc($newPersFunc);
                    } else {

                    }

                } else {
                }

                $this->update($existingPerson);
                $listArray[] = $existingPerson;

            } else {
                // New
                /**@var $newPerson \HSE\HeTools\Domain\Model\Persons */
                $newPerson = $this->objectManager->get('HSE\HeTools\Domain\Model\Persons');

                /**@var $newPersDataList \HSE\HeTools\Domain\Model\PersDataList */
                $newPersDataList = $this->persDataListRepository->findByTitle('room');

                if(!empty($newPersDataList)){
                    /**@var $newPersData \HSE\HeTools\Domain\Model\PersData */
                    $newPersData = $this->objectManager->get('HSE\HeTools\Domain\Model\PersData');
                    $newPersData->setType($newPersDataList);
                    $newPersData->setValue($csvArray[$i]['raum']);
                    $newPerson->addPersData($newPersData);
                }

                /**@var $newPersFuncList \HSE\HeTools\Domain\Model\PersFuncList */
                $newPersFuncList = $this->persFuncListRepository->findByTitle($csvArray[$i]['fkt_sva']);


                if (!empty($newPersFuncList)) {
                    /**@var $newPersFunc \HSE\HeTools\Domain\Model\PersFunc */
                    $newPersFunc = $this->objectManager->get('HSE\HeTools\Domain\Model\PersFunc');
                    $newPersFunc->setType($newPersFuncList);

                    /**@var $faculties \HSE\HeTools\Domain\Model\Faculties */
                    $faculties = $this->facultiesRepository->findByShortcut($csvArray[$i]['hb_sva']);
                    if(!empty($faculties)) {
                        $newPersFunc->setFaculty($faculties);
                    } else{
                    }

                    /**@var $institutions \HSE\HeTools\Domain\Model\Institutions */
                    $institutions = $this->institutionsRepository->findByTitle($csvArray[$i]['hb_sva']);
                    if(!empty($institutions)) {
                        $newPersFunc->setInstitution($institutions);
                    } else {
                    }
                    $newPerson->addPersFunc($newPersFunc);
                }

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

    public function isFunctionInPerson($person, $title){

        /**@var $person \HSE\HeTools\Domain\Model\Persons */
        $persFuncArray = $person->getPersFunc();

        foreach($persFuncArray as $value) {
            $titleArray[] = $value->getType()->getTitle();
        }

        $result = FALSE;
        foreach($titleArray as $value){
            if($value == $title){
                $result = TRUE;
            } else {
            }
        }
        return $result;

    }


    /**
     * Create new BackendUser from importData
     *
     * @param array $importData
     *
     * return \TYPO3\CMS\Extbase\Domain\Model\BackendUser
     */
    protected function createBackendUser ($importData) {
        /** @var $backendUser \TYPO3\CMS\Beuser\Domain\Model\BackendUser  */
        $backendUser = $this->objectManager->get('TYPO3\CMS\Beuser\Domain\Model\BackendUser');
        $backendUser->setUsername($importData['login']);
        $backendUser->setRealName($importData['vorname'] . ' ' . $importData['nachname']);
        $backendUser->setEmail($importData['mailok']);
        $backendUser->setPid(0);

        /** @var $backendUserGroupRepository \TYPO3\CMS\Extbase\Domain\Repository\BackendUserGroupRepository  */
        $backendUserGroupRepository = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Repository\BackendUserGroupRepository');

        /*
         * #### TEST - Start
         *
         * Creating be_groups during import
         * for test purposes only!
         *
         * will be removed after testing is finished
         */
        /** @var $backendUserGroup \TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup  */
        $backendUserGroup = $backendUserGroupRepository->findOneByTitle($importData['hb_sva']);
        if (empty($backendUserGroup)) {
            /** @var $backendUserGroup \TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup  */
            $backendUserGroup = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup');
            $backendUserGroup->setTitle($importData['hb_sva']);
            $backendUserGroup->setPid(0);
            $backendUserGroupRepository->add($backendUserGroup);
        }

        $backendUserGroups = $this->objectManager->get('TYPO3\CMS\Extbase\Persistence\ObjectStorage');
        $backendUserGroups->attach($backendUserGroup);

        $backendUser->setBackendUserGroups($backendUserGroups);
        /*
         * #### TEST - End
         */

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

        $frontendUser = $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser::class);
        $frontendUser->setUsername($importData['login']);
        $frontendUser->setFirstName($importData['vorname']);
        $frontendUser->setLastName($importData['nachname']);
        $frontendUser->setName($importData['vorname'] . ' ' . $importData['nachname']);
        $frontendUser->setEmail($importData['mailok']);

        // use storagefolder if given
        if (!empty($pidFeUsers)) {
            $frontendUser->setPid($pidFeUsers);
        }
        return $frontendUser;
    }

    public function createPersonsList($functions, $faculty, $listManually, $exclude){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $query = $query->matching(
            $query->logicalOr(
                $query->logicalAnd(
                    $query->in('persFunc.type.uid', explode(',', $functions)),
                    $query->in('persFunc.faculty.uid', explode(',', $faculty)),
                    $query->logicalNot($query->in('uid', explode(',', $exclude))
                    )
                ),
                $query->in('uid', explode(',', $listManually))
            )
        );

        $queryResult = $query->execute();

        $results = $queryResult->toArray();
        return $results;
    }

}

?>