<?php
namespace HSE\HeTools\Controller;

use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\MathUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

/**
 * PersonsController
 */
class PersonsController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * personsRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersonsRepository
     * @inject
     */
    protected $personsRepository = null;

    /**
     * persFuncListRepository
     *
     * @var \HSE\HeTools\Domain\Repository\PersFuncListRepository
     * @inject
     */
    protected $persFuncListRepository = null;

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $idFunction = $this->settings['function'];
        $idFaculty = $this->settings['faculty'];
        $idListManually = $this->settings['listManually'];
        $idExclude = $this->settings['listManuallyExclude'];


        if (!empty($idFunction) || !empty($idFaculty) || !empty($listManually)) {
            $personsList = $this->personsRepository->createPersonsList($idFunction, $idFaculty, $idListManually, $idExclude);
        } else {
        }

        //$persIdListManually = $this->settings['listManually'];
        //$persIdArray = explode(',', $persIdListManually);

        //if (!empty($persIdArray)) {
        //    foreach ($persIdArray as &$value) {
        //        $personsList[] = $this->personsRepository->findByUid($value);
        //    }
        //} else {
        //}

        $this->view->assign('personsList', $personsList);

        /* Alternativ über for-Schleife:
           for ($i = 0; $i < count($persIdArray); $i = $i + 1){
           $personsList[$i] = $this->personsRepository->findByUid($persIdArray[$i]);
           }
           */
        
        //$personsList = $this->personsRepository->findByUid($persIdArray[0]);
        DebuggerUtility::var_dump($personsList);

    }
    
    /**
     * action show
     *
     * @return void
     */
    public function showAction()
    {
        $persId = (int) $this->settings['person'];
        $personsData = $this->personsRepository->findByUid($persId);
        DebuggerUtility::var_dump($personsData);
        $this->view->assign('personsData', $personsData);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param \HSE\HeTools\Domain\Model\Persons $newPersons
     * @return void
     */
    public function createAction(\HSE\HeTools\Domain\Model\Persons $newPersons)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->personsRepository->add($newPersons);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \HSE\HeTools\Domain\Model\Persons $persons
     * @ignorevalidation $persons
     * @return void
     */
    public function editAction(\HSE\HeTools\Domain\Model\Persons $persons)
    {
        $this->view->assign('persons', $persons);
    }
    
    /**
     * action update
     *
     * @param \HSE\HeTools\Domain\Model\Persons $persons
     * @return void
     */
    public function updateAction(\HSE\HeTools\Domain\Model\Persons $persons)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->personsRepository->update($persons);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \HSE\HeTools\Domain\Model\Persons $persons
     * @return void
     */
    public function deleteAction(\HSE\HeTools\Domain\Model\Persons $persons)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->personsRepository->remove($persons);
        $this->redirect('list');
    }

}