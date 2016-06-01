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
 * Test case for class HSE\HeTools\Controller\PersonsController.
 *
 */
class PersonsControllerTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{

	/**
	 * @var \HSE\HeTools\Controller\PersonsController
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = $this->getMock('HSE\\HeTools\\Controller\\PersonsController', array('redirect', 'forward', 'addFlashMessage'), array(), '', FALSE);
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function listActionFetchesAllPersonssFromRepositoryAndAssignsThemToView()
	{

		$allPersonss = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array(), array(), '', FALSE);

		$personsRepository = $this->getMock('', array('findAll'), array(), '', FALSE);
		$personsRepository->expects($this->once())->method('findAll')->will($this->returnValue($allPersonss));
		$this->inject($this->subject, 'personsRepository', $personsRepository);

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$view->expects($this->once())->method('assign')->with('personss', $allPersonss);
		$this->inject($this->subject, 'view', $view);

		$this->subject->listAction();
	}

	/**
	 * @test
	 */
	public function showActionAssignsTheGivenPersonsToView()
	{
		$persons = new \HSE\HeTools\Domain\Model\Persons();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persons', $persons);

		$this->subject->showAction($persons);
	}

	/**
	 * @test
	 */
	public function createActionAddsTheGivenPersonsToPersonsRepository()
	{
		$persons = new \HSE\HeTools\Domain\Model\Persons();

		$personsRepository = $this->getMock('', array('add'), array(), '', FALSE);
		$personsRepository->expects($this->once())->method('add')->with($persons);
		$this->inject($this->subject, 'personsRepository', $personsRepository);

		$this->subject->createAction($persons);
	}

	/**
	 * @test
	 */
	public function editActionAssignsTheGivenPersonsToView()
	{
		$persons = new \HSE\HeTools\Domain\Model\Persons();

		$view = $this->getMock('TYPO3\\CMS\\Extbase\\Mvc\\View\\ViewInterface');
		$this->inject($this->subject, 'view', $view);
		$view->expects($this->once())->method('assign')->with('persons', $persons);

		$this->subject->editAction($persons);
	}

	/**
	 * @test
	 */
	public function updateActionUpdatesTheGivenPersonsInPersonsRepository()
	{
		$persons = new \HSE\HeTools\Domain\Model\Persons();

		$personsRepository = $this->getMock('', array('update'), array(), '', FALSE);
		$personsRepository->expects($this->once())->method('update')->with($persons);
		$this->inject($this->subject, 'personsRepository', $personsRepository);

		$this->subject->updateAction($persons);
	}

	/**
	 * @test
	 */
	public function deleteActionRemovesTheGivenPersonsFromPersonsRepository()
	{
		$persons = new \HSE\HeTools\Domain\Model\Persons();

		$personsRepository = $this->getMock('', array('remove'), array(), '', FALSE);
		$personsRepository->expects($this->once())->method('remove')->with($persons);
		$this->inject($this->subject, 'personsRepository', $personsRepository);

		$this->subject->deleteAction($persons);
	}
}
