<?php
namespace HSE\HeTools\Domain\Repository;


class BackendUserRepository extends \TYPO3\CMS\Extbase\Persistence\Repository {

  public function findAllByFilter($filter='', $groups=true)
  {
    $extensionConfiguration = \HSE\HeTools\Utility\ExtensionUtility::getExtensionConfig();
    if (isset($extensionConfiguration['limit_userlist'])) {
      $limitCount = $extensionConfiguration['limit_userlist'];
    } else {
      $limitCount = 50;
    }

    $whereBasic = '(be_users.username NOT LIKE "%_cli%" AND be_users.deleted=0)';
    if (!empty($filter)) {
      $whereUsername = '(be_users.username LIKE "%' . $filter . '%")';
      $whereRealname = '(be_users.realName LIKE "%' . $filter . '%")';
      if ($groups) {
        $whereGroups = '(be_groups.uid IN (SELECT uid FROM be_groups WHERE title LIKE "%' . $filter . '%"))';
      } else {
        $whereGroups = 'FALSE';
      }
      $whereFilterAndGroups = $whereUsername . ' OR ' . $whereRealname . ' OR ' . $whereGroups;
    } else {
      $whereFilterAndGroups = 'TRUE';
    }
    $where = ' WHERE ' . $whereBasic . ' AND (' . $whereFilterAndGroups . ')';

    $select = 'SELECT DISTINCT be_users.username,be_users.realName,be_users.uid,be_users.usergroup ' .
              'FROM be_users LEFT JOIN be_groups ON ( FIND_IN_SET( be_groups.uid, be_users.usergroup ) ) ';
    $join = 'INNER JOIN fe_users ON be_users.username = fe_users.username ';
    $orderby = 'ORDER BY fe_users.last_name, fe_users.first_name ';
    $limit = 'LIMIT 0,' . $limitCount;
    $sqlQuery = $select . $join . $where . $orderby . $limit;

    /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
    $query = $this->createQuery();

    $query->statement($sqlQuery);
    $result = $query->execute(true);
    foreach ($result as $index=>$elem) {
      if (!empty($elem['usergroup'])) {
        $result[$index]['usergroup'] = $this->getBeUsergroups($elem['usergroup']);
      }

    }
    return $result;
  }

  public function getBeUsergroups($usergroups) {
    $groupList = explode(',',$usergroups);
    $titelList = array();
    foreach ($groupList as $usergroup) {
      $sqlQuery = 'SELECT title FROM be_groups where uid=' . $usergroup . ' ORDER BY title';
      /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
      $query = $this->createQuery();
      $query->statement($sqlQuery);
      $result = $query->execute(true);
      if (count($result)==1) {
        $titelList[] = $result[0]['title'];
      }
    }
    return implode(',',$titelList);
  }

}

?>