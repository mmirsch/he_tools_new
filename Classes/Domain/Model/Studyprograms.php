<?php
namespace HSE\HeTools\Domain\Model;

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
 * Studyprograms
 */
class Studyprograms extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * title
     *
     * @var string
     */
    protected $title = '';
    
    /**
     * shortcut
     *
     * @var string
     */
    protected $shortcut = '';
    
    /**
     * degree
     *
     * @var int
     */
    protected $degree = 0;

    /**
     * faculty
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Faculties>
     * @cascade remove
     */
    protected $faculty = null;

    /**
     * campus
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Campus>
     * @cascade remove
     */
    protected $campus = null;

    /**
     * Returns the title
     *
     * @return string $title
     */
    public function getTitle()
    {
        return $this->title;
    }
    
    /**
     * Sets the title
     *
     * @param string $title
     * @return void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    /**
     * Returns the shortcut
     *
     * @return string $shortcut
     */
    public function getShortcut()
    {
        return $this->shortcut;
    }
    
    /**
     * Sets the shortcut
     *
     * @param string $shortcut
     * @return void
     */
    public function setShortcut($shortcut)
    {
        $this->shortcut = $shortcut;
    }
    
    /**
     * Returns the degree
     *
     * @return int $degree
     */
    public function getDegree()
    {
        return $this->degree;
    }
    
    /**
     * Sets the degree
     *
     * @param int $degree
     * @return void
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;
    }
    
    /**
     * __construct
     */
    public function __construct()
    {
        //Do not remove the next line: It would break the functionality
        $this->initStorageObjects();
    }
    
    /**
     * Initializes all ObjectStorage properties
     * Do not modify this method!
     * It will be rewritten on each save in the extension builder
     * You may modify the constructor of this class instead
     *
     * @return void
     */
    protected function initStorageObjects()
    {
        $this->faculty = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a Faculties
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @return void
     */
    public function addFaculty(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->faculty->attach($faculty);
    }
    
    /**
     * Removes a Faculties
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $facultyToRemove The Faculties to be removed
     * @return void
     */
    public function removeFaculty(\HSE\HeTools\Domain\Model\Faculties $facultyToRemove)
    {
        $this->faculty->detach($facultyToRemove);
    }
    
    /**
     * Returns the faculty
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Faculties> $faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }
    
    /**
     * Sets the faculty
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Faculties> $faculty
     * @return void
     */
    public function setFaculty(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $faculty)
    {
        $this->faculty = $faculty;
    }

    /**
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Campus>
     */
    public function getCampus() {
        return $this->campus;
    }

    /**
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\Campus> $campus
     */
    public function setCampus($campus) {
        $this->campus = $campus;
    }

}