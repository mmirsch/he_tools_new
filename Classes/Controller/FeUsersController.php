<?php
namespace HSE\HeTools\Controller;


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

use HSE\HeTools\Utility\BackendUtility;
use HSE\HeTools\Utility\ExtensionUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

/**
 * PersonsController
 */
class FeUsersController extends ActionController
{

    /**
     * frontendUser Repository
     *
     * @var \HSE\HeTools\Domain\Repository\FrontendUserRepository
     * @inject
     */
    protected $frontendUserRepository = null;


    /**
     * action list
     *
     * @param string $search
     * @param boolean $searchInUsergroup
     */
    public function listAction($search='', $searchInUsergroup=FALSE)
    {
        if(empty($search)){
            $feusers = $this->frontendUserRepository->findAll();
        }else {
            if($searchInUsergroup == FALSE) {
                $feusers = $this->frontendUserRepository->findAllByFilterName($search);
            } else {
                $feusers = $this->frontendUserRepository->findAllByFilterNameAndUsergroup($search);
            }
        }
        $this->view->assign('feuserList', $feusers);
    }

}