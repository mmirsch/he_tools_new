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
 * Test case for class HSE\HeTools\Controller\InstitutionsController.
 *
 */
class InstitutionsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\InstitutionsController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\InstitutionsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllInstitutionssFromRepositoryAndAssignsThemToView()
	{

		$allInstitutionss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$institutionsRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$institutionsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allInstitutionss));
		$this->inject($this->subject, 'institutionsRepository', $institutionsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('institutionss', $allInstitutionss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenInstitutionsToView()
	{
		$institutions = new \HSE\HeTools\Domain\Model\Institutions();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('institutions', $institutions);

		$this->subject->showAction($institutions);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenInstitutionsToInstitutionsRepository()
	{
		$institutions = new \HSE\HeTools\Domain\Model\Institutions();

		$institutionsRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$institutionsRepository->expects($this->once())->method('add')->with($institutions);
		$this->inject($this->subject, 'institutionsRepository', $institutionsRepository);

		$this->subject->createAction($institutions);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenInstitutionsToView()
	{
		$institutions = new \HSE\HeTools\Domain\Model\Institutions();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('institutions', $institutions);

		$this->subject->editAction($institutions);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenInstitutionsInInstitutionsRepository()
	{
		$institutions = new \HSE\HeTools\Domain\Model\Institutions();

		$institutionsRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$institutionsRepository->expects($this->once())->method('update')->with($institutions);
		$this->inject($this->subject, 'institutionsRepository', $institutionsRepository);

		$this->subject->updateAction($institutions);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenInstitutionsFromInstitutionsRepository()
	{
		$institutions = new \HSE\HeTools\Domain\Model\Institutions();

		$institutionsRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$institutionsRepository->expects($this->once())->method('remove')->with($institutions);
		$this->inject($this->subject, 'institutionsRepository', $institutionsRepository);

		$this->subject->deleteAction($institutions);
	}
}
