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
 * PersFunc
 */
class PersFunc extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * type
     *
     * @var \HSE\HeTools\Domain\Model\PersFuncList
     */
    protected $type = null;
    
    /**
     * institution
     *
     * @var \HSE\HeTools\Domain\Model\Institutions
     */
    protected $institution = null;
    
    /**
     * faculty
     *
     * @var \HSE\HeTools\Domain\Model\Faculties
     */
    protected $faculty = null;
    
    /**
     * Returns the institution
     *
     * @return \HSE\HeTools\Domain\Model\Institutions $institution
     */
    public function getInstitution()
    {
        return $this->institution;
    }
    
    /**
     * Sets the institution
     *
     * @param \HSE\HeTools\Domain\Model\Institutions $institution
     * @return void
     */
    public function setInstitution(\HSE\HeTools\Domain\Model\Institutions $institution)
    {
        $this->institution = $institution;
    }
    
    /**
     * Returns the faculty
     *
     * @return \HSE\HeTools\Domain\Model\Faculties $faculty
     */
    public function getFaculty()
    {
        return $this->faculty;
    }
    
    /**
     * Sets the faculty
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @return void
     */
    public function setFaculty(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->faculty = $faculty;
    }
    
    /**
     * Returns the type
     *
     * @return \HSE\HeTools\Domain\Model\PersFuncList $type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Sets the type
     *
     * @param \HSE\HeTools\Domain\Model\PersFuncList $type
     * @return void
     */
    public function setType(\HSE\HeTools\Domain\Model\PersFuncList $type)
    {
        $this->type = $type;
    }

}