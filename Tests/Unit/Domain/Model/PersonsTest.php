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
 * Test case for class \HSE\HeTools\Domain\Model\Persons.
 *
 * @copyright Copyright belongs to the respective authors
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PersonsTest extends \TYPO3\CMS\Core\Tests\UnitTestCase
{
	/**
	 * @var \HSE\HeTools\Domain\Model\Persons
	 */
	protected $subject = NULL;

	public function setUp()
	{
		$this->subject = new \HSE\HeTools\Domain\Model\Persons();
	}

	public function tearDown()
	{
		unset($this->subject);
	}

	/**
	 * @test
	 */
	public function getFeuserReturnsInitialValueForFrontendUser()
	{	}

	/**
	 * @test
	 */
	public function setFeuserForFrontendUserSetsFeuser()
	{	}

	/**
	 * @test
	 */
	public function getPersDataReturnsInitialValueForPersData()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPersData()
		);
	}

	/**
	 * @test
	 */
	public function setPersDataForObjectStorageContainingPersDataSetsPersData()
	{
		$persDatum = new \HSE\HeTools\Domain\Model\PersData();
		$objectStorageHoldingExactlyOnePersData = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePersData->attach($persDatum);
		$this->subject->setPersData($objectStorageHoldingExactlyOnePersData);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePersData,
			'persData',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPersDatumToObjectStorageHoldingPersData()
	{
		$persDatum = new \HSE\HeTools\Domain\Model\PersData();
		$persDataObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$persDataObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($persDatum));
		$this->inject($this->subject, 'persData', $persDataObjectStorageMock);

		$this->subject->addPersDatum($persDatum);
	}

	/**
	 * @test
	 */
	public function removePersDatumFromObjectStorageHoldingPersData()
	{
		$persDatum = new \HSE\HeTools\Domain\Model\PersData();
		$persDataObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$persDataObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($persDatum));
		$this->inject($this->subject, 'persData', $persDataObjectStorageMock);

		$this->subject->removePersDatum($persDatum);

	}

	/**
	 * @test
	 */
	public function getPersFuncReturnsInitialValueForPersFunc()
	{
		$newObjectStorage = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$this->assertEquals(
			$newObjectStorage,
			$this->subject->getPersFunc()
		);
	}

	/**
	 * @test
	 */
	public function setPersFuncForObjectStorageContainingPersFuncSetsPersFunc()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();
		$objectStorageHoldingExactlyOnePersFunc = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
		$objectStorageHoldingExactlyOnePersFunc->attach($persFunc);
		$this->subject->setPersFunc($objectStorageHoldingExactlyOnePersFunc);

		$this->assertAttributeEquals(
			$objectStorageHoldingExactlyOnePersFunc,
			'persFunc',
			$this->subject
		);
	}

	/**
	 * @test
	 */
	public function addPersFuncToObjectStorageHoldingPersFunc()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();
		$persFuncObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('attach'), array(), '', FALSE);
		$persFuncObjectStorageMock->expects($this->once())->method('attach')->with($this->equalTo($persFunc));
		$this->inject($this->subject, 'persFunc', $persFuncObjectStorageMock);

		$this->subject->addPersFunc($persFunc);
	}

	/**
	 * @test
	 */
	public function removePersFuncFromObjectStorageHoldingPersFunc()
	{
		$persFunc = new \HSE\HeTools\Domain\Model\PersFunc();
		$persFuncObjectStorageMock = $this->getMock('TYPO3\\CMS\\Extbase\\Persistence\\ObjectStorage', array('detach'), array(), '', FALSE);
		$persFuncObjectStorageMock->expects($this->once())->method('detach')->with($this->equalTo($persFunc));
		$this->inject($this->subject, 'persFunc', $persFuncObjectStorageMock);

		$this->subject->removePersFunc($persFunc);

	}
}
