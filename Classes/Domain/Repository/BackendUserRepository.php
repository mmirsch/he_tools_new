<?php
namespace HSE\HeTools\Domain\Repository;


class BackendUserRepository extends \TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository {

	public function findAllByFilter($filter = '', $groups = true) {
		if (isset($extensionConfiguration['limit_userlist'])) {
			$limitCount = $extensionConfiguration['limit_userlist'];
		} else {
			$limitCount = 20;
		}
		/** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
		$query = $this->createQuery();
		$query->matching(
			$query->logicalAnd(
				$query->logicalNot($query->equals('realName','')),
				$query->logicalOr(
					$query->like('username', '%'.$filter.'%'),
					$query->like('realName', '%'.$filter.'%'),
					$query->like('usergroup.title', '%' . $filter . '%')
				)
			)
		);
		$result = $query->execute(TRUE);
		$resultList = array();
		foreach ($result as $index => $elem) {
			if (!empty($elem['usergroup'])) {
				$result[$index]['usergroup'] = $this->getBeUsergroups($elem['usergroup']);
			}
			$sortName = $this->getLastNameFirstName($elem['username']);
			if (!empty($sortName)) {
				$resultList[$sortName] = $result[$index];
			}
		}
		ksort($resultList);
		$i = 0;
		foreach ($resultList as  $key=>$elem) {
			if ($i>$limitCount) {
				unset($resultList[$key]);
			}
			$i++;
		}
		return $resultList;
	}

	protected function getBeUsergroups($usergroups) {
		$titelList = array();
		if (!empty($usergroups)) {
			$groupList = explode(',', $usergroups);
			/**@var $backendUsergroupsRepository \TYPO3\CMS\Extbase\Domain\Repository\BackendUserGroupRepository */
			$backendUsergroupsRepository =  $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\BackendUserGroupRepository::class);

			foreach ($groupList as $usergroup) {
				/**@var $usergroup \TYPO3\CMS\Extbase\Domain\Model\BackendUserGroup */
				$usergroup = $backendUsergroupsRepository->findByUid($usergroup);
				if (!empty($usergroup)) {
					$titelList[] = $usergroup->getTitle();
				}
			}

		}
		return implode(',', $titelList);
	}

	/*
	 * @param string $backendUsername
	 *
	 * return string
	 */
	protected function getLastNameFirstName($backendUsername) {
		$lastNameFirstName = '';
		/**@var $frontendUserRepository \TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository */
		$frontendUserRepository =  $this->objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class);

		/**@var $frontendUsers \TYPO3\CMS\Extbase\Persistence\QueryResultInterface */
		$frontendUsers =  $frontendUserRepository->findByUsername($backendUsername);

		if ($frontendUsers->count()>0) {
			/**@var $frontendUser \TYPO3\CMS\Extbase\Persistence\FrontendUser */
			$frontendUser = $frontendUsers->getFirst();
			if (!empty($frontendUser)) {
				$lastNameFirstName = $frontendUser->getLastName() . $frontendUser->getFirstName();
			}
		}

		return $lastNameFirstName;
	}


}

?>