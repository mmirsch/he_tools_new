<?php
namespace HSE\HeTools\Domain\Repository;

class PersonsRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

	/**
	 * Gets single fe_user by username
	 *
	 * @param string $username
	 * @return QueryResultInterface|array
	 */
	public function findByUsername($username)	{
		/** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
		$query = $this->createQuery();
		$query->like('feuser.username', $username);
		$queryResult = $query->execute();
		return $queryResult;
	}

	/**
	 * Gets single fe_user by email
	 *
	 * @param string $email
	 * @return QueryResultInterface|array
	 */
	public function findByEmail($email)	{
		/** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
		$query = $this->createQuery();
		$query->like('feuser.email', $email);
		$queryResult = $query->execute();
		return $queryResult;
	}


}

?>