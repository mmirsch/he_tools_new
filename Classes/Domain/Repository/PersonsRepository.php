<?php
namespace HSE\HeTools\Domain\Repository;

class PersonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

	/**
	 * @param string $username
	 * @return QueryResultInterface|array
	 */
	public function findByUsername($username)	{
		/** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
		$query = $this->createQuery();
		$query->like('username.title', $username);
		$queryResult = $query->execute();
		return $queryResult;
	}


}

?>