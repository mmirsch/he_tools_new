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
 * Persons
 */
class Persons extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * feuser
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     */
    protected $feuser = null;
    
    /**
     * persData
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersData>
     * @cascade remove
     */
    protected $persData = null;
    
    /**
     * persFunc
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersFunc>
     * @cascade remove
     */
    protected $persFunc = null;
    
    /**
     * Returns the feuser
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feuser
     */
    public function getFeuser()
    {
        return $this->feuser;
    }
    
    /**
     * Sets the feuser
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feuser
     * @return void
     */
    public function setFeuser(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $feuser)
    {
        $this->feuser = $feuser;
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
        $this->persData = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
        $this->persFunc = new \TYPO3\CMS\Extbase\Persistence\ObjectStorage();
    }
    
    /**
     * Adds a PersData
     *
     * @param \HSE\HeTools\Domain\Model\PersData $persDatum
     * @return void
     */
    public function addPersDatum(\HSE\HeTools\Domain\Model\PersData $persDatum)
    {
        $this->persData->attach($persDatum);
    }
    
    /**
     * Removes a PersData
     *
     * @param \HSE\HeTools\Domain\Model\PersData $persDatumToRemove The PersData to be removed
     * @return void
     */
    public function removePersDatum(\HSE\HeTools\Domain\Model\PersData $persDatumToRemove)
    {
        $this->persData->detach($persDatumToRemove);
    }
    
    /**
     * Returns the persData
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersData> $persData
     */
    public function getPersData()
    {
        return $this->persData;
    }
    
    /**
     * Sets the persData
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersData> $persData
     * @return void
     */
    public function setPersData(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $persData)
    {
        $this->persData = $persData;
    }
    
    /**
     * Adds a PersFunc
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFunc
     * @return void
     */
    public function addPersFunc(\HSE\HeTools\Domain\Model\PersFunc $persFunc)
    {
        $this->persFunc->attach($persFunc);
    }
    
    /**
     * Removes a PersFunc
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFuncToRemove The PersFunc to be removed
     * @return void
     */
    public function removePersFunc(\HSE\HeTools\Domain\Model\PersFunc $persFuncToRemove)
    {
        $this->persFunc->detach($persFuncToRemove);
    }
    
    /**
     * Returns the persFunc
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersFunc> $persFunc
     */
    public function getPersFunc()
    {
        return $this->persFunc;
    }
    
    /**
     * Sets the persFunc
     *
     * @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\HSE\HeTools\Domain\Model\PersFunc> $persFunc
     * @return void
     */
    public function setPersFunc(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $persFunc)
    {
        $this->persFunc = $persFunc;
    }

}