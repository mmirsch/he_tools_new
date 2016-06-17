<?php
namespace HSE\HeTools\ViewHelpers\Be;

use HSE\HeTools\Utility\BackendUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;

/**
 * BackendEditLinkViewHelper
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class EditLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

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
        $link = BackendUtility::createEditUri($tableName, $identifier, $addReturnUrl, $returnUrl);
        return '
        <a class="btn btn-default" href="' . $link . '"><span class="t3js-icon icon icon-size-small icon-state-default icon-actions-document-open" data-identifier="actions-document-open">
            <span class="icon-markup">
                <img src="/typo3/sysext/core/Resources/Public/Icons/T3Icons/actions/actions-document-open.svg" height="16" width="16">
            </span>

            </span>
        </a>';
    }
}
