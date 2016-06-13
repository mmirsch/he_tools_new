<?php
namespace HSE\HeTools\ViewHelpers\Be;

use HSE\HeTools\Utility\BackendUtility;

/**
 * BackendCreateLinkViewHelper
 *
 * @package TYPO3
 * @subpackage Fluid
 */
class SwitchBackendUserLinkViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

	/**
	 * Create a link for backend edit
	 *
	 * @param int $identifier
	 * @return string
	 */
	public function render($identifier)
	{
		$link = BackendUtility::createSwitchBeUserUri($identifier);
		return '
			<a class="btn btn-default" href="' . $link . '" target="_top" title="Benutzer wechseln">
				<span class="t3js-icon icon icon-size-small icon-state-default icon-actions-system-backend-user-switch" data-identifier="actions-system-backend-user-switch">
					<span class="icon-markup">
						<img src="/typo3/sysext/core/Resources/Public/Icons/T3Icons/actions/actions-system-backend-user-switch.svg" height="16" width="16">
					</span>
				</span>
			</a>';
	}
}
