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
 * Test case for class HSE\HeTools\Controller\FacultiesController.
 *
 */
class FacultiesControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\FacultiesController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\FacultiesController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllFacultiessFromRepositoryAndAssignsThemToView()
	{

		$allFacultiess = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$facultiesRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$facultiesRepository->expects($this->once())->method('findAll')->will($this->returnValue($allFacultiess));
		$this->inject($this->subject, 'facultiesRepository', $facultiesRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('facultiess', $allFacultiess);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenFacultiesToView()
	{
		$faculties = new \HSE\HeTools\Domain\Model\Faculties();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('faculties', $faculties);

		$this->subject->showAction($faculties);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenFacultiesToFacultiesRepository()
	{
		$faculties = new \HSE\HeTools\Domain\Model\Faculties();

		$facultiesRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$facultiesRepository->expects($this->once())->method('add')->with($faculties);
		$this->inject($this->subject, 'facultiesRepository', $facultiesRepository);

		$this->subject->createAction($faculties);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenFacultiesToView()
	{
		$faculties = new \HSE\HeTools\Domain\Model\Faculties();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('faculties', $faculties);

		$this->subject->editAction($faculties);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenFacultiesInFacultiesRepository()
	{
		$faculties = new \HSE\HeTools\Domain\Model\Faculties();

		$facultiesRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$facultiesRepository->expects($this->once())->method('update')->with($faculties);
		$this->inject($this->subject, 'facultiesRepository', $facultiesRepository);

		$this->subject->updateAction($faculties);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenFacultiesFromFacultiesRepository()
	{
		$faculties = new \HSE\HeTools\Domain\Model\Faculties();

		$facultiesRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$facultiesRepository->expects($this->once())->method('remove')->with($faculties);
		$this->inject($this->subject, 'facultiesRepository', $facultiesRepository);

		$this->subject->deleteAction($faculties);
	}
}
