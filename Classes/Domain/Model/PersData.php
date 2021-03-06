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
 * PersData
 */
class PersData extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * value
     *
     * @var string
     * @validate NotEmpty
     */
    protected $value = '';

    /**
     * type
     *
     * @var \HSE\HeTools\Domain\Model\PersDataList
     */
    protected $type = null;
    
    /**
     * Returns the value
     *
     * @return string $value
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * Sets the value
     *
     * @param string $value
     * @return void
     */
    public function setValue($value)
    {
        $this->value = $value;
    }
    
    /**
     * Returns the type
     *
     * @return \HSE\HeTools\Domain\Model\PersDataList $type
     */
    public function getType()
    {
        return $this->type;
    }
    
    /**
     * Sets the type
     *
     * @param \HSE\HeTools\Domain\Model\PersDataList $type
     * @return void
     */
    public function setType(\HSE\HeTools\Domain\Model\PersDataList $type)
    {
        $this->type = $type;
    }

}