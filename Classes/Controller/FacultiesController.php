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
 * FacultiesController
 */
class FacultiesController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{

    /**
     * facultiesRepository
     *
     * @var \HSE\HeTools\Domain\Repository\FacultiesRepository
     * @inject
     */
    protected $facultiesRepository = null;
    
    /**
     * action list
     *
     * @return void
     */
    public function listAction()
    {
        $faculties = $this->facultiesRepository->findAll();
        $this->view->assign('faculties', $faculties);
    }
    
    /**
     * action show
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @return void
     */
    public function showAction(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->view->assign('faculty', $faculty);
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
     * @param \HSE\HeTools\Domain\Model\Faculties $newFaculties
     * @return void
     */
    public function createAction(\HSE\HeTools\Domain\Model\Faculties $newFaculties)
    {
        $this->addFlashMessage('The object was created. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->facultiesRepository->add($newFaculties);
        $this->redirect('list');
    }
    
    /**
     * action edit
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @ignorevalidation $faculty
     * @return void
     */
    public function editAction(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->view->assign('faculty', $faculty);
    }
    
    /**
     * action update
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @return void
     */
    public function updateAction(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->addFlashMessage('The object was updated. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->facultiesRepository->update($faculty);
        $this->redirect('list');
    }
    
    /**
     * action delete
     *
     * @param \HSE\HeTools\Domain\Model\Faculties $faculty
     * @return void
     */
    public function deleteAction(\HSE\HeTools\Domain\Model\Faculties $faculty)
    {
        $this->addFlashMessage('The object was deleted. Please be aware that this action is publicly accessible unless you implement an access check. See http://wiki.typo3.org/T3Doc/Extension_Builder/Using_the_Extension_Builder#1._Model_the_domain', '', \TYPO3\CMS\Core\Messaging\AbstractMessage::ERROR);
        $this->facultiesRepository->remove($faculty);
        $this->redirect('list');
    }

}