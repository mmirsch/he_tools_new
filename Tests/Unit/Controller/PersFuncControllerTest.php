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
 * Test case for class HSE\HeTools\Controller\PersFuncController.
 *
 */
class PersFuncControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\PersFuncController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\PersFuncController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllPersFuncsFromRepositoryAndAssignsThemToView()
	{

		$allPersFuncs = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$persFuncRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$persFuncRepository->expects($this->once())->method('findAll')->will($this->returnValue($allPersFuncs));
		$this->inject($this->subject, 'persFuncRepository', $persFuncRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('persFuncs', $allPersFuncs);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenPersFuncToView()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persFunc', $persFunc);

		$this->subject->showAction($persFunc);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenPersFuncToPersFuncRepository()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();

		$persFuncRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$persFuncRepository->expects($this->once())->method('add')->with($persFunc);
		$this->inject($this->subject, 'persFuncRepository', $persFuncRepository);

		$this->subject->createAction($persFunc);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenPersFuncToView()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persFunc', $persFunc);

		$this->subject->editAction($persFunc);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenPersFuncInPersFuncRepository()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();

		$persFuncRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$persFuncRepository->expects($this->once())->method('update')->with($persFunc);
		$this->inject($this->subject, 'persFuncRepository', $persFuncRepository);

		$this->subject->updateAction($persFunc);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenPersFuncFromPersFuncRepository()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();

		$persFuncRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$persFuncRepository->expects($this->once())->method('remove')->with($persFunc);
		$this->inject($this->subject, 'persFuncRepository', $persFuncRepository);

		$this->subject->deleteAction($persFunc);
	}
}
