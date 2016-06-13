<?php
namespace HSE\HeTools\Domain\Repository;

use HSE\HeTools\Domain\Model\Persons;

class PersFuncListRepository extends \TYPO3\CMS\Extbase\Persistence\Repository{

    public function findPersFuncListByTitle($title){
        /** @var \TYPO3\CMS\Extbase\Persistence\QueryInterface $query */
        $query = $this->createQuery();
        $queryResult = $query->matching(
            $query->equals('title', $title)
        )->execute();
        $firstMatch = $queryResult->getFirst();
        return $firstMatch;
    }


}

?>