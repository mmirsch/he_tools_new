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

/**
 * PersFuncController
 */
class PersFuncController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $persFuncs = $this->persFuncRepository->findAll();
        $this->view->assign('persFuncs', $persFuncs);
    }
    
    /**
     * action show
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFunc
     * @return void
     */
    public function showAction(\HSE\HeTools\Domain\Model\PersFunc $persFunc)
    {
        $this->view->assign('persFunc', $persFunc);
    }
    
    /**
     * action new
     *
     * @return void
     */
    public function newAction()
    {
        
    }
    
    /**
     * action create
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $newPersFunc
     * @return void
     */
    public function createAction(\HSE\HeTools\Domain\Model\PersFunc $newPersFunc)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->persFuncRepository->add($newPersFunc);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFunc
     * @ignorevalidation $persFunc
     * @return void
     */
    public function editAction(\HSE\HeTools\Domain\Model\PersFunc $persFunc)
    {
        $this->view->assign('persFunc', $persFunc);
    }
    
    /**
     * action update
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFunc
     * @return void
     */
    public function updateAction(\HSE\HeTools\Domain\Model\PersFunc $persFunc)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->persFuncRepository->update($persFunc);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \HSE\HeTools\Domain\Model\PersFunc $persFunc
     * @return void
     */
    public function deleteAction(\HSE\HeTools\Domain\Model\PersFunc $persFunc)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->persFuncRepository->remove($persFunc);
        $this->redirect('list');
    }

}