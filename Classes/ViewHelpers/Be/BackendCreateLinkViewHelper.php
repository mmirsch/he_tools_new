<?php
namespace HSE\HeTools\ViewHelpers\Be;

/**
 * BackendCreateLinkViewHelper
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class BackendCreateLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * Create a link for backend edit
     *
     * @param string $tableName
     * @param int $identifier
     * @param string $returnUrl
     * @param bool $addReturnUrl
     * @return string
     */
    public function render($tableName, $identifier, $returnUrl = '', $addReturnUrl = true) {
        return \HSE\HeTools\Utility\BackendUtility::createNewUri($tableName, $identifier, $addReturnUrl, $returnUrl);
    }
}
