<?php
namespace  HSE\HeTools\Suggest;

use TYPO3\CMS\Backend\Form\Wizard\SuggestWizardDefaultReceiver;
use TYPO3\CMS\Core\Utility\ArrayUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Utility\IconUtility;


/**
 * Custom suggest receiver for tags
 *
 * @package	TYPO3
 * @subpackage	hfwu_redirects
 */
class PersonsSuggestReceiver extends SuggestWizardDefaultReceiver {


	/**
	 * The constructor of this class
	 *
	 * @param string $table The table to query
	 * @param array $config The configuration (TCA overlayed with TSconfig) to use for this selector
	 * @return void
	 */
	public function __construct($table, $config) {
		$this->table = $table;
		$this->config = $config;

		if (isset($config['maxItemsInResultList'])) {
			$this->maxItems = $config['maxItemsInResultList'];
		}
		if (isset($config['orderBy'])) {
			$this->orderByStatement = $config['orderBy'];
		} else {
			$this->orderByStatement = $table . '.' . $GLOBALS['TCA'][$this->table]['ctrl']['label'];
		}

	}


	/**
	 * Queries a table for records and completely processes them
	 *
	 * Returns a two-dimensional array of almost finished records; the only need to be put into a <li>-structure
	 *
	 * If you subclass this class, you will most likely only want to overwrite the functions called from here, but not
	 * this function itself
	 *
	 * @param array $params
	 * @param integer $ref The parent object
	 * @return array Array of rows or FALSE if nothing found
	 */
	public function queryTable(&$params, $recursionCounter = 0) {
		$rows = array();
		$this->params = &$params;

		$limitStart = $recursionCounter * 50;

		$searchString = $this->params['value'];
		$searchWholePhrase = $this->config['searchWholePhrase'];
		$searchUid = (int)$searchString;
		$select = 'SELECT tx_hetools_domain_model_persons.uid, fe_users.* FROM tx_hetools_domain_model_persons INNER JOIN fe_users ON tx_hetools_domain_model_persons.feuser=fe_users.uid';

		$this->selectClause = 'TRUE';
		if (strlen($searchString)>0) {
			$searchString = $GLOBALS['TYPO3_DB']->quoteStr($searchString, 'fe_users');
			$searchStringForLike = $GLOBALS['TYPO3_DB']->escapeStrForLike($searchString, $this->table);
			if ($searchString[0]!='^' && $searchWholePhrase) {
				$start = '%';
			} else {
				$start = '';
			}
			$this->selectClause = '(fe_users.first_name LIKE \'' . $start . $searchStringForLike . '%\'' .
				' OR fe_users.last_name LIKE \'' . $start . $searchStringForLike . '%\'' .
				' OR fe_users.username LIKE \'' . $start . $searchStringForLike . '%\')' .
				' AND tx_hetools_domain_model_persons.deleted=0 AND tx_hetools_domain_model_persons.hidden=0';

			// treat numbers as page id
			if ($searchUid > 0 && $searchUid == $searchString) {
				$this->selectClause = '(' . $this->selectClause . ' OR ' . $this->table . '.uid = ' . $searchUid . ')';
			}
		}

		$where = 'WHERE ' . $this->selectClause;

		if (empty($this->maxItems)) {
			$this->maxItems = 50;
		}
		$limit = 'LIMIT ' . $limitStart . ',' . $this->maxItems;

		$orderBy = 'ORDER BY ' . $this->orderByStatement;

		$sqlQuery = $select . ' ' . $where . ' ' . $orderBy . ' ' . $limit;
		$res = $GLOBALS['TYPO3_DB']->sql_query($sqlQuery);
		$allRowsCount = $GLOBALS['TYPO3_DB']->sql_num_rows($res);
		if ($allRowsCount) {
			while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {
				// check if we already have collected the maximum number of records
				if (count($rows) > $this->maxItems) {
					break;
				}
				$spriteIcon = IconUtility::getSpriteIconForRecord(
					$this->table, $row, array('style' => 'margin: 0 4px 0 -20px; padding: 0;')
				);
				$uid = $row['t3ver_oid'] > 0 ? $row['t3ver_oid'] : $row['uid'];
				$label = $row['last_name'] . ', ' . $row['first_name'];
				$entry = array(
					'text' => '<span class="suggest-label">' . $label . '</span><span class="suggest-uid">[' . $uid . ']</span>',
					'table' => $this->table,
					'label' => $label,
					'path' => '',
					'uid' => $uid,
					'style' => '',
					'class' => isset($this->config['cssClass']) ? $this->config['cssClass'] : '',
					'sprite' => $spriteIcon
				);
				$rows[$uid] = $this->renderRecord($row, $entry);
			}
			$GLOBALS['TYPO3_DB']->sql_free_result($res);
			// if there are less records than we need, call this function again to get more records
			if (count($rows) < $this->maxItems && $allRowsCount >= 50 && $recursionCounter < $this->maxItems) {
				$tmp = self::queryTable($params, ++$recursionCounter);
				$rows = array_merge($tmp, $rows);
			}
		}
		return $rows;
	}

}