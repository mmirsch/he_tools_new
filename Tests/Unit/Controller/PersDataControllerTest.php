<?php
namespace HSE\HeTools\Tests\Unit\Controller;
/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 2 of the License, or
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
 * Test case for class HSE\HeTools\Controller\PersDataController.
 *
 */
class PersDataControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\PersDataController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\PersDataController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllPersDatasFromRepositoryAndAssignsThemToView()
	{

		$allPersDatas = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$persDataRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$persDataRepository->expects($this->once())->method('findAll')->will($this->returnValue($allPersDatas));
		$this->inject($this->subject, 'persDataRepository', $persDataRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('persDatas', $allPersDatas);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenPersDataToView()
	{
		$persData = new \HSE\HeTools\Domain\Model\PersData();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persData', $persData);

		$this->subject->showAction($persData);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenPersDataToPersDataRepository()
	{
		$persData = new \HSE\HeTools\Domain\Model\PersData();

		$persDataRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$persDataRepository->expects($this->once())->method('add')->with($persData);
		$this->inject($this->subject, 'persDataRepository', $persDataRepository);

		$this->subject->createAction($persData);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenPersDataToView()
	{
		$persData = new \HSE\HeTools\Domain\Model\PersData();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persData', $persData);

		$this->subject->editAction($persData);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenPersDataInPersDataRepository()
	{
		$persData = new \HSE\HeTools\Domain\Model\PersData();

		$persDataRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$persDataRepository->expects($this->once())->method('update')->with($persData);
		$this->inject($this->subject, 'persDataRepository', $persDataRepository);

		$this->subject->updateAction($persData);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenPersDataFromPersDataRepository()
	{
		$persData = new \HSE\HeTools\Domain\Model\PersData();

		$persDataRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$persDataRepository->expects($this->once())->method('remove')->with($persData);
		$this->inject($this->subject, 'persDataRepository', $persDataRepository);

		$this->subject->deleteAction($persData);
	}
}
