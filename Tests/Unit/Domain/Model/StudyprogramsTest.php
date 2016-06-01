<?php

namespace HSE\HeTools\Tests\Unit\Domain\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 
 *
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
 * Test case for class \HSE\HeTools\Domain\Model\Studyprograms.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class StudyprogramsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \HSE\HeTools\Domain\Model\Studyprograms
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \HSE\HeTools\Domain\Model\Studyprograms();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getTitleReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getTitle()
		);
	}

	/**
	 * @test
	 */
	public function setTitleForStringSetsTitle()
	{
		$this->subject->setTitle('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'title',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getShortcutReturnsInitialValueForString()
	{
		$this->assertSame(
			'',
			$this->subject->getShortcut()
		);
	}

	/**
	 * @test
	 */
	public function setShortcutForStringSetsShortcut()
	{
		$this->subject->setShortcut('Conceived at T3CON10');

		$this->assertAttributeEquals(
			'Conceived at T3CON10',
			'shortcut',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function getDegreeReturnsInitialValueForInt()
	{	}

	/**
	 * @test
	 */
	public function setDegreeForIntSetsDegree()
	{	}

	/**
	 * @test
	 */
	public function getFacultyReturnsInitialValueForFaculties()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getFaculty()
		);
	}

	/**
	 * @test
	 */
	public function setFacultyForObjectStorageContainingFacultiesSetsFaculty()
	{
		$faculty = new \HSE\HeTools\Domain\Model\Faculties();
		$objectStorageHoldingExactlyOneFaculty = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOneFaculty->attach($faculty);
		$this->subject->setFaculty($objectStorageHoldingExactlyOneFaculty);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOneFaculty,
			'faculty',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addFacultyToObjectStorageHoldingFaculty()
	{
		$faculty = new \HSE\HeTools\Domain\Model\Faculties();
		$facultyObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$facultyObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($faculty));
		$this->inject($this->subject, 'faculty', $facultyObjectStorageMock);

		$this->subject->addFaculty($faculty);
	}

	/**
	 * @test
	 */
	public function removeFacultyFromObjectStorageHoldingFaculty()
	{
		$faculty = new \HSE\HeTools\Domain\Model\Faculties();
		$facultyObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$facultyObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($faculty));
		$this->inject($this->subject, 'faculty', $facultyObjectStorageMock);

		$this->subject->removeFaculty($faculty);

	}
}
