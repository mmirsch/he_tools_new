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
class BeUsersController extends ActionController
{

    /**
     * BackendUser Repository
     *
     * @var \HSE\HeTools\Domain\Repository\BackendUserRepository
     * @inject
     */
    protected $backendUserRepository = null;


    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $returnUrl = BackendUtility::getReturnUrl();
        $userlist = $this->backendUserRepository->findAllByFilter();
        $this->view->assign('userList', $userlist);
        $this->view->assign('returnUrl', $returnUrl);
    }
    
    /**
     * action show
     *
     * @return void
     */
    public function listAjaxAction()
    {
        $getVars = GeneralUtility::_GET();
        $filter = $getVars['filter'];
        $returnUrl = $getVars['returnUrl'];
        $userlist = $this->backendUserRepository->findAllByFilter($filter);
        $this->view->assign('userList', $userlist);
        $this->view->assign('returnUrl', $returnUrl);
    }



    /**
     * Switches to a given user (SU-mode) and then redirects to the start page of the backend to refresh the navigation etc.
     *
     * @param string $switchUser BE-user record that will be switched to
     * @return void
     */
    public function switchUserAction($switchUser)
    {
        $targetUser = \TYPO3\CMS\Backend\Utility\BackendUtility::getRecord('be_users', $switchUser);

//        $redirectUrl = \HSE\HeTools\Utility\BackendUtility::getReturnUrl();

        if (is_array($targetUser) && $this->getBackendUserAuthentication()->isAdmin()) {
            $updateData['ses_userid'] = (int)$targetUser['uid'];
            $updateData['ses_backuserid'] = (int)$this->getBackendUserAuthentication()->user['uid'];

            // Set backend user listing module as starting module for switchback
            $this->getBackendUserAuthentication()->uc['startModuleOnFirstLogin'] = 'web_HeToolsHetools';

            $this->getBackendUserAuthentication()->uc['startModuleOnFirstLogin'] = 'web_HeToolsHetools->tx_hetools_web_hetoolshetools%5Baction%5D=list&tx_hetools_web_hetoolshetools%5Bcontroller%5D=BeUsers';

            $adminUserFirstLogin = array(
              'startModuleOnFirstLogin' => 'tools_ExtensionmanagerExtensionmanager->tx_extensionmanager_tools_extensionmanagerextensionmanager%5Baction%5D=distributions&tx_extensionmanager_tools_extensionmanagerextensionmanager%5Bcontroller%5D=List',
              'ucSetByInstallTool' => '1',
            );

            $this->getBackendUserAuthentication()->writeUC();

            $whereClause = 'ses_id=' . $this->getDatabaseConnection()->fullQuoteStr($this->getBackendUserAuthentication()->id, 'be_sessions');
            $whereClause .= ' AND ses_name=' . $this->getDatabaseConnection()->fullQuoteStr(\TYPO3\CMS\Core\Authentication\BackendUserAuthentication::getCookieName(), 'be_sessions');
            $whereClause .= ' AND ses_userid=' . (int)$this->getBackendUserAuthentication()->user['uid'];

            $this->getDatabaseConnection()->exec_UPDATEquery(
              'be_sessions',
              $whereClause,
              $updateData
            );

            $redirectUrl = 'index.php' . ($GLOBALS['TYPO3_CONF_VARS']['BE']['interfaces'] ? '' : '?commandLI=1');
            \TYPO3\CMS\Core\Utility\HttpUtility::redirect($redirectUrl);
        }
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDatabaseConnection()
    {
        return $GLOBALS['TYPO3_DB'];
    }

    /**
     * @return BackendUserAuthentication
     */
    protected function getBackendUserAuthentication()
    {
        return $GLOBALS['BE_USER'];
    }

    /**
     * @return LanguageService
     */
    protected function getLanguageService()
    {
        return $GLOBALS['LANG'];
    }

}