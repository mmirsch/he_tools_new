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
 * Test case for class HSE\HeTools\Controller\StudyprogramsController.
 *
 */
class StudyprogramsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\StudyprogramsController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\StudyprogramsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllStudyprogramssFromRepositoryAndAssignsThemToView()
	{

		$allStudyprogramss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$studyprogramsRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$studyprogramsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allStudyprogramss));
		$this->inject($this->subject, 'studyprogramsRepository', $studyprogramsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('studyprogramss', $allStudyprogramss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenStudyprogramsToView()
	{
		$studyprograms = new \HSE\HeTools\Domain\Model\Studyprograms();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('studyprograms', $studyprograms);

		$this->subject->showAction($studyprograms);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenStudyprogramsToStudyprogramsRepository()
	{
		$studyprograms = new \HSE\HeTools\Domain\Model\Studyprograms();

		$studyprogramsRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$studyprogramsRepository->expects($this->once())->method('add')->with($studyprograms);
		$this->inject($this->subject, 'studyprogramsRepository', $studyprogramsRepository);

		$this->subject->createAction($studyprograms);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenStudyprogramsToView()
	{
		$studyprograms = new \HSE\HeTools\Domain\Model\Studyprograms();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('studyprograms', $studyprograms);

		$this->subject->editAction($studyprograms);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenStudyprogramsInStudyprogramsRepository()
	{
		$studyprograms = new \HSE\HeTools\Domain\Model\Studyprograms();

		$studyprogramsRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$studyprogramsRepository->expects($this->once())->method('update')->with($studyprograms);
		$this->inject($this->subject, 'studyprogramsRepository', $studyprogramsRepository);

		$this->subject->updateAction($studyprograms);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenStudyprogramsFromStudyprogramsRepository()
	{
		$studyprograms = new \HSE\HeTools\Domain\Model\Studyprograms();

		$studyprogramsRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$studyprogramsRepository->expects($this->once())->method('remove')->with($studyprograms);
		$this->inject($this->subject, 'studyprogramsRepository', $studyprogramsRepository);

		$this->subject->deleteAction($studyprograms);
	}
}
