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
class BackendUser extends \TYPO3\CMS\Extbase\Domain\Model\BackendUser {

	/**
	 * usergroup
	 *
	 * /**
	 * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup>
	 */
	protected $usergroup = '';

	/*
* Sets the usergroups. Keep in mind that the property is called "usergroup"
* although it can hold several usergroups.
*
* @param \TYPO3\CMS\Extbase\Persistence\ObjectStorage $usergroup
* @return void
* @api
*/
	public function setUsergroup(\TYPO3\CMS\Extbase\Persistence\ObjectStorage $usergroup) {
		$this->usergroup = $usergroup;
	}

	/**
	 * Adds a usergroup to the backend user
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUserGroup $usergroup
	 * @return void
	 * @api
	 */
	public function addUsergroup(\TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup $usergroup) {
		$this->usergroup->attach($usergroup);
	}

	/**
	 * Removes a usergroup from the backend user
	 *
	 * @param \TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup $usergroup
	 * @return void
	 * @api
	 */
	public function removeUsergroup(\TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup $usergroup) {
		$this->usergroup->detach($usergroup);
	}

	/**
	 * Returns the usergroups. Keep in mind that the property is called "usergroup"
	 * although it can hold several usergroups.
	 *
	 * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage An object storage containing the usergroup
	 * @api
	 */
	public function getUsergroup() {
		return $this->usergroup;
	}


}