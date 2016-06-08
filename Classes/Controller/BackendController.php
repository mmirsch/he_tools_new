<?php
namespace HSE\HeTools\Controller;

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
use HSE\HeTools\Service\Persons\Import\PersImport;
use TYPO3\CMS\Core\Utility\DebugUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use HSE\HeTools\Domain\Model\Persons;
use HSE\HeTools\Domain\Model\PersData;

/**
 * BackendController
 *
 */
class BackendController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

	/**
	 * backendRepository
	 *
	 * @var \HSE\HeTools\Domain\Repository\BackendRepository
	 * @inject
	 */
	protected $backendRepository = null;

	/**
	 * personsRepository
	 *
	 * @var \HSE\HeTools\Domain\Repository\PersonsRepository
	 * @inject
	 */
	protected $personsRepository = null;

	/**
	 * action managePersonsAction
	 *
	 * @return void
	 */
	public function managePersonsAction()
	{

	}

	/**
	 * action test
	 *
	 * @return void
	 */
	public function testAction()
	{

	}

	/**
	 * action testAdd
	 *
	 * @return void
	 */
	public function testAddAction()
	{

		/**@var $personsRepository \HSE\HeTools\Domain\Repository\PersonsRepository */
		$personsRepository = $this->objectManager->get('HSE\HeTools\Domain\Repository\PersonsRepository');

		$personsList = $personsRepository->importFromCsvArray();

		//for($i = 0; $i < 2; $i = $i + 1){
			/**@var $newPerson \HSE\HeTools\Domain\Model\Persons */
			//$newPerson = $this->objectManager->get('HSE\HeTools\Domain\Model\Persons');

			/**@var $newFEUser \TYPO3\CMS\Extbase\Domain\Model\FrontendUser */
			//$newFEUser = $this->objectManager->get('TYPO3\CMS\Extbase\Domain\Model\FrontendUser');

			//$newFEUser->setUsername($csvArray[$i]['login']);
			//$newFEUser->setFirstName($csvArray[$i]['vorname']);
			//$newFEUser->setLastName($csvArray[$i]['nachname']);
			//$newFEUser->setEmail($csvArray[$i]['mailok']);
			//$newPerson->setFeuser($newFEUser);
			//$personsRepository->add($newPerson);
		//}


		/**@var $newPersData \TYPO3\CMS\Extbase\Domain\Model\PersData */
		//$newPersData = $this->objectManager->get('HSE\HeTools\Domain\Model\PersData');
		//$personsRepository->add($newPerson);

		$this->view->assign('personsList', $personsList);

	}


	/**
	 * action persImport
	 *
	 * @return void
	 */
	public function importAction()
	{
		$personsList = $this->backendRepository->createCsvArray();
		$this->view->assign('personsList', $personsList);
		DebuggerUtility::var_dump($personsList);
	}



}